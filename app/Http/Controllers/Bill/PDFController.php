<?php

namespace App\Http\Controllers\Bill;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Header;
use App\Models\Payment;
use App\Models\Patient;
use App\Models\Billing;
use App\Models\BillingDetail;
use App\Models\OpBillingDetail;
use App\Models\OtRegistration;
use App\Models\PatientCraditAmount;
use App\Models\OpdRegister;
use App\Models\IpdRegister;
use App\Models\OpRegister;
use App\Models\Charge;
use App\Models\DialysisRegister;
use App\Models\DischargeReport;
use App\Models\User;
use App\Models\EmrMaster;



class PDFController extends Controller
{
    public function print_payment_receipt($section, $id){
        $id = ed($id, false);
        $header_image = Header::where('header_name', 'opd_prescription')->first();
        $PaymentDetails =  Payment::select('payments.*','u.name as created_name')
            ->join('users as u','u.id','=','payments.payment_recived_by')
            ->where('payments.id', $id)
            ->first();
        $patient_details = Patient::select('patients.*','d.name as district_name','s.name as state_name')
            ->leftjoin('districts as d','d.id','=','patients.district')
            ->leftjoin('states as s','s.id','=','patients.state')
            ->where('patients.id',$PaymentDetails->patient_id)
            ->first();
        $amount = $this->numberToWord($PaymentDetails->payment_amount);
        $data = compact('amount', 'PaymentDetails', 'header_image','patient_details');
        // dd($data);
        return view('bill.print.print-receipt')->with($data);
    }
    public function print_bill($section, $bill_id){
        $billId = ed($bill_id, false);
        $header_image = Header::where('header_name', 'bill')->first();
        $bill = Billing::select('billings.*','u1.referral_name','u2.name as created_name')
            ->leftjoin('users as u2','u2.id','=','billings.created_by')
            ->leftjoin('referrals as u1','u1.id','=','billings.referred_by')
            ->where('billings.id',$billId)
            ->first();
        $bill_info = BillingDetail::select('billing_details.*','cc.charges_catagories_name')
            ->join('charges_catagories as cc','cc.id','=','billing_details.charge_category_id')
            ->where('billing_details.billing_id',$billId)
            ->where('billing_details.is_delete',0)
            ->get();
        if($section == 'op'){
            $op_check = OpRegister::where('id',$bill->section_id)->first();
            if($op_check->enquiry_id == 0){
                $bill_info = OpBillingDetail::select('op_billing_details.*','op_billing_details.item_name as charge_name')
                    ->where('op_billing_details.billing_id',$billId)
                    ->where('op_billing_details.is_delete',0)
                    ->get();
            }
        }
        $unique_categories = BillingDetail::join('charges_catagories as cc', 'cc.id', '=', 'billing_details.charge_category_id')
            ->where('billing_details.billing_id', $billId)
            ->where('billing_details.is_delete', 0)
            ->pluck('cc.charges_catagories_name')
            ->unique()
            ->values();
        $doctor_info = User::select('users.*','d.department_name')
			->leftjoin('departments as d','d.id','=','users.department_id')
			->where('users.id',$bill->doctor_id)
			->first();
        $patient_details = Patient::select('patients.*','s.name as state_name','d.name as district_name')
            ->leftjoin('states as s','s.id','=','patients.state')
            ->leftjoin('districts as d','d.id','=','patients.district')
            ->where('patients.id',$bill->patient_id)
            ->first();
        $payment_details = Payment::select('payments.*','u.name as created_name')
            ->join('users as u','u.id','=','payments.payment_recived_by')
            ->where('payments.billing_id', $billId)
            ->get();
        $cradit_details = PatientCraditAmount::select('patient_cradit_amounts.*','u.name as generated_name')
            ->join('users as u','u.id','=','patient_cradit_amounts.generated_by')
            ->where('patient_cradit_amounts.billing_id', $billId)
            ->get();

        if ($bill->section == 'EMG') {
            $section = 'EMERGENCY Patient';
        }else if ($bill->section == 'OPD') {
            $section = 'OPD - Out Patient';
        }else if ($bill->section == 'INVESTIGATION') {
            $section = 'Investigation';
        }
		if($bill->section == 'DAYCARE'){
			$newSection = 'Ipd';
            $model = "App\\Models\\".ucwords(strtolower($newSection))."Register";
        }elseif($bill->section == 'OT'){
            $newSection = $bill->section;
            $model = "App\\Models\\OtRegistration";
		}else{
            $newSection = $bill->section;
            $model = "App\\Models\\".ucwords(strtolower($newSection))."Register";
		}
        if($section == 'ipd'){
            $section_info = $model::select('ipd_registers.*','beds.bed_name','tpa.tpa_name')
                ->join('beds','beds.id','=','ipd_registers.bed_id')
                ->join('tpa_managements as tpa','tpa.id','=','ipd_registers.insurance_id')
                ->where('ipd_registers.id', $bill->section_id)
                ->first();
        }else{
            $section_info = $model::where('id', $bill->section_id)->first();
        }

        // $upbill = Billing::find($billId);
        // $upbill->edit_status = 1;
        // $upbill->update();

        $data = compact('bill', 'bill_info', 'header_image', 'patient_details', 'payment_details', 'cradit_details', 'section','section_info','doctor_info','unique_categories');
        // dd($data);
        return view('bill.print.print-bill')->with($data);
    }
    public function print_prescription($section, $bill_id,$type)
    {
        $billId = ed($bill_id, false);
        if($type == 'withheader'){
            $header_image = Header::where('header_name', 'bill')->first();
        }else{
            $header_image = null;
        }
        $bill = Billing::select('billings.*','u1.name as referred_name','u2.name as created_name')
            ->join('users as u2','u2.id','=','billings.created_by')
            ->leftjoin('users as u1','u1.id','=','billings.referred_by')
            ->where('billings.id',$billId)
            ->first();
        $doctor_info = User::where('id',$bill->doctor_id)->first();
        $patient_details = Patient::select('patients.*','s.name as state_name','d.name as district_name')
            ->leftjoin('states as s','s.id','=','patients.state')
            ->leftjoin('districts as d','d.id','=','patients.district')
            ->where('patients.id',$bill->patient_id)
            ->first();
        if($section == 'opd'){
            $token_no = OpdRegister::where('id',$bill->section_id)->first()->ticket_no;
        }else{
            $token_no = null;
        }
        $data = compact('bill', 'patient_details','doctor_info','token_no','header_image','section');
        return view('bill.print.print-prescription')->with($data);
    }
    public function print_addmission_form($section, $ipd_id,$type)
    {
        $ipd_id = ed($ipd_id, false);
        if($type == 'withheader'){
            $header_image = Header::where('header_name', 'opd_prescription')->first();
        }else{
            $header_image = null;
        }
        if($section == 'ipd'){
            $ipd_details = IpdRegister::select('ipd_registers.*','u1.name as doctor_name','u1.empId as doctor_registration_no','u1.salutation','u1.qualification','u1.experience','u1.specialization','u2.name as other_doctor_name','d.department_name','tpa.tpa_name','w.ward_name','b.bed_name','di.diagonasis_name')
                ->join('users as u1','u1.id','=','ipd_registers.doctor_id')
                ->leftjoin('users as u2','u2.id','=','ipd_registers.other_doctor_id')
                ->join('departments as d','d.id','=','ipd_registers.department_id')
                ->join('tpa_managements as tpa','tpa.id','=','ipd_registers.insurance_id')
                ->join('wards as w','w.id','=','ipd_registers.ward_id')
                ->join('beds as b','b.id','=','ipd_registers.bed_id')
                ->leftjoin('diagonases as di','di.id','=','ipd_registers.diagnosis_id')
                ->where('ipd_registers.id', $ipd_id)
                ->first();
        }else{
            $ipd_details = DialysisRegister::select('dialysis_registers.*','u1.name as doctor_name','u1.empId as doctor_registration_no','u1.salutation','u1.qualification','u1.experience','u1.specialization','d.department_name','tpa.tpa_name','w.ward_name','b.bed_name')
                ->join('users as u1','u1.id','=','dialysis_registers.doctor_id')
                ->join('departments as d','d.id','=','dialysis_registers.department_id')
                ->join('tpa_managements as tpa','tpa.id','=','dialysis_registers.insurance_id')
                ->join('wards as w','w.id','=','dialysis_registers.ward_id')
                ->join('beds as b','b.id','=','dialysis_registers.bed_id')
                ->where('dialysis_registers.id', $ipd_id)
                ->first();
        }
        $patient = Patient::select('patients.*','s.name as state_name','d.name as district_name')
            ->leftjoin('districts as d','d.id','=','patients.district')
            ->leftjoin('states as s','s.id','=','patients.state')
            ->where('patients.id', $ipd_details->patient_id)
            ->first();
        $data = compact('ipd_details','patient','header_image');
        // dd($data);
        return view('bill.print.print-addmission')->with($data);
    }
    public function print_discharge_summary($section, $section_id, $type)
    {
        if($section == 'daycare') {
            $section = 'ipd';
        }
        $section_id = ed($section_id, false);
        if($type == 'withheader'){
            $header_image = Header::where('header_name', 'discharge_summery')->first();
        }else{
            $header_image = null;
        }
        if($section == 'ipd') {
            $ipd_details = IpdRegister::select('ipd_registers.*','u1.name as doctor_name','u1.empId as doctor_registration_no','u1.salutation','u1.qualification','u1.experience','u1.specialization','u2.name as other_doctor_name','d.department_name','tpa.tpa_name','w.ward_name','b.bed_name','di.diagonasis_name')
                ->join('users as u1','u1.id','=','ipd_registers.doctor_id')
                ->leftjoin('users as u2','u2.id','=','ipd_registers.other_doctor_id')
                ->join('departments as d','d.id','=','ipd_registers.department_id')
                ->join('tpa_managements as tpa','tpa.id','=','ipd_registers.insurance_id')
                ->join('wards as w','w.id','=','ipd_registers.ward_id')
                ->join('beds as b','b.id','=','ipd_registers.bed_id')
                ->leftjoin('diagonases as di','di.id','=','ipd_registers.diagnosis_id')
                ->where('ipd_registers.id', $section_id)
                ->first();
        }else{
            $ipd_details = DialysisRegister::select('dialysis_registers.*','u1.name as doctor_name','u1.empId as doctor_registration_no','u1.salutation','u1.qualification','u1.experience','u1.specialization','d.department_name','tpa.tpa_name','w.ward_name','b.bed_name')
                ->join('users as u1','u1.id','=','dialysis_registers.doctor_id')
                ->join('departments as d','d.id','=','dialysis_registers.department_id')
                ->join('tpa_managements as tpa','tpa.id','=','dialysis_registers.insurance_id')
                ->join('wards as w','w.id','=','dialysis_registers.ward_id')
                ->join('beds as b','b.id','=','dialysis_registers.bed_id')
                ->where('dialysis_registers.id', $section_id)
                ->first();
        }
        $patient = Patient::select('patients.*','s.name as state_name','d.name as district_name')
            ->leftjoin('districts as d','d.id','=','patients.district')
            ->leftjoin('states as s','s.id','=','patients.state')
            ->where('patients.id', $ipd_details->patient_id)
            ->first();
        $discharge = DischargeReport::where('section', strtoupper($section))->where('section_id', $section_id)->first();
        $data = compact('ipd_details','patient','header_image','discharge','section');
        // dd($data);
        return view('bill.print.print-discharge')->with($data);
    }
    public function print_requisition($section, Request $request){
        $bill_master_details = Billing::select('billings.*','r.referral_name','u1.name')
            ->leftjoin('referrals as r', 'r.id', '=', 'billings.referred_by')
            ->leftjoin('users as u1', 'u1.id', '=', 'billings.created_by')
            ->where('billings.id',$request->bill_id)->first();
        $patient_details = Patient::select('patients.*','s.name as state_name','d.name as district_name')
            ->leftjoin('districts as d', 'd.id', '=', 'patients.district')
            ->leftjoin('states as s', 's.id', '=', 'patients.state')
            ->where('patients.id',$bill_master_details->patient_id)
            ->first();
        $bill_all_details = BillingDetail::whereIn('id',$request->bill_details_id)->get();
        $requisition_details = [];
        $ipd_details = null;
        if($bill_master_details->section == 'IPD' || $bill_master_details->section == 'DAYCARE'){
            $ipd_details = IpdRegister::select('ipd_registers.*','u1.name as doctor_name','b.bed_name')
                ->leftjoin('users as u1', 'u1.id', '=', 'ipd_registers.doctor_id')
                ->leftjoin('beds as b', 'b.id', '=', 'ipd_registers.bed_id')
                ->where('ipd_registers.id', $bill_master_details->section_id)
                ->first();
        }
        foreach ($bill_all_details as $key => $value) {
            $charge = Charge::where('id', $value->charge_id)->first();
            if ($charge) {
                // Extracting the relevant information
                $requisition_section_id = $charge->requisition_section_id;

                // Creating an array if it doesn't exist
                if (!isset($requisition_details[$requisition_section_id])) {
                    $requisition_details[$requisition_section_id] = array();
                }

                // Adding the investigation details to the corresponding array
                $requisition_details[$requisition_section_id][] = array(
                    'test_name' => $charge->charge_name,
                    'qty' => $value->qty,
                    'bill_created_date' => $value->date,
                    'charge_id' => $charge->id,
                );
            }
        }
        $header_image = Header::where('header_name', 'opd_prescription')->first();
        $back = route('bill.requisition', [$section, ed(@$request->bill_id, true)]);
        $data = compact('requisition_details','ipd_details','bill_master_details','header_image','patient_details','back');
        // dd($data);
        return view('bill.print.print-requisition', $data);
    }
    public function numberToWord($num = '')
    {
        $num    = (string) ((int) $num);

        if ((int) ($num) && ctype_digit($num)) {
            $words  = array();

            $num    = str_replace(array(',', ' '), '', trim($num));

            $list1  = array(
                '', 'one', 'two', 'three', 'four', 'five', 'six', 'seven',
                'eight', 'nine', 'ten', 'eleven', 'twelve', 'thirteen', 'fourteen',
                'fifteen', 'sixteen', 'seventeen', 'eighteen', 'nineteen'
            );

            $list2  = array(
                '', 'ten', 'twenty', 'thirty', 'forty', 'fifty', 'sixty',
                'seventy', 'eighty', 'ninety', 'hundred'
            );

            $list3  = array(
                '', 'thousand', 'million', 'billion', 'trillion',
                'quadrillion', 'quintillion', 'sextillion', 'septillion',
                'octillion', 'nonillion', 'decillion', 'undecillion',
                'duodecillion', 'tredecillion', 'quattuordecillion',
                'quindecillion', 'sexdecillion', 'septendecillion',
                'octodecillion', 'novemdecillion', 'vigintillion'
            );

            $num_length = strlen($num);
            $levels = (int) (($num_length + 2) / 3);
            $max_length = $levels * 3;
            $num    = substr('00' . $num, -$max_length);
            $num_levels = str_split($num, 3);

            foreach ($num_levels as $num_part) {
                $levels--;
                $hundreds   = (int) ($num_part / 100);
                $hundreds   = ($hundreds ? ' ' . $list1[$hundreds] . ' Hundred' . ($hundreds == 1 ? '' : 's') . ' ' : '');
                $tens       = (int) ($num_part % 100);
                $singles    = '';

                if ($tens < 20) {
                    $tens = ($tens ? ' ' . $list1[$tens] . ' ' : '');
                } else {
                    $tens = (int) ($tens / 10);
                    $tens = ' ' . $list2[$tens] . ' ';
                    $singles = (int) ($num_part % 10);
                    $singles = ' ' . $list1[$singles] . ' ';
                }
                $words[] = $hundreds . $tens . $singles . (($levels && (int) ($num_part)) ? ' ' . $list3[$levels] . ' ' : '');
            }
            $commas = count($words);
            if ($commas > 1) {
                $commas = $commas - 1;
            }

            $words  = implode(', ', $words);

            $words  = trim(str_replace(' ,', ',', ucwords($words)), ', ');
            if ($commas) {
                $words  = str_replace(',', ' and', $words);
            }

            return $words;
        } else if (!((int) $num)) {
            return 'Zero';
        }
        return '';
    }
    public function print_e_prescription($section, $bill_id, $type)
    {
        $billId = ed($bill_id, false);
        if ($type == 'withheader') {
            $header_image = Header::where('header_name', 'bill')->first();
        } else {
            $header_image = null;
        }
        $bill = Billing::select('billings.*', 'u1.name as referred_name', 'u2.name as created_name')
            ->join('users as u2', 'u2.id', '=', 'billings.created_by')
            ->leftjoin('users as u1', 'u1.id', '=', 'billings.referred_by')
            ->where('billings.id', $billId)
            ->first();
        $doctor_info = User::where('id', $bill->doctor_id)->first();
        $patient_details = Patient::select('patients.*', 's.name as state_name', 'd.name as district_name')
            ->leftjoin('states as s', 's.id', '=', 'patients.state')
            ->leftjoin('districts as d', 'd.id', '=', 'patients.district')
            ->where('patients.id', $bill->patient_id)
            ->first();
        $emr_details = EmrMaster::where('section', $section)->where('section_id', $bill->section_id)->first();
        if ($section == 'opd') {
            $token_no = OpdRegister::where('id', $bill->section_id)->first()->ticket_no;
        } else {
            $token_no = null;
        }
        $data = compact('bill', 'patient_details', 'doctor_info', 'token_no', 'header_image', 'section', 'emr_details');

        return view('bill.print.print-emrprescription')->with($data);
    }
}
