<?php

namespace App\Http\Controllers\Kitchen;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Yajra\Datatables\DataTables;
use Illuminate\Http\Request;
use App\Models\KtRequisitionItem;
use App\Models\KtRequisition;
use App\Models\KtItem;
use Exception;
use DB;
use Illuminate\Support\Facades\Schema;

class RequisitionController extends Controller
{
    private function hasKitchenRequisitionTables(): bool
    {
        return Schema::hasTable('kt_requisitions')
            && Schema::hasTable('kt_requisition_items');
    }

    public function index(Request $request)
    {
        if (!$this->hasKitchenRequisitionTables()) {
            if ($request->ajax()) {
                return Datatables::of(collect())->make(true);
            }

            return view('kitchen.requisition-list')
                ->with('error', 'Kitchen requisition tables are not available in this database.');
        }

        if ($request->ajax()) {
            $baseQuery = KtRequisition::select(
                'kt_requisitions.*',
                'u.name as generated_by'
            )
            ->join('users as u', 'u.id', '=', 'kt_requisitions.created_by')
            ->where('kt_requisitions.is_delete', 0)
            ->orderBy('kt_requisitions.id', 'DESC');

            // Filter by data
            if (!empty($request->from_date)) {
                $baseQuery->whereDate('kt_requisitions.requisition_date', '>=', date('Y-m-d', strtotime($request->from_date)));
            }
            if (!empty($request->to_date)) {
                $baseQuery->whereDate('kt_requisitions.requisition_date', '<=', date('Y-m-d', strtotime($request->to_date)));
            }

            return Datatables::of($baseQuery)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $actionBtn = '<a href="' . route('kt.requisition-details', ed($row->id, true)) . '" class="btn btn-sm btn-outline-info mx-1" title="View"><i class="bx bxs-info-circle"></i></a>';
                    if($row->is_given == 0){
                        $actionBtn .= '<a href="'.route('kt.edit-requisition', ed($row->id, true)).'" class="btn btn-sm btn-outline-warning mx-1" title="Edit"><i class="bx bxs-edit"></i></a>';
                        $actionBtn .= '<a onclick="return confirm(\'Are you sure you want to delete this record?\');" href="' . route('kt.delete-requisition', ed($row->id, true)) . '" class="btn btn-sm btn-outline-danger mx-1" title="Delete"><i class="bx bxs-trash"></i></a>';
                    }
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
            }
       return view('kitchen.requisition-list');
    }
    public function add_requisition()
    {
        if (!$this->hasKitchenRequisitionTables()) {
            return redirect()->route('kt.requisitions')
                ->with('error', 'Kitchen requisition tables are not available in this database.');
        }

        $title ="Add";
        $item_list = KtItem::where('status','0')->orderBy('id', 'desc')->get();
        $data = compact('item_list','title');
        return view('kitchen.requisition-form')->with($data);
    }
    public function edit_requisition($id)
    {
        if (!$this->hasKitchenRequisitionTables()) {
            return redirect()->route('kt.requisitions')
                ->with('error', 'Kitchen requisition tables are not available in this database.');
        }

        $id = ed($id, false);
        $title ="Edit";
        $item_list = KtItem::where('status','0')->orderBy('id', 'desc')->get();
        $response = KtRequisition::where('id',$id)->first();
        $item_details = KtRequisitionItem::where('requisition_id',$id)->where('is_delete',0)->get();
        $data = compact('response','item_list','item_details','title');
        return view('kitchen.requisition-form')->with($data);
    }
    public function requisition_details($id)
    {
        if (!$this->hasKitchenRequisitionTables()) {
            return redirect()->route('kt.requisitions')
                ->with('error', 'Kitchen requisition tables are not available in this database.');
        }

        $id = ed($id, false);
        $data = KtRequisition::select(
                'kt_requisitions.*',
                'u.name as generated_by'
            )
            ->join('users as u', 'u.id', '=', 'kt_requisitions.created_by')
            ->where('kt_requisitions.id', $id)
            ->first();
        $item_list = KtRequisitionItem::select(
                'kt_requisition_items.*',
                'kt_items.item_name',
            )
            ->join('kt_items', 'kt_items.id', '=', 'kt_requisition_items.item_id')
            ->where('kt_requisition_items.requisition_id', $id)
            ->where('kt_requisition_items.is_delete',0)
            ->get();
        $data = compact('data','item_list');
        // dd($data);
        return view('kitchen.requisition-info')->with($data);
    }
    public function update_requisition(Request $request, $id = 0)
    {
        if (!$this->hasKitchenRequisitionTables()) {
            return redirect()->route('kt.requisitions')
                ->with('error', 'Kitchen requisition tables are not available in this database.');
        }

        $request->validate([
            'requisition_date' => 'required',
        ]);
        try {
            DB::beginTransaction();

            $requisition = $id ? KtRequisition::find($id) : new KtRequisition();
            $requisition->requisition_date = date('Y-m-d H:i:s', strtotime($request->requisition_date));
            $requisition->note = $request->note;
            if($id){
                $requisition->edit_by = Auth::user()->id;
                $requisition->edit_at = date('Y-m-d h:i:s');
            }else{
                $requisition->created_by = Auth::user()->id;
            }
            $requisition->save();
            $requisition_id = $requisition->id;

            $existingItemIds = KtRequisitionItem::where('requisition_id', $requisition_id)->pluck('id')->toArray();
            $submittedItemIds = $request->item_detail_id ?? [];
            $toDelete = array_diff($existingItemIds, $submittedItemIds);

            if (!empty($toDelete)) {
                KtRequisitionItem::whereIn('id', $toDelete)->update(['is_delete' => 1]);
            }
            foreach ($request->item_id as $key => $item_id) {
                $item_detail_id = $request->item_detail_id[$key]?? '';

                $item = $item_detail_id
                    ? KtRequisitionItem::find($item_detail_id)
                    : new KtRequisitionItem();

                $item->requisition_id  = $requisition_id;
                $item->item_id         = $item_id;
                $item->unit_qty        = $request->unit_qty[$key];
                $item->unit_id         = $request->unit_id[$key];
                $item->unit            = $request->unit_name[$key];
                $item->save();
            }

            DB::commit();
            return redirect()->route('kt.requisitions')->with('success', 'Requisition Saved Successfully!');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Something went wrong. Try again!');
        }
    }
    public function delete_requisition($id)
    {
        if (!$this->hasKitchenRequisitionTables()) {
            return redirect()->route('kt.requisitions')
                ->with('error', 'Kitchen requisition tables are not available in this database.');
        }

        $id = ed($id, false);
        $data = KtRequisition::where('id',$id)->first();
        if ($data) {
            $data->update([
                'is_delete' => 1
            ]);
            return redirect()->route('kt.requisitions')->with('success', 'The Item Deleted Successfully');
        } else {
            return back()->with('error', "Something Went Wrong");
        }
    }
}
