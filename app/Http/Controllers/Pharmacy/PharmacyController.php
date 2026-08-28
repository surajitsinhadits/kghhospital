<?php

namespace App\Http\Controllers\Pharmacy;

use App\Http\Controllers\Controller;
use App\Models\MedCatagory;
use Illuminate\Http\Request;
use App\Models\MedVendor;
use App\Models\MedMedicine;
use App\Models\MedUnit;
use Yajra\Datatables\DataTables;
use App\Models\User;
use App\Models\State;
use App\Models\Patient;
use App\Models\MedPatient;
use App\Models\MedBilling;
use App\Models\MedBillingDetail;
use App\Models\MedStock;
use App\Models\MedPayment;
use App\Models\Header;
use App\Models\MedIssue;
use App\Models\MedPurchase;
use App\Models\MedRequisition;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Validation\Rule;




class PharmacyController extends Controller
{
    public function index()
    {
        // TAB DATA SECTION
        $today = Carbon::today();
        $total_requisitions = MedRequisition::where('is_given', 0)->count();
        $total_issued = MedIssue::count();
        $total_medicines = MedMedicine::where('status', 0)->count();
        $total_purchase = MedPurchase::where('is_updated_in_stock', 0)->count();
        $total_purchase_upadte = MedPurchase::where('is_updated_in_stock', 1)->count();
        $medicines = MedMedicine::where('status', 0)->get();
        $stocks = MedStock::select('medicine', 'present_qty')
            ->get()
            ->groupBy('medicine')
            ->map(function ($items) {
                return $items->sum('present_qty');
            });

        $low_stock_count = $medicines->filter(function ($medicine) use ($stocks) {
            $stock_qty = $stocks[$medicine->id] ?? 0;
            $low_level_qty = $medicine->min_level * $medicine->unit_details;
            return $stock_qty <= $low_level_qty;
        })->count();




        $total_bill = MedBilling::where('bill_status', 1)->count();
        $total_approved_bill = MedBilling::where('bill_status', 2)->count();
        $total_cancelled_bill = MedBilling::where('bill_status', 3)->count();
        $total_bill_amount_taken = MedBilling::where('bill_status', 2)->sum('total_payment');
        $today_payment_total = MedPayment::whereDate('payment_date', $today)
            ->sum('payment_amount');
        $total_due = MedBilling::where('bill_status', '!=', 2)->sum('due_amount');
        $total_refund_today = MedBilling::whereDate('refund_at', $today)->sum('refund_amount');

        // END TAB DATA SECTION

        // Latest Approved Bills
        $data = MedBilling::select(
            'med_billings.*',
            'patients.name as internal_patient_name',
            'patients.phone as internal_patient_phone',
            'patients.gender as internal_patient_gender',
            'patients.dob_year as internal_patient_dob_year',
            'patients.dob_month as internal_patient_dob_month',
            'patients.dob_day as internal_patient_dob_day',
            'med_patients.name as patient_name',
            'med_patients.phone as external_patient_phone',
            'med_patients.gender as external_patient_gender',
            'med_patients.dob_year as external_patient_dob_year',
            'med_patients.dob_month as external_patient_dob_month',
            'med_patients.dob_day as external_patient_dob_day',
            'users.name as doctor_name'
        )
            ->leftJoin('patients', 'med_billings.internal_patient_id', '=', 'patients.id')
            ->leftJoin('med_patients', 'med_billings.external_patient_id', '=', 'med_patients.id')
            ->leftJoin('users', 'med_billings.doctor_id', '=', 'users.id')
            ->where('med_billings.bill_status', 2)
            ->orderBy('med_billings.id', 'DESC')
            ->paginate(5);

        // Latest Approved Bills

        //Monthly sales
        $monthlyIncome = MedBilling::where('bill_status', 2)
            ->whereYear('bill_date', date('Y'))
            ->select(DB::raw('MONTH(bill_date) as month'), DB::raw('SUM(grand_total) as total'))
            ->groupBy(DB::raw('MONTH(bill_date)'))
            ->pluck('total', 'month');

        // Fill missing months with 0
        $monthlyIncomeArray = [];
        for ($i = 1; $i <= 12; $i++) {
            $monthlyIncomeArray[] = $monthlyIncome[$i] ?? 0;
        }

        //Monthly sales

        //BILLING COUNT

        $externalCount = MedBilling::whereNotNull('external_patient_id')->count();

        $internalCount = MedBilling::whereNotNull('internal_patient_id')->count();

        //BILLING COUNT

        $startOfThisWeek = $today->copy()->startOfWeek();
        $endOfThisWeek = $today->copy()->endOfWeek();
        $startOfLastWeek = $startOfThisWeek->copy()->subWeek();
        $endOfLastWeek = $startOfLastWeek->copy()->endOfWeek();

        // ✅ Fetch all records in one query using Eloquent
        $billingData = MedBilling::whereBetween('bill_date', [$startOfLastWeek, $endOfThisWeek])
            ->get(['bill_date', 'grand_total']);

        // Group manually: create daily totals for each week
        $lastWeekMap = [];
        $thisWeekMap = [];

        foreach ($billingData as $billing) {
            $date = Carbon::parse($billing->bill_date)->toDateString();

            if ($billing->bill_date >= $startOfLastWeek && $billing->bill_date <= $endOfLastWeek) {
                $lastWeekMap[$date] = ($lastWeekMap[$date] ?? 0) + $billing->grand_total;
            } elseif ($billing->bill_date >= $startOfThisWeek && $billing->bill_date <= $endOfThisWeek) {
                $thisWeekMap[$date] = ($thisWeekMap[$date] ?? 0) + $billing->grand_total;
            }
        }

        // Normalize both weeks (Mon–Sun)
        $daysLabel = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];
        $lastWeek = [];
        $thisWeek = [];

        foreach (range(0, 6) as $i) {
            $dateLast = $startOfLastWeek->copy()->addDays($i)->toDateString();
            $dateThis = $startOfThisWeek->copy()->addDays($i)->toDateString();

            $lastWeek[] = $lastWeekMap[$dateLast] ?? 0;
            $thisWeek[] = $thisWeekMap[$dateThis] ?? 0;
        }

        $lastWeekTotal = array_sum($lastWeek);
        $thisWeekTotal = array_sum($thisWeek);


        return view('pharmacy.index', compact(
            'total_requisitions',
            'total_issued',
            'total_medicines',
            'total_purchase',
            'total_purchase_upadte',
            'low_stock_count',
            'total_bill',
            'total_approved_bill',
            'total_cancelled_bill',
            'total_bill_amount_taken',
            'today_payment_total',
            'total_due',
            'total_refund_today',
            'data',
            'monthlyIncomeArray',
            'internalCount',
            'externalCount',
            'lastWeekTotal',
            'thisWeekTotal',
            'lastWeek',
            'thisWeek',
            'lastWeekTotal',
            'thisWeekTotal',
            'daysLabel'
        ));
    }

    public function medicine_vendor($id = null)
    {
        $title = 'Medicine Vendor';
        $t = $id ? 'Edit Medicine Vendor' : 'Add Medicine Vendor';
        $vendor = $id ? MedVendor::find($id) : null;
        $vendors = MedVendor::orderBy('id', 'DESC')->get();
        $table = 'vendors';
        $data = compact('title', 'vendor', 'vendors', 't', 'table');
        return view('pharmacy.add-med-vendor')->with($data);
    }

    public function update_medicine_vendor(Request $request, $id = 0)
    {
        $request->validate([
            'vendor_name' => 'required|max:100',
            'email' => 'required|email',
            'vendor_ph_no' => 'required|digits:10',
            'vendor_address' => 'required|max:255',
        ]);

        $id ? $data = MedVendor::find($id) : $data = new MedVendor();
        $data->vendor_name = $request->vendor_name;
        $data->email = $request->email;
        $data->vendor_ph_no = $request->vendor_ph_no;
        $data->pin = $request->pin;
        $data->vendor_gst = $request->vendor_gst;
        $data->contact_name = $request->contact_name;
        $data->vendor_address = $request->vendor_address;
        if (!$id) {
            $data->status = '0';
        }
        if ($data->save()) {
            return redirect()->route('pharmacy.medicine-vendor')->with('success', 'Successfully Updated!');
        } else {
            return redirect()->route('pharmacy.medicine-vendor')->with('error', 'Something wrong try again!');
        }
    }

    public function add_medicine($id = null)
    {
        $title = 'Medicine';
        $id = ed($id, false);
        $t = $id ? 'Edit Medicine' : 'Add Medicine';
        $medicine_category = MedCatagory::orderBy('id', 'DESC')->get();
        $med_unit = MedUnit::orderBy('id', 'DESC')->get();
        $medicine = $id ? MedMedicine::find($id) : null;
        $medicines = MedMedicine::orderBy('id', 'DESC')->get();
        $table = 'med_medicines';
        $data = compact('title', 'medicine', 'medicines', 't', 'table', 'medicine_category', 'med_unit');
        return view('pharmacy.add-medicine')->with($data);
    }



    // public function medicine_lists(Request $request)
    // {
    //     $title = 'Medicine';

    //     if ($request->ajax()) {
    //         $data = MedMedicine::select(
    //             'med_medicines.*',
    //             'med_units.medicine_unit_name as unit_name',
    //             'med_catagories.medicine_catagory_name as catagory_name'
    //         )
    //             ->leftJoin('med_units', 'med_medicines.unit', '=', 'med_units.id')
    //             ->leftJoin('med_catagories', 'med_medicines.medicine_catagory', '=', 'med_catagories.id')
    //             ->orderBy('med_medicines.id', 'DESC')
    //             ->get();

    //         return Datatables::of($data)
    //             ->addIndexColumn()
    //             ->addColumn('stock', function ($row) {
    //                 // Total quantity in sub-units (e.g., tablets)
    //                 $totalQty = \App\Models\MedStock::where('medicine', $row->id)->sum('present_qty');
    //                 return $totalQty;
    //             })

    //             ->addColumn('stock_status', function ($row) {
    //                 $totalQty = \App\Models\MedStock::where('medicine', $row->id)->sum('present_qty');
    //                 $unitDetails = $row->unit_details ?? 1; // e.g., 1 strip = 10 tablets
    //                 $minLevel = $row->min_level ?? 0;

    //                 // Convert min_level (in units) to sub-units
    //                 $minQtyInSubUnits = $minLevel * $unitDetails;

    //                 if ($totalQty < $minQtyInSubUnits) {
    //                     return '<span class="badge bg-danger">Out of Stock</span>';
    //                 } else {
    //                     return '<span class="badge bg-success">In Stock</span>';
    //                 }
    //             })

    //             ->addColumn('action', function ($row) {
    //                 $actionBtn = '';
    //                 $actionBtn .= '<a href="' . route('pharmacy.add-medicine', ed($row->id, true)) . '" class="btn btn-sm btn-outline-warning mx-1" title="Edit"><i class="bx bxs-edit"></i></a>';
    //                 return $actionBtn;
    //             })
    //             ->rawColumns(['action'])
    //             ->make(true);
    //     }

    //     return view('pharmacy.medicine-lists', compact('title'));
    // }

    public function medicine_lists(Request $request)
    {
        $title = 'Medicine';

        if ($request->ajax()) {
            $query = MedMedicine::select([
                'med_medicines.id',
                'med_medicines.medicine_name',
                'med_medicines.min_level',
                'med_medicines.unit_details',
                'med_medicines.medicine_composition as medicine_composition',

                // NEW – pull the plain‑text columns
                'med_medicines.unit      as unit_name',
                'med_medicines.sub_unit  as sub_unit_name',

                'c.medicine_catagory_name as catagory_name',
                DB::raw('COALESCE(SUM(s.present_qty),0) as total_qty')
            ])
                ->leftJoin('med_catagories as c', 'med_medicines.medicine_catagory', '=', 'c.id')
                ->leftJoin('med_stocks as s', 'med_medicines.id', '=', 's.medicine')
                ->groupBy([
                    'med_medicines.id',
                    'med_medicines.medicine_name',
                    'med_medicines.min_level',
                    'med_medicines.unit_details',
                    'med_medicines.medicine_composition',

                    // add to GROUP BY for ONLY_FULL_GROUP_BY safety
                    'med_medicines.unit',
                    'med_medicines.sub_unit',

                    'c.medicine_catagory_name',
                ])
                ->orderByDesc('med_medicines.id');

            return datatables()->of($query)
                ->addIndexColumn()

                ->addColumn('stock', function ($row) {
                    $unitSize  = max((int) $row->unit_details, 1);
                    $units     = intdiv($row->total_qty, $unitSize);
                    $subUnits  = $row->total_qty % $unitSize;

                    $unitLbl   = $row->unit_name     ?? 'unit';
                    $subLbl    = $row->sub_unit_name ?? 'sub unit';

                    $parts = [];
                    if ($units)    $parts[] = "$units $unitLbl";
                    if ($subUnits) $parts[] = "$subUnits $subLbl";

                    return $parts ? implode(' ', $parts) : "0 $subLbl";
                })

                ->addColumn('stock_status', function ($row) {
                    $unitSize = max((int) $row->unit_details, 1);
                    $minQty   = ((int) $row->min_level) * $unitSize;

                    $inStock  = $row->total_qty >= $minQty;
                    $cls      = $inStock ? 'bg-success' : 'bg-danger';
                    $txt      = $inStock ? 'In Stock'   : 'Out of Stock';

                    $units    = intdiv($row->total_qty, $unitSize);
                    $subs     = $row->total_qty %  $unitSize;

                    $unitLbl  = $row->unit_name     ?? '';
                    $subLbl   = $row->sub_unit_name ?? '';

                    $parts = [];
                    if ($units) $parts[] = "$units $unitLbl";
                    if ($subs)  $parts[] = "$subs $subLbl";
                    $qtyTxt = $parts ? implode(' ', $parts) : "0 $subLbl";

                    return "<span class=\"badge $cls\">$txt — $qtyTxt</span>";
                })


                ->addColumn('action', function ($row) {
                    $url = route('pharmacy.add-medicine', ed($row->id, true));
                    return "<a href=\"$url\" class=\"btn btn-sm btn-outline-warning mx-1\" title=\"Edit\">
                                <i class=\"bx bxs-edit\"></i>
                            </a>";
                })

                ->rawColumns(['stock_status', 'action', 'stock'])
                ->make(true);
        }

        return view('pharmacy.medicine-lists', compact('title'));
    }




    public function update_medicine(Request $request, $id = 0)
    {
        $request->validate([
            'medicine_name' => [
                'required',
                'max:100',
                Rule::unique('med_medicines', 'medicine_name')->ignore($id),
            ],
            'medicine_catagory' => 'required',
            'unit' => 'required',
            'sub_unit' => 'required',
            'unit_details' => 'required',



        ]);
        // dd($request->all());
        // $id = ed($id, false);
        // dd($id);

        $id ? $data = MedMedicine::find($id) : $data = new MedMedicine();
        $data->medicine_name = $request->medicine_name;
        $data->medicine_catagory = $request->medicine_catagory;
        $data->medicine_company = $request->medicine_company;
        $data->medicine_composition = $request->medicine_composition;
        $data->medicine_group = $request->medicine_group;
        $data->unit = $request->unit;
        $data->sub_unit = $request->sub_unit;
        $data->unit_details = $request->unit_details;
        $data->min_level = $request->min_level;
        $data->tax = $request->tax;
        if (!$id) {
            $data->status = '0';
        }
        if ($data->save()) {
            return redirect()->route('pharmacy.medicine-lists')->with('success', 'Successfully Updated!');
        } else {
            return redirect()->route('pharmacy.add-medicine')->with('error', 'Something wrong try again!');
        }
    }

    public function medicine_billing()
    {
        $medicine_category = MedCatagory::orderBy('id', 'DESC')->get();
        $medicine_name = MedMedicine::select('med_catagories.medicine_catagory_name', 'med_medicines.medicine_name', 'med_catagories.id as medicine_cat_id', 'med_medicines.id as medicine_id')
            ->join('med_catagories', 'med_catagories.id', '=', 'med_medicines.medicine_catagory')->orderBy('med_medicines.medicine_name', 'asc')->get();
        $doctor = User::where('user_type', 'doctor')->where('is_active', 1)->where('is_delete', 0)->get();
        $states = State::where('country_id', '1')->get();
        $data = compact('doctor', 'states', 'medicine_name', 'medicine_category');
        return view('pharmacy.add-medicine-billing')->with($data);
    }


    public function edit_medicine_billing($id)
    {

        $id = ed($id, false);
        //  dd($id);
        $bill = MedBilling::find($id);
        $bill_details = MedBillingDetail::where('med_billing_id', $id)->get();
        // if ($bill) {
        $payments = MedPayment::select('med_payments.*', 'u.name as created_name')
            ->join('users as u', 'u.id', '=', 'med_payments.payment_recived_by')
            ->where('billing_id', $id)
            ->get();
        // }
        // Determine patient source and fetch patient details
        $patient = null;
        if ($bill->external_patient_id) {
            $patient = MedPatient::where('id', $bill->external_patient_id)->first(); // internal patient
        } elseif ($bill->internal_patient_id) {
            $patient = Patient::where('id', $bill->internal_patient_id)->first(); // external patient
        }

        $medicine_category = MedCatagory::orderBy('id', 'DESC')->get();

        $medicine_name = MedMedicine::select(
            'med_catagories.medicine_catagory_name',
            'med_medicines.medicine_name',
            'med_catagories.id as medicine_cat_id',
            'med_medicines.id as medicine_id'
        )
            ->join('med_catagories', 'med_catagories.id', '=', 'med_medicines.medicine_catagory')
            ->orderBy('med_medicines.medicine_name', 'asc')
            ->get();

        $doctor = User::where('user_type', 'doctor')->where('is_active', 1)->where('is_delete', 0)->get();
        $states = State::where('country_id', '1')->get();

        $data = compact('bill', 'bill_details', 'doctor', 'states', 'medicine_name', 'medicine_category', 'patient', 'payments');
        return view('pharmacy.edit-medicine-billing')->with($data);
    }




    public function getMedicinesByCategory(Request $request)
    {
        $medicines = MedMedicine::where('medicine_catagory', $request->category_id)->get();

        return response()->json($medicines);
    }


    public function save_pharmacy_billing(Request $request)
    {
        $request->validate([
            'date' => 'required',
            'cons_doctor' => 'required',
            'name' => 'required',
            'gender' => 'required',
            'phone' => 'required',
            'address' => 'required',
            'state' => 'required',
        ]);

        // dd($request->all());
        $request->uhid ? $patient = Patient::find($request->uhid) : $patient = new MedPatient();
        $patient->name = ucwords($request->name);
        $patient->phone = $request->phone;
        $patient->gender = $request->gender;
        $patient->dob_year = $request->date_of_birth_year ?? 0;
        $patient->dob_month = $request->date_of_birth_month ?? 0;
        $patient->dob_day = $request->date_of_birth_day ?? 0;
        $patient->address = $request->address;
        $patient->state = $request->state;
        $patient->district = is_numeric($request->district) ? $request->district : null;
        $patient->pin_code = $request->pin_no;
        $patient->save();
        $patient_id = $patient->id;

        $bill = new MedBilling;
        $bill->bill_date = $request->date;
        $request->uhid ? $bill->internal_patient_id = $patient_id : $bill->external_patient_id = $patient_id;
        $bill->doctor_id = $request->cons_doctor;
        $bill->sub_total = $request->sub_total;
        $bill->grand_total = $request->grand_total;
        // $bill->discount_amount = $request->sub_total - $request->grand_total;
        $bill->discount = $request->total_discount;
        $bill->discount_type = $request->discount_type;
        $bill->total_payment = $request->total_payment;
        $bill->due_amount = $request->total_due;
        $bill->credit_amount = $request->total_payment > $request->grand_total ? $request->total_payment - $request->grand_total : 0;
        $bill->created_by = Auth::user()->id;
        // $bill->bill_status = 'done';
        $bill->save();

        foreach ($request->medicine_category as $key => $value) {

            $medicine_name = MedMedicine::select('med_catagories.medicine_catagory_name', 'med_medicines.medicine_name', 'med_catagories.id as medicine_cat_id', 'med_medicines.id as medicine_id', 'med_medicines.unit_details')
                ->join('med_catagories', 'med_catagories.id', '=', 'med_medicines.medicine_catagory')->where('med_medicines.id', $request->medicine_name[$key])->first();

            // $unit_details = @$medicine_name->unit_details ?? 1;
            $unit_details = $request->unit_details[$key] ?? 1; // Default to 1 if not set
            $unit_qty = $request->unit_qty[$key] ?? 0;
            $sub_unit_qty = $request->sub_unit_qty[$key] ?? 0;
            $qty = ($unit_qty * $unit_details) + $sub_unit_qty;

            $medicine_details = new MedBillingDetail();
            $medicine_details->med_billing_id = $bill->id;
            $medicine_details->med_category_id = $request->medicine_category[$key];
            $medicine_details->med_name_id = $request->medicine_name[$key];
            $medicine_details->med_name = $medicine_name->medicine_name;
            $medicine_details->batch_no = $request->medicine_batch[$key];
            $medicine_details->expairy_date = $request->expiry_date[$key];
            $medicine_details->unit_details = $request->unit_details[$key];
            $medicine_details->unit_qty = $request->unit_qty[$key];
            $medicine_details->sub_unit_qty = $request->sub_unit_qty[$key];
            $medicine_details->sub_unit = $request->sub_unit[$key];
            $medicine_details->unit = $request->unit[$key];
            $medicine_details->mrp = $request->mrp[$key];
            $medicine_details->discount_percentage = $request->discount[$key];
            $medicine_details->amount = $request->amount[$key];
            $medicine_details->total_qty = $qty;
            // $medicine_details->status = 'done';
            $medicine_details->save();

            MedStock::where('medicine', $request->medicine_name[$key])
                ->where('batch_no', $request->medicine_batch[$key])
                ->decrement('present_qty', $qty);
        }
        // dd($request->payment_amount);

        if (count($request->payment_amount) > 0) {
            foreach ($request->payment_amount as $key => $value) {
                if ($request->payment_amount[$key] > 0) {
                    $payment = new MedPayment();
                    $payment->billing_id = $bill->id;
                    $payment->patient_id =  $patient_id;
                    $payment->payment_amount = $request->payment_amount[$key];
                    $payment->payment_mode = $request->payment_mode[$key];
                    $payment->payment_bank = $request->payment_mode[$key] == 'Cash' ? null : $request->bank_name[$key];
                    $payment->payment_recived_by = Auth::user()->id;
                    $payment->payment_date = date('Y-m-d H:i:s', strtotime($request->payment_date[$key]));
                    $payment->save();
                }
            }
        }
        return redirect()->route('pharmacy.medicine-billing-lists')->with('success', 'Successfully Updated!');
    }

    public function update_pharmacy_billing(Request $request)
    {
        $request->validate([
            'date' => 'required',
            'cons_doctor' => 'required',
            'name' => 'required',
            'gender' => 'required',
            'phone' => 'required',
            'address' => 'required',
            'state' => 'required',
        ]);

        // Patient update (same as before)
        // $request->uhid ? $patient = Patient::find($request->uhid) : $patient = new MedPatient();
        // $request->uhid ? $patient = Patient::where('id', $request->uhid)->first() : $patient = new Patient();

        // if (!$patient) {
        //     $request->uhid ? $patient = MedPatient::where('id', $request->uhid)->first() : $patient = new MedPatient();
        // }
        $patient = Patient::find($request->uhid)
            ?? MedPatient::find($request->uhid)
            ?? new MedPatient(); // create new only in med_patients

        $patient->name = ucwords($request->name);
        $patient->phone = $request->phone;
        $patient->gender = $request->gender;
        $patient->dob_year = $request->date_of_birth_year ?? 0;
        $patient->dob_month = $request->date_of_birth_month ?? 0;
        $patient->dob_day = $request->date_of_birth_day ?? 0;
        $patient->address = $request->address;
        $patient->state = $request->state;
        $patient->district = is_numeric($request->district) ? $request->district : null;
        $patient->pin_code = $request->pin_no;
        $patient->save();
        $patient_id = $patient->id;

        // Bill update
        $bill = MedBilling::find($request->bill_id);
        // $bill->bill_date = $request->date;

        if ($request->submit == 'cancel') {
            $bill->bill_status = 3;
            $bill->due_amount = 0.00;
            $bill->grand_total = 0.00;
            $bill->credit_amount = $bill->credit_amount + $bill->total_payment;
            $bill->edit_at = date('Y-m-d H:i:s');
            $bill->edit_status = 1;
        } else {
            // $request->uhid ? $bill->internal_patient_id = $patient_id : $bill->external_patient_id = $patient_id;
            if (Patient::find($request->uhid)) {
                // It's an internal patient
                $bill->internal_patient_id = $patient_id;
                $bill->external_patient_id = null;
            } else {
                // It's an external patient
                $bill->external_patient_id = $patient_id;
                $bill->internal_patient_id = null;
            }
            $bill->doctor_id = $request->cons_doctor;
            $bill->sub_total = $request->sub_total;
            $bill->grand_total = $request->grand_total;
            $bill->discount = $request->total_discount;
            $bill->discount_type = $request->discount_type;
            $bill->total_payment = $request->total_payment;
            $bill->due_amount = $request->total_due;
            $bill->credit_amount = $request->total_payment > $request->grand_total
                ? $request->total_payment - $request->grand_total
                : 0;
            $bill->edit_by = Auth::id();
            $bill->edit_at = now();
            $bill->bill_status = $request->submit == 'approved' ? 2 : 1;
            $bill->edit_status = 1;
        }
        $bill->save();

        // Get all existing details for this bill
        $existingDetails = MedBillingDetail::where('med_billing_id', $bill->id)->get()->keyBy('id');

        // Process medicines
        foreach ($request->medicine_category as $key => $value) {
            $detailId = $request->med_billing_detail_id[$key] ?? null; // hidden field in form for edit
            $isCancelled = isset($request->cancel_this_service[$detailId]);
            $unit_details = $request->unit_details[$key] ?? 1;
            $unit_qty = $request->unit_qty[$key] ?? 0;
            $sub_unit_qty = $request->sub_unit_qty[$key] ?? 0;
            $qty = ($unit_qty * $unit_details) + $sub_unit_qty;

            if ($detailId && isset($existingDetails[$detailId])) {
                if ($isCancelled) {
                    // Update amount and discount to 0 for cancelled medicine
                    $cancelledDetail = $existingDetails[$detailId];
                    $cancelledDetail->amount = 0;
                    $cancelledDetail->discount_percentage = 0;
                    $cancelledDetail->save();
                    continue;
                }

                if ($request->submit == 'cancel') {
                    // Restore stock if not cancelled via checkbox
                    MedStock::where('medicine', $request->medicine_name[$key])
                        ->where('batch_no', $request->medicine_batch[$key])
                        ->increment('present_qty', $qty);
                }
                // Skip further processing for existing details
                continue;
            }

            // New detail: add and decrement stock
            $medicine_name = MedMedicine::select('med_catagories.medicine_catagory_name', 'med_medicines.medicine_name', 'med_catagories.id as medicine_cat_id', 'med_medicines.id as medicine_id', 'med_medicines.unit_details')
                ->join('med_catagories', 'med_catagories.id', '=', 'med_medicines.medicine_catagory')
                ->where('med_medicines.id', $request->medicine_name[$key])->first();

            $medicine_details = new MedBillingDetail();
            $medicine_details->med_billing_id = $bill->id;
            $medicine_details->med_category_id = $request->medicine_category[$key];
            $medicine_details->med_name_id = $request->medicine_name[$key];
            $medicine_details->med_name = $medicine_name->medicine_name;
            $medicine_details->batch_no = $request->medicine_batch[$key];
            $medicine_details->expairy_date = $request->expiry_date[$key];
            $medicine_details->unit_details = $unit_details;
            $medicine_details->unit_qty = $unit_qty;
            $medicine_details->sub_unit_qty = $sub_unit_qty;
            $medicine_details->sub_unit = $request->sub_unit[$key];
            $medicine_details->unit = $request->unit[$key];
            $medicine_details->mrp = $request->mrp[$key];
            $medicine_details->discount_percentage = $request->discount[$key];
            $medicine_details->amount = $request->amount[$key];
            $medicine_details->total_qty = $qty;
            // $medicine_details->is_delete = 0;
            $medicine_details->save();

            // Decrement stock
            MedStock::where('medicine', $request->medicine_name[$key])
                ->where('batch_no', $request->medicine_batch[$key])
                ->decrement('present_qty', $qty);
        }


        if (count($request->payment_amount) > 0) {
            foreach ($request->payment_amount as $key => $value) {
                if ($request->payment_amount[$key] > 0) {
                    $payment = new MedPayment();
                    $payment->billing_id = $bill->id;
                    $payment->patient_id =  $patient_id;
                    $payment->payment_amount = $request->payment_amount[$key];
                    $payment->payment_mode = $request->payment_mode[$key];
                    $payment->payment_bank = $request->payment_mode[$key] == 'Cash' ? null : $request->bank_name[$key];
                    $payment->payment_recived_by = Auth::user()->id;
                    $payment->payment_date = date('Y-m-d H:i:s', strtotime($request->payment_date[$key]));
                    $payment->save();
                }
            }
        }

        return redirect()->route('pharmacy.medicine-billing-lists')->with('success', 'Successfully Updated!');
    }

    public function medicine_billing_list(Request $request)
    {
        $title = 'Medicine Billing List';
        if ($request->ajax()) {
            $data = MedBilling::select(
                'med_billings.*',
                'patients.name as internal_patient_name',
                'patients.phone as internal_patient_phone',
                'patients.gender as internal_patient_gender',
                'patients.dob_year as internal_patient_dob_year',
                'patients.dob_month as internal_patient_dob_month',
                'patients.dob_day as internal_patient_dob_day',
                'med_patients.name as patient_name',
                'med_patients.phone as external_patient_phone',
                'med_patients.gender as external_patient_gender',
                'med_patients.dob_year as external_patient_dob_year',
                'med_patients.dob_month as external_patient_dob_month',
                'med_patients.dob_day as external_patient_dob_day',
                'users.name as doctor_name'
            )
                ->leftJoin('patients', 'med_billings.internal_patient_id', '=', 'patients.id')
                ->leftJoin('med_patients', 'med_billings.external_patient_id', '=', 'med_patients.id')
                ->leftJoin('users', 'med_billings.doctor_id', '=', 'users.id')
                ->orderBy('med_billings.id', 'DESC')
                ->get();

            return Datatables::of($data)
                ->addColumn('med_id', function ($row) {
                    $html = $row->id . '<br>';

                    if ($row->bill_status == 1) {
                        $html .= '<span class="badge badge-gradient-primary mt-2 ml-1">Draft</span>';
                    } elseif ($row->bill_status == 2) {
                        $html .= '<span class="badge badge-gradient-success mt-2 ml-1">Approved</span>';
                    } else {
                        $html .= '<span class="badge badge-gradient-danger mt-2 ml-1">Cancelled</span>';
                    }

                    return $html;
                })
                ->addColumn('patient_display_name', function ($row) {
                    if (!is_null($row->internal_patient_name)) {
                        return
                            $row->internal_patient_name . ' ( ' . $row->internal_patient_id . ')<br>' .
                            '<i class="fa fa-venus-mars text-blue"></i> ' . $row->internal_patient_gender . ' ' .
                            '<i class="fa fa-calendar-plus-o text-blue ml-1"></i> ' . $row->internal_patient_dob_year . 'Y ' . $row->internal_patient_dob_month . 'M ' . $row->internal_patient_dob_day . 'D<br>' .
                            '<i class="fa fa-phone text-primary"></i> ' . $row->internal_patient_phone .
                            ' <span class="badge badge-gradient-primary mt-2 ml-1">Internal</span>';
                    } elseif (!is_null($row->patient_name)) {
                        return
                            $row->patient_name . ' ( ' . $row->external_patient_id . ')<br>' .
                            '<i class="fa fa-venus-mars text-blue"></i> ' . $row->external_patient_gender . ' ' .
                            '<i class="fa fa-calendar-plus-o text-blue ml-1"></i> ' . $row->external_patient_dob_year . 'Y ' . $row->external_patient_dob_month . 'M ' . $row->external_patient_dob_day . 'D<br>' .
                            '<i class="fa fa-phone text-primary"></i> ' . $row->external_patient_phone .
                            ' <span class="badge badge-gradient-primary mt-2 ml-1">External</span>';
                    } else {
                        return 'N/A';
                    }
                })
                ->addColumn('paymnent_status', function ($row) {
                    if ($row->due_amount > 0) {
                        return '<span class="badge bg-danger fs-15 px-20 py-2 fw-bold">Due: ' . $row->due_amount . ' </span>';
                    } elseif ($row->credit_amount == 0 && $row->refund_amount != 0 && $row->due_amount == 0) {
                        return '<span class="badge bg-success fs-15 px-20 py-2 fw-bold">Refund Done</span>';
                    } elseif ($row->credit_amount > 0) {
                        return '<span class="badge bg-success fs-15 px-20 py-2 fw-bold">Credit: ' . $row->credit_amount . '</span>';
                    } elseif ($row->bill_status == 3) {
                        return '<span class="badge bg-warning fs-15 px-20 py-2 fw-bold">Cancel</span>';
                    } elseif ($row->credit_amount == 0 && $row->due_amount == 0) {
                        return '<span class="badge bg-success fs-15 px-20 py-2 fw-bold">Full Paid</span>';
                    }
                })

                ->addColumn('action', function ($row) {
                    $actionBtn = '';
                    if ($row->bill_status == 1) {
                        $actionBtn .= '<a href="' . route('pharmacy.edit-medicine-billing', ed($row->id, true)) . '" class="btn btn-sm btn-warning mx-1" title="Edit"><i class="bx bxs-edit"></i></a>';
                    }

                    $actionBtn .= '<a href="' . route('pharmacy.med-print-bill', ed($row->id, true)) . '" target="_blank" class="btn btn-sm btn-warning mx-1" title="Print Bill"><i class="bx bxs-printer"></i></a>';

                    if ($row->credit_amount > 0) {
                        //$actionBtn .= '<a href="' . route('pharmacy.edit-medicine-billing', ed($row->id, true)) . '" class="btn btn-sm btn-warning mx-1" title="Refund"><i class="bx bxs-wallet-alt"></i></a>';
                        $actionBtn .= '<button class="btn btn-sm btn-danger mx-1 refund-btn" data-id="' . $row->id . '" title="Refund"><i class="bx bxs-wallet-alt"></i></button>';
                    }
                    return $actionBtn;
                })
                ->addIndexColumn()
                ->rawColumns(['patient_display_name', 'action', 'paymnent_status', 'med_id'])
                ->make(true);
        }
        return view('pharmacy.medicine-billing-list', compact('title'));
    }

    public function med_print_bill($bill_id)
    {
        $billId = ed($bill_id, false);
        $header_image = Header::where('header_name', 'bill')->first();
        $bill = MedBilling::select('med_billings.*', 'u2.name as created_name', 'u1.name as refund_name')
            ->leftjoin('users as u2', 'u2.id', '=', 'med_billings.created_by')
            ->leftjoin('users as u1', 'u1.id', '=', 'med_billings.refund_by')
            ->where('med_billings.id', $billId)
            ->first();
        $bill_info = MedBillingDetail::select(
            'med_billing_details.*',
            'mc.medicine_catagory_name as med_category_name',
            'mm.medicine_name as medicine_name'
        )
            ->leftJoin('med_catagories as mc', 'mc.id', '=', 'med_billing_details.med_category_id')
            ->leftJoin('med_medicines as mm', 'mm.id', '=', 'med_billing_details.med_name_id')
            ->where('med_billing_details.med_billing_id', $billId)
            ->where('med_billing_details.is_delete', 0)
            ->get();


        $doctor_info = User::select('users.*', 'd.department_name')
            ->leftjoin('departments as d', 'd.id', '=', 'users.department_id')
            ->where('users.id', $bill->doctor_id)
            ->first();
        if ($bill->internal_patient_id) {
            // Internal ⇒ patients table
            $patient_details = Patient::query()
                ->select('patients.*', 's.name as state_name', 'd.name as district_name')
                ->leftJoin('states    as s', 's.id', '=', 'patients.state')
                ->leftJoin('districts as d', 'd.id', '=', 'patients.district')
                ->where('patients.id', $bill->internal_patient_id)
                ->first();
        } else {
            // External ⇒ med_patients table
            $patient_details = MedPatient::query()
                ->select('med_patients.*', 's.name as state_name', 'd.name as district_name')
                ->leftJoin('states    as s', 's.id', '=', 'med_patients.state')
                ->leftJoin('districts as d', 'd.id', '=', 'med_patients.district')
                ->where('med_patients.id', $bill->external_patient_id)
                ->first();
        }
        $payment_details = MedPayment::select('med_payments.*', 'u.name as created_name')
            ->join('users as u', 'u.id', '=', 'med_payments.payment_recived_by')
            ->where('med_payments.billing_id', $billId)
            ->get();


        $data = compact('bill', 'bill_info', 'header_image', 'patient_details', 'payment_details', 'doctor_info');
        // dd($data);
        return view('pharmacy.med-print-bill')->with($data);
    }

    public function refundMedicineBilling(Request $request)
    {


        $billing = MedBilling::find($request->id);

        if (!$billing) {
            return response()->json(['status' => 'error', 'message' => 'Billing record not found'], 404);
        }

        // Store original credit as refund and set credit to 0
        $billing->refund_amount = $billing->credit_amount;
        $billing->credit_amount = 0;
        $billing->refund_by = Auth::user()->id;
        $billing->refund_at = now();

        $billing->save();

        return response()->json(['status' => 'success', 'message' => 'Refund processed successfully']);
    }

    public function updateStock(Request $request)
    {


        $stock = MedStock::where('medicine', $request->medicine_id)
            ->where('batch_no', $request->batch_no)
            ->first();
        $bill_details = MedBillingDetail::where('id', $request->id)->first();


        if (!$stock) {
            return response()->json(['message' => 'Stock record not found'], 404);
        }

        if ($request->type === 'restore') {
            $bill_details->is_delete = 1;
            $stock->present_qty += $request->quantity;
        } elseif ($request->type === 'issue') {
            $bill_details->is_delete = 0;
            $stock->present_qty -= $request->quantity;
            if ($stock->present_qty < 0) {
                $stock->present_qty = 0;
            }
        }
        $bill_details->save();
        $stock->save();

        return response()->json(['message' => 'Stock updated successfully']);
    }

    public function getMedicinesByComposition(Request $request)
    {


        $medicines = MedMedicine::where('medicine_composition', $request->composition)
            ->select(
                'med_medicines.id',
                'med_medicines.medicine_name',
                'med_catagories.medicine_catagory_name'
            )
            ->join('med_catagories', 'med_catagories.id', '=', 'med_medicines.medicine_catagory')

            ->get();

        return response()->json($medicines);
    }
}
