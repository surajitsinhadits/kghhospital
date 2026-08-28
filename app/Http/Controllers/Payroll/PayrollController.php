<?php

namespace App\Http\Controllers\Payroll;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\GeneratedSalary;
use App\Models\SalaryRule;
use App\Models\SalaryStructure;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Yajra\Datatables\DataTables;

class PayrollController extends Controller
{

    public function user_generate_payroll(Request $request)
    {
        $title = 'Users';
        $year = $request->query('year');
        $month = $request->query('month');
        $generate_date = sprintf('%04d-%02d-01', $year, $month);

        if ($request->ajax()) {
            $data = User::select('users.*', 'roles.role', 'generated_salaries.id as generated_salary_id')
                ->join('roles', 'roles.id', '=', 'users.role_id')
                ->leftjoin('generated_salaries', 'generated_salaries.user_id', '=', 'users.id')
                ->where('user_type', 'user')
                ->where('generated_salaries.generated_date', '=', $generate_date)
                ->orderBy('id', 'DESC');
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $actionBtn = $row->generated_salary_id ? ('<a href="' . route('payroll.get-generated-salary', ed($row->id, true)) . '" class="btn btn-sm btn-outline-info mx-1" title="View"><i class="bx bxs-info-circle"></i></a>') : 'Not Generated';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('Payroll.generate-payroll', compact('title'));
    }

    public function processSalary(Request $request)
    {

        $year = $request->year;
        $month = $request->month;
        $actionType = $request->action_type;
        switch ($actionType) {
            case 'search':

                $title = 'Users';

                $data = User::select('users.*', 'roles.role', 'generated_salaries.id as generated_salary_id')
                    ->join('roles', 'roles.id', '=', 'users.role_id')
                    ->leftjoin('generated_salaries', 'generated_salaries.user_id', '=', 'users.id')
                    ->where('user_type', 'user')
                    ->where('generated_salaries.generated_date', '=', date('Y-m-01'))
                    ->orderBy('id', 'DESC');
                return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function ($row) {
                        $actionBtn = $row->generated_salary_id
                            ? ('<a href="' . route('payroll.get-generated-salary', ed($row->id, true)) . '" class="btn btn-sm btn-outline-info mx-1" title="View"><i class="bx bxs-info-circle"></i></a>')
                            : 'Not Generated';
                        return $actionBtn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);

                return view('Payroll.generate-payroll', compact('title'));

                break;
            case 'generate':
                $generate_date = sprintf('%04d-%02d-01', $year, $month);

                $data = User::select('users.*', 'roles.role', 'generated_salaries.id as generated_salary_id')
                    ->join('roles', 'roles.id', '=', 'users.role_id')
                    ->leftjoin('generated_salaries', 'generated_salaries.user_id', '=', 'users.id')
                    ->where('user_type', 'user')
                    ->orderBy('id', 'DESC')
                    ->get();

                // dd($data);
                foreach ($data as $user) {
                    $salary_structure_arr = SalaryStructure::join('salary_types', 'salary_structures.salary_type_id', '=', 'salary_types.id')
                        ->join('salary_rules', 'salary_structures.salary_rules_id', '=', 'salary_rules.id')
                        ->where('salary_master_id', 1)
                        ->get();

                    $basic = 20000;
                    $present = 0;
                    $absent = 0;
                    $leave = 0;

                    $salary_structure = [];
                    $salary_value = [];

                    $salary_structure['Basic'] = $basic;
                    $salary_value['Basic'] = $basic;

                    foreach ($salary_structure_arr as $key => $value) {
                        $salary_structure[$value->salary_type_description] = $value->rule;
                        $salary_value[$value->salary_type_description] = eval("return {$value->rule};");
                    }

                    $generated_salary = new GeneratedSalary();
                    $generated_salary->user_id = $user->id;
                    $generated_salary->present = $present;
                    $generated_salary->absent = $absent;
                    $generated_salary->generated_date = $generate_date;
                    $generated_salary->salary_structure = json_encode($salary_structure);
                    $generated_salary->salary_value = json_encode($salary_value);
                    $generated_salary->save();
                }

                return redirect()->back()->with('success', 'Salary generated successfully!');

                break;

            default:

                break;
        }
    }

    public function salary_structure_by_type_id($salary_type_id)
    {
        $data = SalaryRule::where('salary_type_id', $salary_type_id)->get();
        return $data;
    }

    public function generate_salary()
    {
        if (isset($_GET['year']) && isset($_GET['month'])) {
            $year = $_GET['year'];
            $month = $_GET['month'];
            $generate_date = sprintf('%04d-%02d-01', $year, $month);

            // dd($generate_date);

            $data = User::select('users.*', 'roles.role', 'generated_salaries.id as generated_salary_id')
                ->join('roles', 'roles.id', '=', 'users.role_id')
                ->leftjoin('generated_salaries', 'generated_salaries.user_id', '=', 'users.id')
                ->where('user_type', 'user')
                ->orderBy('id', 'DESC')
                ->get();

            // dd($data);
            foreach ($data as $user) {
                $salary_structure_arr = SalaryStructure::join('salary_types', 'salary_structures.salary_type_id', '=', 'salary_types.id')
                    ->join('salary_rules', 'salary_structures.salary_rules_id', '=', 'salary_rules.id')
                    ->where('salary_master_id', 1)
                    ->get();

                $basic = 20000;
                $present = 0;
                $absent = 0;
                $leave = 0;

                $salary_structure = [];
                $salary_value = [];

                $salary_structure['Basic'] = $basic;
                $salary_value['Basic'] = $basic;

                foreach ($salary_structure_arr as $key => $value) {
                    $salary_structure[$value->salary_type_description] = $value->rule;
                    $salary_value[$value->salary_type_description] = eval("return {$value->rule};");
                }

                $generated_salary = new GeneratedSalary();
                $generated_salary->user_id = $user->id;
                $generated_salary->present = $present;
                $generated_salary->absent = $absent;
                $generated_salary->generated_date = $generate_date;
                $generated_salary->salary_structure = json_encode($salary_structure);
                $generated_salary->salary_value = json_encode($salary_value);
                $generated_salary->save();
            }

            return redirect()->back()->with('success', 'Salary generated successfully!');
        } else {
            return redirect()->back()->with('error', 'Salary generated failed!');
        }
    }

    public function get_generated_salary($user_id = 0)
    {
        $generated_salary = GeneratedSalary::where('is_cancel', 0)
            ->when($user_id, fn($query) => $query->where('user_id', ed($user_id, false)))
            ->get();

        $data = [
            'title' => 'Employee Salary Report',
            'salaryDetails' => $generated_salary[0]->salary_value
        ];
        $pdf = Pdf::loadView('Payroll.payroll-pdf', $data);
        return $pdf->download('payroll.pdf');

        return response()->json([
            'data' => $generated_salary,
            'user_id' => ed($user_id, false),
            'message' => 'Generated salary retrieved successfully.'
        ]);
    }


}
