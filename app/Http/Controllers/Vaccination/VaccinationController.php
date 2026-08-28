<?php

namespace App\Http\Controllers\Vaccination;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\VcVaccine;
use App\Models\VcVendor;
use App\Models\State;
use App\Models\Patient;
use App\Models\VcVaccineLot;
use App\Models\VcPatientVaccination;
use App\Models\VcVaccinationConsent;
use App\Models\VcAefiReport;
use App\Models\VcPurchaseDetail;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use DB;

class VaccinationController extends Controller
{
     public function index1(){
        $total['vaccination_year'] = VcPatientVaccination::where('status','completed')
        ->whereYear('created_at', Carbon::now()->year)
        ->count();
        $total['vaccination_today'] = VcPatientVaccination::where('status', 'completed')
        ->whereDate('administered_date', Carbon::today())
        ->count();
        $total['vaccination_yesterday'] = VcPatientVaccination::where('status', 'completed')
        ->whereDate('administered_date', Carbon::yesterday())
        ->count();
        if ($total['vaccination_yesterday'] > 0) {
            $vaccinationChange = (($total['vaccination_today'] - $total['vaccination_yesterday']) / $total['vaccination_yesterday']) * 100;
        } else {
            $vaccinationChange = null;
        }
        $total['pending_reminder'] = VcPatientVaccination::where('status', 'scheduled')
        ->whereBetween('scheduled_date', [
            Carbon::today()->startOfDay(),
            Carbon::today()->addWeek()->endOfDay()
        ])
        ->count();
        $total['scheduled'] = VcPatientVaccination::select(
            'vc_patient_vaccinations.*',
            'p.name as patient_name',
            'v.vaccine_name as vaccine_nm',
            'p.dob_year as age',
            'u.name as user_name'
            )
            ->leftJoin('users as u', 'u.id', '=', 'vc_patient_vaccinations.created_by')
            ->join('vc_vaccines as v', 'v.id', '=', 'vc_patient_vaccinations.vaccine_id')
            ->join('patients as p', 'p.id', '=', 'vc_patient_vaccinations.patient_id')
            ->where('vc_patient_vaccinations.status', 'scheduled')
            ->whereBetween('scheduled_date', [Carbon::today(), Carbon::today()->addMonth()])
            ->orderBy('vc_patient_vaccinations.scheduled_date', 'asc')
            ->take(3)
            ->get();
        // $total['patients_count'] = VcPatientVaccination::select('patient_id')->distinct()->count();
        $total['patients'] = VcPatientVaccination::select(
            'vc_patient_vaccinations.*',
            'p.name as patient_name',
            'p.email as patient_email',
            'p.phone as patient_phone',
            'v.vaccine_name as vaccine_nm',
            'p.dob_year as age',
            )
            ->join('vc_vaccines as v', 'v.id', '=', 'vc_patient_vaccinations.vaccine_id')
            ->join('patients as p', 'p.id', '=', 'vc_patient_vaccinations.patient_id')
            ->orderBy('id', 'DESC')
            ->take(10)
            ->get();

            $today = Carbon::today()->endOfDay(); 
            $oneMonthAgo = $today->copy()->subMonth()->startOfDay(); 
     
        $total['patients_one_month'] = VcPatientVaccination::whereBetween('created_at', [
                $oneMonthAgo,
                $today
            ])
            ->select('patient_id')
            ->distinct()
            ->count();
     
            $twoMonthsAgo = $oneMonthAgo->copy()->subMonth()->startOfDay();
    
        $total['patients_prev_month'] = VcPatientVaccination::whereBetween('created_at', [
                $twoMonthsAgo,
                $oneMonthAgo
            ])
            ->select('patient_id')
            ->distinct()
            ->count();
      
            if ($total['patients_one_month'] != 0) {
                $percentageChange = (($total['patients_one_month'] - $total['patients_prev_month']) / $total['patients_one_month']) * 100;
            } else {
                $percentageChange = null;
            }
        $total['children_count_one_month'] = VcPatientVaccination::select('p.id')
            ->join('patients as p', 'p.id', '=', 'vc_patient_vaccinations.patient_id')
            ->whereBetween('vc_patient_vaccinations.created_at', [$oneMonthAgo, $today])
            ->where('p.dob_year', '>=', 0)
            ->where('p.dob_year', '<=', 18)
            ->distinct('vc_patient_vaccinations.patient_id')
            ->count();
            
        $total['children_count_prev_month'] = VcPatientVaccination::select('p.dob_year')
            ->join('patients as p', 'p.id', '=', 'vc_patient_vaccinations.patient_id')
            ->whereBetween('vc_patient_vaccinations.created_at', [$twoMonthsAgo, $oneMonthAgo])
            ->where('p.dob_year', '>=', 0)
            ->where('p.dob_year', '<=', 18)
            ->distinct('vc_patient_vaccinations.patient_id')
            ->count();

            if ($total['children_count_one_month'] != 0) {
                $childrenPercentageChange = (($total['children_count_one_month'] - $total['children_count_prev_month']) / $total['children_count_one_month']) * 100;
            } else {
                $childrenPercentageChange = null;
            }

        $total['adult_count_one_month'] = VcPatientVaccination::select('p.id')
            ->join('patients as p', 'p.id', '=', 'vc_patient_vaccinations.patient_id')
            ->whereBetween('vc_patient_vaccinations.created_at', [$oneMonthAgo, $today])
            ->where('p.dob_year', '>=', 19)
            ->where('p.dob_year', '<=', 59)
            ->distinct('vc_patient_vaccinations.patient_id')
            ->count();

        $total['adult_count_prev_month'] = VcPatientVaccination::select('p.dob_year')
            ->join('patients as p', 'p.id', '=', 'vc_patient_vaccinations.patient_id')
            ->whereBetween('vc_patient_vaccinations.created_at', [$twoMonthsAgo, $oneMonthAgo])
            ->where('p.dob_year', '>=', 19)
            ->where('p.dob_year', '<=', 59)
            ->distinct('vc_patient_vaccinations.patient_id')
            ->count();

            if ($total['adult_count_one_month'] != 0) {
                $adultPercentageChange = (($total['adult_count_one_month'] - $total['adult_count_prev_month']) / $total['adult_count_one_month']) * 100;
            } else {
                $adultPercentageChange = null;
            }

        $total['senior_citizens_count_one_month'] = VcPatientVaccination::select('p.id')
            ->join('patients as p', 'p.id', '=', 'vc_patient_vaccinations.patient_id')
            ->whereBetween('vc_patient_vaccinations.created_at', [$oneMonthAgo, $today])
            ->where('p.dob_year', '>=', 60)
            ->distinct('vc_patient_vaccinations.patient_id')
            ->count();

        $total['senior_citizens_count_prev_month'] = VcPatientVaccination::select('p.dob_year')
            ->join('patients as p', 'p.id', '=', 'vc_patient_vaccinations.patient_id')
            ->whereBetween('vc_patient_vaccinations.created_at', [$twoMonthsAgo, $oneMonthAgo])
            ->where('p.dob_year', '>=', 60)
            ->distinct('vc_patient_vaccinations.patient_id')
            ->count();

            if ($total['senior_citizens_count_one_month'] != 0) {
                $seniorCitizensPercentageChange = (($total['senior_citizens_count_one_month'] - $total['senior_citizens_count_prev_month']) / $total['senior_citizens_count_one_month']) * 100;
            } else {
                $seniorCitizensPercentageChange = null;
            }


        $total['one_count_one_month'] = VcPatientVaccination::select('p.id')
            ->join('patients as p', 'p.id', '=', 'vc_patient_vaccinations.patient_id')
            ->whereBetween('vc_patient_vaccinations.created_at', [$oneMonthAgo, $today])
            ->where('p.dob_year', '>=', 0)
            ->where('p.dob_year', '<=', 2)
            ->distinct('vc_patient_vaccinations.patient_id')
            ->count();
            // dd($total['one_count_one_month'] );
        $total['one_count_prev_month'] = VcPatientVaccination::select('p.dob_year')
            ->join('patients as p', 'p.id', '=', 'vc_patient_vaccinations.patient_id')
            ->whereBetween('vc_patient_vaccinations.created_at', [$twoMonthsAgo, $oneMonthAgo])
            ->where('p.dob_year', '>=', 0)
            ->where('p.dob_year', '<=', 2)
            ->distinct('vc_patient_vaccinations.patient_id')
            ->count();
            // dd($total['one_count_prev_month'] );
            if ($total['one_count_one_month'] != 0) {
                $onePercentageChange = (($total['one_count_one_month'] - $total['one_count_prev_month']) / $total['one_count_one_month']) * 100;
            } else {
                $onePercentageChange = null;
            }

        $total['second_count_one_month'] = VcPatientVaccination::select('p.id')
            ->join('patients as p', 'p.id', '=', 'vc_patient_vaccinations.patient_id')
            ->whereBetween('vc_patient_vaccinations.created_at', [$oneMonthAgo, $today])
            ->where('p.dob_year', '>=', 3)
            ->where('p.dob_year', '<=', 6)
            ->distinct('vc_patient_vaccinations.patient_id')
            ->count();

        $total['second_count_prev_month'] = VcPatientVaccination::select('p.dob_year')
            ->join('patients as p', 'p.id', '=', 'vc_patient_vaccinations.patient_id')
            ->whereBetween('vc_patient_vaccinations.created_at', [$twoMonthsAgo, $oneMonthAgo])
            ->where('p.dob_year', '>=', 3)
            ->where('p.dob_year', '<=', 6)
            ->distinct('vc_patient_vaccinations.patient_id')
            ->count();

            // dd($total['second_count_prev_month'] );

            if ($total['second_count_one_month'] != 0) {
                $secondPercentageChange = (($total['second_count_one_month'] - $total['second_count_prev_month']) / $total['second_count_one_month']) * 100;
            } else {
                $secondPercentageChange = null;
            }

        $total['third_count_one_month'] = VcPatientVaccination::select('p.id')
            ->join('patients as p', 'p.id', '=', 'vc_patient_vaccinations.patient_id')
            ->whereBetween('vc_patient_vaccinations.created_at', [$oneMonthAgo, $today])
            ->where('p.dob_year', '>=', 7)
            ->where('p.dob_year', '<=', 12)
            ->distinct('vc_patient_vaccinations.patient_id')
            ->count();
            // dd($total['third_count_one_month']);
        $total['third_count_prev_month'] = VcPatientVaccination::select('p.dob_year')
            ->join('patients as p', 'p.id', '=', 'vc_patient_vaccinations.patient_id')
            ->whereBetween('vc_patient_vaccinations.created_at', [$twoMonthsAgo, $oneMonthAgo])
            ->where('p.dob_year', '>=', 7)
            ->where('p.dob_year', '<=', 12)
            ->distinct('vc_patient_vaccinations.patient_id')
            ->count();
            // dd($total['third_count_prev_month']);
            if ($total['third_count_one_month'] != 0) {
                $thirdPercentageChange = (($total['third_count_one_month'] - $total['third_count_prev_month']) / $total['third_count_one_month']) * 100;
            } else {
                $thirdPercentageChange = null;
            }

        $total['fourth_count_one_month'] = VcPatientVaccination::select('p.id')
            ->join('patients as p', 'p.id', '=', 'vc_patient_vaccinations.patient_id')
            ->whereBetween('vc_patient_vaccinations.created_at', [$oneMonthAgo, $today])
            ->where('p.dob_year', '>=', 13)
            ->where('p.dob_year', '<=', 18)
            ->distinct('vc_patient_vaccinations.patient_id')
            ->count();
                                                                                             // dd($total['fourth_count_one_month']);
        $total['fourth_count_prev_month'] = VcPatientVaccination::select('p.dob_year')
            ->join('patients as p', 'p.id', '=', 'vc_patient_vaccinations.patient_id')
            ->whereBetween('vc_patient_vaccinations.created_at', [$twoMonthsAgo, $oneMonthAgo])
            ->where('p.dob_year', '>=', 13)
            ->where('p.dob_year', '<=', 18)
            ->distinct('vc_patient_vaccinations.patient_id')
            ->count();
            // dd($total['fourth_count_prev_month']);
            if ($total['fourth_count_one_month'] != 0) {
                $fourthPercentageChange = (($total['fourth_count_one_month'] - $total['fourth_count_prev_month']) / $total['fourth_count_one_month']) * 100;
            } else {
                $fourthPercentageChange = null;
            }

        $total['fifth_count_one_month'] = VcPatientVaccination::select('p.id')
            ->join('patients as p', 'p.id', '=', 'vc_patient_vaccinations.patient_id')
            ->whereBetween('vc_patient_vaccinations.created_at', [$oneMonthAgo, $today])
            ->where('p.dob_year', '>=', 65)
            ->distinct('vc_patient_vaccinations.patient_id')
            ->count();
           
        $total['fifth_count_prev_month'] = VcPatientVaccination::select('p.dob_year')
            ->join('patients as p', 'p.id', '=', 'vc_patient_vaccinations.patient_id')
            ->whereBetween('vc_patient_vaccinations.created_at', [$twoMonthsAgo, $oneMonthAgo])
            ->where('p.dob_year', '>=', 65)
            ->distinct('vc_patient_vaccinations.patient_id')
            ->count();
    
            if ($total['fifth_count_one_month'] != 0) {
                $fifthPercentageChange = (($total['fifth_count_one_month'] - $total['fifth_count_prev_month']) / $total['fifth_count_one_month']) * 100;
            } else {
                $fifthPercentageChange = null;
            }
        $patient = VcPatientVaccination::select(
            'vc_patient_vaccinations.*'
        )
        ->where('vc_patient_vaccinations.status','completed')
        ->orderBy('vc_patient_vaccinations.id', 'DESC') 
        ->get();

        $vaccine_issuse = VcPatientVaccination::select(
        'vc_patient_vaccinations.vaccine_id',
        'v.vaccine_name',
        DB::raw('COUNT(vc_patient_vaccinations.id) as total')
            )
            ->join('vc_vaccines as v', 'v.id', '=', 'vc_patient_vaccinations.vaccine_id')
            ->groupBy('vc_patient_vaccinations.vaccine_id', 'v.vaccine_name')
            ->orderBy('total', 'DESC') 
            ->get();
   
        $monthlyIncome = [];

        foreach ($patient as $item) {
            if (!empty($item->created_at)) {
                $month = Carbon::parse($item->created_at)->format('Y-m');
                $monthlyIncome[$month] = ($monthlyIncome[$month] ?? 0) + floatval($item->amount);
            }
        }
        
        $purchases = VcPurchaseDetail::all();
        $monthlyExpense = [];

        foreach ($purchases as $item) {
            if (!empty($item->created_at)) {
                $month = Carbon::parse($item->created_at)->format('Y-m');
                $monthlyExpense[$month] = ($monthlyExpense[$month] ?? 0) + floatval($item->amount);
            }
        }

        $labels = [];
        $profits = [];
        $incomeData = [];
        $expenseData = [];
        $backgroundColors = [];

       for ($i = 5; $i >= 0; $i--) {
        $monthKey = Carbon::now()->subMonths($i)->format('Y-m');
        $monthLabel = Carbon::now()->subMonths($i)->format('M');

        $income = $monthlyIncome[$monthKey] ?? 0;
        $expense = $monthlyExpense[$monthKey] ?? 0;
        $profit = $income - $expense;

        $labels[] = $monthLabel;
        $incomeData[] = $income;
        $expenseData[] = $expense;
        $profits[] = $profit < 0 ? 0 : $profit;

        $backgroundColors[] = 'rgba(139, 92, 246, 0.7)';
        }
        $topDistricts = VcPatientVaccination::select(
                'd.name as district_name',
                DB::raw('COUNT(vc_patient_vaccinations.id) as district_patient_count')
            )
            ->join('patients as p', 'p.id', '=', 'vc_patient_vaccinations.patient_id')
            ->leftJoin('districts as d', 'd.id', '=', 'p.district')
            ->whereNotNull('d.name')
            ->groupBy('p.district', 'd.name')
            ->orderByDesc('district_patient_count')
            ->limit(5)
            ->get();
        $data = compact('total','percentageChange','childrenPercentageChange','adultPercentageChange','seniorCitizensPercentageChange','onePercentageChange','secondPercentageChange','thirdPercentageChange','fourthPercentageChange','fifthPercentageChange','vaccinationChange','profits','labels','backgroundColors','expenseData','incomeData','topDistricts','vaccine_issuse');
        return view('vaccination.index1')->with($data);
    }
    public function index(){
        $total['vaccination'] = VcPatientVaccination::where('status','completed')->count();
        $total['patients'] = VcPatientVaccination::select('patient_id')->distinct()->count();
        $total['vaccine'] = VcVaccine::where('status',0)->count();
        $total['today_appointment'] = VcPatientVaccination::whereDate('created_at', \Carbon\Carbon::today())->count();
        $patient_details = VcPatientVaccination::select(
                'vc_patient_vaccinations.*',
                'p.name as patient_name',
                'v.vaccine_name',
                'd.name as district_name'
            )
            ->join('vc_vaccines as v', 'v.id', '=', 'vc_patient_vaccinations.vaccine_id')
            ->join('patients as p', 'p.id', '=', 'vc_patient_vaccinations.patient_id')
            ->leftJoin('districts as d', 'd.id', '=', 'p.district')
            ->where('vc_patient_vaccinations.status','completed')
            ->orderBy('vc_patient_vaccinations.id', 'DESC')
            ->take(5)
            ->get();

        $patient = VcPatientVaccination::select(
                'vc_patient_vaccinations.*'
            )
            ->where('vc_patient_vaccinations.status','completed')
            ->orderBy('vc_patient_vaccinations.id', 'DESC') 
            ->get();
      
        $monthlyIncome = [];

        foreach ($patient as $item) {
            if (!empty($item->created_at)) {
                $month = Carbon::parse($item->created_at)->format('Y-m');
                $monthlyIncome[$month] = ($monthlyIncome[$month] ?? 0) + floatval($item->amount);
            }
        }
        
        $purchases = VcPurchaseDetail::all();
        $monthlyExpense = [];

        foreach ($purchases as $item) {
            if (!empty($item->created_at)) {
                $month = Carbon::parse($item->created_at)->format('Y-m');
                $monthlyExpense[$month] = ($monthlyExpense[$month] ?? 0) + floatval($item->amount);
            }
        }

        $labels = [];
        $profits = [];
        $incomeData = [];
        $expenseData = [];
        $backgroundColors = [];

       for ($i = 5; $i >= 0; $i--) {
        $monthKey = Carbon::now()->subMonths($i)->format('Y-m');
        $monthLabel = Carbon::now()->subMonths($i)->format('M');

        $income = $monthlyIncome[$monthKey] ?? 0;
        $expense = $monthlyExpense[$monthKey] ?? 0;
        $profit = $income - $expense;

        $labels[] = $monthLabel;
        $incomeData[] = $income;
        $expenseData[] = $expense;
        $profits[] = $profit < 0 ? 0 : $profit;

        $backgroundColors[] = 'rgba(139, 92, 246, 0.7)';
        }

        $topDistricts = VcPatientVaccination::select(
                'd.name as district_name',
                DB::raw('COUNT(vc_patient_vaccinations.id) as district_patient_count')
            )
            ->join('patients as p', 'p.id', '=', 'vc_patient_vaccinations.patient_id')
            ->leftJoin('districts as d', 'd.id', '=', 'p.district')
            ->whereNotNull('d.name')
            ->groupBy('p.district', 'd.name')
            ->orderByDesc('district_patient_count')
            ->limit(5)
            ->get();

        $stockSummary = VcVaccineLot::select(
            'v.vaccine_name',
            DB::raw('SUM(vc_vaccine_lots.available_qty) as avlb_qty'),
            DB::raw('SUM(vc_vaccine_lots.total_qty) as total_qty')
        )
        ->join('vc_vaccines as v', 'v.id', '=', 'vc_vaccine_lots.vaccine_id')
        ->groupBy('vc_vaccine_lots.vaccine_id', 'v.vaccine_name')
        ->orderByDesc('total_qty')
        ->get();

        $data = compact('total','patient_details','topDistricts','stockSummary','profits','labels','backgroundColors','incomeData','expenseData');
        return view('vaccination.index')->with($data);
    }
    // vaccines
    public function vaccine(Request $request){
         if ($request->ajax()) {
            $data = VcVaccine::select(
                    'vc_vaccines.*'
                )
                ->orderBy('vc_vaccines.id', 'DESC');

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $actionBtn = '';
                    if ($row->is_approved != 1) {
                        $actionBtn .= '<a href="'.route('vc.edit-vaccine', ed($row->id, true)).'" class="btn btn-sm btn-primary me-2">
                            <i class="fa fa-edit"></i> Edit
                        </a>';
                    }
                    return $actionBtn;
                })
                ->addColumn('relation', function ($row) {
                    $actionBtn = '1 '.$row->unit.' = '.$row->unit_subunit_relation.' '.$row->sub_unit;
                    return $actionBtn;
                })
                ->rawColumns(['action','relation'])
                ->make(true);
        }

        return view('vaccination.vaccine');

    }
    public function vaccine_register(){
        $btn = 'Save';
        $data = compact('btn');
        return view('vaccination.vaccine_register')->with($data);
    }
    public function edit_vaccine($id){
        $id = ed($id, false);
        $btn = 'Update';
        $edit = VcVaccine::find($id);
        $data = compact('btn','edit');
        return view('vaccination.vaccine_register')->with($data);
    }
    public function update_vaccine_register(Request $request, $id = 0){
        $request->validate([
            'vaccine_name' => 'required',
            'age_group' => 'required',
            'no_of_doses' => 'required',
            'injection_site' => 'required',
            'route' => 'required',
            'unit' => 'required',
            'unit_subunit_relation' => 'required',
            'sub_unit' => 'required',
        ]);

        if($id){
            $vaccine = VcVaccine::find($id);
        }else{
            $vaccine = new VcVaccine();
        }
        $vaccine->vaccine_name = $request->vaccine_name;
        $vaccine->brand_name = $request->brand_name;
        $vaccine->manufacturer = $request->manufacturer;
        $vaccine->age_group = $request->age_group;
        $vaccine->storage_temp = $request->storage_temp;
        $vaccine->no_of_doses = $request->no_of_doses;
        $vaccine->interval_days = $request->interval_days;
        $vaccine->injection_site = $request->injection_site;
        $vaccine->route = $request->route;
        $vaccine->disease_prevented = $request->disease_prevented;
        $vaccine->drawbacks = $request->drawbacks;
        $vaccine->remarks = $request->remarks;
        $vaccine->unit = $request->unit;
        $vaccine->sub_unit = $request->sub_unit;
        $vaccine->unit_subunit_relation = $request->unit_subunit_relation;
        $vaccine->save();
        return redirect()->route('vc.vaccine')->with('success', 'Vaccine '.($id ? 'Updated' : 'registered').' successfully');
    }

    // Vaccination
    public function vaccination(Request $request){
        if ($request->ajax()) {
            $data = VcPatientVaccination::select(
                    'vc_patient_vaccinations.*','p.name as patient_name','p.gender','p.dob_year','p.phone','v.vaccine_name'
                )
                ->join('vc_vaccines as v', 'v.id','=','vc_patient_vaccinations.vaccine_id')
                ->join('patients as p', 'p.id','=','vc_patient_vaccinations.patient_id')
                // ->whereIn('vc_patient_vaccinations.status',['scheduled','completed'])
                ->orderBy('vc_patient_vaccinations.id', 'DESC');

            // Filter by date range using Carbon for reliability
            if ($request->filled('vaccine')) {
                $data->where('vc_patient_vaccinations.vaccine_id', $request->vaccine);
            }
            if ($request->filled('status')) {
                $data->where('vc_patient_vaccinations.status', $request->status);
            }
            if ($request->filled('scheduledDate')) {
                $arrSDate = explode(' to ', $request->scheduledDate);
                $data->whereBetween('vc_patient_vaccinations.scheduled_date', [
                    \Carbon\Carbon::parse($arrSDate[0])->startOfDay(),
                    \Carbon\Carbon::parse($arrSDate[1] ?? $arrSDate[0])->endOfDay()
                ]);
            }
            if ($request->filled('administeredDate')) {
                $arrADate = explode(' to ', $request->administeredDate);
                $data->whereBetween('vc_patient_vaccinations.administered_date', [
                    \Carbon\Carbon::parse($arrADate[0])->startOfDay(),
                    \Carbon\Carbon::parse($arrADate[1] ?? $arrADate[0])->endOfDay()
                ]);
            }

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $actionBtn = '<a href="'.route('vc.view-vaccination', ed($row->id, true)).'" class="btn btn-sm btn-primary me-2">
                            <i class="fa fa-eye"></i> View
                        </a>';
                    if ($row->status == 'scheduled') {
                        $actionBtn .= '<a href="'.route('vc.edit-vaccination', ed($row->id, true)).'" class="btn btn-sm btn-primary me-2">
                            <i class="fa fa-edit"></i> Edit
                        </a>';
                    }
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        $title = 'Vaccination Lists';
        $vaccine = VcVaccine::where('status', '0')->get();
        return view('vaccination.vaccination', compact('title', 'vaccine'));
    }
    public function vaccination_register(){
        $states = State::where('country_id', '1')->get();
        $vaccine = VcVaccine::where('status', '0')->get();
        $btn = 'Save';
        $data = compact('states','btn','vaccine');
        return view('vaccination.add-vaccination')->with($data);
    }
    public function edit_vaccination($id){
        $id = ed($id, false);
        $states = State::where('country_id', '1')->get();
        $vaccine = VcVaccine::where('status', '0')->get();
        $btn = 'Update';
        $edit = VcPatientVaccination::find($id);
        if($edit){
            $edit_patient = Patient::find($edit->patient_id);
            $stocks = VcVaccineLot::select('id','batch_number','exp_date','total_qty','available_qty','s_rate','sub_unit','unit_relation')
                ->where('vaccine_id',$edit->vaccine_id)
                ->where('available_qty','>',0)
                ->get()
                ->map(function ($item) {
                    $item->available = $item->available_qty.' '.$item->sub_unit;
                    $item->s_rate = $item->s_rate ? number_format(($item->s_rate / $item->unit_relation), 2) : 'N/A';
                    return $item;
                });
            $vaccine_info = VcVaccine::find($edit->vaccine_id);
            $edit_consent = VcVaccinationConsent::where('vaccination_id', $id)->first();
        }else{
            $edit_patient = $vaccine_info = $edit_consent = null;
            $stocks = [];
        }
        $data = compact('btn','edit','edit_patient','states','vaccine','stocks','vaccine_info','edit_consent');
        // dd($data);
        return view('vaccination.add-vaccination')->with($data);
    }
    public function view_vaccination($id){
        $id = ed($id, false);
        $vaccination = VcPatientVaccination::select('vc_patient_vaccinations.*', 'users.name as create_name','p.name as patient_name','v.vaccine_name as name')
            ->leftjoin('users', 'users.id', '=', 'vc_patient_vaccinations.administered_by')
            ->join('patients as p', 'p.id', '=', 'vc_patient_vaccinations.patient_id')
            ->join('vc_vaccines as v', 'v.id', '=', 'vc_patient_vaccinations.vaccine_id')
            ->where('vc_patient_vaccinations.id', $id)
            ->first();
            // dd($vaccination);
        if($vaccination){
            $patient = Patient::select('patients.*', 'states.name as state_name', 'districts.name as district_name')
                ->leftJoin('states', 'states.id', '=', 'patients.state')
                ->leftJoin('districts', 'districts.id', '=', 'patients.district')
                ->where('patients.id',$vaccination->patient_id)
                ->first();
            $vaccine_info = VcVaccine::find($vaccination->vaccine_id);
            $consents = VcVaccinationConsent::where('vaccination_id', $vaccination->id)->first();
        }else{
            $patient =  $vaccine_info = $consents = null;
        }
        $data = compact('vaccination','patient','vaccine_info','consents');
        // dd($data);
        return view('vaccination.vaccination-view')->with($data);
    }
    public function update_vaccination_register(Request $request, $id = 0){
        // dd($request->administered_by);
        $request->validate([
            'scheduled_date' => 'required',
            'vaccine'        => 'required',
            'phone'          => 'required',
            'name'           => 'required',
            'gender'         => 'required',
            'address'        => 'required',
            'state'          => 'required',
            'pin_code'       => 'nullable|digits:6',
            'aadhar_card_no' => 'nullable|numeric',
            'administered_by'  => $id ? 'required' : 'nullable',
            'batch_number'     => $id ? 'required' : 'nullable',
        ]);

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

            //SAVE vaccination
            $id ? $vaccination = VcPatientVaccination::find($id) : $vaccination = new VcPatientVaccination();
            $vaccination->patient_id = $patient_id;
            $vaccination->vaccine_id = $request->vaccine;
            $vaccination->scheduled_date = date('Y-m-d', strtotime($request->scheduled_date));
            $vaccination->notes = $request->notes;
            if($request->has('administered_date') && $request->administered_date){
                $vaccination->vaccine_lot_id = $request->vaccine_lot_id;
                $vaccination->administered_date = date('Y-m-d H:i:s', strtotime($request->administered_date));
                $vaccination->administered_by = $request->administered_by;
                $vaccination->status = 'completed';
                $vaccination->batch_no = $request->batch_number;
                $vaccination->amount = $request->rate;
            }else{
                $vaccination->created_by = Auth::user()->id;
            }
            $vaccination->save();

            if($request->has('administered_date') && $request->administered_date){
                // Update Vaccine Lot
                $vaccineLot = VcVaccineLot::find($request->vaccine_lot_id);
                if ($vaccineLot) {
                    $vaccineLot->available_qty = $vaccineLot->available_qty - 1;
                    $vaccineLot->update();
                }

                $signature = $consent_form = null;
                // Store the file in storage/app/public/vaccination
                if ($request->hasFile('signature')) {
                    $signatureFile = $request->file('signature');
                    $signatureName = uniqid() . '_' . $signatureFile->getClientOriginalName();
                    $signatureFile->move(public_path('vaccination'), $signatureName);
                    $signature = 'vaccination/' . $signatureName;
                }
                if ($request->hasFile('consent_form')) {
                    $consentFile = $request->file('consent_form');
                    $consentName = uniqid() . '_' . $consentFile->getClientOriginalName();
                    $consentFile->move(public_path('vaccination'), $consentName);
                    $consent_form = 'vaccination/' . $consentName;
                }

                if($request->consent_name){
                    // Update consents
                    $consents = new VcVaccinationConsent();
                    $consents->vaccination_id = $vaccination->id;
                    $consents->patient_id = $patient_id;
                    $consents->signed_by = $request->consent_name;
                    $consents->signed_phone = $request->consent_phone;
                    $consents->signed_at = date('Y-m-d H:i:s', strtotime($request->administered_date));
                    $consents->consent_form_path = $consent_form;
                    $consents->signature_image_path = $signature;
                    $consents->save();
                }

            }

            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Failed! Please try again!');
        }
        if($id){
            return redirect()->route('vc.vaccination')->with('success', 'Vaccination Updated successfully');
        }else{
            return redirect()->route('vc.vaccination')->with('success', 'Vaccination Registration Sucessfully');
        }
    }

    // vendor
    public function add_vendor()
    {
        return view('vaccination.add-vendor');
    }
    public function edit_vendor($id)
    {
        $id = ed($id, false);
        $response = VcVendor::where('id',$id)->orderBy('id', 'desc')->first();
        $data = compact('response');
        return view('vaccination.add-vendor')->with($data);
    }
    public function listing_vendor()
    {
        $response = VcVendor::orderBy('id', 'desc')->get();
       return view('vaccination.vendor-list',compact('response'));
    }
    public function update_vendor(Request $request, $id = 0)
    {
        $request->validate([
            'vendor_name'   => 'required|max:100',
            'phone'         => 'nullable|digits:10',
            'email'         => 'nullable|email',
        ]);

        $id ? $data = VcVendor::find($id) : $data = new VcVendor();

        $data->vendor_name              = $request->vendor_name;
        $data->email                    = $request->email;
        $data->phone                    = $request->phone;
        $data->pin_code                 = $request->pin_code;
        $data->gstin                    = $request->gstin;
        $data->contact_person_name      = $request->contact_person_name;
        $data->address                  = $request->address;

        if($data->save()){
            return redirect()->route('vc.listing-vendor')->with('success', 'Successfully Updated!');
        }else{
            return redirect()->route('vc.listing-vendor')->back()->with('error', 'Something wrong try again!');
        }
    }
    public function getUnitDetails(Request $request)
    {
        $vaccine = VcVaccine::where('vc_vaccines.id', $request->vaccineId)->first();

        if ($vaccine) {
            return response()->json([
                'unit' => $vaccine->unit,
                'sub_unit' => $vaccine->sub_unit,
                'unit_subunit_relation' => $vaccine->unit_subunit_relation
            ]);
        }

        return response()->json([
            'unit' => '',
            'sub_unit' => '',
            'unit_subunit_relation' => ''
        ]);
    }
    public function update_aefi_reports(Request $request, $id = 0)
    {

        $id ? $data = VcAefiReport::find($id) : $data = new VcAefiReport();

        $data->patient_vaccination_id   = $request->patient_vaccination_id;
        $data->symptoms                 = $request->symptoms;
        $data->classification           = $request->classification;
        $data->onset_interval           = $request->onset_interval;
        $data->outcome                  = $request->outcome;
        $data->action_taken             = $request->action_taken;
        $data->investigation_notes      = $request->investigation_notes;
        $data->reported_at              = Carbon::today();

        if($data->save()){
            return redirect()->route('vc.listing-aefi-reports')->with('success', 'Successfully Updated!');
        }else{
            return redirect()->route('vc.listing-aefi-reports')->back()->with('error', 'Something wrong try again!');
        }
    }
    public function listing_aefi_reports(Request $request)
    {
        if ($request->ajax()) {

            $data = VcAefiReport::select(
                'vc_aefi_reports.*',
                'v.scheduled_date as date',
                'v.id as vaccination_id',
                'p.name as patient_name',
                'p.uhid as patient_uhid',
                'p.id as patient_id',
                'vac.vaccine_name'
            )
            ->join('vc_patient_vaccinations as v', 'v.id', '=', 'vc_aefi_reports.patient_vaccination_id')
            ->join('vc_vaccines as vac', 'vac.id', '=', 'v.vaccine_id')
            ->join('patients as p', 'p.id', '=', 'v.patient_id')
            ->orderBy('vc_aefi_reports.id', 'DESC');

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row) {
                    $actionBtn = '<button
                        class="btn btn-sm btn-primary me-2 openEditAefiModal"
                        data-id="'.$row->id.'"
                        data-vaccination_id="'.$row->vaccination_id.'"
                        data-patient_name="'.$row->patient_name.'"
                        data-vaccine_name="'.htmlspecialchars($row->vaccine_name).'"
                        data-symptoms="'.$row->symptoms.'"
                        data-classification="'.$row->classification.'"
                        data-onset_interval="'.$row->onset_interval.'"
                        data-outcome="'.$row->outcome.'"
                        data-action_taken="'.$row->action_taken.'"
                        data-investigation_notes="'.$row->investigation_notes.'"
                    >
                        <i class="fa fa-edit"></i> Edit
                    </button>';

                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('vaccination.aefi-reports-list');
    }
}
