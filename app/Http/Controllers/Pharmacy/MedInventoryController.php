<?php

namespace App\Http\Controllers\Pharmacy;

use Illuminate\Support\Facades\Auth;
use Yajra\Datatables\DataTables;
use App\Models\MedStock;
use App\Models\MedPurchase;
use App\Models\MedPurchaseDetail;
use App\Models\MedVendor;
use App\Models\MedMedicine;
use App\Models\MedFreePurchaseDetail;
use App\Models\MedFreeStock;
use App\Models\MedRequisition;
use App\Models\MedRequisitionDetail;
use App\Models\User;
use App\Models\Department;
use App\Models\MedIssue;
use App\Models\MedIssueDetail;




use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;

class MedInventoryController extends Controller
{
    public function direct_puchase($id = 0)
    {
        $id = ed($id, false);
        $t = $id ? 'Edit Purchase' : 'Create Purchase';
        $po_item = MedPurchaseDetail::where('purchase_id', $id)->get();
        $po_list = MedPurchase::where('id', $id)->first();
        $vendor_list = MedVendor::where('status', '0')->get();
        $medicine_name = MedMedicine::select('med_catagories.medicine_catagory_name', 'med_medicines.medicine_name', 'med_catagories.id as medicine_cat_id', 'med_medicines.id as medicine_id')
            ->join('med_catagories', 'med_catagories.id', '=', 'med_medicines.medicine_catagory')->orderBy('med_medicines.medicine_name', 'asc')->get();
        return view('pharmacy.create-medicine-purchase', compact('vendor_list', 'medicine_name', 'po_item', 'po_list', 't'));
    }

    public function add_medicine_requisition_details($id = 0)
    {
        $id = ed($id, false);
        $t = $id ? 'Edit Requisition' : 'Create Requisition';
        $medicine_name = MedMedicine::select('med_catagories.medicine_catagory_name', 'med_medicines.medicine_name', 'med_catagories.id as medicine_cat_id', 'med_medicines.id as medicine_id')
            ->join('med_catagories', 'med_catagories.id', '=', 'med_medicines.medicine_catagory')->orderBy('med_medicines.medicine_name', 'asc')->get();
        $user_list = User::where('is_active', '1')->get();
        $requisition_list = MedRequisition::where('id', $id)->first();
        $req_details = MedRequisitionDetail::where('requisition_id', $id)->get();
        $department = Department::where('status', '0')->get();

        return view('pharmacy.create-requisition', compact('medicine_name', 'user_list', 'requisition_list', 'req_details', 'department', 't'));
    }

    public function update_requisition(Request $request, $id = 0)
    {
        $request->validate([
            'date' => 'required',
            'dept_id' => 'required',

        ]);

        if ($id) {
            $requisition = MedRequisition::find($id);
            $requisition->edit_by = Auth::id();

            // if (!$requisition) {
            //     return redirect()->back()->with('error', "Requisition record not found");
            // }
            // Delete old requisition details
            MedRequisitionDetail::where('requisition_id', $id)->delete();
            // Update existing requisition
        } else {
            $requisition = new MedRequisition();
            $requisition->genarated_by = Auth::id();
        }

        // Save requisition
        $requisition->date = $request->date;
        $requisition->dept_id = $request->dept_id;
        $requisition->requested_by = $request->requested_by;
        $requisition->note = $request->note;
        $requisition->save();

        $rid = $requisition->id;

        // Save requisition details
        foreach ($request->medicine_name as $key => $items) {
            if (isset($request->medicine_name[$key])) {
                $req_details = new MedRequisitionDetail();
                $req_details->requisition_id = $rid;
                $req_details->medicine_name = $request->medicine_name[$key];
                $req_details->unit_qty = $request->unit_qty[$key];
                $req_details->unit = $request->unit[$key];
                $req_details->sub_unit_qty = $request->sub_unit_qty[$key];
                $req_details->sub_unit = $request->sub_unit[$key];
                $req_details->save();
            }
        }

        return redirect()->route('pharmacy.requisition-lists')->with('success', "Requisition saved successfully!");
    }

    public function requisition_list()
    {
        $title = 'Medicine Requisition List';
        $action = route('pharmacy.requisition-lists');

        if (request()->ajax()) {
            $data = MedRequisition::select(
                'med_requisitions.*',
                'users.name as requested_by_name',
                'departments.department_name'
            )
                ->leftJoin('users', 'med_requisitions.genarated_by', '=', 'users.id')
                ->leftJoin('departments', 'med_requisitions.dept_id', '=', 'departments.id')
                ->orderBy('med_requisitions.id', 'DESC')
                ->get();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('requisition_no', function ($row) {

                    $actionBtn = '<a href="' . route('pharmacy.requisition-details', ed($row->id, true)) . '" title="View Requisition Details" style="color:rgb(0, 78, 161);">' . $row->id . '</a>';

                    return $actionBtn;
                })
                ->addColumn('action', function ($row) {
                    $actionBtn = '';
                    if ($row->is_given == 0) {
                        $actionBtn .= '<a href="' . route('pharmacy.add-requisition', ed($row->id, true)) . '" class="btn btn-sm btn-warning mx-1" title="Edit"><i class="bx bxs-edit"></i></a>';
                    }
                    $actionBtn .= '<a href="' . route('pharmacy.requisition-details', ed($row->id, true)) . '"  class="btn btn-sm btn-info mx-1" title="View"><i class="bx bxs-info-circle"></i></a>';

                    return $actionBtn;
                })
                // ->addColumn('issue', function ($row) {
                //     return $actionBtn;
                // })
                ->rawColumns(['action', 'requisition_no'])
                ->make(true);
        }
        return view('pharmacy.medicine-requisition-listing', compact('title', 'action'));
    }
    public function issue_list()
    {
        $title = 'Medicine Issue List';
        $action = route('pharmacy.issue-lists');
        if (request()->ajax()) {
            $data = MedRequisition::select(
                'med_requisitions.*',
                'users.name as requested_by_name',
                'departments.department_name'
            )
                ->leftJoin('users', 'med_requisitions.genarated_by', '=', 'users.id')
                ->leftJoin('departments', 'med_requisitions.dept_id', '=', 'departments.id')
                ->where('med_requisitions.is_given', '0')
                ->orderBy('med_requisitions.id', 'DESC')
                ->get();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('requisition_no', function ($row) {
                    $actionBtn = '<a href="' . route('pharmacy.requisition-details', ed($row->id, true)) . '" title="View Requisition Details" style="color:rgb(0, 78, 161);">' . $row->id . '</a>';

                    return $actionBtn;
                })
                ->addColumn('action', function ($row) {
                    $actionBtn = '<a href="' . route('pharmacy.create-issue', ed($row->id, true)) . '" class="btn btn-sm btn-success mx-1" title="Issue Medicine"><i class="fas fa-capsules"></i></a>';

                    return $actionBtn;
                })
                // ->addColumn('issue', function ($row) {
                //     return $actionBtn;
                // })
                ->rawColumns(['action', 'requisition_no', 'issue'])
                ->make(true);
        }
        return view('pharmacy.medicine-requisition-listing', compact('title', 'action'));
    }

    public function all_medicine_requisition_details($id)
    {
        $id = ed($id, false);

        $requisition_details = MedRequisition::select(
            'med_requisitions.*',
            'users.name as requested_by_name',
            'departments.department_name',
        )
            ->leftJoin('users', 'med_requisitions.genarated_by', '=', 'users.id')
            ->leftJoin('departments', 'med_requisitions.dept_id', '=', 'departments.id')
            ->where('med_requisitions.id', $id)
            ->first();

        $requisition_item = MedRequisitionDetail::select(
            'med_requisition_details.*',
            'med_medicines.medicine_name as medicine_real_name',
            'med_catagories.medicine_catagory_name as category_name'
        )
            ->Join('med_medicines', 'med_requisition_details.medicine_name', '=', 'med_medicines.id')
            ->Join('med_catagories', 'med_medicines.medicine_catagory', '=', 'med_catagories.id')
            ->where('med_requisition_details.requisition_id', $id)
            ->get();


        return view('pharmacy.medicine-requisition-details', compact('requisition_details', 'requisition_item'));
    }

    public function create_issue($id = 0)
    {
        $id = ed($id, false);
        $requisition_list = MedRequisition::select(
            'med_requisitions.*',
            'users.name as requested_by_name',
            'departments.department_name',
        )
            ->leftJoin('users', 'med_requisitions.genarated_by', '=', 'users.id')
            ->leftJoin('departments', 'med_requisitions.dept_id', '=', 'departments.id')
            ->where('med_requisitions.id', $id)
            ->first();

        $issue_details_data = MedIssueDetail::select(
            'med_issue_details.*',
        )
            ->join('med_issues', 'med_issues.id', '=', 'med_issue_details.issue_id')
            ->where('med_issues.req_id', $id)
            ->get()->keyBy('req_details_id');

        $issue_details = MedIssue::where('req_id', $id)->first();
        $req_details = MedRequisitionDetail::where('requisition_id', $id)->get();
        $department = Department::where('status', '0')->get();
        $medicine_name = MedMedicine::select('med_catagories.medicine_catagory_name', 'med_medicines.medicine_name', 'med_catagories.id as medicine_cat_id', 'med_medicines.id as medicine_id')
            ->join('med_catagories', 'med_catagories.id', '=', 'med_medicines.medicine_catagory')->orderBy('med_medicines.medicine_name', 'asc')->get();
        $data = compact('department', 'medicine_name', 'requisition_list', 'req_details', 'issue_details', 'issue_details_data');

        return view('pharmacy.create-issue')->with($data);
    }


    public function save_direct_purchase(Request $request, $id = 0)
    {
        $request->validate([
            'date' => 'required',
            'vendor' => 'required',
        ]);

        // dd($request->all());
        // If ID exists, fetch and delete old purchase details
        if ($id) {
            $purchase = MedPurchase::find($id);
            if (!$purchase) {
                return redirect()->back()->with('error', "Purchase record not found");
            }

            // Delete old details
            MedPurchaseDetail::where('purchase_id', $id)->delete();
            MedFreePurchaseDetail::where('purchase_id', $id)->delete();
        } else {
            $purchase = new MedPurchase();
            $purchase->generated_by = Auth::id();
            $purchase->is_delete = 0;
        }

        // Save purchase
        $purchase->date = $request->date;
        $purchase->vendor = $request->vendor;
        $purchase->purchase_order_id = $request->po_no;
        $purchase->total = $request->total;
        $purchase->total_sgst_amount = $request->total_sgst_amount;
        $purchase->total_igst_amount = $request->total_igst_amount;
        $purchase->total_cgst_amount = $request->total_cgst_amount;
        $purchase->invoice_no = $request->invoice_no;
        $purchase->note = $request->note;
        $purchase->save();

        $pid = $purchase->id;

        foreach ($request->medicine_id as $key => $items) {
            $purchase_details = new MedPurchaseDetail();
            $purchase_details->purchase_id = $pid;
            $purchase_details->item_id = $request->medicine_id[$key];
            $purchase_details->free_qty = $request->free_qty[$key];
            $purchase_details->unit_qty = $request->unit_qty[$key];
            $purchase_details->unit = $request->unit[$key];
            $purchase_details->sub_unit_qty = $request->sub_unit_qty[$key];
            $purchase_details->sub_unit = $request->sub_unit[$key];
            $purchase_details->expiry_date = $request->expiry_date[$key];
            $purchase_details->batch_no = $request->batch_no[$key];
            $purchase_details->rate = $request->rate[$key];
            $purchase_details->mrp = $request->mrp[$key];
            $purchase_details->net_amount = $request->net_amount[$key];
            $purchase_details->discount_per = $request->discount_percentage[$key];
            $purchase_details->discount_amount = $request->discount_amount[$key];
            $purchase_details->cgst = $request->cgst[$key];
            $purchase_details->sgst = $request->sgst[$key];
            $purchase_details->igst = $request->igst[$key];
            $purchase_details->cgst_amount = $request->cgst_amount[$key];
            $purchase_details->sgst_amount = $request->sgst_amount[$key];
            $purchase_details->igst_amount = $request->igst_amount[$key];
            $purchase_details->amount = $request->amount[$key];
            $purchase_details->save();

            if ($request->free_qty[$key] != 0) {
                $free_purchase = new MedFreePurchaseDetail();
                $free_purchase->purchase_id = $pid;
                $free_purchase->medicine_id = $request->medicine_id[$key];
                $free_purchase->qty = $request->free_qty[$key];
                $free_purchase->unit = $request->unit[$key];
                $free_purchase->batch_no = $request->batch_no[$key];
                $free_purchase->expiry_date = $request->expiry_date[$key];
                $free_purchase->rate = $request->rate[$key];
                $free_purchase->mrp = $request->mrp[$key];
                $free_purchase->save();
            }
        }

        $message = $id ? "Purchase Updated Successfully!" : "Purchase Created Successfully!";
        return redirect()->route('pharmacy.purchase-lists')->with('success', $message);
    }


    public function medicine_purchase_details($id = 0)
    {

        $id = ed($id, false);
        $purchase = MedPurchase::join('users', 'med_purchases.generated_by', '=', 'users.id')
            ->join('med_vendors', 'med_purchases.vendor', '=', 'med_vendors.id')
            ->where('med_purchases.id', $id)
            ->select(
                'med_purchases.*',
                'users.name as generated_by_name',
                'med_vendors.vendor_name as vendor_name'
            )
            ->first();


        $purchase_details = MedPurchaseDetail::join('med_medicines', 'med_medicines.id', '=', 'med_purchase_details.item_id')
            ->join('med_catagories', 'med_medicines.medicine_catagory', '=', 'med_catagories.id')
            ->where('med_purchase_details.purchase_id', $id)
            ->select(
                'med_purchase_details.*',
                'med_medicines.medicine_name',
                'med_catagories.medicine_catagory_name'
            )->get();

        $free_purchase_details = MedFreePurchaseDetail::join('med_medicines', 'med_medicines.id', '=', 'med_free_purchase_details.medicine_id')
            ->join('med_catagories', 'med_medicines.medicine_catagory', '=', 'med_catagories.id')
            ->where('med_free_purchase_details.purchase_id', $id)
            ->select(
                'med_free_purchase_details.*',
                'med_medicines.medicine_name',
                'med_catagories.medicine_catagory_name'
            )->get();
        return view('pharmacy.purchase-details', compact('purchase', 'purchase_details', 'free_purchase_details'));
    }



    public function medicine_purchase_list(Request $request)
    {
        $title = 'Medicine Purchase List';
        if ($request->ajax()) {
            $data = MedPurchase::select(
                'med_purchases.*',
                'med_vendors.vendor_name',
                'users.name as generated_by_name'
            )
                ->leftJoin('med_vendors', 'med_purchases.vendor', '=', 'med_vendors.id')
                ->leftJoin('users', 'med_purchases.generated_by', '=', 'users.id')
                ->orderBy('med_purchases.id', 'DESC')
                ->get();

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $actionBtn = '';
                    $actionBtn = '<a href="' . route('pharmacy.medicine-purchase-details', ed($row->id, true)) . '" class="btn btn-sm btn-info mx-1" title="View"><i class="bx bxs-info-circle"></i></a>';
                    if ($row->is_updated_in_stock != 1) {
                        $actionBtn .= '<a href="' . route('pharmacy.create-purchase', ed($row->id, true)) . '" class="btn btn-sm btn-warning mx-1" title="Edit"><i class="bx bxs-edit"></i></a>';
                    }
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('pharmacy.medicine-purchase-listing', compact('title'));
    }


    public function find_medicine_name_by_medicine_name(Request $request)
    {

        $unit_name = MedMedicine::where('id', $request->medicineName_id)->first();

        return response()->json($unit_name);
    }

    public function medicine_stock_update_from_purchase($id = 0)
    {
        $id = ed($id, false);
        $purchase_details = MedPurchaseDetail::where('purchase_id', $id)->get();
        foreach ($purchase_details as $key => $purchase_medicine) {
            $medicine_details = MedMedicine::where('id', $purchase_medicine->item_id)->first();
            $unitQty = $purchase_medicine->unit_qty ?? 0;
            $subUnitQty = $purchase_medicine->sub_unit_qty ?? 0;
            $unitDetails = $medicine_details->unit_details ?? 1;

            $qty = ($unitQty * $unitDetails) + $subUnitQty;
            $medine_stock = new MedStock();
            $medine_stock->grm_id         =  '';
            $medine_stock->purchase_id  =  $id;
            $medine_stock->po_details_id  =  '';
            $medine_stock->emg_challan_id =  '';
            $medine_stock->stock_status =  '';
            $medine_stock->unit =  $purchase_medicine->unit;
            $medine_stock->sub_unit =  $purchase_medicine->sub_unit;

            $medine_stock->medicine =  $purchase_medicine->item_id;
            $medine_stock->batch_no =  $purchase_medicine->batch_no;
            $medine_stock->exp_date      = $purchase_medicine->expiry_date;
            $medine_stock->unit_qty =  $purchase_medicine->unit_qty;
            $medine_stock->sub_unit_qty =  $purchase_medicine->sub_unit_qty;
            $medine_stock->qty =  $qty;
            $medine_stock->present_qty =  $qty;
            $medine_stock->mrp =  $purchase_medicine->mrp;
            $medine_stock->discount =  $purchase_medicine->discount_amount;
            $medine_stock->discount_per =  $purchase_medicine->discount_per;
            $medine_stock->p_rate =  $purchase_medicine->rate;
            $medine_stock->cgst =  $purchase_medicine->cgst;
            $medine_stock->cgst_value =  $purchase_medicine->cgst_amount;
            $medine_stock->sgst =  $purchase_medicine->sgst;
            $medine_stock->sgst_value =  $purchase_medicine->sgst_amount;
            $medine_stock->igst =  $purchase_medicine->igst;
            $medine_stock->igst_value =  $purchase_medicine->igst_amount;
            $medine_stock->amount =  $purchase_medicine->amount;
            // dd($medine_stock);
            $status = $medine_stock->save();
        }
        $free_purchase_details = MedFreePurchaseDetail::where('purchase_id', $id)->get();
        foreach ($free_purchase_details as $key => $free_medicine) {
            $medicine_details = MedMedicine::where('id', $free_medicine->medicine_id)->first();
            $unitQty = $free_medicine->qty ?? 0;
            $unitDetails = $medicine_details->unit_details ?? 1;

            $qty = ($unitQty * $unitDetails);
            $free_medicine_stock = new MedFreeStock();
            $free_medicine_stock->purchase_id = $free_medicine->purchase_id;
            $free_medicine_stock->medicine = $free_medicine->medicine_id;
            $free_medicine_stock->unit_qty = $free_medicine->qty;
            $free_medicine_stock->qty = $qty;
            $free_medicine_stock->present_qty = $qty;
            $free_medicine_stock->unit = $free_medicine->unit;
            $free_medicine_stock->batch_no = $free_medicine->batch_no;
            $free_medicine_stock->exp_date = $free_medicine->expiry_date;
            $free_medicine_stock->p_rate = $free_medicine->rate;
            $free_medicine_stock->s_rate = $free_medicine->mrp;
            $status = $free_medicine_stock->save();
        }

        MedPurchase::where('id', $id)->update(['is_updated_in_stock' => '1', 'stock_update_by' => Auth::id()]);

        if ($status) {
            return redirect()->back()->with('success', 'All Purchase Medicine Updated Sucessfully');
        } else {
            return redirect()->back()->with('error', "Something Went Wrong");
        }
    }

    public function find_medicine_batch_by_medicine_name(Request $request)
    {
        $medicine_batch_details = MedStock::select('batch_no')->where('medicine', $request->medicine_name_id)->groupBy('batch_no')->orderBy('exp_date', 'ASC')->get();
        return response()->json($medicine_batch_details);
    }


    public function find_medicine_details_by_medicine_batch(Request $request)
    {
        $medicine_details = MedStock::where('batch_no', $request->medicine_batch_no)->first();

        $total_qty = MedStock::where('medicine', $request->medicineId)
            ->where('batch_no', $request->medicine_batch_no)
            ->sum('present_qty');

        $medicine_info = MedMedicine::find($request->medicineId);

        $unit_stock = 0;
        $subunit_stock = 0;
        $available_stock_string = '';

        $unit = strtoupper($medicine_info->unit ?? 'UNIT');
        $subunit = strtoupper($medicine_info->sub_unit ?? 'SUBUNIT');
        $conversion = (int) $medicine_info->unit_details;

        if ($conversion > 0) {
            $unit_stock = floor($total_qty / $conversion);
            $subunit_stock = $total_qty % $conversion;

            $available_stock_string = "{$unit_stock}{$unit}";
            if ($subunit_stock > 0) {
                $available_stock_string .= " {$subunit_stock}{$subunit}";
            }
        } else {
            $available_stock_string = "{$total_qty}{$subunit}";
        }

        return response()->json([
            'medicine_details' => $medicine_details,
            'medicine_stock' => [
                'total_qty' => $total_qty,
                'unit_details' => $conversion,
                'unit_stock' => $unit_stock,
                'subunit_stock' => $subunit_stock,
                'available_stock' => $available_stock_string
            ]
        ]);
    }

    public function save_medicine_issue(Request $request)
    {
        $request->validate([
            'date' => 'required',
        ]);


        $existingIssue = MedIssue::where('req_id', $request->requisition_id)->first();

        if ($existingIssue) {

            $existingIssue->edit_by = Auth::id();
            $existingIssue->total_amount = $request->total;
            $existingIssue->save();

            $issue = $existingIssue;
        } else {

            $issue = new MedIssue();
            $issue->generate_by = Auth::id();
            $issue->req_id = $request->requisition_id;
            $issue->issue_date = $request->date;
            $issue->total_amount = $request->total;
            $issue->note = $request->note;
            $issue->issue_department_id = $request->department_id;
            $issue->save();
        }


        foreach ($request->req_details_ids as $key => $id) {
            if (in_array($id, $request->is_issued ?? [])) {
                $unit_details = MedMedicine::where('id', $request->medicine_name[$key])->value('unit_details');
                $unit_qty = $request->unit_qty[$key] ?? 0;
                $sub_unit_qty = $request->sub_unit_qty[$key] ?? 0;

                $qty = ($unit_qty * $unit_details) + $sub_unit_qty;

                $issue_details = new MedIssueDetail();
                $issue_details->issue_id = $issue->id;
                $issue_details->req_details_id = $id;
                $issue_details->medicine_name = $request->medicine_name[$key];
                $issue_details->unit_qty = $request->unit_qty[$key];
                $issue_details->unit = $request->unit[$key];
                $issue_details->sub_unit_qty = $request->sub_unit_qty[$key];
                $issue_details->sub_unit = $request->sub_unit[$key];
                $issue_details->batch_no = $request->medicines_batch[$key];
                $issue_details->expiry_date = $request->expiry_date[$key];
                $issue_details->rate = $request->rate[$key];
                $issue_details->mrp = $request->mrp[$key];
                $issue_details->net_amount = $request->net_amount[$key];
                $issue_details->cgst = $request->cgst[$key];
                $issue_details->sgst = $request->sgst[$key];
                $issue_details->igst = $request->igst[$key];
                $issue_details->cgst_value = $request->cgst_amount[$key];
                $issue_details->sgst_value = $request->sgst_amount[$key];
                $issue_details->igst_value = $request->igst_amount[$key];
                $issue_details->t_amount = $request->total_amount[$key];
                $issue_details->total_qty = $qty;
                $issue_details->save();

                MedRequisitionDetail::where('id', $id)->update(['is_issued' => 1]);
                MedStock::where('medicine', $request->medicine_name[$key])
                    ->where('batch_no', $request->medicines_batch[$key])
                    ->decrement('present_qty', $qty);
            }
        }


        $allIssued = MedRequisitionDetail::where('requisition_id', $request->requisition_id)
            ->where('is_issued', '!=', 1)
            ->doesntExist();

        if ($allIssued) {
            $issue->is_issued = 1;
            $issue->save();

            DB::table('med_requisitions')
                ->where('id', $request->requisition_id)
                ->update(['is_given' => 1]);
        }

        return redirect()->route('pharmacy.issue-lists')->with('success', "Issue saved successfully!");
    }




    public function issue_report()
    {
        $title = 'Medicine Issue List';
        if (request()->ajax()) {
            $data = MedIssue::select(
                'med_issues.*',
                'generator.name as issued_by_name',
                'editor.name as edit_by_name',
                'departments.department_name'
            )
                ->leftJoin('users as generator', 'med_issues.generate_by', '=', 'generator.id')
                ->leftJoin('users as editor', 'med_issues.edit_by', '=', 'editor.id')
                ->leftJoin('departments', 'med_issues.issue_department_id', '=', 'departments.id')
                ->orderBy('med_issues.id', 'DESC')
                ->get();


            return DataTables::of($data)
                ->addIndexColumn()
                // ->addColumn('requisition_no', function ($row) {

                //     $actionBtn = '<a href="' . route('pharmacy.requisition-details', ed($row->id, true)) . '" title="View Requisition Details" style="color:rgb(0, 78, 161);">' . $row->id . '</a>';

                //     return $actionBtn;
                // })
                ->addColumn('action', function ($row) {

                    $actionBtn = '<a href="' . route('pharmacy.issue-details', ed($row->id, true)) . '" class="btn btn-sm btn-info mx-1" title="View"><i class="bx bxs-info-circle"></i></a>';
                    return $actionBtn;
                })

                ->rawColumns(['action'])
                ->make(true);
        }
        return view('pharmacy.medicine-issue-listing', compact('title'));
    }

    public function all_medicine_issue_details($id)
    {
        $id = ed($id, false);

        $issue_details = MedIssue::select(
            'med_issues.*',
            'generator.name as issued_by_name',
            'editor.name as edit_by_name',
            'departments.department_name'
        )
            ->leftJoin('users as generator', 'med_issues.generate_by', '=', 'generator.id')
            ->leftJoin('users as editor', 'med_issues.edit_by', '=', 'editor.id')
            ->leftJoin('departments', 'med_issues.issue_department_id', '=', 'departments.id')
            ->where('med_issues.id', $id)
            ->first();

        $issued_item = MedIssueDetail::select(
            'med_issue_details.*',
            'med_medicines.medicine_name as medicine_real_name',
            'med_catagories.medicine_catagory_name as category_name'
        )
            ->Join('med_medicines', 'med_issue_details.medicine_name', '=', 'med_medicines.id')
            ->Join('med_catagories', 'med_medicines.medicine_catagory', '=', 'med_catagories.id')
            ->where('med_issue_details.issue_id', $id)
            ->get();


        return view('pharmacy.medicine-issue-details', compact('issue_details', 'issued_item'));
    }
}
