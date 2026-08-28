<?php

namespace App\Http\Controllers\Optical;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Yajra\Datatables\DataTables;
use App\Models\OpVendor;
use App\Models\OpItem;
use App\Models\OpPurchase;
use App\Models\OpStock;
use App\Models\OpPurchaseOrderItem;
use App\Models\OpPurchaseDetail;
use App\Models\OpPurchaseOrder;
use Illuminate\Http\Request;
use Exception;
use DB;

class PurchaseController extends Controller
{
    public function listing_purchase(Request $request)
    {
        if ($request->ajax()) {
            $data = OpPurchase::select(
                'op_purchases.*',
                'v.vendor_name as vendor',
                'u.name as created_by'
            )
            ->join('op_vendors  as v', 'v.id', '=', 'op_purchases.vendor_id')
            ->join('users as u', 'u.id', '=', 'op_purchases.generated_by')
            ->where('op_purchases.is_delete', 0)
            ->orderBy('op_purchases.id', 'DESC');

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('purchase_info', function($row){
                    $html = '<span class="badge badge-gradient-success mt-2 me-1">' . $row->payment_terms . '</span>';
                    $html .= '<span class="badge badge-gradient-primary mt-2 mx-1">By Purchase Order</span>';
                    return $html;
                })
                ->addColumn('action', function($row){
                    $actionBtn = '<a href="' . route('optical.purchase-details', ed($row->id, true)) . '" class="btn btn-sm btn-outline-info mx-1" title="View"><i class="bx bxs-info-circle"></i></a>';
                    if($row->status == 0){
                        $actionBtn .= '<a href="' . route('optical.edit-purchase', ed($row->id, true)) . '" class="btn btn-sm btn-outline-warning mx-1" title="Edit"><i class="bx bxs-edit"></i></a>';
                        $actionBtn .= '<a onclick="return confirm(\'Are you sure you want to delete this record?\');" href="' . route('store.delete-purchase', ed($row->id, true)) . '" class="btn btn-sm btn-outline-danger mx-1" title="Delete"><i class="bx bxs-trash"></i></a>';
                    }
                    return $actionBtn;
                })
                ->rawColumns(['action','purchase_info'])
                ->make(true);
            }
       return view('optical.purchase-list');
    }
    public function add_purchase(Request $request)
    {
        $title = 'Add Purchase';
        $vendor = OpVendor::where('is_active','1')->orderBy('id', 'desc')->get();
        $po = OpPurchaseOrder::where('status',0)->where('is_delete',0)->get();
        $item_list = OpPurchaseOrderItem::select(
            'op_purchase_order_items.item_id as id',
            'op_items.item_name'
        )
        ->join('op_items', 'op_purchase_order_items.item_id', '=', 'op_items.id')
        ->where('op_purchase_order_items.is_delete',0)
        ->groupBy('op_purchase_order_items.item_id', 'op_items.item_name')
        ->orderBy('op_purchase_order_items.id', 'DESC')
        ->get();

        $data = compact('vendor','item_list','title','po');
        return view('optical.add-purchase')->with($data);
    }
    public function edit_purchase($id)
    {
        $id = ed($id, false);
        $edit = OpPurchase::where('id', $id)->where('is_delete', 0)->first();
        if($edit->status == 1){
            return back()->with('error', "Stock Updated not Edit this Purchase!");
        }
        $edit_info = OpPurchaseDetail::select('op_purchase_details.*','op_items.item_name','op_items.sub_unit_no')
            ->join('op_items','op_items.id','=','op_purchase_details.item_id')
            ->where('op_purchase_details.purchase_id', $id)
            ->where('op_purchase_details.is_delete', 0)
            ->get();
        $type = $edit->type;
        $title = $type === 'indirect' ? 'Edit Indirect Purchase' : 'Edit Direct Purchase';
        $vendor = OpVendor::where('is_active','1')->orderBy('id', 'desc')->get();
        $po = OpPurchaseOrder::where('status',0)->where('is_delete',0)->get();
        if($type === 'direct'){
            $item_list = OpItem::where('is_active','1')->where('is_delete',0)->orderBy('id', 'DESC')->get();
        }else{
            $item_list = OpPurchaseOrderItem::select(
                'op_purchase_order_items.item_id as id',
                'op_items.item_name'
            )
            ->join('op_items', 'op_purchase_order_items.item_id', '=', 'op_items.id')
            ->where('op_purchase_order_items.is_delete',0)
            ->groupBy('op_purchase_order_items.item_id', 'op_items.item_name')
            ->orderBy('op_purchase_order_items.id', 'DESC')
            ->get();
        }

        $data = compact('vendor','item_list','title','type','edit','edit_info','po');
        return view('optical.add-purchase')->with($data);
    }
    public function purchase_details($id)
    {
        $id = ed($id, false);
        $data = OpPurchase::select(
            'op_purchases.*',
            'v.vendor_name as vendor',
            'u.name as created_by'
        )
        ->join('op_vendors  as v', 'v.id', '=', 'op_purchases.vendor_id')
        ->join('users as u', 'u.id', '=', 'op_purchases.generated_by')
        ->where('op_purchases.id', $id)
        ->first();
        $item_list = OpPurchaseDetail::select(
            'op_purchase_details.*',
            'op_items.item_name'
        )
        ->join('op_items', 'op_items.id', '=', 'op_purchase_details.item_id')
        ->where('op_purchase_details.purchase_id', $id)
        ->where('op_purchase_details.is_delete', 0)
        ->get();
        $data = compact('data','item_list');
        return view('optical.purchase-info')->with($data);
    }
    public function update_purchase(Request $request, $id = 0)
    {
        $request->validate([
            'date' => 'required',
            'invoice_no' => 'required',
            'vendor_id' => 'required',
            'part_no.*' => 'required',
            'unit_qty.*' => 'required|numeric',
            'sub_unit_qty.*' => 'required|numeric',
            'rate.*' => 'required|numeric',
        ]);
        try {
            DB::beginTransaction();

            $purchase = $id ? OpPurchase::find($id) : new OpPurchase();
            $purchase->date = date('Y-m-d H:i:s',strtotime($request->date));
            $purchase->vendor_id = $request->vendor_id;
            $purchase->invoice_no = $request->invoice_no;
            $purchase->po_id = $request->po_id;
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
                OpPurchaseDetail::where('purchase_id', $purchase_id)
                    ->whereNotIn('id', $request->uppid)
                    ->update(['is_delete' => 1]);
            }
            foreach ($request->item_name as $key => $items) {
                if(@$request->uppid[$key]){
                    $purchase_details = OpPurchaseDetail::find($request->uppid[$key]);
                }else{
                    $purchase_details = new OpPurchaseDetail();
                }
                $purchase_details->purchase_id = $purchase_id;
                $purchase_details->item_id = $request->item_name[$key];
                $purchase_details->unit_qty = $request->unit_qty[$key];
                $purchase_details->sub_unit_qty = $request->sub_unit_qty[$key];
                $purchase_details->sub_unit = $request->sub_unit[$key];
                $purchase_details->unit = $request->unit[$key];
                $purchase_details->part_no = $request->part_no[$key];
                $purchase_details->test_qty = $request->test_qty[$key];
                $purchase_details->exp_date = $request->exp_date[$key];
                $purchase_details->rate = $request->rate[$key];
                $purchase_details->mrp = $request->mrp[$key];
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
                if($request->grn_status == 1){
                    OpPurchaseOrder::where('id', $request->po_id)->update([
                        'status' => 1
                    ]);
                }
                foreach ($request->item_name as $key => $items) {
                    $sub_unit_no = optional(OpItem::where('id', $request->item_name[$key])->first())->sub_unit_no;
                    $stock = new OpStock();
                    $stock->po_id = $purchase_id;
                    $stock->date = date('Y-m-d h:i:s');
                    $stock->item_id = $request->item_name[$key];
                    $stock->exp_date = $request->exp_date[$key];
                    $stock->part_no = $request->part_no[$key];
                    $stock->total = $request->amount[$key];
                    $stock->sub_total = $request->net_amount[$key];
                    $stock->cgst = $request->cgst[$key];
                    $stock->cgst_value = $request->cgst_amount[$key];
                    $stock->sgst = $request->sgst[$key];
                    $stock->sgst_value = $request->sgst_amount[$key];
                    $stock->igst = $request->igst[$key];
                    $stock->igst_value = $request->igst_amount[$key];
                    $stock->unit_qty = $request->unit_qty[$key];
                    $stock->unit = $request->unit[$key];
                    $stock->sub_unit_qty = $request->sub_unit_qty[$key];
                    $stock->sub_unit = $request->sub_unit[$key];
                    $stock->unit_sub_no = $sub_unit_no;
                    $stock->unit_mrp = $request->mrp[$key];
                    $stock->unit_rate = $request->rate[$key];
                    $stock->generated_by = Auth::user()->id;
                    $stock->total_qty = ($request->unit_qty[$key] * $sub_unit_no) + $request->sub_unit_qty[$key];
                    $stock->save();

                    $po = OpPurchaseOrderItem::where('po_id', $request->po_id)->where('item_id', $request->item_name[$key])->first();
                    $po->punit_qty = $po->punit_qty + $request->unit_qty[$key];
                    $po->psubunit_qty = $po->psubunit_qty + $request->sub_unit_qty[$key];
                    $po->update();
                }
            }
            DB::commit();
            return redirect()->route('optical.listing-purchase')->with('success', 'Purchase Saved Successfully!');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Something went wrong. Try again!');
        }
    }
    public function delete_purchase($id)
    {
        $id = ed($id, false);
        $data = OpPurchase::where('id',$id)->first();

        if ($data) {
            if($data->status == 1){
                return back()->with('error', "Stock Updated not Delete this Purchase!");
            }else{
                $data->update([
                    'is_delete' => 1
                ]);
                return redirect()->route('optical.listing-purchase')->with('success', 'The Purchase Deleted Successfully');
            }
        } else {
            return back()->with('error', "Something Went Wrong");
        }
    }
}


