<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Yajra\Datatables\DataTables;
use App\Models\StVendor;
use App\Models\StItem;
use App\Models\StPurchase;
use App\Models\StStock;
use App\Models\StPurchaseOrderItem;
use App\Models\StPurchaseDetail;
use App\Models\StPurchaseOrder;
use App\Models\StPresentStock;
use Illuminate\Http\Request;
use Exception;
use DB;
use App\Models\StStore;
use App\Models\Header;

class PurchaseController extends Controller
{
    public function listing_purchase(Request $request)
{
    if ($request->ajax()) {

        $data = StPurchase::select(
                'st_purchases.*',
                'v.vendor_name as vendor',
                'u.name as created_by',
                'po.fy_po_no as po_no'
            )
            ->leftJoin('st_purchase_orders as po', 'po.id', '=', 'st_purchases.po_id')
            ->leftJoin('st_vendors as v', 'v.id', '=', 'st_purchases.vendor_id')
            ->join('users as u', 'u.id', '=', 'st_purchases.generated_by')
            ->where('st_purchases.is_delete', 0)
            ->orderBy('st_purchases.id', 'DESC');

        return Datatables::of($data)
            ->addIndexColumn()

            // ✅ Payment Terms column updated (Paid/Due amount)
            ->addColumn('purchase_info', function ($row) {

                $subTotal   = (float) ($row->sub_total ?? 0);
                $cgstTotal  = (float) ($row->total_cgst_amount ?? 0);
                $sgstTotal  = (float) ($row->total_sgst_amount ?? 0);
                $igstTotal  = (float) ($row->total_igst_amount ?? 0);
                $grossTotal = $subTotal + $cgstTotal + $sgstTotal + $igstTotal;
                $discType   = strtolower(trim((string) ($row->discount_type ?? '')));
                $discVal    = (float) ($row->discount_amount ?? 0);
                $paidAmount = (float) ($row->vendor_pay_amount ?? 0);

                // discount calculation
                if ($discType === 'percentage' || $discType === '%') {
                    $discount = ($grossTotal * $discVal) / 100;
                } else { // rs / flat
                    $discount = $discVal;
                }

                if ($discount < 0) $discount = 0;
                if ($discount > $grossTotal) $discount = $grossTotal;

                $netTotal = $grossTotal - $discount;
                $due      = $netTotal - $paidAmount;

                $fmt = function ($n) {
                    return number_format((float)$n, 2);
                };

                // existing badges (payment term + direct/by PO)
                $html = '';
                // if (!empty($row->payment_terms)) {
                //     $html .= '<span class="badge badge-gradient-success mt-2 me-1">' . e($row->payment_terms) . '</span>';
                // }

                // if (empty($row->po_id)) {
                //     $html .= '<span class="badge badge-gradient-primary mt-2 mx-1">Direct Purchase</span>';
                // } else {
                //     $html .= '<span class="badge badge-gradient-primary mt-2 mx-1">By Purchase Order</span>';
                // }

                // ✅ Paid / Due badge
                if ($due > 0.009) {
                    $html .= '<span class="badge badge-gradient-danger mt-2 mx-1">Due ₹' . $fmt($due) . '</span>';
                } else {
                    $html .= '<span class="badge badge-gradient-info mt-2 mx-1">Paid</span>';
                }

                return $html;
            })

            ->addColumn('action', function ($row) {
                $actionBtn = '<a href="' . route('store.purchase-details', ed($row->id, true)) . '" class="btn btn-sm btn-outline-info mx-1" title="View"><i class="bx bxs-info-circle"></i></a>';

                if ((int)$row->status === 0) {
                    $actionBtn .= '<a href="' . route('store.edit-purchase', ed($row->id, true)) . '" class="btn btn-sm btn-outline-warning mx-1" title="Edit"><i class="bx bxs-edit"></i></a>';
                    $actionBtn .= '<a onclick="return confirm(\'Are you sure you want to delete this record?\');" href="' . route('store.delete-purchase', ed($row->id, true)) . '" class="btn btn-sm btn-outline-danger mx-1" title="Delete"><i class="bx bxs-trash"></i></a>';
                } else {
                    $actionBtn .= '<a target="_blank" href="' . route('store.print-purchase', ed($row->id, true)) . '" class="btn btn-sm btn-outline-info mx-1" title="Print"><i class="fa fa-print"></i></a>';
                }

                return $actionBtn;
            })

            ->rawColumns(['action', 'purchase_info'])
            ->make(true);
    }

    return view('store.purchase-list');
}
    public function add_purchase(Request $request)
    {
        $type = $request->query('type');
        $title = $type === 'indirect' ? 'Add Indirect Purchase' : 'Add Direct Purchase';
        $vendor = StVendor::where('is_active','1')->orderBy('id', 'desc')->get();
        $store = StStore::where('status','0')->orderBy('id', 'desc')->get();
        $po = StPurchaseOrder::where('vendor_id','!=','0')->where('status',0)->where('is_delete',0)->get();
        if($type === 'direct'){
            $item_list = StItem::where('is_active','1')->where('is_delete',0)->orderBy('id', 'DESC')->get();
        }else{
            $item_list = StPurchaseOrderItem::select(
                'st_purchase_order_items.item_id as id',
                'st_items.item_name'
            )
            ->join('st_items', 'st_purchase_order_items.item_id', '=', 'st_items.id')
            ->where('st_purchase_order_items.is_delete',0)
            ->groupBy('st_purchase_order_items.item_id', 'st_items.item_name')
            ->orderBy('st_purchase_order_items.id', 'DESC')
            ->get();
        }

        $data = compact('vendor','item_list','title','type','po', 'store');
        return view('store.add-purchase')->with($data);
    }
    public function edit_purchase($id)
    {
        $id = ed($id, false);
        $edit = StPurchase::where('id', $id)->where('is_delete', 0)->first();
        if($edit->status == 1){
            return back()->with('error', "Stock Updated not Edit this Purchase!");
        }
        $edit_info = StPurchaseDetail::select('st_purchase_details.*','st_items.item_name','st_items.sub_unit_no')
            ->join('st_items','st_items.id','=','st_purchase_details.item_id')
            ->where('st_purchase_details.purchase_id', $id)
            ->where('st_purchase_details.is_delete', 0)
            ->get();
        $type = $edit->type;
        $title = $type === 'indirect' ? 'Edit Indirect Purchase' : 'Edit Direct Purchase';
        $vendor = StVendor::where('is_active','1')->orderBy('id', 'desc')->get();
        $po = StPurchaseOrder::where('vendor_id','!=','0')->where('status',0)->where('is_delete',0)->get();
        $store = StStore::where('status','0')->orderBy('id', 'desc')->get();
        if($type === 'direct'){
            $item_list = StItem::where('is_active','1')->where('is_delete',0)->orderBy('id', 'DESC')->get();
        }else{
            $item_list = StPurchaseOrderItem::select(
                'st_purchase_order_items.item_id as id',
                'st_items.item_name'
            )
            ->join('st_items', 'st_purchase_order_items.item_id', '=', 'st_items.id')
            ->where('st_purchase_order_items.is_delete',0)
            ->groupBy('st_purchase_order_items.item_id', 'st_items.item_name')
            ->orderBy('st_purchase_order_items.id', 'DESC')
            ->get();
        }

        $data = compact('vendor','item_list','title','type','edit','edit_info','po','store');
        return view('store.add-purchase')->with($data);
    }
    public function purchase_details($id)
    {
        $id = ed($id, false);
        $data = StPurchase::select(
            'st_purchases.*',
            'v.vendor_name as vendor',
            'u.name as created_by'
        )
        ->leftJoin('st_vendors  as v', 'v.id', '=', 'st_purchases.vendor_id')
        ->join('users as u', 'u.id', '=', 'st_purchases.generated_by')
        ->where('st_purchases.id', $id)
        ->first();
        $item_list = StPurchaseDetail::select(
            'st_purchase_details.*',
            'st_items.item_name'
        )
        ->join('st_items', 'st_items.id', '=', 'st_purchase_details.item_id')
        ->where('st_purchase_details.purchase_id', $id)
        ->where('st_purchase_details.is_delete', 0)
        ->get();
        $data = compact('data','item_list');
        return view('store.purchase-info')->with($data);
    }
    public function update_purchase(Request $request, $id = 0)
    {

        // dd($request->all());

        if($request->type == 'indirect'){
            $request->validate([
                'date'              => 'required',
                'vendor_id'         => 'required',
                'store_id'          => 'required',
                'part_no.*'         => 'required',
                'unit_qty.*'        => 'required|numeric',
                'sub_unit_qty.*'    => 'required|numeric',
                'rate.*'            => 'required|numeric',
            ]);
        }else{
            $request->validate([
                'date'              => 'required',
                'store_id'          => 'required',
                'part_no.*'         => 'required',
                'unit_qty.*'        => 'required|numeric',
                'sub_unit_qty.*'    => 'required|numeric',
                'rate.*'            => 'required|numeric',
            ]);
        }

        try {
            DB::beginTransaction();

            $purchase = $id ? StPurchase::find($id) : new StPurchase();
            $purchase->date = date('Y-m-d H:i:s',strtotime($request->date));
            $purchase->vendor_id = $request->vendor_id;
            $purchase->invoice_no = $request->invoice_no;
            if($request->type == 'indirect'){
                $purchase->po_id = $request->po_id;
            }
            $purchase->store_id = $request->store_id;
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
            $purchase->type = $request->type;
            $purchase->status = (int)$request->action_type;
            $purchase->save();
            $purchase_id = $purchase->id;
            if (!empty($request->uppid) && is_array($request->uppid)) {
                StPurchaseDetail::where('purchase_id', $purchase_id)
                    ->whereNotIn('id', $request->uppid)
                    ->update(['is_delete' => 1]);
            }
            foreach ($request->item_name as $key => $items) {
                if(@$request->uppid[$key]){
                    $purchase_details = StPurchaseDetail::find($request->uppid[$key]);
                }else{
                    $purchase_details = new StPurchaseDetail();
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

                // print_r($request->all());die;

                if($request->grn_status == 1 && $request->type == 'indirect'){
                    StPurchaseOrder::where('id', $request->po_id)->update([
                        'status' => 1
                    ]);
                }

                foreach ($request->item_name as $key => $items) {

                    $type_id = optional(StItem::where('id', $request->item_name[$key])->first())->type_id;
                    $unit_sub_no = optional(StItem::where('id', $request->item_name[$key])->first())->sub_unit_no;
                    $total_qty = $request->unit_qty[$key] * $unit_sub_no + $request->sub_unit_qty[$key];

                    /* Start Item asset no */
                    if( $type_id == 6 || $type_id == 8 ){

                        for( $i = 0; $i < $total_qty; $i++ ){
                            $newCode = DB::table('st_asset_no')->where('item_id', $request->item_name[$key])->max('asset_int_no') + 1;
                            DB::table('st_asset_no')->insert(['item_id' => $request->item_name[$key], 'asset_int_no' => $newCode, 'asset_no' => 'RN#'.$newCode]);
                        }

                    }

                    /* Start Item asset no */

                    $stock = new StStock();
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
                    $stock->unit_sub_no = $unit_sub_no;
                    $stock->unit_mrp = $request->mrp[$key];
                    $stock->unit_rate = $request->rate[$key];
                    $stock->generated_by = Auth::user()->id;
                    $stock->present_qty = $total_qty;
                    $stock->save();

                    // Calculate present stock
                    $present = StPresentStock::where('item_id', $request->item_name[$key])->where('type', 'stock')->first();
                    if($present){
                        $new_total_qty = $present->present_total + $total_qty;
                        $present_stock = StPresentStock::find($present->id);
                    }else{
                        $new_total_qty = $total_qty;
                        $present_stock = New StPresentStock();
                        $present_stock->item_id = $request->item_name[$key];
                    }
                    $pre_unit = (int)($new_total_qty / $unit_sub_no);
                    $pre_sub_unit = $new_total_qty % $unit_sub_no;

                    $present_stock->present_unit_qty = $pre_unit;
                    $present_stock->present_subunit_qty = $pre_sub_unit;
                    $present_stock->present_total = $new_total_qty;
                    $present_stock->type = 'stock';
                    $present_stock->save();

                    if($request->type == 'indirect'){
                        $po = StPurchaseOrderItem::where('po_id', $request->po_id)->where('item_id', $request->item_name[$key])->first();
                        $po->punit_qty = $po->punit_qty + $request->unit_qty[$key];
                        $po->psubunit_qty = $po->psubunit_qty + $request->sub_unit_qty[$key];
                        $po->update();
                    }
                }
            }
            DB::commit();
            return redirect()->route('store.listing-purchase')->with('success', 'Purchase Saved Successfully!');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Something went wrong. Try again!');
        }
    }
    public function delete_purchase($id)
    {
        $id = ed($id, false);
        $data = StPurchase::where('id',$id)->first();

        if ($data) {
            if($data->status == 1){
                return back()->with('error', "Stock Updated not Delete this Purchase!");
            }else{
                $data->update([
                    'is_delete' => 1
                ]);
                return redirect()->route('store.listing-purchase')->with('success', 'The Purchase Deleted Successfully');
            }
        } else {
            return back()->with('error', "Something Went Wrong");
        }
    }

    public function print_purchase($id)
    {
        $id = ed($id, false);
        $data = StPurchase::select(
            'st_purchases.*',
            'v.vendor_name as vendor',
            'u.name as created_by'
        )
        ->leftJoin('st_vendors  as v', 'v.id', '=', 'st_purchases.vendor_id')
        ->join('users as u', 'u.id', '=', 'st_purchases.generated_by')
        ->where('st_purchases.id', $id)
        ->first();
        $item_list = StPurchaseDetail::select(
            'st_purchase_details.*',
            'st_items.item_name'
        )
        ->join('st_items', 'st_items.id', '=', 'st_purchase_details.item_id')
        ->where('st_purchase_details.purchase_id', $id)
        ->where('st_purchase_details.is_delete', 0)
        ->get();

        $header_image = Header::where('header_name', 'opd_prescription')->first();
        $back = route('store.listing-purchase');

        $data = compact('data','item_list', 'header_image', 'back');
        return view('store.print.print-purchase')->with($data);
    }

     public function makePayment(Request $request, $id){

        $request->validate([
            'pay_amount' => 'required|numeric|min:0.01',
            'discount_amount' => 'required|numeric|min:0',
        ]);

        $payAmount = (float) $request->pay_amount;
        $discountAmount = max(0, (float) $request->discount_amount);

        $purchase = StPurchase::findOrFail($id);

        // Only allow if status == 1
        if ((int)$purchase->status !== 1) {
            return response()->json([
                'status' => false,
                'message' => 'Payment is not allowed for this purchase.'
            ], 422);
        }

        $subTotal = (float) ($purchase->sub_total ?? 0);
        $cgstTotal = (float) ($purchase->total_cgst_amount ?? 0);
        $sgstTotal = (float) ($purchase->total_sgst_amount ?? 0);
        $igstTotal = (float) ($purchase->total_igst_amount ?? 0);
        $grossTotal = $subTotal + $cgstTotal + $sgstTotal + $igstTotal;
        $discountType = strtolower(trim((string) ($purchase->discount_type ?? '')));
        $discountType = $discountType === 'percentage' ? 'percentage' : 'rs';

        $discountValue = 0.0;
        if ($discountType === 'percentage') {
            $discountValue = ($grossTotal * $discountAmount) / 100;
        } else {
            $discountValue = $discountAmount;
        }

        $discountValue = max($discountValue, 0);
        $discountValue = min($discountValue, $grossTotal);

        $netTotal = max($grossTotal - $discountValue, 0);

        $paid  = (float) ($purchase->vendor_pay_amount ?? 0);
        $due   = max($netTotal - $paid, 0);

        if ($due <= 0) {
            return response()->json([
                'status' => false,
                'message' => 'No due amount remaining.'
            ], 422);
        }

        if ($payAmount > $due) {
            return response()->json([
                'status' => false,
                'message' => 'Pay amount cannot be greater than due amount.'
            ], 422);
        }

        DB::transaction(function () use ($purchase, $payAmount, $paid, $netTotal, $discountAmount) {
            $newPaid = $paid + $payAmount;
            if ($newPaid > $netTotal) {
                $newPaid = $netTotal;
            }

            $purchase->vendor_pay_amount = $newPaid;
            $purchase->discount_amount = $discountAmount;
            $purchase->edit_by = auth()->id() ?? $purchase->edit_by;
            $purchase->edit_at = now();
            $purchase->save();
        });

        return response()->json([
            'status' => true,
            'message' => 'Payment saved successfully.'
        ]);
    }

}
