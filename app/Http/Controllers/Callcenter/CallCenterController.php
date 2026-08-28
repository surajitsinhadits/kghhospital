<?php

namespace App\Http\Controllers\Callcenter;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use App\Models\CallCenterHistory;
use App\Models\CallCenter;
use App\Models\OpdEnquiry;
use App\Models\OtRegistration;
use App\Models\Patient;
use App\Models\VcPatientVaccination;
use Illuminate\Support\Facades\Auth;
use Yajra\Datatables\DataTables;
use Carbon\Carbon;

use Illuminate\Http\Request;

class CallCenterController extends Controller
{
    public function index()
    {
        return view('callcenter.appointment_dashboard');
    }

    public function save_call_center(Request $request)
    {
        $saveArray = [];

        switch ($request->id) {
            case 1:
                $appointment = OpdEnquiry::where('appointment_date', Carbon::today()->format('y-m-d'))->get();
                foreach ($appointment as $item) {
                    $saveArray[] = [
                        'section' => 'OPD',
                        'section_id' => $item->id,
                        'patient_name' => $item->name,
                        'phone' => $item->phone,
                        'appointment_date' => Carbon::parse($item->appointment_date)->format('Y-m-d'),
                        'department' => $item->department_id
                    ];
                }
                break;

            case 2:
                $patientVaccinations = VcPatientVaccination::where('scheduled_date', Carbon::today()->format('Y-m-d'))->get();
                $patient = Patient::whereIn('id', $patientVaccinations->pluck('patient_id'))->get()->keyBy('id');
                foreach ($patientVaccinations as $item) {
                    $saveArray[] = [
                        'section' => 'Vaccination',
                        'section_id' => $item->id,
                        'patient_id' => $item->patient_id,
                        'patient_name' => $patient->get($item->patient_id)->name ?? '',
                        'phone' => $item->phone,
                        'appointment_date' => Carbon::parse($item->scheduled_date)->format('Y-m-d'),
                        'department' => $item->department_id
                    ];
                }
                break;

            case 3:

                break;

            case 4:
                $ot_registation = OtRegistration::whereDate('planned_date', Carbon::today())->get();
                $patient = Patient::whereIn('id', $ot_registation->pluck('patient_id'))->get()->keyBy('id');
                foreach ($ot_registation as $item) {
                    $saveArray[] = [
                        'section' => 'OT',
                        'section_id' => $item->id,
                        'patient_name' => $patient->get($item->patient_id)->name ?? '',
                        'patient_id' => $item->patient_id,
                        'phone' => $item->phone,
                        'appointment_date' => Carbon::parse($item->planned_date)->format('Y-m-d'),
                        'department' => $item->department_id
                    ];
                }
                break;
            default:
                return redirect()->back()->with('error', 'Invalid request');
        }

        CallCenter::insert($saveArray);

        return redirect()->back()->with('success', 'Call center appointments saved successfully.');

    }

    public function callcenter_appointment_list(Request $request)
    {
        if ($request->ajax()) {
            $data = CallCenter::select('call_centers.*', 'patients.uhid as patient_uhid')
                ->leftJoin('patients', 'patients.id', '=', 'call_centers.patient_id')
                ->orderBy('call_centers.id', 'DESC');

            // Filter by date range
            if (!empty($request->from_date)) {
                $data->whereDate('call_centers.appointment_date', '>=', date('Y-m-d', strtotime($request->from_date)));
            }
            if (!empty($request->to_date)) {
                $data->whereDate('call_centers.appointment_date', '<=', date('Y-m-d', strtotime($request->to_date)));
            }
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $actionBtn = '<a href="' . route('callcenter.details-form', ed(@$row->id, true)) . '" class="btn btn-primary btn-sm mx-1" title="Click here to show Call details"><i class="fa fa-eye"></i>Action</a>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('callcenter.appointment_list');
    }

    public function appointment_details_form($id)
    {
        $uid = ed($id, false);
        $patient_details = CallCenter::where('id', $uid)->first();
        $call_status = CallCenterHistory::where('cc_id', $uid)->first();
        if (!empty($patient_details?->patient_id)) {
            $patient_details->patient_uhid = Patient::where('id', $patient_details->patient_id)->value('uhid');
        }

        return view('callcenter.appoitment_call_form', compact('call_status', 'patient_details'));
    }

    public function save_details(Request $request, $id = 0)
    {
        $request->validate([
            'call_at'  => 'required',
            'remarks'  => 'required',
            'action'   => 'required',
        ]);


        $callcenterHistory = $id ? CallCenterHistory::find($id) : new CallCenterHistory();

        $callcenterHistory->cc_id    = $request->cc_id;
        $callcenterHistory->call_at  = $request->call_at;
        $callcenterHistory->call_by  = Auth::id();
        $callcenterHistory->remarks  = $request->remarks;
        $callcenterHistory->action   = $request->action;
        $callcenterHistory->save();

        if ($request->cc_id) {
            $callCentestatus = CallCenter::find($request->cc_id);
            if ($callCentestatus) {
                $callCentestatus->status = 1;
                $callCentestatus->save();
            }
        }

        if ($request->reschedule_date) {
            $callCenter = CallCenter::find($request->cc_id);
            if ($callCenter) {
                $callCenter->appointment_date = $request->reschedule_date;
                $callCenter->save();
            }
        }

        return redirect()->route('callcenter.appointment-list')->with('success', 'Appointment call details saved successfully.');
    }
}
