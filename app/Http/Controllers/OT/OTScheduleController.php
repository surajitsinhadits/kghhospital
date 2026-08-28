<?php

namespace App\Http\Controllers\OT;

use App\Http\Controllers\Controller;
use App\Models\Billing;
use App\Models\BillingDetail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\OtRegistration;
use App\Models\OtRegPackageDetail;
use App\Models\Department;
use App\Models\User;
use App\Models\OtPackageDetail;
use App\Models\OtPackage;
use App\Models\Patient;
use App\Models\Charge;
use App\Models\CssdKitbox;
use App\Models\Investigation;
use App\Models\Operation;
use App\Models\IpdRegister;
use App\Models\OtPreparation;
use App\Models\OtProcedure;
use App\Models\OtProgress;
use App\Models\OtRoom;
use App\Models\OtSchedule;
use App\Models\OtScheduleDetail;
use App\Models\OtSurgicalRequest;
use Carbon\Carbon;
use PhpOffice\PhpSpreadsheet\Calculation\TextData\Format;
use Yajra\Datatables\DataTables;


class OTScheduleController extends Controller
{
    public function index()
    {
        return view('ot.index');
    }

    public function getOTSchedule()
    {
        // $otSchedules = OtRegistration::all();
        return view('ot.operation-schedule');
    }

    public function calendarEvents(Request $request)
    {
        $events = OtScheduleDetail::join('ot_rooms', 'ot_schedule_details.ot_room', '=', 'ot_rooms.id')
            ->select(
                'ot_schedule_details.ot_day',
                'ot_schedule_details.ot_date',
                'ot_schedule_details.ot_name',
                'ot_schedule_details.from_time',
                'ot_schedule_details.to_time',
                'ot_schedule_details.sergeon_id',
                'ot_rooms.name as room_name'
            )
            ->get()
            ->map(function ($item) {
                // Convert comma-separated surgeon IDs to array
                $surgeonIds = explode(',', $item->sergeon_id);

                // Get names of surgeons
                $surgeonNames = User::whereIn('id', $surgeonIds)->pluck('name')->toArray();

                return [
                    'title' => 'OT - ' . $item->ot_name,
                    'room' => $item->room_name,
                    'start' => $item->ot_date . 'T' . date('H:i', strtotime($item->from_time)),
                    'end'   => $item->ot_date . 'T' . date('H:i', strtotime($item->to_time)),
                    'backgroundColor' => '#3788d8',
                    'borderColor' => '#3788d8',
                    'textColor' => '#fff',
                    'extendedProps' => [
                        'surgean' => $surgeonNames,
                    ],
                ];
            });

        return response()->json($events);
    }

    public function add_operation($section = null, $section_id = null)
    {
        $patient_details = $details = null;
        // dd($section, $section_id);
        if ($section == 'ipd') {
            $section_id = ed($section_id, false);
            $details = IpdRegister::where('id', @$section_id)->first();
            $patient_details = Patient::where('id', @$details->patient_id)->first();
        }
        $department = Department::where('status', '0')->get();
        $otpackages = OtPackage::where('status', '0')->get();
        $doctor = User::where('user_type', 'doctor')->where('is_active', 1)->where('is_delete', 0)->get();

        $data = compact('doctor', 'otpackages', 'department', 'patient_details', 'details');
        return view('ot.add-operation')->with($data);
    }

    public function save_operation(Request $request) // ot booking
    {
        $request->validate([
            'department_id' => 'required',
            'cons_doc' => 'required',
            'planned_date' => 'required',
            'name' => 'required',
            'phone' => 'required',
            'gender' => 'required',
            'package_id' => 'required',
        ]);

        $request->uhid ? $patient = Patient::find($request->uhid) : $patient = new Patient();
        $patient->name = ucwords($request->name);
        $patient->phone = $request->phone;
        $patient->gender = $request->gender;
        $patient->dob_year = $request->date_of_birth_year ?? 0;
        $patient->dob_month = $request->date_of_birth_month ?? 0;
        $patient->dob_day = $request->date_of_birth_day ?? 0;
        $patient->address = $request->address;
        $patient->save();
        $patient_id = $patient->id;

        $Operation = OtPackage::where('id', $request->package_id)->first();
        $ot = new OtRegistration();
        $ot->patient_id = $patient_id;
        $ot->ipd_id = $request->ipd_id;
        $ot->cons_doc = implode(',', $request->cons_doc);
        $ot->planned_date = $request->planned_date ? date('Y-m-d H:i', strtotime($request->planned_date)) : date('Y-m-d H:i:s');
        $ot->package_id = $request->package_id;
        $ot->operation_name = $Operation->package_name;
        $ot->department_id = $request->department_id;
        $ot->amount = $request->total_amount;
        if ($request->ipd_id != null) {
            $ot->is_admitted = 'yes';
        }
        $ot->status = 'Planned';
        $ot->register_by = Auth::user()->id;
        $ot->save();
        $ot_red_id = $ot->id;

        foreach ($request->charge_name as $key => $value) {
            $charge = Charge::select('charges.*', 'cc.charges_catagories_name')
                ->join('charges_catagories as cc', 'cc.id', '=', 'charges.sub_category_id')
                ->where('charges.id', $request->charge_name[$key])
                ->first();
            $ot_package_details =  new OtRegPackageDetail();
            $ot_package_details->ot_reg_id = $ot_red_id;
            $ot_package_details->ot_package_id = $request->package_id;
            $ot_package_details->charge_id = $request->charge_name[$key];
            $ot_package_details->charge_name = $charge->charge_name;
            $ot_package_details->rate = $request->rate[$key];
            $ot_package_details->save();
        }
        return redirect()->route('ot.all-ot-listing')->with('success', 'Operation planned successfully.');
    }

    public function ot_list(Request $request)
    {
        $title = 'OT List';
        if ($request->ajax()) {
            $data = OtRegistration::select(
                'ot_registrations.*',
                'patients.name as patient_name',
                'patients.phone',
                'patients.gender',
                'patients.dob_year',
                'patients.dob_month',
                'patients.dob_day',
                'users.name as doctor_name',
                'departments.department_name'
            )
                ->leftJoin('patients', 'ot_registrations.patient_id', '=', 'patients.id')
                ->leftJoin('users', 'ot_registrations.cons_doc', '=', 'users.id')
                ->leftJoin('departments', 'ot_registrations.department_id', '=', 'departments.id')
                ->orderBy('ot_registrations.id', 'DESC')
                ->get();

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('patient', function ($row) {
                    $patientBtn = '<a href="' . route('hr.patient-profile-details', ed($row->patient_id, true)) . '" data-placement="left" data-toggle="tooltip" title="Click here for patient details" style="cursor: pointer !important" data-original-title="Click here for patient details">
                    ' . $row->patient_name . ' (' . $row->patient_id . ')
                    <br>
                    <i class="fa fa-venus-mars text-blue"></i> ' . $row->gender . '
                    <i class="fa fa-calendar-plus-o text-blue ml-1"></i> ' . $row->dob_year . 'Y ' . $row->dob_month . 'M ' . $row->dob_day . 'D

                </a><br>';
                    $patientBtn .= '<i class="fa fa-phone text-primary"></i> ' . $row->phone . '';
                    return $patientBtn;
                })
                ->addColumn('doctor_name', function ($row) {
                    $doctorNames = '';
                    if ($row->cons_doc) {
                        $docIds = explode(',', $row->cons_doc);
                        $doctors = \App\Models\User::whereIn('id', $docIds)->pluck('name');
                        $doctorNames = $doctors->implode(', ');
                    }
                    return $doctorNames;
                })
                ->addColumn('details', function ($row) {
                    $detailsBtn = '<i class="fa fa-calendar-alt text-primary"></i> <b>Planned Dt: </b>' . dateFor($row->planned_date, true) . ' <br>
                        <i class="fa fa-rainbow text-primary"></i> <b>Dept: </b> ' . $row->department_name . '';

                    return $detailsBtn;
                })
                ->addColumn('status', function ($row) {
                    $admittedStatus = $row->is_admitted == 'no'
                        ? '<i class="fa fa-bed text-primary"></i> <span class="text-danger font-weight-bold">Not Admitted</span><br>'
                        : '<i class="fa fa-bed text-primary"></i> <span class="text-success" style="font-weight: 900;"><strong>Admitted</strong></span><br>';

                    // Handle operation status
                    $otStatus =  '<i class="fa fa-hourglass-half text-primary"></i> <span class="text-info font-weight-bold">' . $row->status . '</span>';


                    return $admittedStatus . $otStatus;
                })
                ->addColumn('action', function ($row) {
                    $actionBtn = '';
                    $actionBtn = '<a href="' . route('ot.ot-info', ed($row->id, true)) . '" class="btn btn-primary btn-sm mx-1" title="Click here to show bill details"><i class="fa fa-eye"></i> View</a>';
                    return $actionBtn;
                })
                ->rawColumns(['action', 'patient', 'doctor_name', 'details', 'status'])
                ->make(true);
        } else {
            return view('ot.ot-listing', compact('title'));
        }
    }

    public function ot_info($id)
    {
        $id = ed($id, false);

        // Fetch OT registration info with related joins
        $info = OtRegistration::select(
            'ot_registrations.*',
            'patients.name as patient_name',
            'patients.phone',
            'patients.gender',
            'patients.dob_year',
            'patients.dob_month',
            'patients.dob_day',
            'users.name as doctor_name',
            'departments.department_name',
            'ot_registrations.planned_date',
        )
            ->leftJoin('patients', 'ot_registrations.patient_id', '=', 'patients.id')
            ->leftJoin('users', 'ot_registrations.cons_doc', '=', 'users.id')
            ->leftJoin('departments', 'ot_registrations.department_id', '=', 'departments.id')
            ->where('ot_registrations.id', $id)
            ->first();

        $ot_preparation = OtPreparation::select(
            'ot_preparation.*',
            'users.name as created_by',
            'ot.test_name' // fetch raw IDs from surgical request
        )
            ->leftJoin('users', 'ot_preparation.created_by', '=', 'users.id')
            ->leftJoin('ot_surgical_request as ot', 'ot_preparation.ot_surg_req_id', '=', 'ot.id')
            ->where('ot_preparation.ot_reg_id', $id)
            ->first();

        $ot_schedule_details = OtScheduleDetail::select(
            'ot_schedule_details.*',
            'ot_rooms.name as room_name',
            'departments.department_name',
        )->leftjoin('ot_rooms', 'ot_schedule_details.ot_room', '=', 'ot_rooms.id')
            ->leftJoin('departments', 'ot_schedule_details.dept_id', '=', 'departments.id')
            ->where('ot_schedule_details.ot_reg_id', $id)
            ->first();

        $ot_progress = OtProgress::select(
            'ot_progress.*',
            'ot_registrations.id',
            'ot_registrations.operation_name as operation_name',
            'ot_surgical_request.id',
            'ot_procedures.code as procedure_code',
            'ot_procedure_names.name as procedure_name',
            'cssd_kitboxes.name as sterilized_kit_name',
        )
            ->leftJoin('ot_registrations', 'ot_registrations.id', '=', 'ot_progress.ot_reg_id')
            ->leftjoin('ot_surgical_request', 'ot_surgical_request.ot_reg_id', '=', 'ot_progress.ot_reg_id')
            ->leftJoin('ot_procedures', 'ot_surgical_request.procedure_code', '=', 'ot_procedures.id')
            ->leftJoin('ot_procedure_names', 'ot_surgical_request.procedure_name', '=', 'ot_procedure_names.id')
            ->leftJoin('cssd_kitboxes', 'ot_progress.kit_id', '=', 'cssd_kitboxes.id')
            ->where('ot_progress.ot_reg_id', $id)
            ->first();

        // $fromTime = Carbon::parse($ot_schedule_details->from_time);
        // $toTime = Carbon::parse($ot_schedule_details->to_time);
        // $now = Carbon::now();

        // if ($now->lt($fromTime)) {
        //     $progress = 0;
        // } elseif ($now->gt($toTime)) {
        //     $progress = 100;
        // } else {
        //     $totalDuration = $toTime->diffInSeconds($fromTime);
        //     $elapsed = $now->diffInSeconds($fromTime);
        //     $progress = ($elapsed / $totalDuration) * 100;
        //     $progress = round($progress, 2); // Round to 2 decimal places
        // }

        if ($ot_schedule_details) {
            $sergeonIds = explode(',', $ot_schedule_details->sergeon_id ?? '');
            $sergeonNames = User::whereIn('id', $sergeonIds)->pluck('name')->implode(', ');
            @$ot_schedule_details->surgeon_name = @$sergeonNames;

            $anaesthesiaIds = explode(',', $ot_schedule_details->anaesthesia_id ?? '');
            $anaesthesiaNames = User::whereIn('id', $anaesthesiaIds)->pluck('name')->implode(', ');
            @$ot_schedule_details->anaesthesia_name = @$anaesthesiaNames;

            $nurseIds = explode(',', $ot_schedule_details->nurse_id ?? '');
            $nurseNames = User::whereIn('id', $nurseIds)->pluck('name')->implode(', ');
            @$ot_schedule_details->nurse_name = @$nurseNames;

            $ot_technicianIds = explode(',', $ot_schedule_details->technician_id ?? '');
            $ot_technicianNames = User::whereIn('id', $ot_technicianIds)->pluck('name')->implode(', ');
            @$ot_schedule_details->ot_technician_name = @$ot_technicianNames;
        }

        $doctorIds = explode(',', @$info->cons_doc);
        $doctorNames = User::whereIn('id', $doctorIds)->pluck('name')->implode(', ');
        $info->doctor_names = $doctorNames;
        if ($ot_preparation) {
            $testIds = explode(',', $ot_preparation->test_name ?? '');
            $testNames = Charge::whereIn('id', $testIds)->pluck('charge_name');
            @$ot_preparation->test_names = @$testNames;
        }
        // Safely check if record exists
        if (!$info) {
            return redirect()->back()->with('error', 'OT Registration not found.');
        }

        // Get patient info
        $info->patient_info = Patient::select('patients.*', 's.name as state_name', 'dist.name as district_name')
            ->leftJoin('districts as dist', 'dist.id', '=', 'patients.district')
            ->leftJoin('states as s', 's.id', '=', 'patients.state')
            ->where('patients.id', $info->patient_id)
            ->first();

        return view('ot.ot-info', compact('info', 'ot_preparation', 'ot_schedule_details', 'ot_progress'));
    }

    // public function getProgressPercentage($id)
    // {
    //     $schedule = OtScheduleDetail::where('ot_reg_id', $id)->first();

    //     if (!$schedule) {
    //         return response()->json(['progress' => 0]);
    //     }

    //     $fromTime = Carbon::parse($schedule->from_time);
    //     $toTime = Carbon::parse($schedule->to_time);
    //     $now = Carbon::now();

    //     if ($now->lt($fromTime)) {
    //         $progress = 0;
    //     } elseif ($now->gt($toTime)) {
    //         $progress = 100;
    //     } else {
    //         $total = $toTime->diffInSeconds($fromTime);
    //         $elapsed = $now->diffInSeconds($fromTime);
    //         $progress = round(($elapsed / $total) * 100, 2);
    //     }

    //     return response()->json(['progress' => $progress]);
    // }


    public function getProgressPercentage($id)
    {
        $schedule = OtScheduleDetail::where('ot_reg_id', $id)->first();

        if (!$schedule) {
            return response()->json(['progress' => 0]);
        }

        $otDate = Carbon::parse($schedule->ot_date)->toDateString();
        $currentDate = Carbon::now()->toDateString();

        // If the OT date is not today, return 0% progress
        if ($otDate !== $currentDate) {
            return response()->json(['progress' => 0]);
        }

        $fromTime = Carbon::parse($schedule->from_time);
        $toTime = Carbon::parse($schedule->to_time);
        $now = Carbon::now();

        if ($now->lt($fromTime)) {
            $progress = 0;
        } elseif ($now->gt($toTime)) {
            $progress = 100;
        } else {
            $total = $toTime->diffInSeconds($fromTime);
            $elapsed = $now->diffInSeconds($fromTime);
            $progress = round(($elapsed / $total) * 100, 2);
        }

        return response()->json(['progress' => $progress]);
    }

    public function add_operation_schedule_details($section = null, $section_id = null)
    {
        $section_id = ed($section_id, false);
        // dd($section_id);

        $procedure = OtProcedure::where('status', '0')->get();
        $department = Department::where('status', '0')->get();
        $nurse = User::where('role_id', 18)->where('is_active', 1)->where('is_delete', 0)->get();
        $ot_technician = User::where('role_id', 19)->where('is_active', 1)->where('is_delete', 0)->get();
        $ot_rooms = OtRoom::where('is_used', 'no')->where('status', 0)->get();
        $ot_registration = OtRegistration::where('id', $section_id)->first();
        $otpackages = OtPackage::where('type', 'normal')->where('status', '0')->get();
        $ottimepackages = OtPackage::where('type', 'time')->where('status', '0')->get();
        $tests = Charge::where('charge_type', 'investigation')->get();
        $edit_request = OtSurgicalRequest::where('ot_reg_id', $section_id)->first();

        $data = compact('procedure', 'department', 'nurse', 'ot_technician', 'ot_rooms', 
        'ot_registration', 'otpackages', 'ottimepackages', 'tests', 'edit_request');
        return view('ot.add-operation-surgical')->with($data);
    }

    public function save_operation_request(Request $request) // ot add operation details
    {
        $request->validate([
            'ot_reg_id' => 'required',
            'patient_id' => 'required',
            'procedure_code' => 'required',
            'procedure_name' => 'required',
            'proposed_date' => 'required',
            'from_time' => 'required',
            'to_time' => 'required',
            'ot_room' => 'required',
            'department_id' => 'required',
            // 'surgeon_name' => 'required',
            // 'anaesthetist_name' => 'required',
            'package_id' => 'required',

        ]);

        $ot_surgical = new OtSurgicalRequest();
        $ot_surgical->ot_reg_id = $request->ot_reg_id;
        $ot_surgical->patient_id = $request->patient_id;
        $ot_surgical->procedure_code = $request->procedure_code;
        $ot_surgical->procedure_name = $request->procedure_name;
        $ot_surgical->proposed_ot_date = date('Y-m-d', strtotime($request->proposed_date));
        $ot_surgical->from_time = Carbon::parse($request->from_time)->format('H:i');
        $ot_surgical->to_time = Carbon::parse($request->to_time)->format('H:i');
        $ot_surgical->department = $request->department_id;
        $ot_surgical->surgeon = !empty($request->surgeon_name) ? implode(',', $request->surgeon_name) : NULL;
        $ot_surgical->anaesthetist = !empty($request->anaesthetist_name) ? implode(',', $request->anaesthetist_name) : NULL;
        $ot_surgical->ot_room = $request->ot_room;
        $ot_surgical->ot_package = $request->package_id;
        $ot_surgical->blood_unit = $request->blood_unit;
        $ot_surgical->anesthesia_type = $request->anaesthesia_type;
        $ot_surgical->consent = $request->operation_consent ? 'yes' : 'no';
        $ot_surgical->done_by = Auth::user()->id;
        $ot_surgical->test_name = is_array($request->test_name) && !empty($request->test_name)
            ? implode(',', $request->test_name)
            : null;
        $ot_surgical->nurse = is_array($request->nurse_name) && !empty($request->nurse_name)
            ? implode(',', $request->nurse_name)
            : null;
        $ot_surgical->ot_technician = is_array($request->ot_technician_id) && !empty($request->ot_technician_id)
            ? implode(',', $request->ot_technician_id)
            : null;

        $ot_surgical->save();

        if($request->save == 'confirm'){
            $ot_registration = OtRegistration::find($request->ot_reg_id);
            $ot_registration->status = 'Requested';
            $ot_registration->save();
        }

        // $ot_registration = OtRegistration::find($request->ot_reg_id);
        // $ot_registration->status = 'Requested';
        // $ot_registration->save();

        return redirect()->route('ot.ot-info', ['id' => ed($request->ot_reg_id, true)])
            ->with('success', 'Operation Raised successfully.');
    }

    public function update_operation_request(Request $request)
    {

        // print_r($request->all());die;
        $request->validate([
            'id' => 'required', // ID of the record to update
            'ot_reg_id' => 'required',
            'patient_id' => 'required',
            'procedure_code' => 'required',
            'procedure_name' => 'required',
            'proposed_date' => 'required',
            'department_id' => 'required',
            // 'surgeon_name' => 'required',
            // 'anaesthetist_name' => 'required',
            'package_id' => 'required',
        ]);

        $ot_surgical = OtSurgicalRequest::where('id', $request->id)->first();
        $ot_surgical->procedure_code = $request->procedure_code;
        $ot_surgical->procedure_name = $request->procedure_name;
        $ot_surgical->proposed_ot_date = date('Y-m-d', strtotime($request->proposed_date));
        $ot_surgical->from_time = $request->from_time ? Carbon::parse($request->from_time)->format('H:i') : null;
        $ot_surgical->to_time = $request->to_time ? Carbon::parse($request->to_time)->format('H:i') : null;
        $ot_surgical->department = $request->department_id;
        $ot_surgical->surgeon = !empty($request->surgeon_name) ? implode(',', $request->surgeon_name) : NULL;
        $ot_surgical->anaesthetist = !empty($request->anaesthetist_name) ? implode(',', $request->anaesthetist_name) : NULL;
        $ot_surgical->ot_room = $request->ot_room;
        $ot_surgical->ot_package = $request->package_id;
        $ot_surgical->blood_unit = $request->blood_unit;
        $ot_surgical->anesthesia_type = $request->anaesthesia_type;
        $ot_surgical->consent = $request->operation_consent == 'yes' ? 'yes' : 'no';
        $ot_surgical->done_by = Auth::user()->id;
        $ot_surgical->test_name = !empty($request->test_name) ? implode(',', $request->test_name) : null;
        $ot_surgical->nurse = !empty($request->nurse_name) ? implode(',', $request->nurse_name) : null;
        $ot_surgical->ot_technician = !empty($request->ot_technician_id) ? implode(',', $request->ot_technician_id) : null;

        $ot_surgical->save();

        if($request->save == 'confirm'){
            $ot_registration = OtRegistration::find($request->ot_reg_id);
            $ot_registration->status = 'Requested';
            $ot_registration->save();
        }

        return redirect()->route('ot.ot-info', ['id' => ed($request->ot_reg_id, true)])
            ->with('success', 'Operation Request updated successfully.');
    }

    public function ot_preparation($section = null, $id)
    {
        $id = ed($id, false);
        $info = OtSurgicalRequest::where('ot_reg_id', $id)->first();
        $testIds = [];

        // Extract test IDs if available
        if ($info && $info->test_name) {
            $testIds = explode(',', $info->test_name);
        }
        
        $edit_preparation = OtPreparation::where('ot_reg_id', $id)->first();
        // print_r($edit_preparation);die;
        $ot_registration = OtRegistration::where('id', $id)->first();

        $existingInvestigationCharges = Investigation::where('patient_id', $ot_registration->patient_id)->where('report_status', '>=', 3)
            ->pluck('charge_id')->toArray();
        // print_r($existingInvestigationCharges);die;
        // $all_test_ids = [];
        // if( !empty($testIds) && !empty($existingInvestigationCharges) ){
        //     $all_test_ids = array_unique(array_merge($testIds, $existingInvestigationCharges));
        // } elseif( !empty($testIds) && empty($existingInvestigationCharges) ){
        //     $all_test_ids = $testIds;
        // } elseif( empty($testIds) && !empty($existingInvestigationCharges) ){
        //     $all_test_ids = $existingInvestigationCharges;
        // }

        $testNames = Charge::whereIn('id', $testIds)->get(['id', 'charge_name']);
        $existingTestNames = Charge::whereIn('id', $existingInvestigationCharges)->get(['id', 'charge_name']);
        // dd($testNames);die;

        $data = compact('info', 'testNames', 'edit_preparation', 'existingInvestigationCharges', 'existingTestNames');

        return view('ot.ot-preparation')->with($data);
    }

    public function save_ot_preparation(Request $request)
    {

        $ot_preparation =  new OtPreparation();
        $ot_preparation->ot_reg_id = $request->ot_reg_id;
        $ot_preparation->ot_surg_req_id = $request->ot_surg_id;
        $ot_preparation->patient_id = $request->patient_id;
        // $ot_preparation->preparation_date = date('Y-m-d H:i:s');
        $ot_preparation->who_validation = $request->who_validation;
        $ot_preparation->asa_score = $request->asa_score;
        $ot_preparation->co_morbidity = $request->co_morbidity;
        $ot_preparation->test_confirmation = $request->test_confirmation;
        $ot_preparation->reschedule_reason = $request->reschedule_reason;

        if ($request->hasFile('consent_file')) {
            $file = $request->file('consent_file');
            $filename = 'consent_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/consent_files'), $filename); // Save to /public/uploads/consent_files
            $ot_preparation->consent_file = 'uploads/consent_files/' . $filename;
        }

        $ot_preparation->created_by = Auth::user()->id;
        $ot_preparation->reschedule_check = $request->reschedule_check;
        ($request->save == '2') ? $ot_preparation->status = 'Confirmed' : $ot_preparation->status = 'Draft';
        $ot_preparation->save();

        if ($request->save == '2') {
            $ot_surgical = OtSurgicalRequest::where('id', $request->ot_surg_id)->first();
            $ot_surgical->ot_status = 'Confirmed';
            $ot_surgical->save();

            $ot_registration = OtRegistration::where('id', $request->ot_reg_id)->first();
            $ot_registration->status = 'Prepared';
            $ot_registration->save();
        }


        return redirect()->route('ot.ot-info', ['id' => ed($request->ot_reg_id, true)])
            ->with('success', 'OT preparation saved successfully.');
    }

    public function update_ot_preparation(Request $request)
    {
        $ot_preparation = OtPreparation::where('id', $request->preparation_id)->first();

        if (!$ot_preparation) {
            return redirect()->back()->with('error', 'Preparation record not found.');
        }

        $ot_preparation->who_validation = $request->who_validation;
        $ot_preparation->asa_score = $request->asa_score;
        $ot_preparation->co_morbidity = $request->co_morbidity;
        $ot_preparation->test_confirmation = $request->test_confirmation;
        $ot_preparation->reschedule_reason = $request->reschedule_reason;
        $ot_preparation->reschedule_check = $request->reschedule_check;
        $ot_preparation->updated_by = Auth::user()->id; // optional: if you track updates

        if ($request->hasFile('consent_file')) {
            $file = $request->file('consent_file');
            $filename = 'consent_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/consent_files'), $filename);
            $ot_preparation->consent_file = 'uploads/consent_files/' . $filename;
        }

        $ot_preparation->status = ($request->save == '2') ? 'Confirmed' : 'Draft';
        $ot_preparation->save();

        if ($request->save == '2') {
            OtSurgicalRequest::where('id', $request->ot_surg_id)->update(['ot_status' => 'Confirmed']);
            OtRegistration::where('id', $request->ot_reg_id)->update(['status' => 'Prepared']);
        }

        return redirect()->route('ot.ot-info', ['id' => ed($request->ot_reg_id, true)])
            ->with('success', 'OT preparation updated successfully.');
    }

    public function ot_schedule_confirmation($section = null, $id)
    {
        $section_id = ed($id, false);

        $department = Department::where('status', '0')->get();
        $nurse = User::where('role_id', 18)->where('is_active', 1)->where('is_delete', 0)->get();
        $ot_technician = User::where('role_id', 19)->where('is_active', 1)->where('is_delete', 0)->get();
        $ot_rooms = OtRoom::where('is_used', 'no')->where('status', 0)->get();

        $ot_surgical_request = OtSurgicalRequest::where('ot_reg_id', $section_id)->first();
        $ot_preparation = OtPreparation::where('ot_reg_id', $section_id)->first();
        $ot_registration = OtRegistration::where('id', $section_id)->first();
        $edit_schedule = OtScheduleDetail::where('ot_reg_id', $section_id)->first();
        $billing = Billing::where('section', 'OT')->where('section_id', $section_id)->first();
        // print_r($billing->id);die;

        $data = compact('department', 'nurse', 'ot_technician', 'ot_rooms', 'ot_surgical_request', 'ot_preparation', 'ot_registration', 'edit_schedule', 'billing');
        return view('ot.create-ot-schedule')->with($data);
    }

    public function save_ot_schedule(Request $request)
    {

        $request->validate([
            'ot_reg_id' => 'required',
            'ot_surg_req_id' => 'required',
            'ot_room' => 'required',
            'ot_date' => 'required',
            'from_time' => 'required',
            'to_time' => 'required',
            'department_id' => 'required'
        ]);

        $dayOfWeek = date('l', strtotime(date('Y-m-d', strtotime($request->ot_date))));
        $ot_schedule = new OtScheduleDetail();
        $ot_schedule->ot_reg_id = $request->ot_reg_id;
        $ot_schedule->ot_surg_req_id = $request->ot_surg_req_id;
        $ot_schedule->ot_preparation_id = $request->ot_preparation_id;
        $ot_schedule->patient_id = $request->patient_id;
        $ot_schedule->dept_id = $request->department_id;
        $ot_schedule->ot_date = date('Y-m-d', strtotime($request->ot_date));
        $ot_schedule->ot_day = $dayOfWeek;
        $ot_schedule->from_time = Carbon::parse($request->from_time)->format('H:i');
        $ot_schedule->to_time = Carbon::parse($request->to_time)->format('H:i');
        $ot_schedule->ot_room = $request->ot_room;
        $ot_schedule->ot_name = $request->ot_name;

        $ot_schedule->flags = is_array($request->flags) && !empty($request->flags)
            ? implode(',', $request->flags)
            : null;
        $ot_schedule->nurse_id = is_array($request->nurse_name) && !empty($request->nurse_name)
            ? implode(',', $request->nurse_name)
            : null;
        $ot_schedule->technician_id = is_array($request->ot_technician) && !empty($request->ot_technician)
            ? implode(',', $request->ot_technician)
            : null;
        $ot_schedule->sergeon_id = !empty($request->surgeon_name) ? implode(',', $request->surgeon_name) : NULL;
        $ot_schedule->anaesthesia_id = !empty($request->anaesthetist_name) ? implode(',', $request->anaesthetist_name) : NULL;
        $ot_schedule->created_by = Auth::user()->id;
        $ot_schedule->save();

        // Update the OT room status
        if ($request->save == 'proceed') {
            //SAVE in Billing Section
            $ot_reg_package_details = OtRegistration::where('id', $ot_schedule->ot_reg_id)->first();
            $total_ot_amount = $ot_reg_package_details->amount;
            $bill = new Billing();
            $bill->uid = Billing::where('section', 'OT')->selectRaw('MAX(CAST(uid AS UNSIGNED)) as max_uid')->value('max_uid') + 1;
            $bill->section = 'OT';
            $bill->section_id = $ot_schedule->ot_reg_id;
            $bill->bill_date = date('Y-m-d H:i:s');
            $bill->patient_id = $ot_schedule->patient_id;
            // $bill->doctor_id = $request->cons_doctor;
            $bill->total = $total_ot_amount;
            $bill->sub_total = $total_ot_amount;
            $bill->total_payment = 0.00;
            $bill->due_amount = $total_ot_amount;
            $bill->grand_total = $total_ot_amount;
            $bill->status = 'Done';
            $bill->bill_status = 1;
            $bill->created_by = Auth::user()->id;
            $bill->save();
            $bill_id = $bill->id;

            //SAVE in Billing Details
            $ot_reg_package_details = OtRegPackageDetail::where('ot_reg_id', $ot_schedule->ot_reg_id)->get();
            // dd($ot_reg_package_details);
            foreach ($ot_reg_package_details as $value) {
                $charge = Charge::select('charges.*', 'cc.charges_catagories_name')
                    ->join('charges_catagories as cc', 'cc.id', '=', 'charges.sub_category_id')
                    ->where('charges.id', $value->charge_id)
                    ->first();

                $bill_details =  new BillingDetail();
                $bill_details->billing_id = $bill_id;
                $bill_details->charge_category_id = $charge->category_id;
                $bill_details->charge_sub_category_id = $charge->sub_category_id;
                $bill_details->date = date('Y-m-d H:i:s');
                $bill_details->charge_id = $value->charge_id;
                $bill_details->charge_name = $charge->charge_name;
                $bill_details->standard_charges = $value->rate;
                $bill_details->qty = 1;
                $bill_details->amount = $value->rate;
                $bill_details->save();
            }

            OtRegistration::where('id', $request->ot_reg_id)->update(['status' => 'Inprogress']);
            OtRoom::where('id', $request->ot_room)->update(['is_used' => 'yes']);

        } else {

            if (@$ot_schedule) {
                OtRoom::where('id', $request->ot_room)->update(['booked' => 'yes']);
                OtRegistration::where('id', $request->ot_reg_id)->update(['status' => 'Scheduled']);
            }

        }

        return redirect()->route('ot.ot-info', ['id' => ed($request->ot_reg_id, true)])
            ->with('success', 'OT Schedule created successfully.');
    }

    public function update_ot_schedule(Request $request)
    {
        $request->validate([
            'schedule_id' => 'required',
            'ot_reg_id' => 'required',
            'ot_surg_req_id' => 'required',
            'ot_room' => 'required',
            'ot_date' => 'required',
            'from_time' => 'required',
            'to_time' => 'required',
            'department_id' => 'required'
        ]);

        $ot_schedule = OtScheduleDetail::where('id', $request->schedule_id)->first();

        if (!$ot_schedule) {
            return redirect()->back()->with('error', 'Schedule not found.');
        }

        $dayOfWeek = date('l', strtotime($request->ot_date));
        $ot_schedule->dept_id = $request->department_id;
        $ot_schedule->ot_date = date('Y-m-d', strtotime($request->ot_date));
        $ot_schedule->ot_day = $dayOfWeek;
        $ot_schedule->from_time = Carbon::parse($request->from_time)->format('H:i');
        $ot_schedule->to_time = Carbon::parse($request->to_time)->format('H:i');
        $ot_schedule->ot_room = $request->ot_room;
        $ot_schedule->ot_name = $request->ot_name;

        $ot_schedule->flags = is_array($request->flags) && !empty($request->flags)
            ? implode(',', $request->flags)
            : null;
        $ot_schedule->nurse_id = is_array($request->nurse_name) && !empty($request->nurse_name)
            ? implode(',', $request->nurse_name)
            : null;
        $ot_schedule->technician_id = is_array($request->ot_technician) && !empty($request->ot_technician)
            ? implode(',', $request->ot_technician)
            : null;
        $ot_schedule->sergeon_id = !empty($request->surgeon_name) ? implode(',', $request->surgeon_name) : NULL;
        $ot_schedule->anaesthesia_id = !empty($request->anaesthetist_name) ? implode(',', $request->anaesthetist_name) : NULL;
        $ot_schedule->updated_by = Auth::user()->id; // Optional if you're tracking updates

        $ot_schedule->save();

        if ($request->save == 'proceed') {
            //SAVE in Billing Section
            $ot_reg_package_details = OtRegistration::where('id', $ot_schedule->ot_reg_id)->first();
            $total_ot_amount = $ot_reg_package_details->amount;
            $bill = new Billing();
            $bill->uid = Billing::where('section', 'OT')->selectRaw('MAX(CAST(uid AS UNSIGNED)) as max_uid')->value('max_uid') + 1;
            $bill->section = 'OT';
            $bill->section_id = $ot_schedule->ot_reg_id;
            $bill->bill_date = date('Y-m-d H:i:s');
            $bill->patient_id = $ot_schedule->patient_id;
            // $bill->doctor_id = $request->cons_doctor;
            $bill->total = $total_ot_amount;
            $bill->sub_total = $total_ot_amount;
            $bill->total_payment = 0.00;
            $bill->due_amount = $total_ot_amount;
            $bill->grand_total = $total_ot_amount;
            $bill->status = 'Done';
            $bill->bill_status = 1;
            $bill->created_by = Auth::user()->id;
            $bill->save();
            $bill_id = $bill->id;

            //SAVE in Billing Details
            $ot_reg_package_details = OtRegPackageDetail::where('ot_reg_id', $ot_schedule->ot_reg_id)->get();
            // dd($ot_reg_package_details);
            foreach ($ot_reg_package_details as $value) {
                $charge = Charge::select('charges.*', 'cc.charges_catagories_name')
                    ->join('charges_catagories as cc', 'cc.id', '=', 'charges.sub_category_id')
                    ->where('charges.id', $value->charge_id)
                    ->first();

                $bill_details =  new BillingDetail();
                $bill_details->billing_id = $bill_id;
                $bill_details->charge_category_id = $charge->category_id;
                $bill_details->charge_sub_category_id = $charge->sub_category_id;
                $bill_details->date = date('Y-m-d H:i:s');
                $bill_details->charge_id = $value->charge_id;
                $bill_details->charge_name = $charge->charge_name;
                $bill_details->standard_charges = $value->rate;
                $bill_details->qty = 1;
                $bill_details->amount = $value->rate;
                $bill_details->save();
            }
            OtRegistration::where('id', $request->ot_reg_id)->update(['status' => 'Inprogress']);
            OtRoom::where('id', $request->ot_room)->update(['is_used' => 'yes']);
        }

        // Update OT Room and Registration statuses
        // OtRoom::where('id', $request->ot_room)->update(['booked' => 'yes']);
        // OtRegistration::where('id', $request->ot_reg_id)->update(['status' => 'Scheduled']);

        return redirect()->route('ot.ot-info', ['id' => ed($request->ot_reg_id, true)])
            ->with('success', 'OT Schedule updated successfully.');
    }

    public function ot_progress($section = null, $id)
    {

        $section_id = ed($id, false);
        $ot_registration = OtRegistration::where('id', $section_id)->first();
        $ot_schedule_details = OtScheduleDetail::where('ot_reg_id', $section_id)->first();
        $ot_preparation = OtPreparation::where('ot_reg_id', $section_id)->first();
        $ot_surgical_request = OtSurgicalRequest::where('ot_reg_id', $section_id)->first();
        $cssd_instrument = CssdKitbox::where('status', '=', 'sterilized')->get();
        $edit_ot_progress = OtProgress::where('ot_reg_id', $section_id)->first();
        $data = compact('ot_registration', 'ot_schedule_details', 'ot_preparation', 'ot_surgical_request', 'cssd_instrument', 'edit_ot_progress');
        return view('ot.ot-progress')->with($data);
    }

    public function save_ot_progress(Request $request)
    {
        $request->validate([
            'ot_reg_id' => 'required',
            'patient_id' => 'required',
            'kit_id'   => 'required|array|min:1',  // must be an array with at least 1 item
            'kit_id.*' => 'string|distinct'
        ]);

        $ot_progress = new OtProgress();
        $ot_progress->ot_reg_id = $request->ot_reg_id;
        $ot_progress->ot_schedule_id = $request->ot_schedule_id;
        $ot_progress->patient_id = $request->patient_id;
        $ot_progress->kit_id = implode(',', $request->kit_id);
        $ot_progress->created_by   = Auth::user()->id;
        $ot_progress->device_used     = json_encode(is_array($request->device_used) ? array_values($request->device_used) : []);
        $ot_progress->fluid_administrative     = json_encode(is_array($request->fluid_administrative) ? array_values($request->fluid_administrative) : []);
        $ot_progress->anesthetic_drugs     = json_encode(is_array($request->anesthetic_drugs) ? array_values($request->anesthetic_drugs) : []);
        $ot_progress->save();

        if ($request->save == 'complete') {

            OtRegistration::where('id', $request->ot_reg_id)->update(['status' => 'Completed']);
            OtRoom::where('id', $request->ot_room)->update(['is_used' => 'no']);
            OtScheduleDetail::where('ot_reg_id', $request->ot_reg_id)->update(['to_time' => date('H:i')]);
            
        }

        return redirect()->route('ot.ot-info', ['id' => ed($request->ot_reg_id, true)])
            ->with('success', 'OT Progress updated successfully.');
    }

    public function update_ot_progress(Request $request)
    {
        $request->validate([
            'ot_progress_id' => 'required',
            'ot_reg_id' => 'required',
            'patient_id' => 'required',
            'incision_time' => 'required',
            'closure_time' => 'required',
            'discrepancy_flag' => 'required',
            'kit_id'   => 'required|array|min:1',  // must be an array with at least 1 item
            'kit_id.*' => 'string|distinct'
        ]);

        $ot_progress = OtProgress::where('id', $request->ot_progress_id)->first();

        if (!$ot_progress) {
            return redirect()->back()->with('error', 'OT Progress record not found.');
        }

        $ot_progress->kit_id = implode(',', $request->kit_id);
        $ot_progress->device_used = json_encode(is_array($request->device_used) ? array_values($request->device_used) : []);
        $ot_progress->fluid_administrative = json_encode(is_array($request->fluid_administrative) ? array_values($request->fluid_administrative) : []);
        $ot_progress->anesthetic_drugs = json_encode(is_array($request->anesthetic_drugs) ? array_values($request->anesthetic_drugs) : []);
        $ot_progress->vitals = json_encode(is_array($request->vitals) ? array_values($request->vitals) : []);
        $ot_progress->blood_loss = $request->blood_loss;
        $ot_progress->incision_time = date('H:i', strtotime($request->incision_time));
        if ($request->closure_time) $ot_progress->closure_time = date('H:i', strtotime($request->closure_time));
        $ot_progress->discrepency_flags = $request->discrepancy_flag;
        $ot_progress->updated_by = Auth::user()->id;
        $ot_progress->save();

        if ($request->save == 'complete') {

            OtRegistration::where('id', $request->ot_reg_id)->update(['status' => 'Completed']);
            OtRoom::where('id', $request->ot_room)->update(['is_used' => 'no']);
            OtScheduleDetail::where('ot_reg_id', $request->ot_reg_id)->update(['to_time' => date('H:i')]);
        }

        return redirect()->route('ot.ot-info', ['id' => ed($request->ot_reg_id, true)])
            ->with('success', 'OT Progress updated successfully.');
    }

    // public function ot_test_preparation_update(Request $request)
    // {
    //     dd($request->all());
    //     $ot_preparation = OtPreparation::where('id', $request->ot_preparation_id)->first();
    //     $finalTestData = [];

    //     foreach ($request->input('test', []) as $testId => $testData) {
    //         // Checkbox checked
    //         if (!empty($testData['confirmed'])) {
    //             $finalTestData[] = $testId;
    //         }

    //         // File uploaded
    //         if ($request->hasFile("test.$testId.file")) {
    //             $file = $request->file("test")[$testId]['file'];
    //             if ($file && $file->isValid()) {
    //                 $destinationPath = public_path('test_upload');
    //                 $fileName = time() . '_' . uniqid() . '_' . $file->getClientOriginalName();
    //                 $file->move($destinationPath, $fileName);

    //                 $finalTestData[] = $fileName;
    //             }
    //         }
    //     }

    //     $ot_preparation->test_confirmation = $request->test_confirmation;
    //     $ot_preparation->test = implode(',', $finalTestData);
    //     $ot_preparation->save();

    //     return redirect()->back()->with('success', 'Test preparation updated successfully.');
    // }

    public function ot_test_preparation_update(Request $request)
    {
        $ot_preparation = OtPreparation::find($request->ot_preparation_id);
        if( !$ot_preparation ) {

            $ot_preparation = new OtPreparation;
            $ot_preparation->ot_reg_id = $request->ot_reg_id;
            $ot_preparation->ot_surg_req_id = $request->ot_surg_id;
            $ot_preparation->patient_id = $request->patient_id;
            $ot_preparation->created_by = Auth::user()->id;
            $ot_preparation->updated_by = Auth::user()->id;
        }

        $finalTestData = [];

        foreach ($request->input('test', []) as $testId => $testData) {
            // Case 1: If confirmed, save only the ID and skip file upload
            if (!empty($testData['confirmed'])) {
                $finalTestData[] = $testId;
                continue;
            }

            // Case 2: Not confirmed, but file uploaded — save only file name
            if ($request->hasFile("test.$testId.file")) {
                $file = $request->file("test.$testId.file");

                if ($file && $file->isValid()) {
                    $destinationPath = public_path('test_upload');
                    if (!file_exists($destinationPath)) {
                        mkdir($destinationPath, 0755, true);
                    }

                    $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                    $file->move($destinationPath, $fileName);

                    $finalTestData[] = $fileName;
                }
            }
        }

        $ot_preparation->test_confirmation = $request->test_confirmation;
        $ot_preparation->test = implode(',', $finalTestData);
        $ot_preparation->save();

        return response()->json(['status' => true, 'message' => 'Test preparation updated successfully.']);
    }
}
