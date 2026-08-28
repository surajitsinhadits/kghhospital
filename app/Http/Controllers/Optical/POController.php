<?php
namespace App\Http\Controllers\optical;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Yajra\Datatables\DataTables;
use App\Models\OpVendor;
use App\Models\OpItem;
use App\Models\OpPurchaseOrder;
use App\Models\OpPurchaseOrderItem;
use Illuminate\Http\Request;
use Exception;
use DB;

class POController extends Controller
{

    public function listing_purchase_order(Request $request)
    {
        if ($request->ajax()) {
            $data = OpPurchaseOrder::select(
                'op_purchase_orders.*',
                'v.vendor_name as vendor',
                'u.name as created_by'
            )
            ->join('op_vendors  as v', 'v.id', '=', 'op_purchase_orders.vendor_id')
            ->join('users as u', 'u.id', '=', 'op_purchase_orders.generated_by')
            ->where('op_purchase_orders.is_delete', 0)
            ->orderBy('op_purchase_orders.id', 'DESC');

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $actionBtn = '<a href="' . route('optical.purchase-order-details', ed($row->id, true)) . '" class="btn btn-sm btn-outline-info mx-1" title="View"><i class="bx bxs-info-circle"></i></a>';
                    if(!$row->status){
                        $actionBtn .= '<a href="'.route('optical.edit-purchase-order', ed($row->id, true)).'" class="btn btn-sm btn-outline-warning mx-1" title="Edit"><i class="bx bxs-edit"></i></a>';
                        $actionBtn .= '<a onclick="return confirm(\'Are you sure you want to delete this record?\');" href="' . route('optical.delete-purchase-order', ed($row->id, true)) . '" class="btn btn-sm btn-outline-danger mx-1" title="Delete"><i class="bx bxs-trash"></i></a>';
                    }
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
            }
       return view('optical.purchase-order-list');
    }
    public function add_purchase_order()
    {
        $title = "Add";
        $vendor = OpVendor::where('is_active','1')->orderBy('id', 'desc')->get();
        $item_list = OpItem::where('is_active','1')->where('is_delete','0')->orderBy('id', 'desc')->get();
        $data = compact('item_list','vendor','title');
        // dd($data);
        return view('optical.add-purchase-order')->with($data);
    }
    public function edit_purchase_order($id)
    {
        $id = ed($id, false);
        $title = "Edit";
        $vendor = OpVendor::where('is_active','1')->orderBy('id', 'desc')->get();
        $item_list = OpItem::where('is_active','1')->where('is_delete','0')->orderBy('id', 'desc')->get();
        $response = OpPurchaseOrder::where('id',$id)->first();
        $item_details = OpPurchaseOrderItem::select('op_purchase_order_items.*','op_items.sub_unit_no')
            ->join('op_items','op_items.id','=','op_purchase_order_items.item_id')
            ->where('op_purchase_order_items.po_id',$id)
            ->where('op_purchase_order_items.is_delete',0)
            ->get();
        $data = compact('response','vendor','item_list','item_details','title');
        // dd($data);
        return view('optical.add-purchase-order')->with($data);
    }
    public function purchase_order_details($id)
    {
        $id = ed($id, false);
        $data = OpPurchaseOrder::select(
                'op_purchase_orders.*',
                'v.vendor_name as vendor',
                'u.name as created_by'
            )
            ->join('op_vendors  as v', 'v.id', '=', 'op_purchase_orders.vendor_id')
            ->join('users as u', 'u.id', '=', 'op_purchase_orders.generated_by')
            ->where('op_purchase_orders.id', $id)
            ->first();
        $item_list = OpPurchaseOrderItem::select(
                'op_purchase_order_items.*',
                'op_items.item_name'
            )
            ->join('op_items', 'op_items.id', '=', 'op_purchase_order_items.item_id')
            ->where('op_purchase_order_items.po_id', $id)
            ->where('op_purchase_order_items.is_delete',0)
            ->get();
        $data = compact('data','item_list');
        return view('optical.purchase-order-info')->with($data);
    }
    public function update_purchase_order(Request $request, $id = 0)
    {
        $request->validate([
            'po_date' => 'required',
            'vendor_id' => 'required',
        ]);
        try {
            DB::beginTransaction();

            $po = $id ? OpPurchaseOrder::find($id) : new OpPurchaseOrder();
            $po->po_date = date('Y-m-d H:i:s', strtotime($request->po_date));
            $po->vendor_id = $request->vendor_id;
            $po->note = $request->note;
            if($id){
                $po->edit_by = Auth::user()->id;
                $po->edit_at = date('Y-m-d h:i:s');
            }else{
                $po->generated_by = Auth::user()->id;
            }
            $po->save();
            $po_id = $po->id;

            $existingItemIds = OpPurchaseOrderItem::where('po_id', $po_id)->pluck('id')->toArray();
            $submittedItemIds = $request->item_detail_id ?? [];
            $toDelete = array_diff($existingItemIds, $submittedItemIds);

            if (!empty($toDelete)) {
                OpPurchaseOrderItem::whereIn('id', $toDelete)->update(['is_delete' => 1]);
            }
            foreach ($request->item_id as $key => $item_id) {
                if($request->unit_qty[$key] == 0 && $request->sub_unit_qty[$key] == 0){
                    DB::rollback();
                    return back()->with('error', 'Unit & Subunit both are not zero');
                }
                $item_detail_id = $request->item_detail_id[$key]?? '';

                $item = $item_detail_id
                    ? OpPurchaseOrderItem::find($item_detail_id)
                    : new OpPurchaseOrderItem();

                $item->po_id           = $po_id;
                $item->item_id         = $item_id;
                $item->unit_qty        = $request->unit_qty[$key];
                $item->unit_id         = $request->unit_id[$key];
                $item->unit_name       = $request->unit_name[$key];
                $item->sub_unit_qty    = $request->sub_unit_qty[$key];
                $item->sub_unit_id     = $request->sub_unit_id[$key];
                $item->sub_unit_name   = $request->sub_unit_name[$key];
                $item->save();
            }

            DB::commit();
            return redirect()->route('optical.listing-purchase-order')->with('success', 'Purchase Order Saved Successfully!');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Something went wrong. Try again!');
        }
    }
    public function delete_purchase_order($id)
    {
        $id = ed($id, false);
        $data = OpPurchaseOrder::where('id',$id)->first();
        if ($data) {
            $data->update([
                'is_delete' => 1
            ]);
            return redirect()->route('optical.listing-purchase-order')->with('success', 'The Purchase Order Deleted Successfully');
        } else {
            return back()->with('error', "Something Went Wrong");
        }
    }
    public function get_po_details(Request $request)
    {
        $po_id = $request->po_id;
        $po = OpPurchaseOrder::find($po_id);
        if ($po) {
            $items = OpPurchaseOrderItem::select('op_purchase_order_items.*', 'op_items.item_name', 'op_items.sub_unit_no')
                ->join('op_items', 'op_items.id', '=', 'op_purchase_order_items.item_id')
                ->where('op_purchase_order_items.po_id', $po_id)
                ->where('op_purchase_order_items.is_delete', 0)
                ->get();
            return response()->json([
                'status' => true,
                'data' => [
                    'po_date' => date('Y-m-d', strtotime($po->po_date)),
                    'vendor_id' => $po->vendor_id,
                    'note' => $po->note,
                    'items' => $items
                ]
            ]);
        } else {
            return response()->json(['status' => false, 'message' => 'PO not found']);
        }
    }
}


