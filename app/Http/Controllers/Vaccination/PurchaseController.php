<?php

namespace App\Http\Controllers\Vaccination;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\VcVaccine;
use App\Models\VcVendor;
use App\Models\VcPurchase;
use App\Models\VcVaccineLot;
use App\Models\VcPurchaseDetail;
use App\Models\VcPatientVaccination;
use Yajra\Datatables\DataTables;
use Illuminate\Support\Facades\Auth;
use DB;

class PurchaseController extends Controller
{
      public function add_purchase(Request $request)
    {
        $title = 'Add Purchase';
        $vendor = VcVendor::where('is_active','1')->orderBy('id', 'desc')->get();
        $vaccine = VcVaccine::where('status','0')->orderBy('id','desc')->get();
        $data = compact('title','vendor','vaccine');
        return view('vaccination.add-purchase')->with($data);
    }
    public function edit_purchase($id)
    {
        $id = ed($id, false);
        $edit = VcPurchase::where('id', $id)->where('is_delete', 0)->first();
        if($edit->status == 1){
            return back()->with('error', "Stock Updated not Edit this Purchase!");
        }
        $edit_info = VcPurchaseDetail::select('vc_purchase_details.*','vc_vaccines.vaccine_name')
            ->join('vc_vaccines','vc_vaccines.id','=','vc_purchase_details.vaccine_id')
            ->where('vc_purchase_details.purchase_id', $id)
            ->where('vc_purchase_details.is_delete', 0)
            ->get();

        $title = 'Edit Purchase';
        $vendor = VcVendor::where('is_active','1')->orderBy('id', 'desc')->get();
        $vaccine = VcVaccine::where('status','0')->orderBy('id','desc')->get();

        $data = compact('edit','edit_info','title','vendor','vaccine');
        return view('vaccination.add-purchase')->with($data);
    }
    public function update_purchase(Request $request, $id = 0)
    {
        $request->validate([
            'date' => 'required',
            'invoice_no' => 'required',
            'vendor_id' => 'required',
            'item_name.*' => 'required',
            'batch_no.*' => 'required',
        ]);


        foreach (($request->batch_no ?? []) as $key => $batchNo) {
            $existing = VcPurchaseDetail::where('batch_number', $batchNo)
                ->where('is_delete', 0)
                ->where('id', '!=', $request->uppid[$key] ?? 0)
                ->first();
            if ($existing) {
               if ($existing) {
                return back()->with('error', 'Duplicate batch numbers are not allowed. Try again!');
            }
            }
        }
        try {
            DB::beginTransaction();

            $purchase = $id ? VcPurchase::find($id) : new VcPurchase();
            $purchase->date = date('Y-m-d H:i:s',strtotime($request->date));
            $purchase->vendor_id = $request->vendor_id;
            $purchase->invoice_no = $request->invoice_no;
            $purchase->total = $request->total;
            $purchase->sub_total = $request->sub_total;
            $purchase->total_sgst_amount = $request->total_sgst_amount;
            $purchase->total_igst_amount = $request->total_igst_amount;
            $purchase->total_cgst_amount = $request->total_cgst_amount;
            $purchase->note = $request->note;
            $purchase->discount_amount = $request->total_discount_amount;
            $purchase->discount_type = $request->discount_type;
            $purchase->payment_terms = $request->payment_terms;
            if($id){
                $purchase->edit_by = Auth::user()->id;
                $purchase->edit_at = date('Y-m-d h:i:s');
            }else{
                $purchase->generated_by = Auth::user()->id;
            }
            $purchase->status = (int)$request->action_type;
            $purchase->save();
            $purchase_id = $purchase->id;
            if (!empty($request->uppid) && is_array($request->uppid)) {
                VcPurchaseDetail::where('purchase_id', $purchase_id)
                    ->whereNotIn('id', $request->uppid)
                    ->update(['is_delete' => 1]);
            }
            foreach ($request->item_name as $key => $items) {
                if(@$request->uppid[$key]){
                    $purchase_details = VcPurchaseDetail::find($request->uppid[$key]);
                }else{
                    $purchase_details = new VcPurchaseDetail();
                }
                $purchase_details->purchase_id = $purchase_id;
                $purchase_details->vaccine_id = $request->item_name[$key];
                $purchase_details->unit_qty = $request->unit_qty[$key];
                $purchase_details->sub_unit_qty = $request->sub_unit_qty[$key];
                $purchase_details->sub_unit = $request->sub_unit[$key];
                $purchase_details->unit = $request->unit[$key];
                $purchase_details->batch_number = $request->batch_no[$key];
                $purchase_details->exp_date = $request->exp_date[$key];
                $purchase_details->p_rate = $request->rate[$key];
                $purchase_details->s_rate = $request->mrp[$key];
                $purchase_details->net_amount = $request->net_amount[$key];
                $purchase_details->discount_percentage = $request->discount_percentage[$key];
                $purchase_details->discount_amount = $request->discount_amount[$key];
                $purchase_details->cgst = $request->cgst[$key];
                $purchase_details->sgst = $request->sgst[$key];
                $purchase_details->igst = $request->igst[$key];
                $purchase_details->cgst_amount = $request->cgst_amount[$key];
                $purchase_details->sgst_amount = $request->sgst_amount[$key];
                $purchase_details->igst_amount = $request->igst_amount[$key];
                $purchase_details->amount = $request->amount[$key];
                $purchase_details->save();

            }

            if((int)$request->action_type == 1){
                foreach ($request->item_name as $key => $items) {
                    $unit_subunit_relation = VcVaccine::where('id',$request->item_name[$key])->first();
                    $relation = $unit_subunit_relation->unit_subunit_relation;
                    $stock = new VcVaccineLot();
                    $stock->vaccine_id = $request->item_name[$key];
                    $stock->purchase_details_id = $purchase_details->id;
                    $stock->batch_number = $request->batch_no[$key];
                    $stock->exp_date = $request->exp_date[$key];
                    $stock->unit_qty = $request->unit_qty[$key];
                    $stock->unit = $request->unit[$key];
                    $stock->sub_unit_qty = $request->sub_unit_qty[$key];
                    $stock->sub_unit = $request->sub_unit[$key];
                    $stock->s_rate = $request->mrp[$key];
                    $stock->total_qty = ($request->unit_qty[$key] * $relation) + $request->sub_unit_qty[$key];
                    $stock->available_qty = ($request->unit_qty[$key] * $relation) + $request->sub_unit_qty[$key];
                    $stock->unit_relation = $relation;
                    $stock->save();
                }
            }
            DB::commit();
            return redirect()->route('vc.listing-purchase')->with('success', 'Purchase Saved Successfully!');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Something went wrong. Try again!');
        }
    }
    public function listing_purchase(Request $request)
    {
        if ($request->ajax()) {

            $data = VcPurchase::select(
                'vc_purchase.*',
                'v.vendor_name as vendor',
                'u.name as created_by'
            )
            ->join('vc_vendors  as v', 'v.id', '=', 'vc_purchase.vendor_id')
            ->join('users as u', 'u.id', '=', 'vc_purchase.generated_by')
            ->where('vc_purchase.is_delete', 0)
            ->orderBy('vc_purchase.id', 'DESC');

            return Datatables::of($data)
                ->addIndexColumn()

                ->addColumn('action', function($row){
                    $actionBtn = '<a href="' . route('vc.purchase-details', ed($row->id, true)) . '" class="btn btn-sm btn-outline-info mx-1" title="View"><i class="bx bxs-info-circle"></i></a>';
                    if($row->status == 0){
                        $actionBtn .= '<a href="' . route('vc.edit-purchase', ed($row->id, true)) . '" class="btn btn-sm btn-outline-warning mx-1" title="Edit"><i class="bx bxs-edit"></i></a>';
                        $actionBtn .= '<a onclick="return confirm(\'Are you sure you want to delete this record?\');" href="' . route('vc.delete-purchase', ed($row->id, true)) . '" class="btn btn-sm btn-outline-danger mx-1" title="Delete"><i class="bx bxs-trash"></i></a>';
                    }
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);

            }
       return view('vaccination.purchase-list');
    }
    public function purchase_details($id)
    {
        $id = ed($id, false);
        $data = VcPurchase::select(
            'vc_purchase.*',
            'v.vendor_name as vendor',
            'u.name as created_by'
        )
        ->join('vc_vendors  as v', 'v.id', '=', 'vc_purchase.vendor_id')
        ->join('users as u', 'u.id', '=', 'vc_purchase.generated_by')
        ->where('vc_purchase.id', $id)
        ->first();
        $vaccine_list = VcPurchaseDetail::select(
            'vc_purchase_details.*',
            'vc_vaccines.vaccine_name'
        )
       ->join('vc_vaccines','vc_vaccines.id','=','vc_purchase_details.vaccine_id')
        ->where('vc_purchase_details.purchase_id', $id)
        ->where('vc_purchase_details.is_delete', 0)
        ->get();
        $data = compact('data','vaccine_list');
        return view('vaccination.purchase-info')->with($data);
    }
    public function delete_purchase($id)
    {
        $id = ed($id, false);
        $data = VcPurchase::where('id',$id)->first();

        if ($data) {
            if($data->status == 1){
                return back()->with('error', "Stock Updated not Delete this Purchase!");
            }else{
                $data->update([
                    'is_delete' => 1
                ]);
                return redirect()->route('vc.listing-purchase')->with('success', 'The Purchase Deleted Successfully');
            }
        } else {
            return back()->with('error', "Something Went Wrong");
        }
    }
    public function stock_details(Request $request)
    {
        if ($request->ajax()) {

            $data = VcVaccineLot::select(
                    DB::raw('MAX(vc_vaccine_lots.id) as lot_id'),
                    'vc_vaccine_lots.vaccine_id',
                    DB::raw('SUM(vc_vaccine_lots.available_qty) as total_qty')
                )
                ->groupBy('vc_vaccine_lots.vaccine_id')
                ->orderBy('vc_vaccine_lots.id', 'DESC');

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('vaccine_info', function ($row) {
                    $atag = '<a href="'.route('vc.stock-info', ed($row->vaccine_id, true)).'" target="_blank" rel="noopener noreferrer">'.optional(VcVaccine::find($row->vaccine_id))->vaccine_name ?? '--'.'</a>';
                    return $atag;
                })
                ->addColumn('sub_unit', function ($row) {
                    return optional(VcVaccineLot::find($row->lot_id))->sub_unit ?? '';
                })
                ->addColumn('unit_relation', function ($row) {
                    $lot = VcVaccineLot::find($row->lot_id);
                    if ($lot && $lot->unit && $lot->sub_unit && $lot->unit_relation) {
                        return "1 {$lot->unit} = {$lot->unit_relation} {$lot->sub_unit}";
                    }
                    return '-';
                })
                ->addColumn('status', function ($row) {
                    if ($row->total_qty == 0) {
                        return '<span class="badge badge-gradient-secondary mt-2">Out Of Stock</span>';
                    } elseif ($row->total_qty <= 20) {
                        return '<span class="badge badge-gradient-warning mt-2">Low Stock</span>';
                    } else {
                        return '<span class="badge badge-gradient-success mt-2">Available</span>';
                    }
                })
                ->rawColumns(['status','vaccine_info'])
                ->make(true);
        }
        return view('vaccination.stock-list');
    }

    public function stock_info($vaccine_id)
    {
        $id = ed($vaccine_id, false);
        $vaccine_details = VcVaccine::
              where('vc_vaccines.id',$id)
            ->orderBy('vc_vaccines.id', 'DESC')
            ->first();

            if($vaccine_details){

                $stocks= VcVaccineLot::select(
                    'vc_vaccine_lots.*',
                    'vcp.*'
                )
                ->join('vc_purchase_details as vcp', 'vcp.id', '=', 'vc_vaccine_lots.purchase_details_id')
                ->where('vc_vaccine_lots.vaccine_id',$id)
                ->orderBy('vc_vaccine_lots.id', 'DESC')
                ->get()
                ->map(function ($item) {

                        $item->unit_price = $item->s_rate && $item->unit_relation
                            ? number_format(($item->s_rate / $item->unit_relation), 2)
                            : 'N/A';

                        return $item;
                    });

                 $issues= VcPatientVaccination::select(
                    'vc_patient_vaccinations.*',
                    'vl.vaccine_name',
                    'u.name as user_name',
                    'p.name as patient_name',
                    'p.uhid as patient_uhid'
                )
                ->join('vc_vaccines as vl', 'vl.id', '=', 'vc_patient_vaccinations.vaccine_id')
                ->join('users as u', 'u.id', '=', 'vc_patient_vaccinations.created_by')
                ->join('patients as p', 'p.id', '=', 'vc_patient_vaccinations.patient_id')
                ->where('vc_patient_vaccinations.vaccine_id', $id)
                ->where('vc_patient_vaccinations.status', 'completed')
                ->orderBy('vc_patient_vaccinations.id', 'DESC')
                ->get();
                //   dd($issues);
            }

        $data = compact('vaccine_details','stocks','issues');

        return view('vaccination.stock-info')->with($data);
    }
}
