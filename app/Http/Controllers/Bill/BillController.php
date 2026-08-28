<?php

namespace App\Http\Controllers\Bill;

use App\Http\Controllers\Controller;
use App\Models\Billing;
use App\Models\BillingDetail;
use App\Models\CaseReference;
use App\Models\Charge;
use App\Models\ChargesHasNormal;
use App\Models\Header;
use App\Models\Investigation;
use App\Models\InvestigationDetail;
use App\Models\IpdRegister;
use App\Models\OpBillingDetail;
use App\Models\OpItem;
use App\Models\OpRegister;
use App\Models\OtRegistration;
use App\Models\Package;
use App\Models\Patient;
use App\Models\PatientCraditAmount;
use App\Models\PatientDoctorStatus;
use App\Models\Payment;
use App\Models\Referral;
use App\Models\User;
use App\Models\Setting;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class BillController extends Controller
{
    public function billing_details($section, $bill_id)
    {
        $bill_id = ed($bill_id, false);
        $section == 'ot' ? $db = 'ot_registrations' : $db = strtolower($section) . '_registers';
        /*$fetch_data = '';
        if( !empty($section) && (strtolower($section) == 'opd' || strtolower($section) == 'investigation' ) ){
            $fetch_data = ', or.referred_by as add_referred_by, or.provider as add_provider, or.market_by as add_market_by';
        }

        $bill = Billing::select('billings.*', 'u1.name as doctor_name', 'u2.name as created_name',
            'u3.name as edited_name', 'u4.name as approved_user_name'.$fetch_data)
            ->leftJoin('users as u1', 'u1.id', '=', 'billings.doctor_id')
            ->leftJoin('users as u2', 'u2.id', '=', 'billings.created_by')
            ->leftJoin('users as u3','u3.id','=','billings.edit_by')
            ->leftJoin('users as u4','u4.id','=','billings.approved_by')
            ->leftJoin($db . ' as or', 'or.id', '=', 'billings.section_id')
            ->where('billings.id', $bill_id)
            ->first();
        dd($db, $bill);*/

        // base select columns
        $select = [
            'billings.*',
            'u1.name as doctor_name',
            'u2.name as created_name',
            'u3.name as edited_name',
            'u4.name as approved_user_name',
        ];

        $query = Billing::select($select)
            ->leftJoin('users as u1', 'u1.id', '=', 'billings.doctor_id')
            ->leftJoin('users as u2', 'u2.id', '=', 'billings.created_by')
            ->leftJoin('users as u3', 'u3.id', '=', 'billings.edit_by')
            ->leftJoin('users as u4', 'u4.id', '=', 'billings.approved_by')
            ->where('billings.id', $bill_id);

        // only join opd / investigation register when needed
        if (in_array($section, ['opd', 'investigation'])) {

            // choose the table name based on section
            $db = $section === 'opd'
                ? 'opd_registers'
                : 'investigation_registers';

            $query->leftJoin($db . ' as reg', 'reg.id', '=', 'billings.section_id')
                ->addSelect([
                    'reg.referred_by as add_referred_by',
                    'reg.provider as add_provider',
                    'reg.market_by as add_market_by',
                ]);
        }

        $bill = $query->first();
        // dd($bill);
        if ($bill) {
            $bill_info = BillingDetail::select('billing_details.*', 'u1.name as doctor_name', 'charges.charge_name as actual_charge_name')
                ->where('billing_id', $bill->id)
                ->whereIn('billing_details.is_delete', [0, 1])
                ->leftJoin('users as u1', 'u1.id', '=', 'billing_details.doctor_id')
                ->leftJoin('charges', function ($join) {
                    $join->on('charges.id', '=', 'billing_details.charge_id');
                    // $join->on('charges.id', '=', 'billing_details.charge_name')->whereRaw('billing_details.charge_name REGEXP "^[0-9]+$"');
                })
                ->orderBy('billing_details.date', 'DESC')
                ->get();
            if($section == 'op'){
                $op_check = OpRegister::where('id',$bill->section_id)->first();
                if($op_check->enquiry_id == 0){
                    $bill_info = OpBillingDetail::select('op_billing_details.*', 'op_items.item_name as actual_charge_name')
                        ->where('op_billing_details.billing_id', $bill->id)
                        ->whereIn('op_billing_details.is_delete', [0, 1])
                        ->leftJoin('op_items', function ($join) {
                            $join->on('op_items.id', '=', 'op_billing_details.item_id');
                        })
                        ->orderBy('op_billing_details.date', 'DESC')
                        ->get();
                }
            }

            $payments = Payment::select('payments.*', 'u.name as created_name')
                ->join('users as u', 'u.id', '=', 'payments.payment_recived_by')
                ->where('billing_id', $bill->id)
                ->get();
            $refund = PatientCraditAmount::select('patient_cradit_amounts.*', 'u.name as created_name')
                ->join('users as u', 'u.id', '=', 'patient_cradit_amounts.generated_by')
                ->where('billing_id', $bill->id)
                ->where('type', 'debit')
                ->where('remarks', 'refund')
                ->get();
            $reused = PatientCraditAmount::select('patient_cradit_amounts.*', 'u.name as created_name')
                ->join('users as u', 'u.id', '=', 'patient_cradit_amounts.generated_by')
                ->where('billing_id', $bill->id)
                ->where('type', 'debit')
                ->where('remarks', 'reused')
                ->get();
            $advance_used =  PatientCraditAmount::select('patient_cradit_amounts.*', 'u.name as created_name')
                ->join('users as u', 'u.id', '=', 'patient_cradit_amounts.generated_by')
                ->where('use_bill_id', $bill->id)
                ->where('type', 'used')
                ->where('remarks', 'added')
                ->get();
        } else {
            $bill_info = $payments = $refund = $reused = $advance_used = [];
        }

        $market_by = Referral::select('id', 'referral_name as name', 'total_percentage', 'lab_percentage')
            ->where('type', 'market_by')
            ->where('is_active', 1)
            ->where('is_delete', 0)
            ->get();

        $provider = Referral::select('id', 'referral_name as name', 'total_percentage', 'lab_percentage')
            ->where('type', 'provider')
            ->where('is_active', 1)
            ->where('is_delete', 0)
            ->get();

        $referral = Referral::select('id', 'referral_name as name', 'total_percentage', 'lab_percentage')
            ->where('type', 'referral')
            ->where('is_active', 1)
            ->where('is_delete', 0)
            ->get();

        $patient_details = null;
        $ipd_label_info = null;
        $patient_label_doctor = null;
        $header_image = Header::where('header_name', 'bill')->first();

        if ($bill && $section == 'ipd') {
            $patient_details = Patient::find($bill->patient_id);
            $patient_label_doctor = optional(User::find($bill->doctor_id))->name ?? optional(Referral::find($bill->referred_by))->referral_name;
            $ipd_label_info = IpdRegister::select(
                'beds.bed_name',
                'ipd_registers.admission_type',
                'ipd_registers.admission_date'
            )
                ->join('beds', 'beds.id', '=', 'ipd_registers.bed_id')
                ->where('ipd_registers.id', $bill->section_id)
                ->first();
        }

        $data = compact('bill', 'bill_info', 'payments', 'refund', 'reused', 'section', 'advance_used', 'market_by', 'provider', 'referral', 'patient_details', 'ipd_label_info', 'patient_label_doctor', 'header_image');
        // $data = compact('bill', 'bill_info', 'payments', 'refund', 'reused', 'section', 'advance_used', 'market_by', 'provider', 'referral');
        // dd($data);
        return view('bill.bill-details')->with($data);
    }
    public function edit_bill($section, $bill_id)
    {
        $bill_id = ed($bill_id, false);
        // $db = strtolower($section) . '_registers';

        $charges = $advance_amount_details = $creditUsages = $added_amount = $other_table_details = [];

        $section == 'ot' ? $db = 'ot_registrations' : $db = strtolower($section) . '_registers';
        // dd($db);
        $tds_value = Setting::where('id', 10)->first(['value'])->value ?? 0;
        $packages = Package::where('status', '0')->get();
        $doctor = User::where('user_type', 'doctor')->where('is_active', 1)->where('is_delete', 0)->get();
        $referral = Referral::where('type', 'referral')->where('is_active', 1)->where('is_delete', 0)->get();
        $provider = Referral::where('type', 'provider')->where('is_active', 1)->where('is_delete', 0)->get();
        $market_by = Referral::where('type', 'market_by')->where('is_active', 1)->where('is_delete', 0)->get();
        $bill = Billing::select('billings.*', 'u1.name as doctor_name', 'u2.name as created_name', 'u3.name as edit_name')
            ->leftjoin('users as u1', 'u1.id', '=', 'billings.doctor_id')
            ->leftjoin('users as u2', 'u2.id', '=', 'billings.created_by')
            ->leftjoin('users as u3', 'u3.id', '=', 'billings.edit_by')
            ->join($db . ' as or', 'or.id', '=', 'billings.section_id')
            ->where('billings.id', $bill_id)
            ->first();

        if( $bill && (strtolower($section) == 'ipd' || strtolower($section) == 'dialysis') ){

            $other_table_details = Billing::select('or.insurance_id')->join($db . ' as or', 'or.id', '=', 'billings.section_id')
            ->where('billings.id', $bill_id)->first();

        }

        if ($bill) {

            $charges = Charge::select('charges.id', 'charges.charge_name', 'chs.charge_amount')
            ->join('charges_has_sections as chs', 'chs.charge_id', '=', 'charges.id')
            ->join('charges_sections as cs', 'cs.id', '=', 'chs.charge_section_id')
            ->where('cs.charges_section_name', ($bill->section == 'op' ? 'OPD' : strtoupper($bill->section)))
            ->where('charges.is_active', 1)
            ->where('charges.is_delete', 0)
            ->get();

            if($bill->section == 'op'){
                $op_check = OpRegister::where('id',$bill->section_id)->first();
                if($op_check->enquiry_id == 0){
                    $charges = OpItem::select('op_items.id', 'op_items.item_name as charge_name')
                        ->where('op_items.is_active', 1)
                        ->where('op_items.is_delete', 0)
                        ->get();
                }
            }

            $advance_payments = Payment::select('id', 'payment_date', 'payment_amount')
                ->where('section_id', $bill->section_id)
                ->where('section', 'ipd')
                ->get();

            // Fetch credit usages grouped by from_payment_id
            $creditUsages = PatientCraditAmount::select('from_payment_id', DB::raw('SUM(amount) as used_amount'))
                ->where('use_bill_id', $bill_id)
                ->groupBy('from_payment_id')
                ->get()
                ->keyBy('from_payment_id');

            $added_amount = PatientCraditAmount::select('patient_cradit_amounts.*', 'u.name as created_name')
                ->join('users as u', 'u.id', '=', 'patient_cradit_amounts.generated_by')->where('use_bill_id', $bill_id)->get();


            $advance_amount_details = $advance_payments->map(function ($payment) use ($creditUsages) {
                $usedAmount = $creditUsages[$payment->id]->used_amount ?? 0;
                $payment->remaining_amount = $payment->payment_amount - $usedAmount;
                return $payment;
            })->filter(function ($payment) {
                return $payment->remaining_amount > 0;
            });



            $bill_info = BillingDetail::where('billing_id', $bill->id)->whereIn('billing_details.is_delete', [0, 1])->orderBy('billing_details.date', 'DESC')->get();
            if($section == 'op'){
                $op_check = OpRegister::where('id',$bill->section_id)->first();
                if($op_check->enquiry_id == 0){
                    $bill_info = OpBillingDetail::select('op_billing_details.*','op_billing_details.item_name as charge_name')->where('billing_id', $bill->id)->whereIn('op_billing_details.is_delete', [0, 1])->orderBy('op_billing_details.date', 'DESC')->get();
                }
            }
            $payments = Payment::select('payments.*', 'u.name as created_name')
                ->join('users as u', 'u.id', '=', 'payments.payment_recived_by')
                ->where('billing_id', $bill->id)
                ->get();
            $cradits = PatientCraditAmount::select('patient_cradit_amounts.*', 'u.name as created_name')
                ->join('users as u', 'u.id', '=', 'patient_cradit_amounts.generated_by')
                ->where('billing_id', $bill->id)
                ->where('type', 'debit')
                ->get();
        } else {
            $bill_info = $payments = $cradits = [];
        }
        $data = compact('bill', 'bill_info', 'payments', 'cradits', 'doctor', 'referral', 'provider',
            'market_by', 'charges', 'section', 'packages', 'advance_amount_details', 'creditUsages',
            'added_amount', 'other_table_details', 'tds_value');
        // dd($data);
        if ($bill) {
            return view('bill.edit-bill')->with($data);
        }else{
            return redirect()->back();
        }

    }
    public function create_bill($section, $ipd_id)
    {
        $ipd_id = ed($ipd_id, false);
        $tds_value = Setting::where('id', 10)->first(['value'])->value ?? 0;
        $packages = Package::where('status', '0')->get();
        $doctor = User::where('user_type', 'doctor')->where('is_active', 1)->where('is_delete', 0)->get();
        $referral = Referral::where('type', 'referral')->where('is_active', 1)->where('is_delete', 0)->get();
        $charges = Charge::select('charges.id', 'charges.charge_name', 'chs.charge_amount')
            ->join('charges_has_sections as chs', 'chs.charge_id', '=', 'charges.id')
            ->join('charges_sections as cs', 'cs.id', '=', 'chs.charge_section_id')
            ->where('cs.charges_section_name', strtoupper($section))
            ->where('charges.is_active', 1)
            ->where('charges.is_delete', 0)
            ->get();

        // $advanceList = Payment::where('section_id',$ipd_id)->where('section','ipd')->get();
        $payments = DB::table('payments')
            ->select('id', 'payment_date', 'payment_amount')
            ->where('section_id', $ipd_id)
            ->where('section', 'ipd')
            ->get();

        $creditUsages = DB::table('patient_cradit_amounts')
            ->select('from_payment_id', DB::raw('SUM(amount) as used_amount'))
            ->whereNotNull('use_bill_id')
            ->groupBy('from_payment_id')
            ->get()
            ->keyBy('from_payment_id');


        $advance_amount_details = $payments->map(function ($payment) use ($creditUsages) {
            $usedAmount = $creditUsages[$payment->id]->used_amount ?? 0;
            $payment->remaining_amount = $payment->payment_amount - $usedAmount;
            return $payment;
        })->filter(function ($payment) {
            return $payment->remaining_amount > 0;
        });

        $data = compact('packages', 'doctor', 'referral', 'charges', 'ipd_id', 'section', 'advance_amount_details', 'tds_value');
        // dd($data);
        return view('bill.create-bill')->with($data);
    }
    public function create_receipt($section, $bill_id)
    {
        $bill_id = ed($bill_id, false);
        $type = 'Create';
        $bill = Billing::select('billings.*', 'u2.name as created_name')
            ->join('users as u2', 'u2.id', '=', 'billings.created_by')
            ->where('billings.id', $bill_id)
            ->first();

        $data = compact('bill_id', 'bill', 'section', 'type');
        // dd($data);
        return view('bill.create-receipt')->with($data);
    }
    public function insert_bill($section, Request $request)
    {
        $model = "App\\Models\\" . ucwords($section) . "Register";
        $ipd = $model::where('id', $request->section_id)->first();
        DB::beginTransaction();
        try {
            $craditAmount = 0;
            //SAVE in Billing Section
            $bill = new Billing();
            $bill->uid = Billing::where('section', @$ipd->admission_type ? $ipd->admission_type : strtoupper($section))->selectRaw('MAX(CAST(uid AS UNSIGNED)) as max_uid')->value('max_uid') + 1;
            $bill->section = @$ipd->admission_type ? $ipd->admission_type : strtoupper($section);
            $bill->section_id = $request->section_id;
            $bill->bill_date = date('Y-m-d H:i:s');
            $bill->patient_id = $ipd->patient_id;
            $bill->doctor_id = $ipd->doctor_id;
            $bill->referred_by = $ipd->referred_by;
            $bill->market_by = $ipd->market_by;
            $bill->provider = $ipd->provider;
            // $bill->case_id = CaseReference::where('patient_id', $ipd->patient_id)->where('section', strtoupper($section))->where('section_id', $request->section_id)->first()->id;

            $bill->total = $request->total ?? 0.00;
            $bill->sub_total = $request->sub_total ?? 0.00;
            $bill->miscellaneous_amount = ($request->total ?? 0.00) - ($request->sub_total ?? 0.00);
            $bill->miscellaneous = $request->miscellaneous_charge ?? 0;
            $bill->miscellaneous_type = $request->miscellaneous_charge_type;
            $bill->discount_amount = (($request->total ?? 0.00) - ($request->grand_total ?? 0.00)) ?? 0.00;
            $bill->discount = $request->total_discount ?? 0;
            $bill->discount_type = $request->discount_type;
            $bill->discount_status = 'Approved';
            $bill->total_payment = $request->total_payment;
            if ($request->grand_total < $request->total_payment) {
                $craditAmount = $request->total_payment - $request->grand_total;
                $bill->cradit_amount = $craditAmount;
                $bill->due_amount = 0.00;
            } elseif ($request->grand_total > $request->total_payment) {
                $bill->due_amount = $request->grand_total - $request->total_payment;
            }
            $bill->grand_total = $request->grand_total ?? 0.00;
            $bill->tds_amount = $request->tds_amount ?? 0.00;

            $bill->status = 'Done';
            $bill->finance_remark = $request->finance_remark;
            $bill->department_party_remark = $request->department_party_remark;
            $bill->bill_status = $request->save;
            $bill->created_by = Auth::user()->id;
            $bill->save();

            if ($craditAmount > 0) {
                PatientCraditAmount::create([
                    'patient_id' => $ipd->patient_id,
                    'billing_id' => $bill->id,
                    'date' => date('Y-m-d H:i:s'),
                    'amount' => $craditAmount,
                    'type' => 'credit',
                    'remarks' => 'added',
                    'generated_by' => Auth::id(),
                ]);
            }

            if (@$request->advance_payment_id[0] != null) {
                foreach ($request->advance_payment_id as $key => $value) {
                    if ($request->adjust_advance_amount[$key] > 0) {
                        $user_credit2 = new PatientCraditAmount();
                        $user_credit2->from_payment_id = $request->advance_payment_id[$key];
                        $user_credit2->patient_id = $ipd->patient_id;
                        $user_credit2->use_bill_id = $bill->id;
                        $user_credit2->type = 'used';
                        $user_credit2->remarks = 'added';
                        $user_credit2->amount = $request->adjust_advance_amount[$key];
                        $user_credit2->date = date('Y-m-d H:i', strtotime($request->bill_date));
                        $user_credit2->generated_by = Auth::user()->id;
                        $user_credit2->save();
                    }
                }
            }

            //SAVE in Billing Details
            foreach (@$request->charge_name ?? [] as $key => $value) {
                $charge = Charge::select('charges.*', 'cc.charges_catagories_name')
                    ->join('charges_catagories as cc', 'cc.id', '=', 'charges.sub_category_id')
                    ->where('charges.id', $request->charge_name[$key])
                    ->first();

                $bill_details =  new BillingDetail();
                $bill_details->billing_id =  $bill->id;
                $bill_details->charge_category_id = $charge->category_id;
                $bill_details->charge_sub_category_id = $charge->sub_category_id;
                $bill_details->date = date('Y-m-d H:i:s', strtotime($request->date[$key]));
                $bill_details->charge_id = $request->charge_name[$key];
                if ($section == 'ipd' || $section == 'dialysis') {
                    if (@$request->doctor_name[$key]) {
                        $bill_details->doctor_id = $request->doctor_name[$key];
                    }
                }
                $bill_details->charge_name = $charge->charge_name;
                $bill_details->commision_amount = 0.00;
                $bill_details->standard_charges = $request->rate[$key];
                $bill_details->discount_percentage = $request->discount_in_per[$key];
                $bill_details->discount_amount = $request->discount_amount[$key] ?? 0.00;
                $bill_details->qty = $request->qty[$key];
                $bill_details->amount = $request->amount[$key];
                $bill_details->save();

                //SAVE in investigations
                if ($charge->charge_type == 'investigation') {
                    $charge_normal = ChargesHasNormal::where('charge_id', $charge->id)->get();
                    if ($charge->category_id == 10) {
                        $type = 'pathology';
                    } elseif ($charge->category_id == 12) {
                        $type = 'non-pathology';
                    } elseif ($charge->category_id == 11) {
                        $type = 'radiology';
                    } else {
                        $type = null;
                    }
                    if ($type) {
                        $investigation = new Investigation();
                        $investigation->type = $type;
                        $investigation->charge_id = $charge->id;
                        $investigation->bill_id =  $bill->id;
                        $investigation->bill_details_id = $bill_details->id;
                        $investigation->patient_id = $ipd->patient_id;
                        $investigation->bill_created_by = Auth::user()->id;
                        $investigation->bill_created_date = date('Y-m-d H:i:s');
                        $investigation->expected_delivery_at = date('Y-m-d');
                        $investigation->report_status = '0'; // 0 => only bill created, 1 => sample collected, 2 => sample collecting, 3 => lab received, 4 => report generated, 5 => report deliverd
                        $investigation->section =  @$ipd->admission_type ? $ipd->admission_type : strtoupper($section);
                        $investigation->section_id = $request->section_id;
                        $investigation->doctor_id = $request->cons_doctor;
                        $investigation->save();

                        foreach ($charge_normal as $key => $value) {
                            $investigation_details = new InvestigationDetail();
                            $investigation_details->investigation_id = $investigation->id;
                            $investigation_details->charge_normal_id = $value->id;
                            $investigation_details->save();
                        }
                    }
                }
            }

            //SAVE in Payment
            if (count($request->payment_amount) > 0) {
                foreach ($request->payment_amount as $key => $value) {
                    if ($request->payment_amount[$key] > 0) {
                        $payment = new Payment();
                        $payment->billing_id = $bill->id;
                        $payment->patient_id = $ipd->patient_id;
                        $payment->section = @$ipd->admission_type ? $ipd->admission_type : strtoupper($section);
                        $payment->payment_amount = $request->payment_amount[$key];
                        $payment->payment_mode = $request->payment_mode[$key];
                        $payment->payment_bank = $request->payment_mode[$key] == 'Cash' ? null : $request->bank_name;
                        $payment->payment_recived_by = Auth::user()->id;
                        $payment->payment_date = date('Y-m-d H:i:s', strtotime($request->payment_date[$key]));
                        $payment->save();
                    }
                }
            }

            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Failed! Please try again!');
        }

        return redirect()->route('bill.billing-details', [strtolower($section), ed($bill->id, true)])->with('success', 'Bill Added Sucessfully');
    }

    public function shift_bill($section, Request $request){
        $request->validate([
            'bill_id' => 'required|exists:billings,id',
        ]);
        DB::beginTransaction();
        try {
            $oldBill = Billing::findOrFail($request->bill_id);
            $targetSection = $oldBill->section === 'DAYCARE' ? 'IPD' : 'DAYCARE';
            $register = IpdRegister::find($oldBill->section_id);
            if ($register) {
                $register->admission_type = $targetSection;
                $register->save();
            }

            $maxUid = Billing::where('section', $targetSection)
                ->selectRaw('MAX(CAST(uid AS UNSIGNED)) as max_uid')
                ->value('max_uid') ?? 0;
            $newBill = $oldBill->replicate();
            $newBill->id = null;
            $newBill->uid = $maxUid + 1;
            $newBill->section = $targetSection;
            $newBill->bill_status = 1;
            $newBill->save();

            BillingDetail::where('billing_id', $oldBill->id)->update(['billing_id' => $newBill->id]);
            Investigation::where('bill_id', $oldBill->id)
                ->update([
                    'bill_id' => $newBill->id,
                    'section' => $targetSection,
                    'section_id' => $oldBill->section_id,
                ]);
            Payment::where('billing_id', $oldBill->id)->update([
                'billing_id' => $newBill->id,
                'section' => $targetSection,
            ]);

            $zeroFields = [
                'total', 'sub_total', 'total_payment', 'due_amount',
                'cradit_amount', 'grand_total', 'discount_amount',
                'discount', 'miscellaneous_amount', 'miscellaneous',
            ];
            foreach ($zeroFields as $field) {
                $oldBill->$field = 0;
            }

            $oldBill->bill_status = 3;
            $oldBill->save();

            DB::commit();
            return redirect()->route('bill.billing-details', [strtolower($targetSection), ed($newBill->id, true)])
                ->with('success', 'Patient shifted to ' . $targetSection . ' successfully.');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('shift bill error: '.$e->getMessage());
            return redirect()->back()->with('error', 'Failed to shift patient. Please try again.');
        }
    }
    public function edit_receipt($section, $pay_id)
    {
        $pay_id = ed($pay_id, false);
        $type = 'Edit';
        $payments = Payment::select('payments.*')
            ->where('payments.id', $pay_id)
            ->first();
        $bill_id = $payments->billing_id;
        $bill = Billing::select('billings.*', 'u2.name as created_name')
            ->join('users as u2', 'u2.id', '=', 'billings.created_by')
            ->where('billings.id', $payments->billing_id)
            ->where('billings.section', $payments->section)
            ->first();

        $data = compact('pay_id', 'bill_id', 'bill', 'payments', 'section', 'type');
        // dd($data);
        return view('bill.create-receipt')->with($data);
    }
    public function insert_receipt($section, Request $request)
    {
        $request->validate([
            "bill_id" => 'required',
            "amount" => 'required',
        ]);
        $payment = new Payment();
        $payment->billing_id = $request->bill_id;
        $payment->patient_id = Billing::where('id', $request->bill_id)->first()->patient_id;
        $payment->section = Billing::where('id', $request->bill_id)->first()->section;
        $payment->payment_amount = $request->amount;
        $payment->payment_mode = $request->payment_mode;
        $payment->payment_bank = $request->payment_mode == 'Cash' ? null : $request->bank_name;
        $payment->payment_recived_by = Auth::user()->id;
        $payment->payment_date = date('Y-m-d H:i:s', strtotime($request->payment_date));
        if ($payment->save()) {
            $bill = Billing::find($request->bill_id);
            $total_pay = $bill->total_payment + $request->amount;
            if ($bill->grand_total < $total_pay) {
                $bill->cradit_amount = $total_pay - $bill->grand_total;
            }
            $bill->total_payment = $total_pay;
            
            if ($bill->due_amount <= $request->amount) {
                $bill->due_amount = 0.00;
                $bill->bill_status = 2;
            } else {
                $bill->due_amount = $bill->due_amount - $request->amount;
                $bill->bill_status = 1;
            }
            $bill->update();
            if ($bill->section == 'OT') {
                return redirect()->route('ot.ot-info', ['id' => ed($bill->section_id, true)])
                    ->with('success', 'Payment received successfully.');
            }

            $url1 = route('bill.print-payment-receipt', [$section, ed($payment->id, true)]);
            $return_action = route('bill.billing-details', [$section, ed($request->bill_id, true)]);
            return view('open-single-tabs', compact('url1', 'return_action'));
        } else {
            return redirect()->back()->with('error', 'Failed! Please try again!');
        }
    }
    public function update_receipt($section, Request $request)
    {
        $request->validate([
            "bill_id" => 'required',
            "amount" => 'required',
        ]);
        $old_payment = Payment::find($request->pay_id);
        $payment = Payment::find($request->pay_id);
        $payment->payment_amount = $request->amount;
        $payment->payment_mode = $request->payment_mode;
        $payment->payment_bank = $request->payment_mode == 'Cash' ? null : $request->bank_name;
        $payment->payment_date = date('Y-m-d H:i:s', strtotime($request->payment_date));
        if ($payment->update()) {
            $bill = Billing::find($request->bill_id);
            $due_amount = $cradit_amount = 0.00;
            if ($old_payment->payment_amount > $request->amount) { // 200 to 100
                $diff_amount = $old_payment->payment_amount - $request->amount;
                $total_payment = $bill->total_payment - $diff_amount;
                if ($bill->due_amount > 0) {
                    $due_amount = $bill->due_amount + $diff_amount;
                } elseif ($bill->cradit_amount > 0) {
                    $cradit_amount = $bill->cradit_amount - $diff_amount;
                } elseif ($bill->due_amount == 0 && $bill->cradit_amount == 0) {
                    $due_amount = $bill->due_amount + $diff_amount;
                } else {
                    return redirect()->back()->with('error', 'Failed! Please try again!');
                }
                $bill->total_payment = $total_payment;
                $bill->due_amount = $due_amount;
                $bill->cradit_amount = $cradit_amount;
                $bill->update();
                return redirect()->route('bill.billing-details', [strtolower($section), ed($request->bill_id, true)])->with('success', 'Successfully Updated');
            } elseif ($old_payment->payment_amount < $request->amount) { // 100 to 200
                $diff_amount = $request->amount - $old_payment->payment_amount;
                $total_payment = $bill->total_payment + $diff_amount;
                if ($bill->due_amount > 0) {
                    $due_amount = $bill->due_amount - $diff_amount;
                } elseif ($bill->cradit_amount > 0) {
                    $cradit_amount = $bill->cradit_amount + $diff_amount;
                } elseif ($bill->due_amount == 0 && $bill->cradit_amount == 0) {
                    $due_amount = $bill->due_amount - $diff_amount;
                } else {
                    return redirect()->back()->with('error', 'Failed! Please try again!');
                }
                $bill->total_payment = $total_payment;
                $bill->due_amount = $due_amount;
                $bill->cradit_amount = $cradit_amount;
                $bill->update();
                return redirect()->route('bill.billing-details', [strtolower($section), ed($request->bill_id, true)])->with('success', 'Successfully Updated');
            } else {
                return redirect()->route('bill.billing-details', [strtolower($section), ed($request->bill_id, true)])->with('success', 'Successfully Updated');
            }
        } else {
            return redirect()->back()->with('error', 'Failed! Please try again!');
        }
    }
    public function delete_receipt($section, $pay_id)
    {
        $pay_id = ed($pay_id, false);
        $payments = Payment::select('payments.*')
            ->where('payments.id', $pay_id)
            ->first();
        $bill_id = $payments->billing_id;

        $bill = Billing::find($bill_id);
        $due_amount = $cradit_amount = 0.00;
        $diff_amount = $payments->payment_amount;
        $total_payment = $bill->total_payment - $diff_amount;
        if ($bill->due_amount > 0) {
            $due_amount = $bill->due_amount + $diff_amount;
        } elseif ($bill->cradit_amount > 0) {
            $cradit_amount = $bill->cradit_amount - $diff_amount;
        } elseif ($bill->due_amount == 0 && $bill->cradit_amount == 0) {
            $due_amount = $bill->due_amount + $diff_amount;
        } else {
            return redirect()->back()->with('error', 'Failed! Please try again!');
        }
        $bill->total_payment = $total_payment;
        $bill->due_amount = $due_amount;
        $bill->cradit_amount = $cradit_amount;
        if ($bill->update()) {
            $data = Payment::find($pay_id);
            $data->deleted_at = date('Y-m-d H:i:s');
            $data->update();
            return redirect()->route('bill.billing-details', [$section, ed($bill_id, true)])->with('success', 'Successfully Deleted');
        } else {
            return redirect()->back()->with('error', 'Failed! Please try again!');
        }
    }
    public function update_bill($section, Request $request)
    {
		// dd($request->all());
        $section == 'ot' ? $model = "App\\Models\\OtRegistration" : $model = "App\\Models\\" . ucwords(strtolower($section)) . "Register";
        DB::beginTransaction();
        try {
            if ($request->save == 'cancel') {
                $opd = $model::find($request->section_id);
                if($section != 'ot'){
                    $opd->edit_by = Auth::user()->id;
                    $opd->edit_at = date('Y-m-d H:i:s');
                }
                $opd->update();

                $bill = Billing::find($request->bill_id);
                    if ($section == 'opd' || $section == 'emg') {
                        $checkStatus = PatientDoctorStatus::where('doctor_id', $bill->doctor_id)->where('patient_id', $bill->patient_id)->where('section_id', $request->section_id)->first();
                        $checkStatus->status = 2;
                        $checkStatus->is_delete = 1;
                        $checkStatus->update();
                    }
                    $cradit = new PatientCraditAmount();
                    $cradit->patient_id = $bill->patient_id;
                    $cradit->billing_id = $request->bill_id;
                    $cradit->date = date('Y-m-d H:i:s');
                    $cradit->amount = $bill->total_payment ?? 0;
                    $cradit->type = 'credit';
                    $cradit->generated_by = Auth::user()->id;
                    $cradit->save();
                $bill->cradit_amount = $bill->cradit_amount + $bill->total_payment;
                $bill->due_amount = 0.00;
                $bill->bill_status = 3;
                $bill->edit_by = Auth::user()->id;
                $bill->edit_at = date('Y-m-d H:i:s');
                $bill->update();
            } else {
                //SAVE in Register Details
                $old_opd = $model::where('id', $request->section_id)->first();
                if ($section == 'ipd') {
                    $mainSection = $old_opd->admission_type;
                } else {
                    $mainSection = strtoupper($section);
                }

                $opd = $model::find($request->section_id);
                if ($section == 'opd') {
                    if ($old_opd->doctor_id != $request->cons_doctor) {
                        $opd->department_id = User::where('id', $request->cons_doctor)->first()->department_id;
                        $opd->doctor_id = $request->cons_doctor;
                    }
                    $opd->referred_by = $request->referred_by;
                    $opd->provider = $request->provider;
                    $opd->market_by = $request->market_by;
                }
                if($section != 'ot'){
                    $opd->edit_by = Auth::user()->id;
                    $opd->edit_at = date('Y-m-d H:i:s');
                }
                $opd->update();

                // SAVE in PATIENT DOCTOR STATUS
                if ($section == 'opd') {
                    if ($old_opd->doctor_id != $request->cons_doctor) {
                        $checkStatus = PatientDoctorStatus::where('doctor_id', $request->cons_doctor)->where('patient_id', $old_opd->patient_id)->first();
                        $checkStatus ? $patient_type = 'old' : $patient_type = 'new';
                        $doctorPatientStatus = new PatientDoctorStatus();
                        $doctorPatientStatus->section = $mainSection;
                        $doctorPatientStatus->section_id = $request->section_id;
                        $doctorPatientStatus->doctor_id = $request->cons_doctor;
                        $doctorPatientStatus->patient_id = $old_opd->patient_id;
                        $doctorPatientStatus->patient_type = $patient_type;
                        $doctorPatientStatus->date = $old_opd->appointment_date ? date('Y-m-d', strtotime($old_opd->appointment_date)) : null;
                        $doctorPatientStatus->in_time = date('H:i');
                        $doctorPatientStatus->save();

                        $checkStatus = PatientDoctorStatus::where('doctor_id', $old_opd->doctor_id)->where('patient_id', $old_opd->patient_id)->where('section_id', $request->section_id)->first();
                        $checkStatus->status = 2;
                        $checkStatus->is_delete = 1;
                        $checkStatus->update();
                    }
                }

                //SAVE in Billing Section
                $bill = Billing::find($request->bill_id);

                // Section-specific updates
                if ($section == 'opd') {
                    $bill->doctor_id = $request->cons_doctor;
                    $bill->referred_by = $request->referred_by;
                    $bill->provider = $request->provider;
                    $bill->market_by = $request->market_by;
                }

                // Basic billing values
                $bill->total = $request->total;
                $bill->sub_total = $request->sub_total ?? $request->total;
                $bill->total_payment = $request->total_payment ?? 0;

                // Calculate discount
                $discountAmount = 0;
                $discountAmount = $request->discount_type === 'flat'
                    ? $request->total_discount
                    : ($bill->total * $request->total_discount) / 100;
                $bill->discount_amount = $discountAmount ?? 0.00;
                $bill->discount = $request->total_discount ?? 0;
                $bill->discount_type = $request->discount_type;

                // Calculate miscellaneous charges
                $miscellaneousAmount = 0;
                if (@$request->miscellaneous_charge_type) {
                    $miscellaneousAmount = $request->miscellaneous_charge_type === 'flat'
                        ? $request->miscellaneous_charge
                        : ($bill->sub_total * $request->miscellaneous_charge) / 100;
                }
                $bill->miscellaneous_amount = $miscellaneousAmount;
                $bill->miscellaneous = @$request->miscellaneous_charge ?? 0;
                $bill->miscellaneous_type = @$request->miscellaneous_charge_type ?? null;

                // Final grand total
                $credit = $due = 0;
                $amount_receipt_without_cradit_use_and_refund = ($request->total_payment - $request->previous_credit_used);
                $amount_status = $request->grand_total - $amount_receipt_without_cradit_use_and_refund;

                if ($amount_status > 0) {
                    $due = $amount_status;
                    $credit = 0;
                } elseif ($amount_status < 0) {
                    $due = 0;
                    $credit = $amount_receipt_without_cradit_use_and_refund - $request->grand_total;
                }

                $grandTotal = ($bill->total - $discountAmount) + $miscellaneousAmount;
                // $bill->grand_total = $grandTotal;
                $bill->grand_total = $request->grand_total ?? 0;
                $bill->tds_amount = $request->tds_amount ?? 0;

                // Apply due and credit values to bill
                $bill->due_amount = $due;
                $bill->cradit_amount = $credit;

                if ($credit > 0) {
                    PatientCraditAmount::create([
                        'patient_id' => $old_opd->patient_id,
                        'billing_id' => $request->bill_id,
                        'date' => date('Y-m-d H:i:s'),
                        'amount' => $credit,
                        'type' => 'credit',
                        'remarks' => 'added',
                        'generated_by' => Auth::id(),
                    ]);
                }

                // Remarks and status
                $bill->finance_remark = $request->finance_remark;
                $bill->department_party_remark = $request->department_party_remark;
                $request->save ? $bill->bill_status = $request->save : '';
                $bill->edit_at = now();
                $bill->edit_by = Auth::id();
                $bill->update();

                if (@$request->advance_payment_id[0] != null) {
                    foreach ($request->advance_payment_id as $key => $value) {
                        if ($request->adjust_advance_amount[$key] > 0) {
                            $user_credit2 = new PatientCraditAmount();
                            $user_credit2->from_payment_id = $request->advance_payment_id[$key];
                            $user_credit2->patient_id = $old_opd->patient_id;
                            $user_credit2->use_bill_id = $bill->id;
                            $user_credit2->type = 'used';
                            $user_credit2->remarks = 'added';
                            $user_credit2->amount = $request->adjust_advance_amount[$key];
                            $user_credit2->date = date('Y-m-d H:i', strtotime($request->bill_date));
                            $user_credit2->generated_by = Auth::user()->id;
                            $user_credit2->save();
                        }
                    }
                }

                //SAVE in Billing Details
                $dy_sectuin = false;
                $dy_model = BillingDetail::class;
                if ($bill->section == 'OP') {
                    $op_check = OpRegister::where('id', $bill->section_id)->first();
                    if ($op_check->enquiry_id == 0) {
                        $dy_sectuin = true;
                        $dy_model = OpBillingDetail::class;
                    }
                }
                if (count(@$request->bill_details_id ?? []) > 0) {
                    $dy_model::whereNotIn('id', $request->bill_details_id)
                        ->where('billing_id', $request->bill_id)
                        ->update(['is_delete' => 2]);
                }
                foreach (@$request->charge_name ?? [] as $key => $value) {
                    if($dy_sectuin == true){
                        $charge = OpItem::select('op_items.*')
                            ->where('op_items.id', $request->charge_name[$key])
                            ->first();

                        if (@$request->bill_details_id[$key]) {
                            if (@$request->cancel_this_service[$request->bill_details_id[$key]] == 'on') {
                                $bill_details =  OpBillingDetail::find($request->bill_details_id[$key]);
                                $bill_details->amount = 0;
                                $bill_details->is_delete = 1;
                                $bill_details->update();
                            } else {
                                $bill_details = OpBillingDetail::find($request->bill_details_id[$key]);
                                $bill_details->standard_charges = $request->rate[$key];
                                $bill_details->discount_percentage = $request->discount_in_per[$key];
                                $bill_details->discount_amount = $request->discount_amount[$key] ?? 0.00;
                                $bill_details->date = $request->date[$key] ?? $old_opd->admission_date;
                                $bill_details->qty = $request->qty[$key];
                                $bill_details->amount = $request->amount[$key];
                                $bill_details->update();
                            }
                        } else {
                            $bill_details =  new OpBillingDetail();
                            $bill_details->billing_id = $request->bill_id;
                            $bill_details->date = $request->date[$key] ?? $old_opd->admission_date;
                            $bill_details->item_id = $request->charge_name[$key];
                            $bill_details->item_name = $charge->item_name;
                            $bill_details->standard_charges = $request->rate[$key];
                            $bill_details->discount_percentage = $request->discount_in_per[$key];
                            $bill_details->discount_amount = $request->discount_amount[$key] ?? 0.00;
                            $bill_details->qty = $request->qty[$key];
                            $bill_details->amount = $request->amount[$key];
                            $bill_details->save();
                        }
                    }else{
                        $charge = Charge::select('charges.*', 'cc.charges_catagories_name')
                            ->join('charges_catagories as cc', 'cc.id', '=', 'charges.sub_category_id')
                            ->where('charges.id', $request->charge_name[$key])
                            ->first();

                        if (@$request->bill_details_id[$key]) {
                            if (@$request->cancel_this_service[$request->bill_details_id[$key]] == 'on') {
                                $bill_details =  BillingDetail::find($request->bill_details_id[$key]);
                                $bill_details->amount = 0;
                                $bill_details->is_delete = 1;
                                $bill_details->update();

                                $investigati = Investigation::where('bill_details_id', $bill_details->id)
                                    ->where('bill_id', $request->bill_id)
                                    ->where('charge_id', $charge->id)
                                    ->where('is_delete', 0)
                                    ->first();
                                if ($investigati) {
                                    $inves =  Investigation::find($investigati->id);
                                    $inves->is_delete = 1;
                                    $inves->update();
                                }
                            } else {
                                $bill_details = BillingDetail::find($request->bill_details_id[$key]);
                                $bill_details->standard_charges = $request->rate[$key];
                                $bill_details->discount_percentage = $request->discount_in_per[$key];
                                $bill_details->discount_amount = $request->discount_amount[$key] ?? 0.00;
                                $bill_details->date = $request->date[$key] ?? $old_opd->admission_date;
                                $bill_details->qty = $request->qty[$key];
                                $bill_details->amount = $request->amount[$key];
                                if ($section == 'ipd' || $section == 'dialysis') {
                                    if (@$request->doctor_name[$key]) {
                                        $bill_details->doctor_id = $request->doctor_name[$key];
                                    }
                                }
                                $bill_details->update();
                            }
                        } else {
                            $bill_details =  new BillingDetail();
                            $bill_details->billing_id = $request->bill_id;
                            $bill_details->charge_category_id = $charge->category_id;
                            $bill_details->charge_sub_category_id = $charge->sub_category_id;
                            $bill_details->date = $request->date[$key] ?? $old_opd->admission_date;
                            $bill_details->charge_id = $request->charge_name[$key];
                            if ($section == 'ipd' || $section == 'dialysis') {
                                if (@$request->doctor_name[$key]) {
                                    $bill_details->doctor_id = $request->doctor_name[$key];
                                }
                            }
                            $bill_details->charge_name = $charge->charge_name;
                            $bill_details->commision_amount = 0;
                            $bill_details->standard_charges = $request->rate[$key];
                            $bill_details->discount_percentage = $request->discount_in_per[$key];
                            $bill_details->discount_amount = $request->discount_amount[$key] ?? 0.00;
                            $bill_details->qty = $request->qty[$key];
                            $bill_details->amount = $request->amount[$key];
                            $bill_details->save();

                            //SAVE in investigations
                            if ($charge->charge_type == 'investigation') {
                                $charge_normal = ChargesHasNormal::where('charge_id', $charge->id)->get();
                                if ($charge->category_id == 10) {
                                    $type = 'pathology';
                                } elseif ($charge->category_id == 12) {
                                    $type = 'non-pathology';
                                } elseif ($charge->category_id == 11) {
                                    $type = 'radiology';
                                } else {
                                    $type = null;
                                }
                                // $check = Investigation::where('bill_id', $request->bill_id)
                                //     ->where('charge_id', $request->charge_name[$key])
                                //     ->whereDate('bill_created_date', date('Y-m-d H:i:s', strtotime($request->date[$key])))
                                //     ->where('is_delete', 0)
                                //     ->first();
                                if ($type) {
                                    $investigation = new Investigation();
                                    $investigation->type = $type;
                                    $investigation->charge_id = $charge->id;
                                    $investigation->bill_id =  $request->bill_id;
                                    $investigation->bill_details_id = $bill_details->id;
                                    $investigation->patient_id = $old_opd->patient_id;
                                    $investigation->bill_created_by = Auth::user()->id;
                                    $investigation->bill_created_date = date('Y-m-d H:i:s');
                                    $investigation->expected_delivery_at = date('Y-m-d');
                                    $investigation->report_status = '0'; // 0 => only bill created, 1 => sample collected, 2 => sample collecting, 3 => lab received, 4 => report generated, 5 => report deliverd
                                    $investigation->section = $mainSection;
                                    $investigation->section_id = $request->section_id;
                                    $investigation->doctor_id = $old_opd->doctor_id;
                                    $investigation->save();

                                    foreach ($charge_normal as $key => $value) {
                                        $investigation_details = new InvestigationDetail();
                                        $investigation_details->investigation_id = $investigation->id;
                                        $investigation_details->charge_normal_id = $value->id;
                                        $investigation_details->save();
                                    }
                                }
                            }
                        }
                    }
                }

                //SAVE in Payment
                if (count($request->payment_amount) > 0) {
                    foreach ($request->payment_amount as $key => $value) {
                        if ($request->payment_amount[$key] > 0) {
                            $payment = new Payment();
                            $payment->billing_id = $request->bill_id;
                            $payment->patient_id = $old_opd->patient_id;
                            $payment->section = $bill->section;
                            $payment->payment_amount = $request->payment_amount[$key];
                            $payment->payment_mode = $request->payment_mode[$key];
                            $payment->payment_bank = $request->payment_mode[$key] == 'Cash' ? null : $request->bank_name;
                            $payment->payment_recived_by = Auth::user()->id;
                            $payment->payment_date = date('Y-m-d H:i:s');
                            $payment->save();
                        }
                    }
                }
            }
            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
			//dd($e, $request->all());
            return redirect()->back()->with('error', 'Failed! Please try again!');
        }
        return redirect()->route('bill.billing-details', [strtolower($section), ed($request->bill_id, true)])->with('success', 'Bill Updated Sucessfully');
    }
    public function get_receipt($section, $secid)
    {
        $secid = ed($secid, false);
        if ($section == 'ot') {
            $db = 'ot_registrations';
        } else {
            $db = strtolower($section) . '_registers';
        }
        $patient_id = DB::table($db)->where('id', $secid)->first();
        if( empty($patient_id) ){
            return redirect()->back();
        }else{
            $patient_id = $patient_id->patient_id;
        }
        $payments = Payment::select('payments.*', 'u.name as created_name')
            ->join('users as u', 'u.id', '=', 'payments.payment_recived_by')
            ->where('payments.patient_id', $patient_id)
            ->get();

        $data = compact('secid', 'payments', 'section');
        // dd($data);
        return view('bill.bill-receipt')->with($data);
    }
    public function get_billing($section, $secid)
    {
        $secid = ed($secid, false);
        if ($section == 'ot') {
            $db = 'ot_registrations';
        } else {
            $db = strtolower($section) . '_registers';
        }
        $patient_id = DB::table($db)->where('id', $secid)->first();
        if( empty($patient_id) ){
            return redirect()->back();
        }else{
            $patient_id = $patient_id->patient_id;
        }
        $bill = Billing::select('billings.*', 'u1.name as doctor_name', 'u2.name as created_name')
            ->leftJoin('users as u1', 'u1.id', '=', 'billings.doctor_id')
            ->leftJoin('users as u2', 'u2.id', '=', 'billings.created_by')
            ->leftJoin($db . ' as or', 'or.id', '=', 'billings.section_id')
            ->where('billings.patient_id', $patient_id)
            ->get();

        $data = compact('secid', 'bill', 'section');
        return view('bill.bill-list')->with($data);
    }
    public function get_refund($section, $secid)
    {
        $secid = ed($secid, false);
        $db = strtolower($section) . '_registers';
        $refund_list = [];
        $section_info = DB::table($db)->select('patient_id')->where('id', $secid)->first();
        if( !empty($section_info) ):

            $refund_list = Billing::select('billings.*', 'u1.name as doctor_name', 'u2.name as refund_name', 'pca.id as refund_id', 'pca.amount')
                ->leftjoin('users as u1', 'u1.id', '=', 'billings.doctor_id')
                ->leftjoin('users as u2', 'u2.id', '=', 'billings.refund_by')
                ->leftjoin('patient_cradit_amounts as pca', 'pca.billing_id', '=', 'billings.id')
                ->leftjoin($db . ' as or', 'or.id', '=', 'billings.section_id')
                ->where('billings.patient_id', $section_info->patient_id)
                ->where('billings.refund_amount', '>', 0)
                ->where('pca.type', 'debit')
                ->where('pca.remarks', 'refund')
                ->get();
        endif;

        $data = compact('secid', 'refund_list', 'section');
        // dd($data);
        return view('bill.refund-list')->with($data);
    }
    public function requisition($section, $bill_id)
    {
        $bill_id = ed($bill_id, false);
        $bill_details = Billing::where('id', $bill_id)->first();
        $patient_charge_details_for_requisition = BillingDetail::select('billing_details.id', 'billing_details.billing_id', 'charges.charge_name', 'billing_details.date')
            ->leftjoin('charges', 'charges.id', '=', 'billing_details.charge_id')
            ->where('billing_details.billing_id', $bill_id)
            ->whereIn('billing_details.charge_category_id', ['10', '11', '12'])
            ->orderBy('date', 'ASC')
            ->get();

        $ipd_details = null;
        if ($bill_details->section == 'IPD' || $bill_details->section == 'DAYCARE') {
            $ipd_details = IpdRegister::where('id', $bill_details->section_id)->first();
        }
        return view('bill.requisition', compact('patient_charge_details_for_requisition', 'ipd_details', 'bill_details', 'bill_id', 'section'));
    }
    public function refund($section, $billid)
    {
        $bill_id = ed($billid, false);
        $section == 'ot' ? $db = 'ot_registrations' : $db = strtolower($section) . '_registers';
        $bill = Billing::select('billings.*', 'u1.name as doctor_name', 'u2.name as created_name', 'u3.name as edit_name')
            ->leftjoin('users as u1', 'u1.id', '=', 'billings.doctor_id')
            ->leftjoin('users as u2', 'u2.id', '=', 'billings.created_by')
            ->leftjoin('users as u3', 'u3.id', '=', 'billings.edit_by')
            ->join($db . ' as or', 'or.id', '=', 'billings.section_id')
            ->where('billings.id', $bill_id)
            ->first();

        $data = compact('bill', 'bill_id', 'section');
        // dd($data);
        return view('bill.refund-form')->with($data);
    }
    public function update_refund($section, Request $request)
    {
        $request->validate([
            "bill_id" => 'required',
            "cradit_amount" => 'required',
            "refund_amount" => 'required',
        ]);
        $data = Billing::find($request->bill_id);
        $data->cradit_amount = $request->cradit_amount - $request->refund_amount;
        $data->refund_amount = $data->refund_amount + $request->refund_amount;
        $data->refund_by = Auth::user()->id;
        $data->refund_at = date('Y-m-d H:i:s');
        if ($data->update()) {
            $cradit = new PatientCraditAmount();
            $cradit->patient_id = $data->patient_id;
            $cradit->billing_id = $request->bill_id;
            $cradit->date = date('Y-m-d H:i:s');
            $cradit->amount = $request->refund_amount;
            $cradit->type = 'debit';
            $cradit->generated_by = Auth::user()->id;
            $cradit->remarks = 'refund';
            $cradit->save();
            return redirect()->route('bill.billing-details', [$section, ed($request->bill_id, true)])->with('success', 'Successfully Refunded!');
        } else {
            return redirect()->back()->with('error', 'Something wrong try again!');
        }
    }

    public function update_user_id(Request $request)
    {

        if ($request->section == 'opd') {
            $db = 'opd_registers';
        } elseif ($request->section == 'investigation') {
            $db = 'investigation_registers';
        }

        // get section id from bill
        $bill = Billing::where('id', $request->bill_id)->first(['section_id']);

        // base query for the row you want to update
        $query = DB::table($db)->where('id', $bill->section_id);

        // build data to update
        $data = [
            'update_by' => Auth::id(),
            'update_at' => date('Y-m-d H:i:s'), // or now()
        ];

        if ($request->market_by) {
            $data['market_by'] = $request->market_by;
        }
        if ($request->provider) {
            $data['provider'] = $request->provider;
        }
        if ($request->referral) {
            $data['referred_by'] = $request->referral;
        }

        // run the update on the query
        $updated = $query->update($data);

        if ($updated) {
            return redirect()
                ->route('bill.billing-details', [$request->section, ed($request->bill_id, true)])
                ->with('success', 'User ID updated successfully!');
        } else {
            return redirect()
                ->back()
                ->with('error', 'Failed to update User ID. Please try again!');
        }

    }

}
