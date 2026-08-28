<?php

namespace App\Http\Controllers\Bill;

use App\Http\Controllers\Controller;
use App\Models\Billing;
use App\Models\Charge;
use Illuminate\Http\Request;
use App\Models\Diagonase;
use App\Models\EmgRegister;
use App\Models\EmrLog;
use App\Models\EmrMaster;
use App\Models\IpdRegister;
use App\Models\MedMedicine;
use App\Models\OpdRegister;
use App\Models\Patient;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Exception;


class EmrController extends Controller
{
    public function create_prescription($section = null, $section_id = null, $emr_id = null)
    {
        $section_id = ed($section_id, false);
        // $section = '';
        if (@$section == 'opd') {
            $opd_details = OpdRegister::where('id', $section_id)->first();
        } else {
            $opd_details = EmgRegister::where('id', $section_id)->first();
        }
        $patient_details = Patient::where('id', @$opd_details->patient_id)->first();
        $doctor_details = User::where('id', @$opd_details->doctor_id)->first();
        $diagonase = Diagonase::where('status', 0)->get();
        $compositions = MedMedicine::select('medicine_composition')
            ->distinct()
            ->pluck('medicine_composition');
        $tests = Charge::where('charge_type', 'investigation')->get();
        $emr_id = ed($emr_id, false);
        $emr_data = $emr_id ? EmrMaster::where('id', $emr_id)->first() : null;


        return view('bill.create-prescription', compact('section_id', 'section', 'diagonase', 'compositions', 'opd_details', 'patient_details', 'doctor_details', 'tests', 'emr_data'));
    }

    public function emr_store(Request $request)
    {

        DB::beginTransaction();

        try {
            $request->validate([
                'patient_id' => ['required', 'exists:patients,id'],
                'doctor_id'  => ['required'],
                'date'       => ['required'],
            ]);

            $data = new EmrMaster();
            $data->patient_id   = $request->patient_id;
            $data->date         = date('Y-m-d H:i:s', strtotime($request->date));
            $data->doctor_id    = $request->doctor_id;
            $data->section_id   = $request->section_id;
            $data->section      = $request->section;
            $data->advice       = $request->advice;
            $data->created_by   = Auth::user()->id;
            $data->vitals     = json_encode(is_array($request->vitals) ? array_values($request->vitals) : []);
            $data->complaints = json_encode(is_array($request->complaints) ? array_values($request->complaints) : []);
            $data->diagnosis  = json_encode(is_array($request->diagnosis) ? array_values($request->diagnosis) : []);
            $data->medicines  = json_encode(is_array($request->medicines) ? array_values($request->medicines) : []);
            $data->test_name  = json_encode(is_array($request->test_name) ? array_values($request->test_name) : []);
            if (!is_array($request->vitals) || empty($request->vitals)) {
                return redirect()->back()->with('error', 'Please enter at least one vital sign.');
            }
            if (!is_array($request->complaints) || empty($request->complaints)) {
                return redirect()->back()->with('error', 'Please enter at least one vital sign.');
            }
            if (!is_array($request->diagnosis) || empty($request->diagnosis)) {
                return redirect()->back()->with('error', 'Please enter at least one vital sign.');
            }

            $data->save();
            DB::commit();

            $bill = Billing::where('section_id', $request->section_id)->where('section', $request->section)->first();
            if ($bill) {
                return redirect()->route('bill.billing-details', [$request->section, ed(@$bill->id, true)])
                    ->with('success', 'Prescription updated successfully!');
            } else {
                return redirect()->back()->with('success', 'Prescription created successfully!');
            }
        } catch (Exception $e) {
            DB::rollBack();

            return redirect()->back()->with('error', 'Failed! Please try again!');
        }
        // return redirect()->route('hr.patient-profile-details', ed($request->patient_id, true))
        //     ->with('success', 'Prescription created successfully!');
        // return redirect()->back()->with('success', 'Prescription created successfully!');
    }

    public function emr_update(Request $request)
    {
        DB::beginTransaction();

        try {
            $request->validate([
                'patient_id' => ['required', 'exists:patients,id'],
                'doctor_id'  => ['required'],
                'date'       => ['required'],
            ]);

            $data = EmrMaster::where('id', $request->emr_master_id)->first();
            $data->advice       = $request->advice;
            $data->vitals       = json_encode(array_values($request->vitals ?? []));
            $data->complaints   = json_encode(array_values($request->complaints ?? []));
            $data->diagnosis    = json_encode(array_values($request->diagnosis ?? []));
            $data->medicines    = json_encode(array_values($request->medicines ?? []));
            $data->test_name    = json_encode(array_values($request->test_name ?? []));
            $data->save();

            $emr_logs = new EmrLog();
            $emr_logs->emr_id = $data->id;
            $emr_logs->edit_by = Auth::user()->id;
            $emr_logs->edit_at = now()->format('Y-m-d H:i:s');
            $emr_logs->save();
            DB::commit();
            $bill = Billing::where('section_id', $request->section_id)->where('section', $request->section)->first();
            if ($bill) {
                return redirect()->route('bill.billing-details', [$request->section, ed(@$bill->id, true)])
                    ->with('success', 'Prescription updated successfully!');
            } else {
                return redirect()->back()->with('success', 'Prescription updated successfully!');
            }
        } catch (Exception $e) {
            DB::rollBack();

            return redirect()->back()->with('error', 'Failed! Please try again!');
        }

        // return redirect()->route('hr.patient-profile-details', ed($request->patient_id, true))
        //     ->with('success', 'Prescription updated successfully!');
        // return back()->with('success', 'Prescription updated successfully!');
    }


    public function create_ipd_prescription($section = null, $section_id = null, $emr_id = null)
    {
        $section_id = ed($section_id, false);
        $ipd_details = IpdRegister::where('id', $section_id)->first();
        $patient_details = Patient::where('id', @$ipd_details->patient_id)->first();
        $doctor_details = User::where('id', @$ipd_details->doctor_id)->first();
        $diagonase = Diagonase::where('status', 0)->get();
        $compositions = MedMedicine::select('medicine_composition')
            ->distinct()
            ->pluck('medicine_composition');
        $tests = Charge::where('charge_type', 'investigation')->get();
        $emr_id = ed($emr_id, false);
        $emr_data = $emr_id ? EmrMaster::where('id', $emr_id)->first() : null;


        return view('bill.ipd-prescription', compact('section_id', 'section', 'diagonase', 'compositions', 'patient_details', 'doctor_details', 'tests', 'emr_data', 'ipd_details'));
    }

    public function ipd_emr_store(Request $request)
    {
        DB::beginTransaction();

        try {
            $request->validate([
                'patient_id' => ['required', 'exists:patients,id'],
                'doctor_id'  => ['required'],
                'date'       => ['required'],
            ]);

            $data = new EmrMaster();
            $data->patient_id   = $request->patient_id;
            $data->date         = date('Y-m-d H:i:s', strtotime($request->date));
            $data->doctor_id    = $request->doctor_id;
            $data->section_id   = $request->section_id;
            $data->section      = $request->section;
            $data->advice       = $request->advice;
            $data->created_by   = Auth::user()->id;
            $data->progress_note         = json_encode(is_array($request->progress_note) ? array_values($request->progress_note) : []);
            $data->nursing_instructions = json_encode(is_array($request->nursing_instructions) ? array_values($request->nursing_instructions) : []);
            $data->vitals     = json_encode(is_array($request->vitals) ? array_values($request->vitals) : []);
            $data->complaints = json_encode(is_array($request->complaints) ? array_values($request->complaints) : []);
            $data->diagnosis  = json_encode(is_array($request->diagnosis) ? array_values($request->diagnosis) : []);
            $data->medicines  = json_encode(is_array($request->medicines) ? array_values($request->medicines) : []);
            $data->test_name  = json_encode(is_array($request->test_name) ? array_values($request->test_name) : []);

            if (!is_array($request->vitals) || empty($request->vitals)) {
                return redirect()->back()->with('error', 'Please enter at least one vital sign.');
            }
            if (!is_array($request->complaints) || empty($request->complaints)) {
                return redirect()->back()->with('error', 'Please enter at least one vital sign.');
            }
            if (!is_array($request->diagnosis) || empty($request->diagnosis)) {
                return redirect()->back()->with('error', 'Please enter at least one vital sign.');
            }
            $data->save();

            DB::commit();

            $bill = Billing::where('section_id', $request->section_id)
                ->where('section', $request->section)
                ->first();

            if ($bill) {
                return redirect()->route('bill.billing-details', [$request->section, ed(@$bill->id, true)])
                    ->with('success', 'Prescription updated successfully!');
            } else {
                return redirect()->back()->with('success', 'Prescription created successfully!');
            }
        } catch (Exception $e) {
            DB::rollBack();

            return redirect()->back()->with('error', 'Failed! Please try again!');
        }
    }


    public function ipd_emr_update(Request $request)
    {
        DB::beginTransaction();

        try {
            $request->validate([
                'patient_id' => ['required', 'exists:patients,id'],
                'doctor_id'  => ['required'],
                'date'       => ['required'],
            ]);

            $data = EmrMaster::where('id', $request->emr_master_id)->firstOrFail();
            $data->advice               = $request->advice;
            $data->progress_note        = json_encode(array_values($request->progress_note ?? []));
            $data->nursing_instructions = json_encode(array_values($request->nursing_instructions ?? []));
            $data->vitals               = json_encode(array_values($request->vitals ?? []));
            $data->complaints           = json_encode(array_values($request->complaints ?? []));
            $data->diagnosis            = json_encode(array_values($request->diagnosis ?? []));
            $data->medicines            = json_encode(array_values($request->medicines ?? []));
            $data->test_name            = json_encode(array_values($request->test_name ?? []));
            $data->save();

            // Save log
            $emr_logs = new EmrLog();
            $emr_logs->emr_id   = $data->id;
            $emr_logs->edit_by  = Auth::user()->id;
            $emr_logs->edit_at  = now()->format('Y-m-d H:i:s');
            $emr_logs->save();

            DB::commit();

            $bill = Billing::where('section_id', $request->section_id)
                ->where('section', $request->section)
                ->first();

            if ($bill) {
                return redirect()->route('bill.billing-details', [$request->section, ed(@$bill->id, true)])
                    ->with('success', 'Prescription updated successfully!');
            } else {
                return redirect()->back()->with('success', 'Prescription updated successfully!');
            }
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Failed to update! Please try again.');
        }
    }
}
