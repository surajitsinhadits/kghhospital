<?php

namespace App\Http\Controllers\Kitchen;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Yajra\Datatables\DataTables;
use Illuminate\Http\Request;
use App\Models\KtSupplier;
use App\Models\KtItem;
use App\Models\KtPurchaseOrder;
use App\Models\KtPurchaseOrderItem;
use Exception;
use DB;

class POController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $baseQuery = KtPurchaseOrder::select(
                'kt_purchase_orders.*',
                's.supplier',
                'u.name as created_by'
            )
            ->join('kt_suppliers  as s', 's.id', '=', 'kt_purchase_orders.vendor_id')
            ->join('users as u', 'u.id', '=', 'kt_purchase_orders.generated_by')
            ->where('kt_purchase_orders.is_delete', 0)
            ->orderBy('kt_purchase_orders.id', 'DESC');

            // Filter by data
            if (!empty($request->from_date)) {
                $baseQuery->whereDate('kt_purchase_orders.po_date', '>=', date('Y-m-d', strtotime($request->from_date)));
            }
            if (!empty($request->to_date)) {
                $baseQuery->whereDate('kt_purchase_orders.po_date', '<=', date('Y-m-d', strtotime($request->to_date)));
            }

            return Datatables::of($baseQuery)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $actionBtn = '<a href="' . route('kt.purchase-order-details', ed($row->id, true)) . '" class="btn btn-sm btn-outline-info mx-1" title="View"><i class="bx bxs-info-circle"></i></a>';
                    $actionBtn .= '<a href="'.route('kt.edit-purchase-order', ed($row->id, true)).'" class="btn btn-sm btn-outline-warning mx-1" title="Edit"><i class="bx bxs-edit"></i></a>';
                    $actionBtn .= '<a onclick="return confirm(\'Are you sure you want to delete this record?\');" href="' . route('kt.delete-purchase-order', ed($row->id, true)) . '" class="btn btn-sm btn-outline-danger mx-1" title="Delete"><i class="bx bxs-trash"></i></a>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
            }
       return view('kitchen.purchase-order-list');
    }
    public function add_purchase_order()
    {
        $title = "Add";
        $vendor = KtSupplier::where('status','0')->get();
        $item_list = KtItem::where('status','0')->orderBy('id', 'desc')->get();
        $data = compact('item_list','vendor','title');
        // dd($data);
        return view('kitchen.purchase-order-form')->with($data);
    }
    public function edit_purchase_order($id)
    {
        $id = ed($id, false);
        $title = "Edit";
        $vendor = KtSupplier::where('status','0')->orderBy('id', 'desc')->get();
        $item_list = KtItem::where('status','0')->orderBy('id', 'desc')->get();
        $response = KtPurchaseOrder::where('id',$id)->first();
        $item_details = KtPurchaseOrderItem::where('po_id',$id)->where('is_delete',0)->get();
        $data = compact('response','vendor','item_list','item_details','title');
        // dd($data);
        return view('kitchen.purchase-order-form')->with($data);
    }
    public function purchase_order_details($id)
    {
        $id = ed($id, false);
        $data = KtPurchaseOrder::select(
                'kt_purchase_orders.*',
                's.supplier',
                'u.name as created_by'
            )
            ->join('kt_suppliers  as s', 's.id', '=', 'kt_purchase_orders.vendor_id')
            ->join('users as u', 'u.id', '=', 'kt_purchase_orders.generated_by')
            ->where('kt_purchase_orders.id', $id)
            ->first();
        $item_list = KtPurchaseOrderItem::select(
                'kt_purchase_order_items.*',
                'kt_items.item_name'
            )
            ->join('kt_items', 'kt_items.id', '=', 'kt_purchase_order_items.item_id')
            ->where('kt_purchase_order_items.po_id', $id)
            ->where('kt_purchase_order_items.is_delete',0)
            ->get();
        $data = compact('data','item_list');
        return view('kitchen.purchase-order-info')->with($data);
    }
    public function update_purchase_order(Request $request, $id = 0)
    {
        $request->validate([
            'po_date' => 'required',
            'vendor_id' => 'required',
        ]);
        try {
            DB::beginTransaction();

            $po = $id ? KtPurchaseOrder::find($id) : new KtPurchaseOrder();
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

            $existingItemIds = KtPurchaseOrderItem::where('po_id', $po_id)->pluck('id')->toArray();
            $submittedItemIds = $request->item_detail_id ?? [];
            $toDelete = array_diff($existingItemIds, $submittedItemIds);

            if (!empty($toDelete)) {
                KtPurchaseOrderItem::whereIn('id', $toDelete)->update(['is_delete' => 1]);
            }
            foreach ($request->item_id as $key => $item_id) {
                $item_detail_id = $request->item_detail_id[$key]?? '';

                $item = $item_detail_id
                    ? KtPurchaseOrderItem::find($item_detail_id)
                    : new KtPurchaseOrderItem();

                $item->po_id           = $po_id;
                $item->item_id         = $item_id;
                $item->unit_qty        = $request->unit_qty[$key];
                $item->unit_id         = $request->unit_id[$key];
                $item->unit            = $request->unit_name[$key];
                $item->save();
            }

            DB::commit();
            return redirect()->route('kt.purchase-orders')->with('success', 'Purchase Order Saved Successfully!');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Something went wrong. Try again!');
        }
    }
    public function delete_purchase_order($id)
    {
        $id = ed($id, false);
        $data = KtPurchaseOrder::where('id',$id)->first();
        if ($data) {
            $data->update([
                'is_delete' => 1
            ]);
            return redirect()->route('kt.purchase-orders')->with('success', 'The Purchase Order Deleted Successfully');
        } else {
            return back()->with('error', "Something Went Wrong");
        }
    }
}
