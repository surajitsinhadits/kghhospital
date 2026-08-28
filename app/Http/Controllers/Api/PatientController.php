<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Billing;
use App\Models\Charge;
use App\Models\Department;
use App\Models\EmgRegister;
use App\Models\EmrMaster;
use App\Models\Investigation;
use App\Models\IpdRegister;
use App\Models\OpdEnquiry;
use App\Models\OpdRegister;
use App\Models\Patient;
use App\Models\PatientNote;
use App\Models\Payment;
use App\Models\TimeSchedule;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PatientController extends Controller
{
    public function appointments(Request $request)
    {
        $patientId = Auth::id();
        $phone_number = Patient::find($patientId)->phone;

        $perPage = (int) $request->input('per_page', 100);
        $page = max(1, (int) $request->input('page', 1));

        $query = OpdEnquiry::select(
            'opd_enquiries.*',
            'u1.salutation as bs',
            'u1.name as booking_name',
            'u2.salutation as ds',
            'u2.name as doctor_name'
        )
            ->join('users as u1', 'u1.id', '=', 'opd_enquiries.booking_by')
            ->join('users as u2', 'u2.id', '=', 'opd_enquiries.doctor_id')
            ->where('opd_enquiries.is_delete', '0');

        // Filtering by field and value
        if (!empty($request->field_name) && !empty($request->field_value)) {
            if ($request->field_name === 'opd_enquiries.doctor_id') {
                $query->where('opd_enquiries.doctor_id', $request->field_value);
            } else {
                $query->where($request->field_name, 'LIKE', '%' . $request->field_value . '%');
            }
        }

        // Date range filter
        if (!empty($request->from_date)) {
            $query->whereDate('opd_enquiries.appointment_date', '>=', date('Y-m-d', strtotime($request->from_date)));
        }
        if (!empty($request->to_date)) {
            $query->whereDate('opd_enquiries.appointment_date', '<=', date('Y-m-d', strtotime($request->to_date)));
        }

        // Sorting by date desc, time asc and using pagination
        $paginator = $query
            ->where('opd_enquiries.phone', $phone_number)
            ->orderBy('opd_enquiries.appointment_date', 'desc')
            ->orderBy('opd_enquiries.appointment_time', 'asc')
            ->paginate($perPage, ['*'], 'page', $page);

        // Add formatted app_date to each item
        $paginator->getCollection()->transform(function ($row) {
            $row->app_date = \Carbon\Carbon::parse($row->appointment_date)->format('d-m-Y') . ' ' . \Carbon\Carbon::parse($row->appointment_time)->format('h:i A');
            return $row;
        });

        return response()->json([
            'success' => true,
            'data' => $paginator->items(),
            'msg' => 'Appointments fetched successfully',
            'pagination' => [
                'total' => $paginator->total(),
                'per_page' => $paginator->perPage(),
                'current_page' => $paginator->currentPage(),
                'last_page' => $paginator->lastPage(),
            ]
        ]);
    }

    public function get_patient_all_bill(Request $request)
    {
        $patientId = Auth::id();

        $perPage = (int) $request->input('per_page', 50); // or any default
        $page = max(1, (int) $request->input('page', 1));

        $bill = Billing::select('billings.*', 'u1.name as doctor_name', 'u2.name as created_name')
            ->join('users as u1', 'u1.id', '=', 'billings.doctor_id')
            ->join('users as u2', 'u2.id', '=', 'billings.created_by')
            ->where('billings.patient_id', $patientId)
            ->orderBy('billings.id', 'desc')
            ->paginate($perPage, ['*'], 'page', $page);

        return response()->json([
            'success' => true,
            'msg' => 'Bills fetched successfully',
            'data' => $bill->items(),
            'pagination' => [
                'total' => $bill->total(),
                'per_page' => $bill->perPage(),
                'current_page' => $bill->currentPage(),
                'last_page' => $bill->lastPage(),
            ]
        ]);
    }

    public function get_doctors()
    {
        $today = Carbon::now()->format('Y-m-d');
        $all_doctor = User::where('user_type', 'doctor')->get();
        $active_doctor = [];
        $datar = [];

        foreach ($all_doctor as $value) {
            $minMaxTimes = DB::table('time_schedules')
                ->where('date', $today)
                ->where('doctor_id', $value->id)
                ->select(DB::raw('MIN(from_time) as min_from_time'), DB::raw('MAX(to_time) as max_to_time'))
                ->first();

            if (!empty($minMaxTimes->min_from_time != null)) {
                $in_out = DB::table('patient_doctor_statuses')
                    ->where('doctor_id', $value->id)
                    ->where('date', $today)
                    ->latest()
                    ->first();

                $s = '';
                $color = '#dbdbdb';
                if (@$in_out->status == '1') {
                    $s = 'In';
                    $color = '#b9d8ff';
                } elseif (@$in_out->status == '0') {
                    $s = 'Out';
                    $color = '#94e6ff';
                } elseif (@$in_out->status == '2') {
                    $s = 'Unavailable';
                    $color = '#ffb9b2';
                } else {
                    $s = '';
                    $color = '#dbdbdb';
                }

                $datar[] = [
                    'doctor_id' => $value->id,
                    'name' => $value->name,
                    'details' => $value->specialization . ' // ' . $value->qualification,
                    'avilable_time1' => $minMaxTimes->min_from_time,
                    'avilable_time' => $minMaxTimes->min_from_time != '' ? date('h:i A', strtotime($minMaxTimes->min_from_time)) . ' -- ' . date('h:i A', strtotime($minMaxTimes->max_to_time)) : '',
                    'in_out_status' => $s,
                    'in_out_details' => $in_out,
                    'color' => $color,
                ];
                $active_doctor = collect($datar)->sortBy('avilable_time1')->values()->all();
            }
        }
        return response()->json([
            'msg' => 'Doctors fetched successfully',
            'success' => true,
            'data' => $active_doctor
        ]);
    }

    public function patient_details()
    {
        try {
            $id = Auth::id();
            if (empty($id)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid patient id.'
                ], 400);
            }

            $patient_details = Patient::where('id', $id)->first();
            if (!$patient_details) {
                return response()->json([
                    'success' => false,
                    'message' => 'Patient not found.'
                ], 404);
            }

            $bill_details = Billing::where('patient_id', $id)->latest('id')->get();
            $totalDue = $bill_details->sum('due_amount');
            $totalCredit = $bill_details->sum('cradit_amount');

            $emr_details = EmrMaster::select('emr_masters.*', 'u.name as doctor_name')
                ->join('users as u', 'emr_masters.doctor_id', '=', 'u.id')
                ->where('emr_masters.patient_id', $id)
                ->latest('emr_masters.id')
                ->get();

            $opd_details = OpdRegister::select(
                'opd_registers.*',
                'u.name as doctor_name',
                'd.department_name',
                'b.id as billing_id',
                'b.uid',
                'b.due_amount',
                'b.cradit_amount',
                'b.bill_status'
            )
                ->join('users as u', 'u.id', '=', 'opd_registers.doctor_id')
                ->join('departments as d', 'd.id', '=', 'opd_registers.department_id')
                ->join('billings as b', function ($join) {
                    $join->on('b.section_id', '=', 'opd_registers.id')
                        ->where('b.section', '=', 'OPD');
                })
                ->where('opd_registers.patient_id', $id)
                ->where('opd_registers.is_delete', 0)
                ->latest('opd_registers.id')
                ->get();

            // OPD Enquiry
            $enquiry_ids = $opd_details->pluck('enquiry_id')->unique()->filter()->toArray();

            $opd_enquiry = empty($enquiry_ids) ? collect() : OpdEnquiry::select(
                'opd_enquiries.*',
                'u.name as doctor_name'
            )
                ->join('users as u', 'u.id', '=', 'opd_enquiries.doctor_id')
                ->whereIn('opd_enquiries.id', $enquiry_ids)
                ->get();

            // EMG Details
            $emg_details = EmgRegister::select(
                'emg_registers.*',
                'u.name as doctor_name',
                'd.department_name',
                'b.id as billing_id',
                'b.uid',
                'b.due_amount',
                'b.cradit_amount',
                'b.bill_status'
            )
                ->join('users as u', 'u.id', '=', 'emg_registers.doctor_id')
                ->join('departments as d', 'd.id', '=', 'emg_registers.department_id')
                ->join('billings as b', function ($join) {
                    $join->on('b.section_id', '=', 'emg_registers.id')
                        ->where('b.section', '=', 'EMG');
                })
                ->where('emg_registers.patient_id', $id)
                ->where('emg_registers.is_delete', 0)
                ->latest('emg_registers.id')
                ->get();

            // IPD Details
            $ipd_details = IpdRegister::select(
                'ipd_registers.*',
                'u.name as doctor_name',
                'd.department_name',
                'b.bed_name',
                'w.ward_name'
            )
                ->join('users as u', 'u.id', '=', 'ipd_registers.doctor_id')
                ->join('departments as d', 'd.id', '=', 'ipd_registers.department_id')
                ->join('wards as w', 'w.id', '=', 'ipd_registers.ward_id')
                ->join('beds as b', 'b.id', '=', 'ipd_registers.bed_id')
                ->where('ipd_registers.admission_type', 'IPD')
                ->where('ipd_registers.patient_id', $id)
                ->where('ipd_registers.is_delete', 0)
                ->latest('ipd_registers.id')
                ->get();

            // Daycare Details
            $daycare_details = IpdRegister::select(
                'ipd_registers.*',
                'u.name as doctor_name',
                'd.department_name',
                'b.bed_name',
                'w.ward_name'
            )
                ->join('users as u', 'u.id', '=', 'ipd_registers.doctor_id')
                ->join('departments as d', 'd.id', '=', 'ipd_registers.department_id')
                ->join('wards as w', 'w.id', '=', 'ipd_registers.ward_id')
                ->join('beds as b', 'b.id', '=', 'ipd_registers.bed_id')
                ->where('ipd_registers.admission_type', 'DAYCARE')
                ->where('ipd_registers.patient_id', $id)
                ->where('ipd_registers.is_delete', 0)
                ->latest('ipd_registers.id')
                ->get();

            // Receipt Details
            $receipt_details = Payment::select(
                'payments.*',
                'u.name as payment_recived_by_name'
            )
                ->join('users as u', 'u.id', '=', 'payments.payment_recived_by')
                ->where('payments.patient_id', $id)
                ->latest('payments.id')
                ->get();

            // Refund Details
            $refund_details = Billing::select(
                'billings.*',
                'u1.name as doctor_name',
                'u2.name as refund_name',
                'pca.id as refund_id'
            )
                ->join('users as u1', 'u1.id', '=', 'billings.doctor_id')
                ->join('users as u2', 'u2.id', '=', 'billings.refund_by')
                ->join('patient_cradit_amounts as pca', 'pca.billing_id', '=', 'billings.id')
                ->where('billings.refund_amount', '>', 0)
                ->where('pca.type', 'debit')
                ->where('pca.remarks', 'refund')
                ->where('billings.patient_id', $id)
                ->get();

            // Notes
            $note_details = PatientNote::where('patient_id', $id)
                ->where('is_delete', 0)
                ->latest('id')
                ->get();

            return response()->json([
                'success' => true,
                'message' => 'Patient details fetched successfully.',
                'data' => [
                    'bill_details' => $bill_details,
                    'patient_details' => $patient_details,
                    'opd_details' => $opd_details,
                    'totalCredit' => $totalCredit,
                    'totalDue' => $totalDue,
                    'opd_enquiry' => $opd_enquiry,
                    'emg_details' => $emg_details,
                    'ipd_details' => $ipd_details,
                    'daycare_details' => $daycare_details,
                    'receipt_details' => $receipt_details,
                    'refund_details' => $refund_details,
                    'note_details' => $note_details,
                    'emr_details' => $emr_details,
                ]
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch patient details.',
                'error' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }

    public function department_list()
    {
        $department = Department::select('id', 'department_name')->where('status', '0')->get();
        return response()->json([
            'success' => true,
            'message' => 'Department list fetched successfully.',
            'data' => $department
        ]);
    }

    public function get_doctors_by_dept(Request $request)
    {
        $doctors = User::where('department_id', $request->dept_id)->where('is_active', '1')->where('is_delete', '0')->get();
        return response()->json([
            'success' => true,
            'message' => 'Doctor list fetched successfully.',
            'data' => $doctors
        ]);
    }

    public function get_schedule(Request $request)
    {
        $today = date('Y-m-d');
        $department_id = User::where('id', $request->doctorId)->first()->department_id;
        $uniqueDates = TimeSchedule::where('doctor_id', $request->doctorId)
            ->where('is_delete', '0')
            ->where('is_active', '1')
            ->where('date', '>=', $today)
            ->distinct('date')
            ->orderBy('date', 'ASC')
            ->pluck('date')
            ->map(function ($date) {
                return Carbon::parse($date)->format('Y-m-d');
            });

        $data = [
            'doctor_id' => $request->doctorId,
            'department_id' => $department_id,
            'uniqueDates' => $uniqueDates
        ];

        return response()->json([
            'success' => true,
            'data' => $data,
            'message' => 'Schedule fetched successfully.',
        ]);
    }

    public function get_timeslot(Request $request)
    {
        $today = date('Y-m-d');
        $uniqueDates_withtiming = TimeSchedule::where('doctor_id', $request->doctor_id)->where('is_delete', '0')->where('is_active', '1')->where('date', date('Y-m-d', strtotime($request->date)))->get();
        $doctor_id = $request->doctor_id;
        $a_date = date("d-m-Y", strtotime($request->date));
        $p_date = date("d M Y", strtotime($request->date));
        $p_day = date("l", strtotime($request->date));
        $uniqueDates = TimeSchedule::where('doctor_id', $request->doctor_id)
            ->where('is_delete', '0')
            ->where('is_active', '1')
            ->where('date', '>=', $today)
            ->distinct('date')
            ->orderBy('date', 'ASC')
            ->pluck('date');
        return response()->json([
            'success' => true,
            'a_date' => $a_date,
            'p_date' => $p_date,
            'p_day' => $p_day,
            'doctor_id' => $doctor_id,
            'uniqueDates_withtiming' => $uniqueDates_withtiming
        ]);
    }

    public function rate_query()
    {
        $charges = Charge::select('charges.id', 'charges.charge_name', 'chs.charge_amount')
            ->join('charges_has_sections as chs', 'chs.charge_id', '=', 'charges.id')
            ->join('charges_sections as cs', 'cs.id', '=', 'chs.charge_section_id')
            ->where('cs.charges_section_name', 'INVESTIGATION')
            ->where('is_active', 1)
            ->where('is_delete', 0)
            ->get();

        return response()->json([
            'success' => true,
            'data' => $charges,
            'message' => 'Rate Query fetched successfully.',
        ]);
    }

    public function complete_investigation_report(Request $request)
    {

        $id = Auth::id();
        $data = Investigation::select(
            'investigations.id',
            'investigations.bill_id',
            'b.uid',
            'investigations.bill_created_date',
            'p.name as patient_name',
            'investigations.patient_id',
            'p.phone',
            'p.gender',
            'p.dob_year',
            'p.dob_month',
            'p.dob_day',
            'r.referral_name',
            'u.name as doctor_name',
            'investigations.section',
            'investigations.section_id',
            'beds.bed_name'
        )
            ->join('billings as b', 'b.id', '=', 'investigations.bill_id')
            ->join('patients as p', 'p.id', '=', 'investigations.patient_id')
            ->leftJoin('referrals as r', 'r.id', '=', 'investigations.referral_id')
            ->leftJoin('users as u', 'u.id', '=', 'investigations.doctor_id')
            ->leftJoin('ipd_registers', function ($join) {
                $join->on('ipd_registers.id', '=', 'investigations.section_id')
                    ->where('investigations.section', '=', 'IPD')
                    ->join('beds', 'beds.id', '=', 'ipd_registers.bed_id');
            })
            ->where('patients.id', $id)
            ->where('investigations.is_delete', 0)
            ->OrderBy('investigations.bill_created_date', 'DESC');

        // Filter based on field_name and field_value
        // if (!empty($request->field_name) && !empty($request->field_value)) {
        //     $data->where($request->field_name, 'LIKE', '%' . $request->field_value . '%');
        // }

        // Filter by status
        if (is_numeric($request->status_value) && $request->status_value == 0) {
            $status = (string)$request->status_value;
            $data->where('investigations.report_status', $status);
            $data->whereIn('investigations.id', function ($subQuery) use ($status) {
                $subQuery->select(DB::raw('MAX(id)'))
                    ->from('investigations')
                    ->where('report_status', $status)
                    ->groupBy('bill_id');
            });
        } else {
            $status = explode('-', $request->status_value);
            $data->whereIn('investigations.report_status', $status);
            $data->whereIn('investigations.id', function ($subQuery) use ($status) {
                $subQuery->select(DB::raw('MAX(id)'))
                    ->from('investigations')
                    ->whereIn('report_status', $status)
                    ->groupBy('bill_id');
            });
        }

        // Filter by test
        // if (!empty($request->select_value)) {
        //     $data->whereIn('investigations.charge_id', $request->select_value);
        // }

        // Filter by date range
        if (!empty($request->from_date)) {
            $data->whereDate('investigations.bill_created_date', '>=', date('Y-m-d', strtotime($request->from_date)));
        }
        if (!empty($request->to_date)) {
            $data->whereDate('investigations.bill_created_date', '<=', date('Y-m-d', strtotime($request->to_date)));
        }

        return response()->json([
            'success' => true,
            'data' => $data,
            'message' => 'Completion report fetched successfully.',
        ]);
    }
}
