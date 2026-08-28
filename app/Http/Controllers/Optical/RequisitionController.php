<?php

namespace App\Http\Controllers\Optical;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Yajra\Datatables\DataTables;
use App\Models\OpRequisition;
use App\Models\OpRequisitionItem;
use App\Models\OpDepartment;
use App\Models\Department;
use App\Models\OpItem;
use Illuminate\Http\Request;
use DB;

class RequisitionController extends Controller
{
    public function listing_requisition(Request $request)
    {
        if ($request->ajax()) {
            $data = OpRequisition::select(
                'op_requisitions.*',
                'd.department_name as department',
                'u.name as generated_by'
            )
            ->join('departments  as d', 'd.id', '=', 'op_requisitions.department_id')
            ->join('users as u', 'u.id', '=', 'op_requisitions.created_by')
            ->where('op_requisitions.is_delete', 0)
            ->orderBy('op_requisitions.id', 'DESC');

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $actionBtn = '<a href="' . route('optical.requisition-details', ed($row->id, true)) . '" class="btn btn-sm btn-outline-info mx-1" title="View"><i class="bx bxs-info-circle"></i></a>';
                    if(!$row->is_given){
                        $actionBtn .= '<a href="'.route('optical.edit-requisition', ed($row->id, true)).'" class="btn btn-sm btn-outline-warning mx-1" title="Edit"><i class="bx bxs-edit"></i></a>';
                        $actionBtn .= '<a onclick="return confirm(\'Are you sure you want to delete this record?\');" href="' . route('optical.delete-requisition', ed($row->id, true)) . '" class="btn btn-sm btn-outline-danger mx-1" title="Delete"><i class="bx bxs-trash"></i></a>';
                    }
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
            }
       return view('optical.requisition-list');
    }
    public function add_requisition()
    {
        $title ="Add";
        $department = Department::where('status','0')->orderBy('id', 'desc')->get();
        $item_list = OpItem::where('is_active','1')->where('is_delete','0')->orderBy('id', 'desc')->get();
        $data = compact('item_list','department','title');
        return view('optical.add-requisition')->with($data);
    }
    public function edit_requisition($id)
    {
        $id = ed($id, false);
        $title ="Add";
        $department = Department::where('status','0')->orderBy('id', 'desc')->get();
        $item_list = OpItem::where('is_active','1')->where('is_delete','0')->orderBy('id', 'desc')->get();
        $response = OpRequisition::where('id',$id)->first();
        $item_details = OpRequisitionItem::select('op_requisition_items.*','op_items.sub_unit_no')
            ->join('op_items','op_items.id','=','op_requisition_items.item_id')
            ->where('op_requisition_items.requisition_id',$id)
            ->where('op_requisition_items.is_delete',0)
            ->get();
        $data = compact('response','department','item_list','item_details','title');
        return view('optical.add-requisition')->with($data);
    }
    public function requisition_details($id)
    {
        $id = ed($id, false);
        $data = OpRequisition::select(
                'op_requisitions.*',
                'd.department_name as department',
                'u.name as generated_by'
            )
            ->join('departments as d', 'd.id', '=', 'op_requisitions.department_id')
            ->join('users as u', 'u.id', '=', 'op_requisitions.created_by')
            ->where('op_requisitions.id', $id)
            ->first();
        $item_list = OpRequisitionItem::select(
                'op_requisition_items.*',
                'op_items.item_name',
                'op_items.sub_unit_no'
            )
            ->join('op_items', 'op_items.id', '=', 'op_requisition_items.item_id')
            ->where('op_requisition_items.requisition_id', $id)
            ->where('op_requisition_items.is_delete',0)
            ->get();
        $data = compact('data','item_list');
        return view('optical.requisition-info')->with($data);
    }
    public function update_requisition(Request $request, $id = 0)
    {
        $request->validate([
            'requisition_date' => 'required',
            'department_id' => 'required',
        ]);
        try {
            DB::beginTransaction();

            $requisition = $id ? OpRequisition::find($id) : new OpRequisition();
            $requisition->requisition_date = date('Y-m-d H:i:s', strtotime($request->requisition_date));
            $requisition->department_id = $request->department_id;
            $requisition->note = $request->note;
            if($id){
                $requisition->edit_by = Auth::user()->id;
                $requisition->edit_at = date('Y-m-d h:i:s');
            }else{
                $requisition->created_by = Auth::user()->id;
            }
            $requisition->save();

            $requisition_id = $requisition->id;

            $existingItemIds = OpRequisitionItem::where('requisition_id', $requisition_id)->pluck('id')->toArray();
            $submittedItemIds = $request->item_detail_id ?? [];
            $toDelete = array_diff($existingItemIds, $submittedItemIds);

            if (!empty($toDelete)) {
                OpRequisitionItem::whereIn('id', $toDelete)->update(['is_delete' => 1]);
            }
            foreach ($request->item_id as $key => $item_id) {
                if($request->unit_qty[$key] == 0 && $request->sub_unit_qty[$key] == 0){
                    DB::rollback();
                    return back()->with('error', 'Unit & Subunit both are not zero');
                }
                $item_detail_id = $request->item_detail_id[$key]?? '';

                $item = $item_detail_id
                    ? OpRequisitionItem::find($item_detail_id)
                    : new OpRequisitionItem();

                $item->requisition_id  = $requisition_id;
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
            return redirect()->route('optical.listing-requisition')->with('success', 'Requisition Saved Successfully!');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Something went wrong. Try again!');
        }
    }
    public function delete_requisition($id)
    {
        $id = ed($id, false);
        $data = OpRequisition::where('id',$id)->first();
        if ($data) {
            $data->update([
                'is_delete' => 1
            ]);
            return redirect()->route('optical.listing-requisition')->with('success', 'The Item Deleted Successfully');
        } else {
            return back()->with('error', "Something Went Wrong");
        }
    }
}
