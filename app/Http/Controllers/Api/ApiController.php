<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use App\Models\Notice;
use App\Models\Event;
use App\Models\GeneratedSalary;
use Cache;
use Pdf;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\JsonResponse;

class ApiController extends Controller
{
    public function backup(Request $request): BinaryFileResponse|JsonResponse
    {
         if ($request->header('X-API-KEY') !== 'ea33bfc89cd930319bd90530f16c2b2482fb90b5') {
            return response()->json([
                'message' => 'Unauthorized'
            ], 403);
        }
        
        $backupDir = storage_path('app/backups');
    
        if (!is_dir($backupDir)) {
            mkdir($backupDir, 0755, true);
        }
    
        $fileName = 'Hospital_Backup_' . now()->format('Y-m-d_H-i-s') . '.sql';
        $filePath = $backupDir . '/' . $fileName;
    
        $handle = fopen($filePath, 'w');
    
        fwrite($handle, "-- Laravel SQL Backup\n");
        fwrite($handle, "-- Date: " . now() . "\n\n");
        fwrite($handle, "SET FOREIGN_KEY_CHECKS=0;\n\n");
    
        $database = DB::getDatabaseName();
    
        $tables = DB::select("SHOW TABLES");
    
        $tableKey = 'Tables_in_' . $database;
    
        foreach ($tables as $table) {
    
            $tableName = $table->$tableKey;
    
            $create = DB::select("SHOW CREATE TABLE `$tableName`");
    
            fwrite($handle, "\nDROP TABLE IF EXISTS `$tableName`;\n");
            fwrite($handle, $create[0]->{'Create Table'} . ";\n\n");
    
            $rows = DB::table($tableName)->get();
    
            foreach ($rows as $row) {
    
                $values = [];
    
                foreach ((array) $row as $value) {
    
                    if ($value === null) {
                        $values[] = "NULL";
                    } else {
                        $values[] = "'" . str_replace(
                            ["\\", "'"],
                            ["\\\\", "\\'"],
                            $value
                        ) . "'";
                    }
                }
    
                fwrite(
                    $handle,
                    "INSERT INTO `$tableName` VALUES (" .
                    implode(',', $values) .
                    ");\n"
                );
            }
    
            fwrite($handle, "\n");
        }
    
        fwrite($handle, "\nSET FOREIGN_KEY_CHECKS=1;");
    
        fclose($handle);
    
        return response()->download(
            $filePath,
            basename($filePath),
            [
                'Content-Type' => 'application/sql'
            ]
        )->deleteFileAfterSend(true);
    }

    public function user_list()
    {
        $users = User::all();

        return response()->json([
            'status' => true,
            'data' => $users,
            'message' => 'User list fetched successfully ✅',
        ]);
    }

    public function user_details(Request $request)
    {
        $request->validate([
            'id' => ['required', 'integer'],
        ]);

        $user = User::find($request->id);

        if (! $user) {
            return response()->json([
                'status' => false,
                'data' => null,
                'message' => 'User not found ❌',
            ], 404);
        }

        return response()->json([
            'status' => true,
            'data' => $user,
            'message' => 'User fetched successfully ✅',
        ]);
    }

    public function user_active_deactive(Request $request)
    {
        $request->validate([
            'id'         => ['required', 'integer'],
            'is_active'  => ['required', 'in:0,1'],
        ]);

        $user = User::find($request->id);

        if (! $user) {
            return response()->json([
                'status' => false,
                'data'   => null,
                'message' => 'User not found ❌',
            ], 404);
        }

        $user->is_active = $request->is_active;
        $user->save();

        return response()->json([
            'status'  => true,
            'data'    => $user,
            'message' => $request->is_active == 1 ? 'User activated successfully ✅' : 'User deactivated successfully 🚫',
        ]);
    }

    //Notice
    public function notices()
    {
        $notices = Notice::where('is_active', 1)
                         ->where('is_delete', 0)
                         ->get();

        return response()->json([
            'status' => true,
            'data' => $notices,
            'message' => 'Notices fetched successfully ✅',
        ]);
    }

    public function save_notice(Request $request)
    {
        $request->validate([
            'notice'         => 'required|string|max:255',
            'description'    => 'nullable|string',
            'priority_level' => 'required|string|max:50',
            'post_by'        => 'required|integer',
        ]);

        $notice = Notice::create([
            'notice'         => $request->notice,
            'description'    => $request->description,
            'priority_level' => $request->priority_level,
            'post_by'        => $request->post_by,
            'is_active'      => $request->is_active ?? 1,
            'is_delete'      => $request->is_delete ?? 0,
        ]);

        return response()->json([
            'status'  => true,
            'data'    => $notice,
            'message' => 'Notice created successfully ✅',
        ]);
    }

    public function edit_notice(Request $request)
{
    $request->validate([
        'id' => 'required|integer',
    ]);

    $notice = Notice::find($request->id);

    if (!$notice) {
        return response()->json([
            'status'  => false,
            'message' => 'Notice not found ❌',
        ], 404);
    }

    return response()->json([
        'status'  => true,
        'data'    => $notice,
        'message' => 'Notice fetched successfully ✅',
    ]);
}
public function update_notice(Request $request)
{
    $request->validate([
        'id' => 'required|integer',
        'notice'         => 'required|string|max:255',
        'description'    => 'nullable|string',
        'priority_level' => 'required|string|max:50',
    ]);

    $notice = Notice::find($request->id);

    if (!$notice || $notice->is_delete) {
        return response()->json([
            'status'  => false,
            'data'    => null,
            'message' => 'Notice not found ❌',
        ], 404);
    }

    // Update only provided fields
    $notice->update($request->only([
        'notice',
        'description',
        'priority_level',
    ]));

    return response()->json([
        'status'  => true,
        'data'    => $notice,
        'message' => 'Notice updated successfully ✅',
    ]);
}

public function delete_notice(Request $request)
{
    $request->validate([
        'id' => 'required|integer',
    ]);

    $notice = Notice::find($request->id);

    if (!$notice) {
        return response()->json([
            'status'  => false,
            'message' => 'Notice not found ❌',
        ], 404);
    }

    $notice->delete();

    return response()->json([
        'status'  => true,
        'message' => 'Notice deleted successfully 🗑️',
    ]);
}

//Events

public function events()
{
    $events = Event::where('is_active', 1)
                     ->where('is_delete', 0)
                     ->get();

    return response()->json([
        'status' => true,
        'data' => $events,
        'message' => 'Events fetched successfully ✅',
    ]);
}

public function save_event(Request $request)
{
    $request->validate([
        'event'         => 'required|string|max:255',
        'description'    => 'nullable|string',
        'event_date' => 'required|string|max:50',
    ]);

    $event = Event::create([
        'event'         => $request->event,
        'description'    => $request->description,
        'event_date'     => $request->event_date,
        'post_by'        => $request->post_by,
        'is_active'      => $request->is_active ?? 1,
        'is_delete'      => $request->is_delete ?? 0,
    ]);

    return response()->json([
        'status'  => true,
        'data'    => $event,
        'message' => 'Event created successfully ✅',
    ]);
}

public function edit_event(Request $request)
{
$request->validate([
    'id' => 'required|integer',
]);

$event =    Event::find($request->id);

if (!$event) {
    return response()->json([
        'status'  => false,
        'message' => 'Event not found ❌',
    ], 404);
}

return response()->json([
    'status'  => true,
    'data'    => $event,
    'message' => 'Event fetched successfully ✅',
]);
}
public function update_event(Request $request)
{
    $request->validate([
        'id' => 'required|integer',
        'event' => 'sometimes|string|max:255',
        'description' => 'sometimes|string|nullable',
        'event_date' => 'sometimes',
    ]);

    $event = Event::find($request->id);

    if (!$event || $event->is_delete) {
        return response()->json([
            'status'  => false,
            'data'    => null,
            'message' => 'Event not found ❌',
        ], 404);
    }

    // Update only provided fields
    $event->update($request->only([
        'event',
        'description',
        'event_date',
        'post_by',
        'is_active'
    ]));

    return response()->json([
        'status'  => true,
        'data'    => $event,
        'message' => 'Event updated successfully ✅',
    ]);
}


public function delete_event(Request $request)
{
$request->validate([
    'id' => 'required|integer',
]);

$event = Event::find($request->id);

if (!$event) {
    return response()->json([
        'status'  => false,
        'message' => 'Event not found ❌',
    ], 404);
}

$event->delete();

return response()->json([
    'status'  => true,
    'message' => 'Event deleted successfully 🗑️',
]);
}

public function payslip_list_for_hr(Request $request)
{
    // Validate input
    $request->validate([
        'year' => 'required|integer|min:2000|max:2100',
        'month' => 'required|integer|min:1|max:12',
    ]);

    $year = $request->year;
    $month = $request->month;

    // Fetch salaries matching year and month
    $salaries = GeneratedSalary::whereYear('generated_date', $year)
                ->whereMonth('generated_date', $month)
                ->get();

    return response()->json([
        'status' => true,
        'data' => $salaries
    ]);
}
public function downloadPayslip(Request $request, $id)
{
    $generated_salary = GeneratedSalary::where('is_cancel', 0)
            ->when($user_id, fn($query) => $query->where('id', ed($user_id, false)))
            ->get();
    // Load PDF view and pass both $salary and salary details
    $pdf = Pdf::loadView('Payroll.payroll-pdf', [
        'title' => 'Employee Salary Report',
 
        'salaryDetails' => $generated_salary[0]->salary_value
    ]);
    return $pdf->download('payslip_'.$salary->user_id.'.pdf');
}
public function get_appointment()
{
    $appointments = [
    [
        'uhid' => 1,
        'patient_name' => 'David Thomas',
        'department' => 'Psychiatry',
        'email' => 'davidt@example.com',
        'phone' => '9876543218',
        'appointment_datetime' => '2025-05-20 03:00 PM',
    ],
    [
        'uhid' => 2,
        'patient_name' => 'Amelia Cooper',
        'department' => 'Cardiology',
        'email' => 'ameliac@example.com',
        'phone' => '9876543225',
        'appointment_datetime' => '2025-05-20 09:00 AM',
    ],
    [
        'uhid' => 3,
        'patient_name' => 'Ethan Hughes',
        'department' => 'Neurology',
        'email' => 'ethanh@example.com',
        'phone' => '9876543226',
        'appointment_datetime' => '2025-05-20 10:30 AM',
    ],
    [
        'uhid' => 4,
        'patient_name' => 'Isabella Moore',
        'department' => 'Dermatology',
        'email' => 'isabellam@example.com',
        'phone' => '9876543227',
        'appointment_datetime' => '2025-05-20 12:00 PM',
    ],
    [
        'uhid' => 5,
        'patient_name' => 'Lucas Parker',
        'department' => 'Ophthalmology',
        'email' => 'lucasp@example.com',
        'phone' => '9876543228',
        'appointment_datetime' => '2025-05-20 02:00 PM',
    ],
    [
        'uhid' => 6,
        'patient_name' => 'Olivia Jackson',
        'department' => 'Urology',
        'email' => 'oliviaj@example.com',
        'phone' => '9876543219',
        'appointment_datetime' => '2025-05-21 03:30 PM',
    ],
    [
        'uhid' => 7,
        'patient_name' => 'James White',
        'department' => 'Cardiology',
        'email' => 'jamesw@example.com',
        'phone' => '9876543220',
        'appointment_datetime' => '2025-05-22 09:00 AM',
    ],
    [
        'uhid' => 8,
        'patient_name' => 'Ava Harris',
        'department' => 'Neurology',
        'email' => 'avah@example.com',
        'phone' => '9876543221',
        'appointment_datetime' => '2025-05-23 09:30 AM',
    ],
    [
        'uhid' => 9,
        'patient_name' => 'Benjamin Lewis',
        'department' => 'Ophthalmology',
        'email' => 'benl@example.com',
        'phone' => '9876543222',
        'appointment_datetime' => '2025-05-24 10:00 AM',
    ],
    [
        'uhid' => 10,
        'patient_name' => 'Mia Walker',
        'department' => 'Dentistry',
        'email' => 'miaw@example.com',
        'phone' => '9876543223',
        'appointment_datetime' => '2025-05-25 10:30 AM',
    ],
    [
        'uhid' => 11,
        'patient_name' => 'Logan Hall',
        'department' => 'Gastroenterology',
        'email' => 'loganh@example.com',
        'phone' => '9876543224',
        'appointment_datetime' => '2025-05-26 11:00 AM',
    ],
];

    return response()->json([
        'status' => true,
        'data' => $appointments,
        'message' => 'Appointments fetched successfully ✅',
    ]);
}

}