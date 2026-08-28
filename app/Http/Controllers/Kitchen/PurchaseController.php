<?php

namespace App\Http\Controllers\Kitchen;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Yajra\Datatables\DataTables;
use Illuminate\Http\Request;
use App\Models\KtSupplier;
use App\Models\KtItem;
use App\Models\KtPurchase;
use App\Models\KtPurchaseOrderItem;
use App\Models\KtPurchaseDetail;
use App\Models\KtPurchaseOrder;
use Exception;
use DB;

class PurchaseController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $baseQuery = KtPurchase::select(
                'kt_purchases.*',
                's.supplier',
                'u.name as created_by'
            )
            ->join('kt_suppliers  as s', 's.id', '=', 'kt_purchases.vendor_id')
            ->join('users as u', 'u.id', '=', 'kt_purchases.generated_by')
            ->where('kt_purchases.is_delete', 0)
            ->orderBy('kt_purchases.id', 'DESC');

            // Filter by data
            if (!empty($request->from_date)) {
                $baseQuery->whereDate('kt_purchases.date', '>=', date('Y-m-d', strtotime($request->from_date)));
            }
            if (!empty($request->to_date)) {
                $baseQuery->whereDate('kt_purchases.date', '<=', date('Y-m-d', strtotime($request->to_date)));
            }

            return Datatables::of($baseQuery)
                ->addIndexColumn()
                ->addColumn('purchase_info', function($row){
                    $html = '<span class="badge badge-gradient-success mt-2 me-1">' . $row->payment_terms . '</span>';
                    return $html;
                })
                ->addColumn('action', function($row){
                    $actionBtn = '<a href="' . route('kt.purchase-details', ed($row->id, true)) . '" class="btn btn-sm btn-outline-info mx-1" title="View"><i class="bx bxs-info-circle"></i></a>';
                    if($row->is_stock == 0){
                        $actionBtn .= '<a href="' . route('kt.edit-purchase', ed($row->id, true)) . '" class="btn btn-sm btn-outline-warning mx-1" title="Edit"><i class="bx bxs-edit"></i></a>';
                        $actionBtn .= '<a onclick="return confirm(\'Are you sure you want to delete this record?\');" href="' . route('kt.delete-purchase', ed($row->id, true)) . '" class="btn btn-sm btn-outline-danger mx-1" title="Delete"><i class="bx bxs-trash"></i></a>';
                    }
                    return $actionBtn;
                })
                ->rawColumns(['action','purchase_info'])
                ->make(true);
            }
        return view('kitchen.purchase-list');
    }
    public function add_purchase(Request $request)
    {
        $title = 'Add Purchase';
        $vendor = KtSupplier::where('status','0')->orderBy('id', 'desc')->get();
        $po = KtPurchaseOrder::where('status',0)->where('is_delete',0)->get();
        $item_list = KtItem::where('status',0)->orderBy('id', 'DESC')->get();
        // $item_list = KtPurchaseOrderItem::select(
        //     'kt_purchase_order_items.item_id as id',
        //     'kt_items.item_name'
        // )
        // ->join('kt_items', 'kt_purchase_order_items.item_id', '=', 'kt_items.id')
        // ->where('kt_purchase_order_items.is_delete',0)
        // ->groupBy('kt_purchase_order_items.item_id', 'kt_items.item_name')
        // ->orderBy('kt_purchase_order_items.id', 'DESC')
        // ->get();

        $data = compact('vendor','item_list','title','po');
        return view('kitchen.purchase-form')->with($data);
    }
    public function edit_purchase($id)
    {
        $id = ed($id, false);
        $edit = KtPurchase::where('id', $id)->where('is_delete', 0)->first();
        if($edit->status == 1){
            return back()->with('error', "Stock Updated not Edit this Purchase!");
        }
        $edit_info = KtPurchaseDetail::select('kt_purchase_details.*','kt_items.item_name')
            ->join('kt_items','kt_items.id','=','kt_purchase_details.item_id')
            ->where('kt_purchase_details.purchase_id', $id)
            ->where('kt_purchase_details.is_delete', 0)
            ->get();
        $title = 'Edit Purchase';
        $vendor = KtSupplier::where('status','0')->orderBy('id', 'desc')->get();
        $po = KtPurchaseOrder::where('status',0)->where('is_delete',0)->get();
        $item_list = KtItem::where('status','0')->orderBy('id', 'DESC')->get();
        // $item_list = KtPurchaseOrderItem::select(
        //     'kt_purchase_order_items.item_id as id',
        //     'kt_items.item_name'
        // )
        // ->join('kt_items', 'kt_purchase_order_items.item_id', '=', 'kt_items.id')
        // ->where('kt_purchase_order_items.is_delete',0)
        // ->groupBy('kt_purchase_order_items.item_id', 'kt_items.item_name')
        // ->orderBy('kt_purchase_order_items.id', 'DESC')
        // ->get();

        $data = compact('vendor','item_list','title','edit','edit_info','po');
        return view('kitchen.purchase-form')->with($data);
    }
    public function purchase_details($id)
    {
        $id = ed($id, false);
        $data = KtPurchase::select(
            'kt_purchases.*',
            's.supplier',
            'u.name as created_by'
        )
        ->join('kt_suppliers  as s', 's.id', '=', 'kt_purchases.vendor_id')
        ->join('users as u', 'u.id', '=', 'kt_purchases.generated_by')
        ->where('kt_purchases.id', $id)
        ->first();
        $item_list = KtPurchaseDetail::select(
            'kt_purchase_details.*',
            'kt_items.item_name'
        )
        ->join('kt_items', 'kt_items.id', '=', 'kt_purchase_details.item_id')
        ->where('kt_purchase_details.purchase_id', $id)
        ->where('kt_purchase_details.is_delete', 0)
        ->get();
        $data = compact('data','item_list');
        return view('kitchen.purchase-info')->with($data);
    }
    public function update_purchase(Request $request, $id = 0)
    {
        $request->validate([
            'date' => 'required',
            'invoice_no' => 'required',
            'vendor_id' => 'required',
        ]);
        try {
            DB::beginTransaction();

            $purchase = $id ? KtPurchase::find($id) : new KtPurchase();
            $purchase->po_id = $request->po_id;
            $purchase->date = date('Y-m-d H:i:s',strtotime($request->date));
            $purchase->vendor_id = $request->vendor_id;
            $purchase->invoice_no = $request->invoice_no;
            $purchase->total = $request->total;
            $purchase->sub_total = $request->sub_total;
            $purchase->total_gst_amount = $request->total_gst_amount;
            $purchase->note = $request->note;
            $purchase->discount_amount = (($request->sub_total + $request->total_gst_amount) - $request->total) ?? 0.00;
            $purchase->discount_value = $request->total_discount_amount ?? 0.00;
            $purchase->discount_type = $request->discount_type;
            $purchase->payment_terms = $request->payment_terms;
            if($id){
                $purchase->edit_by = Auth::user()->id;
                $purchase->edit_at = date('Y-m-d h:i:s');
            }else{
                $purchase->generated_by = Auth::user()->id;
            }
            $purchase->is_stock = (int)$request->action_type;
            $purchase->save();
            $purchase_id = $purchase->id;
            if (!empty($request->uppid) && is_array($request->uppid)) {
                KtPurchaseDetail::where('purchase_id', $purchase_id)
                    ->whereNotIn('id', $request->uppid)
                    ->update(['is_delete' => 1]);
            }
            foreach ($request->item_name as $key => $items) {
                if(@$request->uppid[$key]){
                    $purchase_details = KtPurchaseDetail::find($request->uppid[$key]);
                }else{
                    $purchase_details = new KtPurchaseDetail();
                }
                $purchase_details->purchase_id = $purchase_id;
                $purchase_details->item_id = $request->item_name[$key];
                $purchase_details->unit_qty = $request->unit_qty[$key];
                $purchase_details->unit = $request->unit[$key];
                $purchase_details->exp_date = $request->exp_date[$key];
                $purchase_details->rate = $request->rate[$key];
                $purchase_details->mrp = $request->mrp[$key];
                $purchase_details->net_amount = $request->net_amount[$key];
                $purchase_details->discount_percentage = $request->discount_percentage[$key];
                $purchase_details->discount_amount = $request->discount_amount[$key];
                $purchase_details->gst = $request->gst[$key];
                $purchase_details->gst_amount = $request->gst_amount[$key];
                $purchase_details->amount = $request->amount[$key];
                $purchase_details->save();
            }
            DB::commit();
            return redirect()->route('kt.purchase')->with('success', 'Purchase Saved Successfully!');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Something went wrong. Try again!');
        }
    }
    public function delete_purchase($id)
    {
        $id = ed($id, false);
        $data = KtPurchase::where('id',$id)->first();

        if ($data) {
            if($data->status == 1){
                return back()->with('error', "Stock Updated not Delete this Purchase!");
            }else{
                $data->update([
                    'is_delete' => 1
                ]);
                return redirect()->route('kt.purchase')->with('success', 'The Purchase Deleted Successfully');
            }
        } else {
            return back()->with('error', "Something Went Wrong");
        }
    }
}
