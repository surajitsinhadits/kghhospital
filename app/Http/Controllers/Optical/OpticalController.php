<?php

namespace App\Http\Controllers\Optical;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\OpVendor;
use App\Models\OpDepartment;
use App\Models\OpCompany;
use App\Models\OpItemType;
use App\Models\OpUnit;
use App\Models\OpItemCategory;
use App\Models\OpItem;
use App\Models\OpStock;
use DB;
use Yajra\Datatables\DataTables;
use App\Models\OpSurgeryCase;
use App\Models\OpEnquiry;
use Carbon\Carbon;
use App\Models\OpRequisition;
use App\Models\OpRegister;
use App\Models\OpPurchaseOrder;
use App\Models\OpPurchase;
use App\Models\OpBillingDetail;


class OpticalController extends Controller
{
    public function index()
    {

        $today = date('Y-m-d');
        $todayEnquiry = OpEnquiry::whereDate('appointment_date', $today)->where('is_delete', 0)->count();
        $yesterdayEnquiry = OpEnquiry::whereDate('appointment_date', date('Y-m-d', strtotime('-1 day')))->where('is_delete', 0)->count();
        $upcomingEnquiry = OpEnquiry::whereDate('appointment_date', '>', $today)->where('is_delete', 0)->count();

        $percentageChange = 0;
        if( $todayEnquiry == 0 && $yesterdayEnquiry == 0 ){
            $percentageChange = 0;
        } elseif( !empty($yesterdayEnquiry) && $todayEnquiry > $yesterdayEnquiry) {
            $percentageChange = (($todayEnquiry - $yesterdayEnquiry) / $yesterdayEnquiry) * 100;
            $percentageChange = number_format($percentageChange, 2); // 2 decimals
        } elseif( $yesterdayEnquiry > 0 && $todayEnquiry == 0 ) {
            $percentageChange = -100;
        } elseif( $yesterdayEnquiry == 0 && $todayEnquiry > 0 ) {
            $percentageChange = 100;
        } elseif( !empty($todayEnquiry) && $yesterdayEnquiry > $todayEnquiry ){
            $percentageChange = (($todayEnquiry - $yesterdayEnquiry) / $yesterdayEnquiry) * 100;
            $percentageChange = number_format($percentageChange, 2); // 2 decimals
        }

        if( $percentageChange > 0 ){
            $percentageChange = '+' . $percentageChange;
        }

        $totalSurgery = OpSurgeryCase::where('is_delete', 0)->count();
        $totalItems = OpItem::where('is_active', 1)->where('is_delete', 0)->count();

        $firstDayLastWeek = Carbon::now()->subDays(13)->toDateString();
        $lastDayLastWeek  = Carbon::now()->subDays(7)->toDateString();

        $firstDay = Carbon::now()->subDays(6)->toDateString();
        $lastDay   = Carbon::now()->toDateString();
        
        $lastWeeklyRequition = OpRequisition::where('is_delete', 0)
            ->whereDate('requisition_date', '>=', $firstDayLastWeek)
            ->whereDate('requisition_date', '<=', $lastDayLastWeek)
            ->count();

        $weeklyRequition = OpRequisition::where('is_delete', 0)
            ->whereDate('requisition_date', '>=', $firstDay)
            ->whereDate('requisition_date', '<=', $lastDay)
            ->count();


        $weekPercentageChangeRequition = 0;
        if( $weeklyRequition == 0 && $lastWeeklyRequition == 0 ){
            $weekPercentageChangeRequition = 0;
        } elseif( !empty($lastWeeklyRequition) && $weeklyRequition > $lastWeeklyRequition) {
            $weekPercentageChangeRequition = (($weeklyRequition - $lastWeeklyRequition) / $lastWeeklyRequition) * 100;
            $weekPercentageChangeRequition = number_format($weekPercentageChangeRequition, 2); // 2 decimals
        } elseif( $lastWeeklyRequition > 0 && $weeklyRequition == 0 ) {
            $weekPercentageChangeRequition = -100;
        } elseif( $lastWeeklyRequition == 0 && $weeklyRequition > 0 ) {
            $weekPercentageChangeRequition = 100;
        } elseif( !empty($weeklyRequition) && $lastWeeklyRequition > $weeklyRequition ){
            $weekPercentageChangeRequition = (($weeklyRequition - $lastWeeklyRequition) / $lastWeeklyRequition) * 100;
            $weekPercentageChangeRequition = number_format($weekPercentageChangeRequition, 2); // 2 decimals
        }

        if( $weekPercentageChangeRequition > 0 ){
            $weekPercentageChangeRequition = '+' . $weekPercentageChangeRequition;
        }

        $todayOpticalBilling = OpRegister::where('enquiry_id', 0)
            ->where('enquiry_id', 0)
            ->where('is_active', 1)
            ->where('is_delete', 0)
            ->whereDate('appointment_date', $today)
            ->count();

        $lastWeeklyPurchaseOrder = OpPurchaseOrder::where('is_delete', 0)
            ->where('status', 0)
            ->whereDate('po_date', '>=', $firstDayLastWeek)
            ->whereDate('po_date', '<=', $lastDayLastWeek)
            ->count();

        $weeklyPurchaseOrder = OpPurchaseOrder::where('is_delete', 0)
            ->where('status', 0)
            ->whereDate('po_date', '>=', $firstDay)
            ->whereDate('po_date', '<=', $lastDay)
            ->count();

        $weekPercentageChangePO = 0;
        if( $weeklyPurchaseOrder == 0 && $lastWeeklyPurchaseOrder == 0 ){
            $weekPercentageChangePO = 0;
        } elseif( !empty($lastWeeklyPurchaseOrder) && $weeklyPurchaseOrder > $lastWeeklyPurchaseOrder) {
            $weekPercentageChangePO = (($weeklyPurchaseOrder - $lastWeeklyPurchaseOrder) / $lastWeeklyPurchaseOrder) * 100;
            $weekPercentageChangePO = number_format($weekPercentageChangePO, 2); // 2 decimals
        } elseif( $lastWeeklyPurchaseOrder > 0 && $weeklyPurchaseOrder == 0 ) {
            $weekPercentageChangePO = -100;
        } elseif( $lastWeeklyPurchaseOrder == 0 && $weeklyPurchaseOrder > 0 ) {
            $weekPercentageChangePO = 100;
        } elseif( !empty($weeklyPurchaseOrder) && $lastWeeklyPurchaseOrder > $weeklyPurchaseOrder ){
            $weekPercentageChangePO = (($weeklyPurchaseOrder - $lastWeeklyPurchaseOrder) / $lastWeeklyPurchaseOrder) * 100;
            $weekPercentageChangePO = number_format($weekPercentageChangePO, 2); // 2 decimals
        }

        if( $weekPercentageChangePO > 0 ){
            $weekPercentageChangePO = '+' . $weekPercentageChangePO;
        }

        $lastWeeklyPurchase = OpPurchase::where('is_delete', 0)
            ->where('status', 0)
            ->whereDate('date', '>=', $firstDayLastWeek)
            ->whereDate('date', '<=', $lastDayLastWeek)
            ->count();

        $weeklyPurchase = OpPurchase::where('is_delete', 0)
            ->where('status', 0)
            ->whereDate('date', '>=', $firstDay)
            ->whereDate('date', '<=', $lastDay)
            ->count();

        $weekPercentageChangeP = 0;
        if( $weeklyPurchase == 0 && $lastWeeklyPurchase == 0 ){
            $weekPercentageChangeP = 0;
        } elseif( !empty($lastWeeklyPurchase) && $weeklyPurchase > $lastWeeklyPurchase) {
            $weekPercentageChangeP = (($weeklyPurchase - $lastWeeklyPurchase) / $lastWeeklyPurchase) * 100;
            $weekPercentageChangeP = number_format($weekPercentageChangeP, 2); // 2 decimals
        } elseif( $lastWeeklyPurchase > 0 && $weeklyPurchase == 0 ) {
            $weekPercentageChangeP = -100;
        } elseif( $lastWeeklyPurchase == 0 && $weeklyPurchase > 0 ) {
            $weekPercentageChangeP = 100;
        } elseif( !empty($weeklyPurchase) && $lastWeeklyPurchase > $weeklyPurchase ){
            $weekPercentageChangeP = (($weeklyPurchase - $lastWeeklyPurchase) / $lastWeeklyPurchase) * 100;
            $weekPercentageChangeP = number_format($weekPercentageChangeP, 2); // 2 decimals
        }

        if( $weekPercentageChangeP > 0 ){
            $weekPercentageChangeP = '+' . $weekPercentageChangeP;
        }

        $allRequisition = OpRequisition::select(
                'op_requisitions.id',
                'op_requisitions.requisition_date',
                'd.department_name as department',
                'u.name as generated_by'
            )
            ->join('departments  as d', 'd.id', '=', 'op_requisitions.department_id')
            ->join('users as u', 'u.id', '=', 'op_requisitions.created_by')
            ->where('op_requisitions.is_delete', 0)
            ->latest('op_requisitions.created_at')->take(7)->get();


        $itemIds = OpStock::select('item_id')
            ->distinct('item_id')
            ->pluck('item_id');

        $items = OpItem::select('op_items.*','u1.unit','u2.unit as sub_unit')
            ->join('op_units as u1','u1.id','=','op_items.unit_id')
            ->join('op_units as u2','u2.id','=','op_items.sub_unit_id')
            ->whereIn('op_items.id', $itemIds)
            ->where('op_items.is_delete', 0)
            ->get();

        $allItems = [];
        $stocks = OpStock::get();
        $issues = OpBillingDetail::get();

        foreach($items as $item){

            $unit_sub_no = $item->sub_unit_no;
            $total_stock = $stocks->where('item_id', $item->id)->sum('total_qty') ?? 0;
            $total_issus = $issues->where('item_id', $item->id)->sum('qty') ?? 0;
            $remaining_sub = $total_stock - $total_issus;
            $remaining_unit = intdiv($remaining_sub, $unit_sub_no);
            $remaining_sub_unit = $remaining_sub % $unit_sub_no;
            $qty = $remaining_unit.' '.$item->unit.' '.$remaining_sub_unit.' '.$item->sub_unit;

            $allItems[] = [
                'id' => $item->id,
                'item' => $item->item_name,
                'low_level' => $item->low_level,
                'unit' => $item->unit,
                'sub_unit' => $item->sub_unit,
                'unit_qty' => $remaining_unit,
                'sub_unit_qty' => $remaining_sub_unit,
                'total_qty' => $remaining_sub,
            ];

        }

        $months = [];

        for ($i = 0; $i < 12; $i++) {

            $date = Carbon::now()->subMonths($i);
            $months[] = [
                'month_name'    => $date->format('M y'),
                'start_date'    => $date->copy()->startOfMonth()->toDateString(),
                'end_date'      => $date->copy()->endOfMonth()->toDateString(),
            ];

        }

        $months = array_reverse($months);

        $optical_billing = []; $eye_examination = [];
        $categories = [];
        foreach($months as $month){

            $categories[] = $month['month_name'];

            $op_billing = OpRegister::join('billings as b', 'b.section_id', '=', 'op_registers.id')
                ->where('op_registers.is_active', 1)
                ->where('op_registers.is_delete', '0')
                ->whereIn('b.bill_status', [1,2])
                ->where('b.section', 'OP')
                ->where('op_registers.enquiry_id', 0)
                ->whereDate('b.bill_date', '>=', $month['start_date'])
                ->whereDate('b.bill_date', '<=', $month['end_date'])
                ->sum('b.grand_total');

            $optical_billing[] = (int)$op_billing;

            $eye_exa = OpEnquiry::join('op_registers as opr', 'opr.enquiry_id', '=', 'op_enquiries.id')
                ->join('billings as b', 'b.section_id', '=', 'opr.id')
                ->where('opr.is_active', 1)
                ->where('opr.is_delete', '0')
                ->where('op_enquiries.is_delete', '0')
                ->whereIn('b.bill_status', [1,2])
                ->where('b.section', 'OP')
                ->whereDate('b.bill_date', '>=', $month['start_date'])
                ->whereDate('b.bill_date', '<=', $month['end_date'])
                ->sum('b.grand_total');

            $eye_examination[] = (int)$eye_exa;

        }

        $opticalBilling = OpRegister::join('billings as b', 'b.section_id', '=', 'op_registers.id')
                ->where('op_registers.is_active', 1)
                ->where('op_registers.is_delete', '0')
                ->whereIn('b.bill_status', [1,2])
                ->where('b.section', 'OP')
                ->where('op_registers.enquiry_id', 0)
                ->whereDate('b.bill_date', '>=', $firstDay)
                ->whereDate('b.bill_date', '<=', $lastDay)
                ->sum('b.grand_total');

        $eyeExamination = OpEnquiry::selectRaw('DATE(b.bill_date) as bill_date')->join('op_registers as opr', 'opr.enquiry_id', '=', 'op_enquiries.id')
            ->join('billings as b', 'b.section_id', '=', 'opr.id')
            ->where('opr.is_active', 1)
            ->where('opr.is_delete', '0')
            ->where('op_enquiries.is_delete', '0')
            ->whereIn('b.bill_status', [1,2])
            ->where('b.section', 'OP')
            ->whereDate('b.bill_date', '>=', $firstDay)
            ->whereDate('b.bill_date', '<=', $lastDay)
            ->sum('b.grand_total');

        $weeklyChart[] = (int)$opticalBilling;
        $weeklyChart[] = (int)$eyeExamination;
        // print_r($weeklyChart);die;
        return view('optical.dashboard',
            compact(
                'todayEnquiry',
                'upcomingEnquiry',
                'weekPercentageChangeRequition',
                'totalSurgery',
                'percentageChange',
                'totalItems',
                'todayOpticalBilling',
                'weekPercentageChangePO',
                'weekPercentageChangeP',
                'allRequisition',
                'allItems',
                'optical_billing',
                'eye_examination',
                'categories',
                'weeklyChart',
                'weeklyRequition',
                'weeklyPurchaseOrder',
                'weeklyPurchase'
            )
        );


    }

    public function add_vendor()
    {
        return view('optical.add-vendor');
    }

    public function edit_vendor($id)
    {
        $id = ed($id, false);
        $response = OpVendor::where('id',$id)->orderBy('id', 'desc')->first();
        $data = compact('response');
        return view('optical.add-vendor')->with($data);
    }

    public function listing_vendor(Request $request)
    {
        if ($request->ajax()) {
            $data = OpVendor::orderBy('op_vendors.id', 'DESC');
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('activate', function ($row) {
                    $checked = $row->is_active == 1 ? 'checked' : '';
                    return '<label class="switch">
                                <input type="checkbox" ' . $checked . '
                                    onchange="toggleStatus(\'' . $row->id . '\', \'op_vendors\',\'is_active\', this)">
                                <span class="slider round"></span>
                            </label>';
                })
                ->addColumn('action', function ($row) {
                    $edit = route('optical.edit-vendor', ['id' => ed($row->id, true)]);
                    return '<a href="' . $edit . '" class="btn btn-sm btn-outline-warning mx-1" title="Edit"><i class="bx bxs-edit"></i></a>';
                })
                ->rawColumns(['vendor_name', 'action', 'activate'])
                ->make(true);
        }
        return view('optical.vendor-list');


        // $response = OpVendor::orderBy('id', 'desc')->get();
        // return view('optical.vendor-list',compact('response'));
    }

    public function update_vendor(Request $request, $id = 0)
    {
        if( !empty($id) ){
            $request->validate([
                'vendor_name'   => 'required|max:100|unique:op_vendors,vendor_name,'.$id,
                'phone'         => 'nullable|digits:10',
                'email'         => 'nullable|email',
            ]);
        } else {
            $request->validate([
                'vendor_name'   => 'required|max:100|unique:op_vendors,vendor_name',
                'phone'         => 'nullable|digits:10',
                'email'         => 'nullable|email',
            ]);
        }

        $id ? $data = OpVendor::find($id) : $data = new OpVendor();

        $data->vendor_name              = $request->vendor_name;
        $data->email                    = $request->email;
        $data->phone                    = $request->phone;
        $data->pin_code                 = $request->pin_code;
        $data->gstin                    = $request->gstin;
        $data->contact_person_name      = $request->contact_person_name;
        $data->address                  = $request->address;

        if($data->save()){
            return redirect()->route('optical.listing-vendor')->with('success', 'Successfully Updated!');
        }else{
            return redirect()->route('optical.listing-vendor')->back()->with('error', 'Something wrong try again!');
        }
    }

    public function optical_department()
    {
        $title = 'Optical Department';
        $t1 = 'Optical Department List';
        $t2 = 'Add Optical Department';
        $form = ['department_name'];
        $head = ['Sl. No.','Department Name','Action'];
        $btn['name'] = 'Add Department';
        $btn['action'] = Route('optical.update-optical-department');
        $edit['data'] = null;
        $edit['url'] = Route('optical.edit-optical-department');
        $response = OpDepartment::orderBy('id', 'desc')->get();
        $table = 'op_departments';
        $data = compact('title','t1', 't2', 'form','head','btn','edit','response','table');
        return view('optical.master-form')->with($data);
    }

    public function edit_optical_department($id = 0)
    {
        if(!$id){
            return redirect()->route('optical.optical-department');
        }
        $id = ed($id, false);
        $title = 'Edit Optical Department List';
        $t1 = 'Optical Department List';
        $t2 = 'Edit Optical Department';
        $form = ['department_name'];
        $head = ['Sl. No.', 'Department Name','Action'];
        $btn['name'] = 'Update Department';
        $btn['action'] = Route('optical.update-optical-department',$id);
        $edit['data'] =  OpDepartment::find($id);
        $edit['reset'] = Route('optical.optical-department');
        $edit['url'] = Route('optical.edit-optical-department');
        $response = OpDepartment::orderBy('id', 'desc')->get();
        $table = "op_departments";
        $data = compact('title','t1', 't2', 'form','head','btn','edit','response','table');
        return view('optical.master-form')->with($data);
    }

    public function update_optical_department(Request $request, $id = 0)
    {
        $request->validate([
            'department_name' => 'required|max:100',
        ]);

        $id ? $data = OpDepartment::find($id) : $data = new OpDepartment();
        $data->department_name = $request->department_name;
        if($data->save()){
            return redirect()->route('optical.optical-department')->with('success', 'Successfully Updated!');
        }else{
            return redirect()->route('optical.optical-department')->with('error', 'Something wrong try again!');
        }
    }

    public function item_brand()
    {
        $title = 'Company';
        $t1 = 'Company List';
        $t2 = 'Add Company';
        $form = ['company_name'];
        $head = ['Sl. No.','Company Name','Action'];
        $btn['name'] = 'Add Company';
        $btn['action'] = Route('optical.update-item-brand');
        $edit['data'] = null;
        $edit['url'] = Route('optical.edit-item-brand');
        $response = OpCompany::orderBy('id', 'desc')->get();
        $table = 'op_companies';
        $data = compact('title','t1', 't2', 'form','head','btn','edit','response','table');
        return view('optical.master-form')->with($data);
    }

    public function edit_item_brand($id = 0)
    {
        if(!$id){
            return redirect()->route('optical.item-brand');
        }
        $id = ed($id, false);
        $title = 'Edit Company';
        $t1 = 'Company List';
        $t2 = 'Edit Company';
        $form = ['company_name'];
        $head = ['Sl. No.', 'Company Name','Action'];
        $btn['name'] = 'Update Company';
        $btn['action'] = Route('optical.update-item-brand',$id);
        $edit['data'] =  OpCompany::find($id);
        $edit['reset'] = Route('optical.item-brand');
        $edit['url'] = Route('optical.edit-item-brand');
        $response = OpCompany::orderBy('id', 'desc')->get();
        $table = "op_companies";
        $data = compact('title','t1', 't2', 'form','head','btn','edit','response','table');
        return view('optical.master-form')->with($data);
    }

    public function update_item_brand(Request $request, $id = 0)
    {
        if( !empty($id) ){
            $request->validate([
                'company_name' => 'required|max:100|unique:op_companies,company_name,'.$id,
            ]);
        } else {
            $request->validate([
                'company_name' => 'required|max:100|unique:op_companies,company_name',
            ]);
        }

        $id ? $data = OpCompany::find($id) : $data = new OpCompany();
        $data->company_name = $request->company_name;
        if($data->save()){
            return redirect()->route('optical.item-brand')->with('success', 'Successfully Updated!');
        }else{
            return redirect()->route('optical.item-brand')->with('error', 'Something wrong try again!');
        }
    }

     public function item_type()
    {
        $title = 'Item Type';
        $t1 = 'Item Type List';
        $t2 = 'Add Item Type';
        $form = ['type_name'];
        $head = ['Sl. No.','Item Type Name','Action'];
        $btn['name'] = 'Add Item Type';
        $btn['action'] = Route('optical.update-item-type');
        $edit['data'] = null;
        $edit['url'] = Route('optical.edit-item-type');
        $response = OpItemType::orderBy('id', 'desc')->get();
        $table = 'op_item_types';
        $data = compact('title','t1', 't2', 'form','head','btn','edit','response','table');
        return view('optical.master-form')->with($data);
    }

    public function edit_item_type($id = 0)
    {
        if(!$id){
            return redirect()->route('optical.item-type');
        }
        $id = ed($id, false);
        $title = 'Edit Item Type';
        $t1 = 'Item Type List';
        $t2 = 'Edit Item Type';
        $form = ['type_name'];
        $head = ['Sl. No.', 'Item Type Name','Action'];
        $btn['name'] = 'Update Item Type';
        $btn['action'] = Route('optical.update-item-type',$id);
        $edit['data'] =  OpItemType::find($id);
        $edit['reset'] = Route('optical.item-type');
        $edit['url'] = Route('optical.edit-item-type');
        $response = OpItemType::orderBy('id', 'desc')->get();
        $table = "op_item_types";
        $data = compact('title','t1', 't2', 'form','head','btn','edit','response','table');
        return view('optical.master-form')->with($data);
    }

    public function update_item_type(Request $request, $id = 0)
    {
        if( !empty($id) ){
            $request->validate([
                'type_name' => 'required|max:100|unique:op_item_types,type_name,'.$id,
            ]);
        } else {
            $request->validate([
                'type_name' => 'required|max:100|unique:op_item_types,type_name',
            ]);
        }

        $id ? $data = OpItemType::find($id) : $data = new OpItemType();
        $data->type_name = $request->type_name;
        if($data->save()){
            return redirect()->route('optical.item-type')->with('success', 'Successfully Updated!');
        }else{
            return redirect()->route('optical.item-type')->with('error', 'Something wrong try again!');
        }
    }

    public function item_unit()
    {
        $title = 'Unit';
        $t1 = 'Unit';
        $t2 = 'Add Unit';
        $form = ['unit'];
        $head = ['Sl. No.','Item Unit','Action'];
        $btn['name'] = 'Add Unit';
        $btn['action'] = Route('optical.update-item-unit');
        $edit['data'] = null;
        $edit['url'] = Route('optical.edit-item-unit');
        $response = OpUnit::orderBy('id', 'desc')->get();
        $table = 'op_units';
        $data = compact('title','t1', 't2', 'form','head','btn','edit','response','table');
        return view('optical.master-form')->with($data);
    }

    public function edit_item_unit($id = 0)
    {
        if(!$id){
            return redirect()->route('optical.item-unit');
        }
        $id = ed($id, false);
        $title = 'Edit Unit';
        $t1 = 'Unit';
        $t2 = 'Edit Unit';
        $form = ['unit'];
        $head = ['Sl. No.', 'Item Unit','Action'];
        $btn['name'] = 'Update Unit';
        $btn['action'] = Route('optical.update-item-unit',$id);
        $edit['data'] =  OpUnit::find($id);
        $edit['reset'] = Route('optical.item-unit');
        $edit['url'] = Route('optical.edit-item-unit');
        $response = OpUnit::orderBy('id', 'desc')->get();
        $table = "op_units";
        $data = compact('title','t1', 't2', 'form','head','btn','edit','response','table');
        return view('optical.master-form')->with($data);
    }

    public function update_item_unit(Request $request, $id = 0)
    {
        if( !empty($id) ){
            $request->validate([
                'unit' => 'required|max:100|unique:op_units,unit,'.$id,
            ]);
        } else {
            $request->validate([
                'unit' => 'required|max:100|unique:op_units,unit',
            ]);
        }

        $id ? $data = OpUnit::find($id) : $data = new OpUnit();
        $data->unit = $request->unit;
        if($data->save()){
            return redirect()->route('optical.item-unit')->with('success', 'Successfully Updated!');
        }else{
            return redirect()->route('optical.item-unit')->with('error', 'Something wrong try again!');
        }
    }

    public function item_catagory()
    {
        $title = 'Item Category';
        $t1 = 'Item Category List';
        $t2 = 'Add Item Category';
        $form = ['category_name'];
        $head = ['Sl. No.','Category Name','Action'];
        $btn['name'] = 'Add Category ';
        $btn['action'] = Route('optical.update-item-catagory');
        $edit['data'] = null;
        $edit['url'] = Route('optical.edit-item-catagory');
        $edit['suburl'] = Route('optical.sub-categories');
        $response = OpItemCategory::where('parent_id',0)->orderBy('id', 'desc')->get();
        $table = 'op_item_categories';
        $data = compact('title','t1', 't2', 'form','head','btn','edit','response','table');
        return view('optical.master-form')->with($data);
    }

    public function edit_item_catagory($id = 0)
    {
        if(!$id){
            return redirect()->route('optical.item-catagory');
        }
        $id = ed($id, false);
        $title = 'Edit Item Category';
        $t1 = 'Item Category List';
        $t2 = 'Edit Item Category';
        $form = ['category_name'];
        $head = ['Sl. No.', 'Category Name','Action'];
        $btn['name'] = 'Update Category';
        $btn['action'] = Route('optical.update-item-catagory',$id);
        $edit['data'] =  OpItemCategory::find($id);
        $edit['reset'] = Route('optical.item-catagory');
        $edit['url'] = Route('optical.edit-item-catagory');
        $response = OpItemCategory::where('parent_id',0)->orderBy('id', 'desc')->get();
        $table = "op_item_categories";
        $data = compact('title','t1', 't2', 'form','head','btn','edit','response','table');
        return view('optical.master-form')->with($data);
    }

    public function update_item_catagory(Request $request, $id = 0)
    {
        if( !empty($id) ){
            $request->validate([
                'category_name' => 'required|max:100|unique:op_item_categories,category_name,'.$id,
            ]);
        } else {
            $request->validate([
                'category_name' => 'required|max:100|unique:op_item_categories,category_name',
            ]);
        }

        $id ? $data = OpItemCategory::find($id) : $data = new OpItemCategory();
        $data->category_name = $request->category_name;
        $data->parent_id = @$request->parent_id ?? 0;

        if($data->save()){
            return redirect()->route('optical.item-catagory')->with('success', 'Successfully Updated!');
        }else{
            return redirect()->route('optical.item-catagory')->with('error', 'Something wrong try again!');
        }
    }

    public function parent_categories()
    {
        $categories = OpItemCategory::where('parent_id', 0)->get();
        return response()->json($categories);
    }

    public function sub_categories($id)
    {
        $id = ed($id, false);
        $title = 'Item Sub-Category';
        $t1 = 'Item Sub-Category List';
        $t2 = 'Add Item Category';
        $form = ['category_name'];
        $head = ['Sl. No.', 'Category Name','Action'];
        $btn['name'] = 'Add Category';
        $btn['action'] = Route('optical.update-item-catagory');
        $edit['data'] = null;
        $edit['url'] = Route('optical.edit-item-catagory');
        $response = OpItemCategory::where('parent_id',$id)->orderBy('id', 'desc')->get();
        $table = "op_item_categories";
        $data = compact('title','t1', 't2', 'form','head','btn','edit','response','table');
        return view('optical.master-form')->with($data);
    }

    public function listing_item(Request $request)
    {
        if ($request->ajax()) {
            $data = OpItem::select(
                    'op_items.*',
                    'c.category_name',
                    'u.unit',
                    'su.unit as sub_unit'
                )
                ->join('op_item_categories as c', 'c.id', '=', 'op_items.category_id')
                ->join('op_units as u', 'u.id', '=', 'op_items.unit_id')
                ->join('op_units as su', 'su.id', '=', 'op_items.sub_unit_id')
                ->Where('is_delete', '0')
                ->orderBy('op_items.id', 'DESC');
            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('item_name', function ($row) {
                    $url = route('optical.item-info', ['id' => ed($row->id, true)]);
                    return '<a href="' . $url . '">' . e($row->item_name) . '</a>';
                })
                ->addColumn('activate', function ($row) {
                    $checked = $row->is_active == 1 ? 'checked' : '';
                    return '<label class="switch">
                                <input type="checkbox" ' . $checked . '
                                    onchange="toggleStatus(\'' . $row->id . '\', \'op_items\',\'is_active\', this)">
                                <span class="slider round"></span>
                            </label>';
                })
                ->addColumn('action', function ($row) {
                    $edit = route('optical.edit-item', ['id' => ed($row->id, true)]);
                    $delete = route('optical.delete-item', ed($row->id, true));
                    return '<a href="' . $edit . '" class="btn btn-sm btn-outline-warning mx-1" title="Edit"><i class="bx bxs-edit"></i></a>';
                        //    '<a onclick="return confirm(\'Are you sure you want to delete this record?\');" href="' . $delete . '" class="btn btn-sm btn-outline-danger mx-1" title="Delete"><i class="bx bxs-trash"></i></a>';
                })
                ->rawColumns(['item_name', 'action','activate'])
                ->make(true);
        }
        return view('optical.item-list');

    }

    public function add_item()
    {
        $item_type =  OpItemType::where('status','0')->orderBy('id', 'desc')->get();
        $item_category =  OpItemCategory::where('parent_id','0')->where('status','0')->orderBy('id', 'desc')->get();
        // $item_subcategory =  OpItemCategory::where('parent_id','!=','0')->where('status','0')->orderBy('id', 'desc')->get();
        $item_company = OpCompany::where('status','0')->orderBy('id', 'desc')->get();
        $unit = OpUnit::where('status','0')->orderBy('id', 'desc')->get();
        $data = compact('item_type', 'item_category', 'item_company', 'unit');
        return view('optical.add-item')->with($data);
    }

    public function edit_item($id)
    {
        $id = ed($id, false);
        $item_type = OpItemType::where('status','0')->orderBy('id', 'desc')->get();
        $item_category = OpItemCategory::where('parent_id','0')->where('status','0')->orderBy('id', 'desc')->get();
        $item_subcategory = OpItemCategory::where('parent_id','!=','0')->where('status','0')->orderBy('id', 'desc')->get();
        $item_company = OpCompany::where('status','0')->orderBy('id', 'desc')->get();
        $unit = OpUnit::where('status','0')->orderBy('id', 'desc')->get();
        $response = OpItem::where('id',$id)->orderBy('id', 'desc')->first();
        $data = compact('item_type','item_category','item_subcategory','item_company','unit','response');
        return view('optical.add-item')->with($data);
    }

    public function update_item(Request $request, $id = 0)
    {
        if( !empty($id) ){

            $request->validate([
                'type_id'     => 'required',
                'category_id' => 'required',
                'item_name'   => 'required|max:100',
                'low_level'   => 'required|max:100',
            ]);

        } else {

            $request->validate([
                'type_id'     => 'required',
                'category_id' => 'required',
                'item_name'   => 'required|max:100',
                'low_level'   => 'required|max:100',
                'unit_id'     => 'required|max:100',
                'sub_unit_no' => 'required',
                'sub_unit_id' => 'required',
            ]);

        }

        $id ? $data = OpItem::find($id) : $data = new OpItem();

        $data->type_id         = $request->type_id;
        $data->category_id     = $request->category_id;
        $data->sub_category_id = $request->sub_category_id;
        $data->item_name       = $request->item_name;
        $data->low_level       = $request->low_level;
        $data->company_id      = $request->company_id;
        $data->hsn_sac_no      = $request->hsn_sac_no;

        if( empty($id) ){

            $data->unit_id         = $request->unit_id;
            $data->sub_unit_no     = $request->sub_unit_no;
            $data->sub_unit_id     = $request->sub_unit_id;

        }

        if($data->save()){
            return redirect()->route('optical.listing-item')->with('success', 'Successfully Updated!');
        }else{
            return redirect()->route('optical.listing-item')->back()->with('error', 'Something wrong try again!');
        }
    }

    public function delete_item($id)
    {
        $id = ed($id, false);
        $data = OpItem::where('id',$id)->first();

        if ($data) {
            $data->update([
                'is_delete' => 1
            ]);
            return redirect()->route('optical.listing-item')->with('success', 'The Item Deleted Successfully');
        } else {
            return back()->with('error', "Something Went Wrong");
        }
    }

    public function getUnitDetails(Request $request)
    {
        $item = OpItem::where('op_items.id', $request->itemId)
        ->leftJoin('op_units as unit', 'op_items.unit_id', '=', 'unit.id')
        ->leftJoin('op_units as sub_unit', 'op_items.sub_unit_id', '=', 'sub_unit.id')
        ->select([
            'unit.unit as unit_name',
            'unit.id as unit_id',
            'sub_unit.unit as sub_unit_name',
            'sub_unit.id as sub_unit_id',
            'op_items.sub_unit_no'
        ])
        ->first();

        if ($item) {
            return response()->json([
                'unit' => $item->unit_name,
                'sub_unit' => $item->sub_unit_name,
                'unit_id' => $item->unit_id,
                'sub_unit_id' => $item->sub_unit_id,
                'sub_unit_no' => $item->sub_unit_no
            ]);
        }

        return response()->json([
            'unit' => '',
            'sub_unit' => '',
            'unit_id' => '',
            'sub_unit_id' => '',
            'sub_unit_no' => ''
        ]);
    }

    public function getBatchDetails(Request $request)
    {
        $item = OpStock::where('item_id', $request->itemId)
            ->where('exp_date', '>', Carbon::now())
            ->get() ?? [];

        return response()->json([
            'batch' => $item
        ]);
    }

    public function item_info($item_id)
    {
        $id = ed($item_id, false);
        $item_details = OpItem::select(
                'op_items.*',
                'c.category_name',
                'u.unit',
                'su.unit as sub_unit',
                'b.company_name'
            )
            ->join('op_item_categories as c', 'c.id', '=', 'op_items.category_id')
            ->join('op_units as u', 'u.id', '=', 'op_items.unit_id')
            ->join('op_units as su', 'su.id', '=', 'op_items.sub_unit_id')
            ->leftJoin('op_companies as b', 'b.id', '=', 'op_items.company_id')
            ->where('op_items.id',$id)
            ->Where('is_delete', 0)
            ->orderBy('op_items.id', 'DESC')
            ->first();

        if( $item_details ){

            $stocks = OpStock::get();
            $issues = OpBillingDetail::get();

            $unit_sub_no = $item_details->sub_unit_no;
            $total_stock = $stocks->where('item_id', $item_details->id)->sum('total_qty') ?? 0;
            $total_issus = $issues->where('item_id', $item_details->id)->sum('qty') ?? 0;
            $remaining_sub = $total_stock - $total_issus;
            $remaining_unit = intdiv($remaining_sub, $unit_sub_no);
            $remaining_sub_unit = $remaining_sub % $unit_sub_no;
            $qty = $remaining_unit.' '.$item_details->unit.' '.$remaining_sub_unit.' '.$item_details->sub_unit;

            $itemDetails = [
                'id' => $item_details->id,
                'item' => $item_details->item_name,
                'low_level' => $item_details->low_level,
                'unit' => $item_details->unit,
                'sub_unit' => $item_details->sub_unit,
                'unit_qty' => $remaining_unit,
                'sub_unit_qty' => $remaining_sub_unit,
                'total_qty' => $remaining_sub,
            ];

            // print_r($itemDetails);die;

        }
    
        $data = compact('itemDetails', 'item_details');

        return view('optical.item-info')->with($data);
    }

    public function get_subcategories($id)
    {
        $subcategories = OpItemCategory::where('parent_id', $id)->get(['id','category_name']);
        return response()->json($subcategories);
    }

}


