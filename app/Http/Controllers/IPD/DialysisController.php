<?php

namespace App\Http\Controllers\IPD;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\TpaManagement;
use App\Models\State;
use App\Models\Referral;
use App\Models\User;
use App\Models\Ward;
use App\Models\Bed;
use App\Models\DialysisRegister;
use App\Models\Patient;
use App\Models\Package;
use App\Models\Diagonase;
use App\Models\CaseReference;
use App\Models\PatientBedHistory;
use App\Models\PatientDoctorStatus;
use App\Models\DialysisMachineHistory;
use Exception;
use Illuminate\Routing\RedirectController;
use Yajra\Datatables\DataTables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DialysisController extends Controller
{

    public function index(Request $request){
        $doctor = User::where('user_type','doctor')->where('is_active', 1)->where('is_delete', 0)->get();
        if ($request->ajax()) {
            $data = DialysisRegister::select(
                'dialysis_registers.id', 'dialysis_registers.type','dialysis_registers.patient_id', 'dialysis_registers.admission_date','dialysis_registers.discharge_status',
                'p.name as patient_name', 'p.phone', 'p.gender','p.dob_year', 'p.dob_month', 'p.dob_day',
                'u1.name as doctor_name',
                'd.department_name', 'tpa.tpa_name', 'w.ward_name', 'dmh.machine_no', 'dmh.start_time', 'dmh.end_time',
                'b.bed_name', DB::raw('MAX(bi.id) as billing_id'), 'bi.due_amount'
            )
                ->join('patients as p', 'p.id', '=', 'dialysis_registers.patient_id')
                ->join('users as u1', 'u1.id', '=', 'dialysis_registers.doctor_id')
                ->join('departments as d', 'd.id', '=', 'dialysis_registers.department_id')
                ->join('tpa_managements as tpa', 'tpa.id', '=', 'dialysis_registers.insurance_id')
                ->join('wards as w', 'w.id', '=', 'dialysis_registers.ward_id')
                ->join('beds as b', 'b.id', '=', 'dialysis_registers.bed_id')
                ->leftJoin('dialysis_machine_history as dmh', 'dmh.dialysis_id', '=', 'dialysis_registers.id')
                ->leftJoin('billings as bi', function ($join) {
                    $join->on('bi.section_id', '=', 'dialysis_registers.id')
                        ->where('bi.section', '=', 'DIALYSIS');
                })
                ->where('dialysis_registers.is_delete',0)
                ->groupBy('dialysis_registers.id', 'p.name', 'p.phone', 'p.gender', 'p.dob_year',
                        'p.dob_month', 'p.dob_day', 'u1.name',  'd.department_name',
                        'tpa.tpa_name', 'w.ward_name', 'b.bed_name','bi.due_amount',
                        'dialysis_registers.type', 'dialysis_registers.patient_id',
                        'dialysis_registers.admission_date','dialysis_registers.discharge_status',
                        'dmh.machine_no', 'dmh.start_time', 'dmh.end_time')
                ->orderBy('dialysis_registers.id', 'DESC');

                // Filter based on field_name and field_value
                if (!empty($request->field_name) && !empty($request->field_value)) {
                    if ($request->field_name === 'dialysis_registers.doctor_id') {
                        $data->where('dialysis_registers.doctor_id', $request->field_value);
                    } else {
                        $data->where($request->field_name, 'LIKE', '%' . $request->field_value . '%');
                    }
                }

                // Filter by date range
                if (!empty($request->from_date)) {
                    $data->whereDate('dialysis_registers.admission_date', '>=', date('Y-m-d',strtotime($request->from_date)));
                }
                if (!empty($request->to_date)) {
                    $data->whereDate('dialysis_registers.admission_date', '<=', date('Y-m-d',strtotime($request->to_date)));
                }
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('patient', function($row){
                    $patientBtn = '<a href="'.route('hr.patient-profile-details',ed($row->patient_id, true)).'" data-placement="left" data-toggle="tooltip" title="Click here for patient details" style="cursor: pointer !important" data-original-title="Click here for patient details">
                        '.$row->patient_name.'
                        <br>
                        <i class="fa fa-venus-mars text-blue"></i> '.$row->gender.'
                        <i class="fa fa-calendar-plus-o text-blue ml-1"></i> '.$row->dob_year.'Y '.$row->dob_month.'M '.$row->dob_day.'D
                        <span class="badge badge-gradient-primary mt-2 ml-1">'.$row->type.'</span>
                    </a><br>';
                    $patientBtn .= '<i class="fa fa-phone text-primary"></i> '.$row->phone.'
                        <i class="fas fa-comment-dots mx-2"></i>
                    </a>';
                    return $patientBtn;
                })
                ->addColumn('doctor', function($row){
                    $doctorBtn = '<i class="fa fa-user-md text-primary"></i> <b>Under Doct: </b> DR. '.$row->doctor_name.' <br>
                        <i class="fa fa-box text-primary"></i> <b>Machine No: </b> '.$row->machine_no;
                    return $doctorBtn;
                })
                ->addColumn('details', function($row){
                    $detailsBtn = '<i class="fa fa-calendar-alt text-primary"></i> <b>Adm Dt: </b>'.dateFor($row->admission_date, true).' <br>
                        <i class="fa fa-rainbow text-primary"></i> <b>Dept: </b> '.$row->department_name.' <br>
                        <i class="fas fa-clinic-medical text-primary"></i> <b>Patient Type: </b>'.$row->tpa_name;

                    return $detailsBtn;
                })
                ->addColumn('bed', function($row){
                    $bedBtn = '<i class="fa fa-bed"></i> <b>Bed:</b> '.$row->bed_name.' <br>
                        <i class="fas fa-yin-yang"></i> <b>Ward:</b> '.$row->ward_name;
                    return $bedBtn;
                })
                ->addColumn('action', function($row){
                    if($row->billing_id){
                        $actionBtn = '<a href="'.route('bill.billing-details', ['dialysis', ed($row->billing_id, true)]).'" class="btn btn-primary btn-sm mx-1" title="Click here to show bill details"><i class="fa fa-eye"></i> View</a>';
                    }else{
                        $actionBtn = '<a href="'.route('ipd.dialysis-info', ed($row->id, true)).'" class="btn btn-primary btn-sm mx-1" title="Click here to show bill details"><i class="fa fa-eye"></i> View</a>';
                    }
                    return $actionBtn;
                })
                ->rawColumns(['action','patient','doctor','details','bed'])
                ->make(true);
        }
        $data = compact('doctor');
        return view('ipd.dialysis')->with($data);
    }

    public function dialysis_info($id){
        $id = ed($id, false);
        $tpa = TpaManagement::where('status','0')->get();
        $doctor = User::where('user_type','doctor')->where('is_active', 1)->where('is_delete', 0)->get();
        $info = DialysisRegister::select('dialysis_registers.*','u1.name as doctor_name','u1.salutation','u1.qualification','u1.experience','u1.specialization','d.department_name','tpa.tpa_name','w.ward_name','b.bed_name')
            ->join('users as u1','u1.id','=','dialysis_registers.doctor_id')
            ->join('departments as d','d.id','=','dialysis_registers.department_id')
            ->join('tpa_managements as tpa','tpa.id','=','dialysis_registers.insurance_id')
            ->join('wards as w','w.id','=','dialysis_registers.ward_id')
            ->join('beds as b','b.id','=','dialysis_registers.bed_id')
            ->where('dialysis_registers.id',$id)
            ->first();
        $info->patient_info = Patient::select('patients.*','s.name as state_name','d.name as district_name')
            ->leftjoin('districts as d','d.id','=','patients.district')
            ->leftjoin('states as s','s.id','=','patients.state')
            ->where('patients.id',$info->patient_id)
            ->first();
        $info->referral_name = Referral::select('referral_name as name')->where('id',$info->referred_by)->first();
        $info->provider_name = Referral::select('referral_name as name')->where('id',$info->provider)->first();
        $info->market_by_name = Referral::select('referral_name as name')->where('id',$info->market_by)->first();
        $data = compact('tpa','doctor','info');
        // dd($data);
        return view('ipd.dialysis-info')->with($data);
    }

    public function edit_admission($dialysis_id){
        $dialysis_id = ed($dialysis_id, false);
        $tpa = TpaManagement::where('status','0')->get();
        $states = State::where('country_id','1')->get();
        $wards = Ward::where('ward_name', '=', 'DIALYSIS')->where('status','0')->get();
        $referral = Referral::where('type','referral')->where('is_active', 1)->where('is_delete', 0)->get();
        $provider = Referral::where('type','provider')->where('is_active', 1)->where('is_delete', 0)->get();
        $market_by = Referral::where('type','market_by')->where('is_active', 1)->where('is_delete', 0)->get();
        $doctor = User::where('user_type','doctor')->where('is_active', 1)->where('is_delete', 0)->get();

        $info = DialysisRegister::select('dialysis_registers.*','b.bed_name', 'dmh.machine_no', 'dmh.start_time', 'dmh.end_time')
            ->join('beds as b','b.id','=','dialysis_registers.bed_id')
            ->leftJoin('dialysis_machine_history as dmh','dmh.dialysis_id','=','dialysis_registers.id')
            ->where('dialysis_registers.id',$dialysis_id)
            ->first();
        $info->patient_info = Patient::select('patients.*')
            ->where('patients.id',$info->patient_id)
            ->first();
        $data = compact('tpa','states','wards','referral','provider','market_by','doctor','info');
        // dd($data);
        return view('ipd.dialysis-edit')->with($data);
    }

    public function dialysis_register($section = null, $section_id = null){

        if($section && $section_id){
            $section_id = ed($section_id, false);
            $model = "App\\Models\\".ucwords($section)."Register";
            $section_info = $model::where('id', $section_id)->first();
            if( empty($section_info) ){
                return redirect()->back();
            }
            $patient_info = Patient::where('id', $section_info->patient_id)->first();
            $moved_by = strtoupper($section);
        }else{
            $section_info = $patient_info = null;
            $moved_by = 'DIRECT';
        }
        $tpa = TpaManagement::where('status','0')->get();
        $states = State::where('country_id','1')->get();
        $wards = Ward::where('ward_name', '=', 'DIALYSIS')->where('status','0')->get();
        $referral = Referral::where('type','referral')->where('is_active', 1)->where('is_delete', 0)->get();
        $provider = Referral::where('type','provider')->where('is_active', 1)->where('is_delete', 0)->get();
        $market_by = Referral::where('type','market_by')->where('is_active', 1)->where('is_delete', 0)->get();
        $doctor = User::where('user_type','doctor')->where('is_active', 1)->where('is_delete', 0)->get();
        $data = compact('tpa','states','wards','referral','provider','market_by','doctor','section_info','patient_info','moved_by');
        return view('ipd.dialysis-register')->with($data);

    }

    public function bed_history($dialysis_id){
        $section_id = ed($dialysis_id, false);
        $section = 'dialysis';
        $wards = Ward::where('ward_name', '=', 'DIALYSIS')->where('status','0')->get();
        $history = PatientBedHistory::select('patient_bed_histories.*','beds.bed_name','wards.ward_name')
            ->join('beds','beds.id','=','patient_bed_histories.bed_id')
            ->join('wards','wards.id','=','beds.ward_id')
            ->where('section','DIALYSIS')
            ->where('section_id',$section_id)
            ->orderBy('id','DESC')
            ->get();
        $data = compact('section','section_id','wards','history');
        // dd($data);
        return view('ipd.bed-history')->with($data);
    }

    public function relish_patient($dialysis_id){
        $dialysis_id = ed($dialysis_id, false);
        $check = DialysisRegister::select('dialysis_registers.*', 'b.due_amount')
            ->leftJoin('billings as b', function ($join) {
                $join->on('b.section_id', '=', 'dialysis_registers.id')
                    ->where('b.section', 'DIALYSIS');
            })
            ->where('dialysis_registers.id', $dialysis_id)
            ->first();

        if($check->dialysis_status){
            return redirect()->back()->with('error', 'Allready Release this Patient!');
        }else{
            if(@$check->due_amount > 0){
                return redirect()->back()->with('error', 'Due Bill Amount '.$check->due_amount.'. Please collect due then Release');
            }else{
                Bed::where('id', $check->bed_id)->update(['is_used' => 'no']);
                PatientBedHistory::where('patient_id', $check->patient_id)
                    ->where('bed_id', $check->bed_id)
                    ->latest('id')
                    ->limit(1)
                    ->update(['to_date' => now()]);
                $data = DialysisRegister::find($check->id);
                $data->dialysis_status = 1;
                $data->relish_by = Auth::user()->id;
                $data->relish_at = date('Y-m-d H:i:s');
                $data->update();
                return redirect()->back()->with('success', 'Sucessfully Release Patient');
            }
        }
        $tpa = TpaManagement::where('status','0')->get();
        $states = State::where('country_id','1')->get();
        $wards = Ward::where('status','0')->get();
        $referral = Referral::where('type','referral')->where('is_active', 1)->where('is_delete', 0)->get();
        $provider = Referral::where('type','provider')->where('is_active', 1)->where('is_delete', 0)->get();
        $market_by = Referral::where('type','market_by')->where('is_active', 1)->where('is_delete', 0)->get();
        $doctor = User::where('user_type','doctor')->where('is_active', 1)->where('is_delete', 0)->get();

        $info = DialysisRegister::select('dialysis_registers.*','b.bed_name')
            ->join('beds as b','b.id','=','dialysis_registers.bed_id')
            ->where('dialysis_registers.id',$dialysis_id)
            ->first();
        $info->patient_info = Patient::select('patients.*')
            ->where('patients.id',$info->patient_id)
            ->first();
        $data = compact('tpa','states','wards','referral','provider','market_by','doctor','info');
        // dd($data);
        return view('ipd.dialysis-edit')->with($data);
    }

    public function check_availability(Request $request)
    {
        foreach (['admission_date', 'dialysis_machine', 'start_time', 'bed'] as $field) {
            if (!$request->filled($field)) {
                return response()->json([
                    'available' => true,
                    'messages' => [],
                ]);
            }
        }

        try {
            $selectedStartTime = $this->dialysisStartDateTime($request);
        } catch (Exception $e) {
            return response()->json([
                'available' => false,
                'messages' => ['Invalid dialysis date or time selection.'],
            ]);
        }

        $messages = $this->dialysisAvailabilityMessages(
            $request,
            $selectedStartTime,
            $request->filled('dialysis_id') ? (int) $request->dialysis_id : null
        );

        return response()->json([
            'available' => empty($messages),
            'messages' => $messages,
        ]);
    }

    private function dialysisMachineDateRange(Request $request): array
    {
        $fromDate = $this->dialysisStartDateTime($request);
        $toDate = Carbon::parse($fromDate->format('Y-m-d') . ' ' . $request->end_time);

        if ($toDate->lessThanOrEqualTo($fromDate)) {
            $toDate->addDay();
        }

        return [$fromDate, $toDate];
    }

    private function dialysisStartDateTime(Request $request): Carbon
    {
        $admissionDate = $this->parseDialysisAdmissionDate($request->admission_date)->format('Y-m-d');
        return Carbon::parse($admissionDate . ' ' . $request->start_time);
    }

    private function parseDialysisAdmissionDate(string $value): Carbon
    {
        $value = trim($value);
        $formats = [
            'd-m-Y h:i A',
            'd-m-Y H:i',
            'd-m-Y',
            'Y-m-d h:i A',
            'Y-m-d H:i:s',
            'Y-m-d H:i',
            'Y-m-d',
        ];

        foreach ($formats as $format) {
            try {
                $date = Carbon::createFromFormat($format, $value);
                if ($date instanceof Carbon) {
                    return $date;
                }
            } catch (Exception $e) {
                // Try the next known format before falling back to Carbon::parse.
            }
        }

        return Carbon::parse($value);
    }

    private function dialysisAvailabilityMessages(Request $request, Carbon $selectedStartTime, ?int $excludeDialysisId = null): array
    {
        $selectedStart = $selectedStartTime->format('Y-m-d H:i:s');
        $baseQuery = DialysisMachineHistory::query()
            ->select(
                'dialysis_machine_history.*',
                'beds.bed_name',
                'patients.name as patient_name'
            )
            ->leftJoin('beds', 'beds.id', '=', 'dialysis_machine_history.bed_id')
            ->leftJoin('patients', 'patients.id', '=', 'dialysis_machine_history.patient_id')
            ->where('dialysis_machine_history.start_time', '<=', $selectedStart)
            ->where('dialysis_machine_history.end_time', '>=', $selectedStart);

        if ($excludeDialysisId) {
            $baseQuery->where('dialysis_machine_history.dialysis_id', '!=', $excludeDialysisId);
        }

        $messages = [];
        $machineConflict = (clone $baseQuery)
            ->where('dialysis_machine_history.machine_no', $request->dialysis_machine)
            ->first();

        if ($machineConflict) {
            $messages[] = 'Selected start time is inside an existing dialysis slot. Machine ' . $request->dialysis_machine . ' is already assigned from '
                . date('d-m-Y h:i A', strtotime($machineConflict->start_time)) . ' to '
                . date('d-m-Y h:i A', strtotime($machineConflict->end_time))
                . ($machineConflict->patient_name ? ' for ' . $machineConflict->patient_name : '') . '.';
        }

        $bedConflict = (clone $baseQuery)
            ->where('dialysis_machine_history.bed_id', $request->bed)
            ->first();

        if ($bedConflict) {
            $messages[] = 'Selected start time is inside an existing dialysis slot. Bed ' . ($bedConflict->bed_name ?: '#' . $request->bed) . ' is already assigned from '
                . date('d-m-Y h:i A', strtotime($bedConflict->start_time)) . ' to '
                . date('d-m-Y h:i A', strtotime($bedConflict->end_time))
                . ($bedConflict->patient_name ? ' for ' . $bedConflict->patient_name : '') . '.';
        }

        return $messages;
    }

    public function update_dialysis_register(Request $request){
        $request->validate([
            'admission_date' => 'required',
            'insurance_type' => 'required',
            'name' => 'required',
            'phone' => 'required|digits:10',
            'gender' => 'required',
            'guardian_name' => 'required',
            'relation' => 'required',
            'address' => 'required',
            'state' => 'required',
            'under_doctor' => 'required',
            'dialysis_machine' => 'required',
            'start_time' => 'required',
            'end_time' => 'required',
            'bed_category' => 'required',
            'bed' => 'required',
            'referred_by' => 'required',
            'uhid' => 'nullable|exists:patients,id',
        ]);

        try {
            [$from_date, $to_date] = $this->dialysisMachineDateRange($request);
            $admissionDate = $this->parseDialysisAdmissionDate($request->admission_date);
        } catch (Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Invalid dialysis date or time selection.');
        }
        $availabilityMessages = $this->dialysisAvailabilityMessages($request, $from_date);
        if (!empty($availabilityMessages)) {
            return redirect()->back()->withInput()->with('error', implode(' ', $availabilityMessages));
        }

        //   dd($request);
        DB::beginTransaction();
        try {
            //Check Dialysis Admission
            $check_dialysis = DialysisRegister::where('patient_id', $request->uhid)->whereDate('admission_date', Carbon::today())->first();
            if ($check_dialysis) {
                return redirect()->back()->with('error', 'This Patient is already admitted in Dialysis');
            }

            //SAVE in Patient
            $request->uhid ? $patient = Patient::find($request->uhid) : $patient = new Patient();
            $patient->phone = $request->phone;
            $patient->marital_status = $request->marital_status;
            $patient->name = ucwords($request->name);
            $patient->gender = $request->gender;
            $patient->guardian_name = $request->guardian_name;
            $patient->guardian_realation = $request->relation;
            $patient->guardian_contact_no = $request->guardian_contact_no;
            $patient->date_of_birth = $request->date_of_birth;
            $patient->dob_year = $request->date_of_birth_year;
            $patient->dob_month = $request->date_of_birth_month;
            $patient->dob_day = $request->date_of_birth_day;
            $patient->address = $request->address;
            $patient->state = $request->state;
            $patient->district = is_numeric($request->district) ? $request->district : null;
            $patient->pin_code = $request->pin_code;
            $patient->identification_name = 'Aadhar Card';
            $patient->identification_number = $request->aadhar_card_no;
            $patient->save();
            $patient_id = $patient->id;

            //SAVE in Dialysis Details
            $dialysis = new DialysisRegister();
            $dialysis->admission_date = $admissionDate->format('Y-m-d H:i:s');
            $dialysis->patient_id = $patient_id;
            $dialysis->insurance_id = $request->insurance_type;
            $dialysis->insurance_no = $request->insurance_no;
            $dialysis->type = $request->uhid ? 'old' : 'new';
            $dialysis->department_id = User::where('id',$request->under_doctor)->first()->department_id;
            $dialysis->doctor_id = $request->under_doctor;
            $dialysis->ward_id = $request->bed_category;
            $dialysis->bed_id = $request->bed;
            $dialysis->referred_by = $request->referred_by;
            $dialysis->responsible_person = $request->responsible_person;
            $dialysis->responsible_person_relation = $request->responsible_person_relation;
            $dialysis->responsible_person_ph_no = $request->responsible_person_ph_no;
            $dialysis->responsible_person_age = $request->responsible_person_age;
            $dialysis->responsible_person_address = $request->responsible_person_address;
            $dialysis->dialysis_type = $request->moved_by;
            $dialysis->created_by = Auth::user()->id;
            if ($request->id) {
                $dialysis->edit_by = Auth::user()->id;
                $dialysis->edit_at = now();
            }
            $dialysis->save();
            $dialysis_id = $dialysis->id;

            //SAVE in CASE Reference
            $caseReference = new CaseReference;
            $caseReference->patient_id = $patient_id;
            $caseReference->section = 'DIALYSIS';
            $caseReference->section_id = $dialysis_id;
            $caseReference->save();

            //SAVE in PATIENT DOCTOR STATUS
            $checkStatus = PatientDoctorStatus::where('doctor_id',$request->under_doctor)->where('patient_id',$patient_id)->first();
            $checkStatus ? $patient_type = 'old' : $patient_type = 'new';
            $doctorPatientStatus = new PatientDoctorStatus();
            $doctorPatientStatus->section = 'DIALYSIS';
            $doctorPatientStatus->section_id = $dialysis_id;
            $doctorPatientStatus->doctor_id = $request->under_doctor;
            $doctorPatientStatus->patient_id = $patient_id;
            $doctorPatientStatus->patient_type = $patient_type;
            $doctorPatientStatus->date = $admissionDate->format('Y-m-d');
            $doctorPatientStatus->save();

            // UPDATE in BED STATUS
            // Bed::where('id',$request->bed)->update(['is_used' => 'yes']);

            //SAVE in Dialysis Machine History
            $dialysisMachineHistory = new DialysisMachineHistory();
            $dialysisMachineHistory->dialysis_id = $dialysis_id;
            $dialysisMachineHistory->patient_id = $patient_id;
            $dialysisMachineHistory->bed_id = $request->bed;
            $dialysisMachineHistory->machine_no = $request->dialysis_machine;
            $dialysisMachineHistory->start_time = $from_date->format('Y-m-d H:i:s');
            $dialysisMachineHistory->end_time = $to_date->format('Y-m-d H:i:s');
            $dialysisMachineHistory->save();

            //SAVE in PATIENT BED HISTORY
            $patientBedHistory = new PatientBedHistory();
            $patientBedHistory->patient_id = $patient_id;
            $patientBedHistory->bed_id = $request->bed;
            $patientBedHistory->from_date = $from_date->format('Y-m-d H:i:s');
            $patientBedHistory->to_date = $to_date->format('Y-m-d H:i:s');
            $patientBedHistory->section = 'DIALYSIS';
            $patientBedHistory->section_id = $dialysis_id;
            $patientBedHistory->case_id = $caseReference->id;
            $patientBedHistory->department_id = User::where('id',$request->under_doctor)->first()->department_id;
            $patientBedHistory->cons_doctor_id = $request->under_doctor;
            $patientBedHistory->save();

            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Failed! Please try again!');
        }
        return redirect()->route('ipd.dialysis')->with('success', 'Dialysis Registration Successfully Updated');
    }

    public function update_admission($dialysis_id, Request $request){
        $request->validate([
            'admission_date' => 'required',
            'insurance_type' => 'required',
            'name' => 'required',
            'gender' => 'required',
            'phone' => 'required|digits:10',
            'guardian_name' => 'required',
            'relation' => 'required',
            'address' => 'required',
            'state' => 'required',
            'under_doctor' => 'required',
            'dialysis_machine' => 'required',
            'start_time' => 'required',
            'end_time' => 'required',
            'bed_category' => 'required',
            'bed' => 'required',
            'uhid' => 'nullable|exists:patients,id',
        ]);

        try {
            [$from_date, $to_date] = $this->dialysisMachineDateRange($request);
            $admissionDate = $this->parseDialysisAdmissionDate($request->admission_date);
        } catch (Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Invalid dialysis date or time selection.');
        }
        $availabilityMessages = $this->dialysisAvailabilityMessages($request, $from_date, (int) $dialysis_id);
        if (!empty($availabilityMessages)) {
            return redirect()->back()->withInput()->with('error', implode(' ', $availabilityMessages));
        }

        DB::beginTransaction();
        try {
            //SAVE in Patient
            $request->uhid ? $patient = Patient::find($request->uhid) : $patient = new Patient();
            $patient->name = ucwords($request->name);
            $patient->phone = $request->phone;
            $patient->gender = $request->gender;
            $patient->marital_status = $request->marital_status;
            $patient->guardian_name = $request->guardian_name;
            $patient->guardian_realation = $request->relation;
            $patient->guardian_contact_no = $request->guardian_contact_no;
            $patient->date_of_birth = $request->date_of_birth;
            $patient->dob_year = $request->date_of_birth_year;
            $patient->dob_month = $request->date_of_birth_month;
            $patient->dob_day = $request->date_of_birth_day;
            $patient->address = $request->address;
            $patient->state = $request->state;
            $patient->district = is_numeric($request->district) ? $request->district : null;
            $patient->pin_code = $request->pin_code;
            $patient->identification_name = 'Aadhar Card';
            $patient->identification_number = $request->aadhar_card_no;
            $patient->save();
            $patient_id = $patient->id;

            //SAVE in Dialysis Details
            $old_dialysis = DialysisRegister::find($dialysis_id);
            $dialysis = DialysisRegister::find($dialysis_id);
            $dialysis->admission_date = $admissionDate->format('Y-m-d H:i:s');
            $dialysis->patient_id = $patient_id;
            $dialysis->insurance_id = $request->insurance_type;
            $dialysis->insurance_no = $request->insurance_no;
            $dialysis->type = $request->uhid ? 'old' : 'new';
            $dialysis->department_id = User::where('id',$request->under_doctor)->first()->department_id;
            $dialysis->doctor_id = $request->under_doctor;
            $dialysis->ward_id = $request->bed_category;
            $dialysis->bed_id = $request->bed;
            $dialysis->referred_by = $request->referred_by;
            $dialysis->provider = $request->provider;
            $dialysis->market_by = $request->market_by;
            $dialysis->responsible_person = $request->responsible_person;
            $dialysis->responsible_person_relation = $request->responsible_person_relation;
            $dialysis->responsible_person_ph_no = $request->responsible_person_ph_no;
            $dialysis->responsible_person_age = $request->responsible_person_age;
            $dialysis->responsible_person_address = $request->responsible_person_address;
            $dialysis->edit_by = Auth::user()->id;
            $dialysis->edit_at = date('y-m-d H:i:s');
            $dialysis->update();
            $dialysis_id = $dialysis->id;

            if($old_dialysis->doctor_id != $request->under_doctor){
                //SAVE in PATIENT DOCTOR STATUS
                $checkStatus = PatientDoctorStatus::where('doctor_id',$request->under_doctor)->where('patient_id',$patient_id)->first();
                $checkStatus ? $patient_type = 'old' : $patient_type = 'new';
                $doctorPatientStatus = new PatientDoctorStatus();
                $doctorPatientStatus->section = 'DIALYSIS';
                $doctorPatientStatus->section_id = $dialysis_id;
                $doctorPatientStatus->doctor_id = $request->under_doctor;
                $doctorPatientStatus->patient_id = $patient_id;
                $doctorPatientStatus->patient_type = $patient_type;
                $doctorPatientStatus->date = $admissionDate->format('Y-m-d');
                $doctorPatientStatus->save();
            }

            // UPDATE in Dialysis Machine History
            $dialysisMachineHistory = DialysisMachineHistory::firstOrNew(['dialysis_id' => $dialysis_id]);
            $dialysisMachineHistory->dialysis_id = $dialysis_id;
            $dialysisMachineHistory->patient_id = $patient_id;
            $dialysisMachineHistory->bed_id = $request->bed;
            $dialysisMachineHistory->machine_no = $request->dialysis_machine;
            $dialysisMachineHistory->start_time = $from_date->format('Y-m-d H:i:s');
            $dialysisMachineHistory->end_time = $to_date->format('Y-m-d H:i:s');
            $dialysisMachineHistory->save();

            if($old_dialysis->bed_id != $request->bed){
                // UPDATE in BED STATUS
                // Bed::where('id',$old_dialysis->bed_id)->update(['is_used' => 'no']);
                // Bed::where('id',$request->bed)->update(['is_used' => 'yes']);

                // UPDATE in PATIENT BED HISTORY
                // $patientBedUpdate = PatientBedHistory::where('patient_id',$patient_id)->where('section','DIALYSIS')->where('section_id',$dialysis_id)->orderBy('id','DESC')->first();
                // $patientBedUpdate->to_date = date('Y-m-d H:i:s');
                // $patientBedUpdate->save();

                // DELETE PATIENT BED HISTORY
                $patientBedUpdate = PatientBedHistory::where('patient_id', $patient_id)
                    ->where('section', 'DIALYSIS')
                    ->where('section_id', $dialysis_id)
                    ->orderBy('id', 'DESC')
                    ->first();

                if ($patientBedUpdate) {
                    $patientBedUpdate->delete();
                }

                //SAVE in PATIENT BED HISTORY
                $patientBedHistory = new PatientBedHistory();
                $patientBedHistory->patient_id = $patient_id;
                $patientBedHistory->bed_id = $request->bed;
                $patientBedHistory->from_date = $from_date->format('Y-m-d H:i:s');
                $patientBedHistory->to_date = $to_date->format('Y-m-d H:i:s');
                $patientBedHistory->section = 'DIALYSIS';
                $patientBedHistory->section_id = $dialysis_id;
                $patientBedHistory->department_id = User::where('id',$request->under_doctor)->first()->department_id;
                $patientBedHistory->cons_doctor_id = $request->under_doctor;
                $patientBedHistory->save();
            }else{
                // UPDATE in PATIENT BED HISTORY
                $patientBedUpdate = PatientBedHistory::where('patient_id', $patient_id)
                    ->where('section', 'DIALYSIS')
                    ->where('section_id', $dialysis_id)
                    ->orderBy('id', 'DESC')
                    ->first();

                if ($patientBedUpdate) {
                    $patientBedUpdate->from_date = $from_date->format('Y-m-d H:i:s');
                    $patientBedUpdate->to_date = $to_date->format('Y-m-d H:i:s');
                    $patientBedUpdate->save();
                }
            }

            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Failed! Please try again!');
        }
        return redirect()->back()->with('success', 'Admission Updated Sucessfully');
    }
}
