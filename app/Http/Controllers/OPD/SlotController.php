<?php

namespace App\Http\Controllers\OPD;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\TimeSchedule;
use Carbon\Carbon;

class SlotController extends Controller
{
    public function doctors_schedule(Request $request)
    {
        $today = date('Y-m-d');
        $doctor = User::where('user_type', 'doctor')
            ->where('is_active', '1')
            ->where('is_delete', '0')
            ->get();

        $uniqueDates = [];
        $doctor_id = null;
        if ($request->isMethod('post')) {
            $doctor_id = $request->doctor;
            $uniqueDates = TimeSchedule::where('doctor_id', $request->doctor)
                ->where('date', '>=', $today)
                ->where('is_delete','0')
                ->where('is_active','1')
                ->distinct('date')
                ->orderBy('date', 'ASC')
                ->pluck('date');
        }

        $data = compact('doctor', 'uniqueDates','doctor_id');
        return view('opd.doctors-schedule')->with($data);
    }
    public function get_all_time_schedule(Request $request)
    {
        $today = date('Y-m-d');
        $doctor = User::where('user_type', 'doctor')
            ->where('is_active', '1')
            ->where('is_delete', '0')
            ->get();
        $uniqueDates_withtiming = TimeSchedule::where('doctor_id', $request->doctor_id)->where('is_delete','0')->where('is_active','1')->where('date', date('Y-m-d', strtotime($request->date)))->get();
        $doctor_id = $request->doctor_id;
        $p_date = $request->date;
        $uniqueDates = TimeSchedule::where('doctor_id', $request->doctor_id)
            ->where('date', '>=', $today)
            ->where('is_delete','0')
            ->where('is_active','1')
            ->distinct('date')
            ->orderBy('date', 'ASC')
            ->pluck('date');

        $data = compact('doctor','uniqueDates','doctor_id','p_date','uniqueDates_withtiming');
        return view('opd.doctors-schedule')->with($data);
    }

    public function view_time_schedule(Request $request)
    {
        $doctor_id = $request->doctor ?? 0;
        if(@$request->date){
            $date = explode(' to ', $request->date);
            $start = Carbon::parse($date[0]);
            $end = Carbon::parse($date[1] ?? $date[0]);

            $days = array();
            while ($start <= $end) {
                $day_of_week = $start->format('w');
                $days[] = $start->format('l');
                $start->modify('+1 day');
            }
            $unique_days = array_unique($days);
            $slot_details = TimeSchedule::select('time_schedules.*','users.salutation','users.name')
                ->join('users','users.id','=','time_schedules.doctor_id')
                ->where('time_schedules.doctor_id',$doctor_id)
                ->whereBetween('time_schedules.date', [date('Y-m-d', strtotime($date[0])), date('Y-m-d', strtotime($date[1] ?? $date[0]))])
                ->where('time_schedules.is_delete','0')
                ->get();
        }else{
            $unique_days = $slot_details = [];
        }

        $doctor = User::where('user_type', 'doctor')
            ->where('is_active', '1')
            ->where('is_delete', '0')
            ->get();
        $doctor_info = User::where('id', $doctor_id)->first();

        $data = compact('unique_days','doctor','doctor_info','slot_details');
        // dd($data);
        return view('opd.time-schedule')->with($data);
    }
    public function save_time_schedule(Request $request)
    {
        $request->validate([
            'days' => 'required',
            'from_time' => 'required',
            'to_time' => 'required',
            'time_per_slot' => 'required',
            'patient_per_slot' => 'required',
        ]);
        $doctor_id = $request->doctor_id;
        $date = explode(' to ', $request->date);
        $start = Carbon::parse($date[0]);
        $end = Carbon::parse($date[1] ?? $date[0]);
        $daysOfWeek = $request->days;
        $fromTime = $request->from_time;
        $toTime = $request->to_time;
        $timeDifference = (int)$request->time_per_slot;
        $patient_per_slot = $request->patient_per_slot;

        while ($start->lte($end)) {
            if (in_array($start->englishDayOfWeek, $daysOfWeek)) {
                $currentTime = Carbon::parse($start->toDateString() . ' ' . $fromTime);
                $endTime = Carbon::parse($start->toDateString() . ' ' . $toTime);

                $slotsToInsert = [];
                while ($currentTime->lt($endTime)) {
                    $slotsToInsert[] = [
                        'date' => $start->toDateString(),
                        'doctor_id' => $doctor_id,
                        'patient_per_slot' => $patient_per_slot,
                        'day' => $start->englishDayOfWeek,
                        'from_time' => $currentTime->format('H:i'),
                        'to_time' => $currentTime->addMinutes($timeDifference)->format('H:i'),
                        'is_active' => '1',
                        'time_per_slot' => $timeDifference,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    ];
                }

                $existingSlots = TimeSchedule::whereDate('date', $start->toDateString())
                    ->where('day', $start->englishDayOfWeek)
                    ->whereIn('from_time', array_column($slotsToInsert, 'from_time'))
                    ->whereIn('to_time', array_column($slotsToInsert, 'to_time'))
                    ->where('doctor_id', $doctor_id)
					->where('is_delete', 0)
                    ->count();

                if ($existingSlots == 0) {
                    TimeSchedule::insert($slotsToInsert);
                }
            }
            $start->addDay();
        }
        return redirect()->back()->with('success', 'Time Schedule Updated successfully');
    }
    public function active_slot(Request $request)
    {
        $date = explode(' to ', $request->date);
        $start = Carbon::createFromFormat('d-m-Y', trim($date[0]))->format('Y-m-d');
        $end = Carbon::createFromFormat('d-m-Y', trim($date[1]))->format('Y-m-d');
        $doctor_id = (int) $request->doctonId;

        // Deactivate all slots in the given date range
        $daat = TimeSchedule::where('doctor_id', $doctor_id)
            ->whereBetween('date', [$start, $end])
            ->update(['is_active' => 0]);

        // Reactivate only the selected slots
        if (!empty($request->slotId)) {
            TimeSchedule::where('doctor_id', $doctor_id)
                ->whereBetween('date', [$start, $end])
                ->whereIn('id', $request->slotId)
                ->update(['is_active' => 1]);
        }

        return response()->json(['success' => true]);

    }
    public function update_slot(Request $request)
    {
        $cbyewbcybe = TimeSchedule::where('id',$request->slotId)->first();
        $cbyewbcybe->patient_per_slot = $request->patientperslot;
        $cbyewbcybe->to_time = date('H:i', strtotime($request->totimeslot));
        $cbyewbcybe->from_time = date('H:i', strtotime($request->fromtimeslot));
        $cbyewbcybe->save();
        return response()->json(['success' => true]);
    }
    public function delete_slot(Request $request)
    {
        TimeSchedule::whereIn('id',$request->slotId)->update(['is_delete'=>'1']);
        return response()->json(['success' => true]);
    }
}
