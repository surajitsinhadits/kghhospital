@extends('layouts.structure')
@push('title')
    <title>Investigation Bill</title>
@endpush

@push('css')
<style>
    .upload-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 30px;
        height: 30px;
        border-radius: 50%;
        background-color: #007bff;
        color: white;
        border: none;
        cursor: pointer;
        font-size: 20px;
        transition: 0.3s;
        float: right;
    }
    .upload-btn:hover { background-color: #0056b3; }
    input[type="file"] { display: none; }

    #loader-overlay {
        display: none;
        position: fixed;
        top: 0; left: 0;
        width: 100%; height: 100%;
        background: rgba(255,255,255,0.8);
        z-index: 9999;
        justify-content: center;
        align-items: center;
    }
    .spinner {
        border: 6px solid #f3f3f3;
        border-top: 6px solid #007bff;
        border-radius: 50%;
        width: 60px;
        height: 60px;
        animation: spin 1s linear infinite;
    }
    @keyframes spin { 100% { transform: rotate(360deg); } }
</style>
@endpush

@section('main-content')
<div class="row">
    <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12">
        <form action="{{Route('investigation.update-investigation-register')}}" method="POST" id="yourFormId">
            @csrf
            <input type="hidden" name="submit" id="activeSubmitValue" value="">

            <div class="row">
                <div class="col-xl-12 col-lg-12 col-md-12">
                    <div class="border-0">
                        <div class="tab-content">
                            <div class="tab-pane active" id="tab-7">
                                <div class="card">
                                    <div class="card-header card_hearder_mimi">
                                        <h4 class="card_hearder_mimi_text">INVESTIGATION BILL</h4>
                                    </div>

                                    <div class="card-body hospital_allcardbodydesign ">
                                        <div class="opdneedit">
                                            <div class="row">
                                                <div class="col-lg-12 ">
                                                    <div class="main-profile-contact-list ">
                                                        <div class="row">
                                                            <div class="form-group col-md-2 newaddappon">
                                                                <label class="date-format">Appointment Date <span class="text-danger">*</span></label>
                                                                <input type="text" class="dateTimePickr" name="appointment_date"
                                                                    value="{{ old('appointment_date', @$enq['appointment_date'] ? dateFor($enq['appointment_date'], true) : date('d-m-Y h:i A')) }}" required>
                                                                @error('appointment_date')
                                                                    <small class="text-danger">{{$message}}</small>
                                                                @enderror
                                                            </div>

                                                            <div class="form-group col-md-2 newaddappon">
                                                                <label for="cons_doctor">Consultant Doctor </label>
                                                                <select name="cons_doctor" class="form-control select2-show-search" id="cons_doctor">
                                                                    <option value="">Select Doctor</option>
                                                                    @foreach ($doctor as $doc)
                                                                        <option value="{{$doc->id}}" {{ old('cons_doctor', $enq->doctor_id ?? '') == $doc->id ? 'selected' : '' }}>
                                                                            {{$doc->salutation.' '.$doc->name}}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                                @error('cons_doctor')
                                                                    <small class="text-danger">{{$message}}</small>
                                                                @enderror
                                                            </div>

                                                            <div class="form-group col-md-1 newaddappon">
                                                                <label for="uhid">UHID</label>
                                                                <input type="text" tabindex="1" id="uhid"
                                                                    onkeyup="getPatient(this.value,'id')"
                                                                    class="text-capitalize"
                                                                    value="{{ old('uhid', @$enq->uhid) }}"
                                                                    name="uhid" autofocus="" readonly>
                                                                @error('uhid')
                                                                    <small class="text-danger">{{$message}}</small>
                                                                @enderror
                                                            </div>

                                                            <div class="form-group col-md-2 newaddappon">
                                                                <label for="patient_ph_no">Phone <span class="text-danger">*</span></label>
                                                                <input type="text" tabindex="2" id="patient_ph_no"
                                                                    onkeyup="getPatient(this.value,'phone')"
                                                                    value="{{ old('phone', @$enq->phone) }}"
                                                                    name="phone" maxlength="10"
                                                                    oninput="this.value = this.value.replace(/[^0-9]/g, '');"
                                                                    required>
                                                                @error('phone')
                                                                    <small class="text-danger">{{$message}}</small>
                                                                @enderror
                                                            </div>

                                                            <div class="form-group col-md-2 newaddappon">
                                                                <label for="name"> Patient's name <span class="text-danger">*</span></label>
                                                                <input type="text" tabindex="3" id="name" class="text-capitalize"
                                                                    value="{{ old('uhid', @$enq->name) }}"
                                                                    name="name" onkeyup="getPatient(this.value,'name')" required>
                                                                @error('name')
                                                                    <small class="text-danger">{{$message}}</small>
                                                                @enderror
                                                            </div>

                                                            <div class="form-group col-md-1 newaddappon">
                                                                <label for="gender">Gender <span class="text-danger">*</span></label>
                                                                <select tabindex="4" name="gender" class="form-control" id="gender" required>
                                                                    <option value="">Select Gender</option>
                                                                    <option value="Male" {{ old('gender', $enq->gender ?? '') == "Male" ? 'selected' : '' }}>Male</option>
                                                                    <option value="Female" {{ old('gender', $enq->gender ?? '') == "Female" ? 'selected' : '' }}>Female</option>
                                                                    <option value="Others" {{ old('gender', $enq->gender ?? '') == "Others" ? 'selected' : '' }}>Others</option>
                                                                </select>
                                                                @error('gender')
                                                                    <small class="text-danger">{{$message}}</small>
                                                                @enderror
                                                            </div>

                                                            <div class="form-group col-md-2">
                                                                <label for="aadhaar_card" style="margin: 0;line-height: 34px;">
                                                                    Aadhaar Card
                                                                    <label for="aadhaarFile" class="upload-btn">
                                                                        <i class="fa fa-upload"></i>
                                                                    </label>
                                                                    <input type="file" id="aadhaarFile" name="aadhaar_file" onchange="uploadAadhaar()">
                                                                </label>
                                                                <input type="text" tabindex="2" value="{{ old('aadhaar_card') }}"
                                                                    name="aadhaar_card" id="aadhaar_card" readonly
                                                                    oninput="this.value = this.value.replace(/[^0-9]/g, '');">
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            {{-- Search result --}}
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="card-body hospital_allcardbodydesign" style="display:none" id="search_result">
                                                        <div class="table-responsive">
                                                            <table class="table table-hover card-table table-vcenter text-nowrap border" style="background-color:#d9d9d9;border:1px solid black !important">
                                                                <thead class="text-white" style="background-color:#5e6545">
                                                                    <tr class="border-left">
                                                                        <th class="text-white">UHID</th>
                                                                        <th class="text-white">Patient Name</th>
                                                                        <th class="text-white">Age</th>
                                                                        <th class="text-white">Phone</th>
                                                                        <th class="text-white">Address</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody id="search_result_row"></tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="main-profile-bio mb-0">
                                                <div class="row">
                                                    <div class="form-group col-md-2 newdesignadd">
                                                        <label for="referred_by">Referred By <span class="text-danger">*</span></label>
                                                        <select name="referred_by" tabindex="5" class="form-control select2-show-search" id="referred_by" required>
                                                            <option value="">Select</option>
                                                            @foreach ($referral as $r)
                                                                <option value="{{$r->id}}">{{$r->referral_name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                    <div class="form-group col-md-1 newdesignadd">
                                                        <label for="provider">Provider</label>
                                                        <select name="provider" class="form-control select2-show-search" id="provider">
                                                            <option value="">Select</option>
                                                            @foreach ($provider as $p)
                                                                <option value="{{$p->id}}">{{$p->referral_name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                    <div class="form-group col-md-1 newdesignadd">
                                                        <label for="market_by">Market By</label>
                                                        <select name="market_by" class="form-control select2-show-search" id="market_by">
                                                            <option value="">Select</option>
                                                            @foreach ($market_by as $m)
                                                                <option value="{{$m->id}}">{{$m->referral_name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                    <div class="col-md-1 newdesignadd">
                                                        <label for="date_of_birth_year">Year</label>
                                                        <input type="text" tabindex="6" value="{{ old('date_of_birth_year', @$enq->dob_year) }}" id="date_of_birth_year" name="date_of_birth_year">
                                                        @error('date_of_birth_year') <small class="text-danger">{{$message}}</small> @enderror
                                                    </div>

                                                    <div class="col-md-1 newdesignadd">
                                                        <label for="date_of_birth_month"> Month</label>
                                                        <input type="text" tabindex="7" value="{{ old('date_of_birth_month', @$enq->dob_month) }}" id="date_of_birth_month" name="date_of_birth_month">
                                                        @error('date_of_birth_month') <small class="text-danger">{{$message}}</small> @enderror
                                                    </div>

                                                    <div class="col-md-1 newdesignadd">
                                                        <label for="date_of_birth_day"> Day</label>
                                                        <input type="text" tabindex="8" value="{{ old('date_of_birth_day', @$enq->dob_day) }}" id="date_of_birth_day" name="date_of_birth_day">
                                                        @error('date_of_birth_day') <small class="text-danger">{{$message}}</small> @enderror
                                                    </div>

                                                    <div class="form-group col-md-2" style="margin:25px 0px 0px 0px">
                                                        <label for="address">Address <span class="text-danger">*</span></label>
                                                        <input type="text" tabindex="9" id="address" value="{{ old('address', @$enq->address) }}" name="address" required>
                                                        @error('address') <small class="text-danger">{{$message}}</small> @enderror
                                                    </div>

                                                    <div class="form-group col-md-1" style="margin:23px 0px 0px 0px">
                                                        <label for="state">State <span class="text-danger">*</span></label>
                                                        <select name="state" tabindex="10" class="form-control select2-show-search" onchange="getDistrict(this.value)" id="state" required>
                                                            <option value="">Select State</option>
                                                            @foreach ($states as $s)
                                                                <option value="{{$s->id}}" {{$s->id == 35 ? 'selected' : ''}}>{{$s->name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                    <div class="form-group col-md-1" style="margin:23px 0px 0px 0px">
                                                        <label for="district">District </label>
                                                        <select name="district" tabindex="11" class="form-control select2-show-search" id="district">
                                                            <option value="">Select District</option>
                                                        </select>
                                                    </div>

                                                    <div class="form-group col-md-1" style="margin:25px 0px 0px 0px">
                                                        <label for="pin_no">Pin No.</label>
                                                        <input type="text" id="pin_no" tabindex="12" name="pin_no" value="{{ old('pin_no') }}">
                                                        @error('pin_no') <small class="text-danger">{{$message}}</small> @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Charges --}}
                                    <div class="table-responsive">
                                        <table class="table table-bordered border-left border-bottom border-right" id="data-table" style="width: 98%;margin-left:1%;">
                                            <thead class="bg-primary">
                                                <tr>
                                                    <th scope="col" style="width: 44%" class="text-white">Charge Name <span class="text-danger">*</span></th>
                                                    <th scope="col" style="width: 10%" class="text-white">Rate(₹) <span class="text-danger">*</span></th>
                                                    <th scope="col" style="width: 2%" class="text-white">#</th>
                                                    <th scope="col" style="width: 10%" class="text-white">Qty <span class="text-danger">*</span></th>
                                                    <th scope="col" style="width: 10%" class="text-white">Dis(%) <span class="text-danger">*</span></th>
                                                    <th scope="col" style="width: 10%" class="text-white">Dis Amount(₹) <span class="text-danger">*</span></th>
                                                    <th scope="col" style="width: 10%" class="text-white">Amount(₹) <span class="text-danger">*</span></th>
                                                    <th scope="col" style="width: 2%" class="text-white"></th>
                                                </tr>
                                            </thead>
                                            <tbody id="chargeTable">
                                                <tr id="row">
                                                    <td>
                                                        <select class="form-control select2-show-search" id="charge_name" onchange="getRateByCharge(this)" tabindex="13">
                                                            <option value="">Select</option>
                                                            @foreach ($charges as $ch)
                                                                <option value="{{$ch->id}}" data-amount="{{$ch->charge_amount}}">{{$ch->charge_name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                    <td><input class="form-control" id="rate" onkeyup="updateCalculations('')" value="0" /></td>
                                                    <td><button class="btn btn-success btn-sm" id="myInputbtn" tabindex="14" onclick="validation()" type="button"><i class="fa fa-plus"></i></button></td>
                                                    <td><input class="form-control" id="qty" onkeyup="updateCalculations('')" value="1" /></td>
                                                    <td><input class="form-control" onkeyup="updateCalculations('')" id="discount_in_per" value="0" /></td>
                                                    <td><input class="form-control" onkeyup="updateCalculations('')" id="discount_amount" value="0" /></td>
                                                    <td><input class="form-control" id="amount" value="0" /></td>
                                                    <td><button class="btn btn-success btn-sm" id="buttonId" onclick="validation()" type="button"><i class="fa fa-plus"></i></button></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        @error('charge_name')
                                            <span class="text-danger ml-4">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    {{-- Payment + totals --}}
                                    <div class="row" style="border: 1px solid #ebecf1;margin-left: 17px;margin-right: 10px;">
                                        <div class="col-md-5 border-right">
                                            <div class="table-responsive">
                                                <table class="table table-bordered text-nowrap">
                                                    <thead class="bg-primary text-white">
                                                        <tr>
                                                            <th scope="col" style="width: 20%" class="text-white">Date</th>
                                                            <th scope="col" style="width: 20%" class="text-white">Mode</th>
                                                            <th scope="col" style="width: 20%" class="text-white">Bank</th>
                                                            <th scope="col" style="width: 10%" class="text-white">Amount (₹)</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="chargeTable">
                                                        <tr>
                                                            <td><input type="text" name="payment_date[]" value="{{date('d-m-Y h:i A')}}" readonly></td>
                                                            <td>
                                                                <select class="form-control" name="payment_mode[]">
                                                                    <option value="Cash"> Cash</option>
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <input type="hidden" name="payment_bank[]" class="form-control">--
                                                            </td>
                                                            <td>
                                                                <input type="text" name="payment_amount[]" onkeyup="getPaymentTotal()" class="form-control">
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td><input type="text" name="payment_date[]" value="{{date('d-m-Y h:i A')}}" readonly></td>
                                                            <td>
                                                                <select class="form-control" name="payment_mode[]">
                                                                    <option value="UPI">UPI</option>
                                                                    <option value="Transfer to Bank Account">Transfer to Bank Account</option>
                                                                    <option value="Cheque">Cheque</option>
                                                                    <option value="Card">Card</option>
                                                                    <option value="Online">Online</option>
                                                                    <option value="Other">Other</option>
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <select class="form-control" name="payment_bank[]">
                                                                    <option value="Axis Bank">Axis Bank</option>
                                                                    <option value="Canara Bank">Canara Bank</option>
                                                                    <option value="State Bank">State Bank</option>
                                                                    <option value="RBL Bank">RBL Bank</option>
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <input type="text" name="payment_amount[]" onkeyup="getPaymentTotal()" class="form-control">
                                                                <input type="hidden" name="previous_payment_amount[]" id="previous_payment_amount" value="" readonly>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                        <div class="col-md-4 border-right">
                                            <div class="options mt-2">
                                                <div style="display: none" id="credit_amount_section">
                                                    <div class="table-responsive">
                                                        <table class="table card-table table-vcenter text-nowrap border">
                                                            <thead>
                                                                <tr class="bg-primary">
                                                                    <th class="text-white">Bill No</th>
                                                                    <th class="text-white">Amount</th>
                                                                    <th class="text-white">Adj. Amount</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody id="credit_amount_list"></tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="table-responsive">
                                                <table class="table table-bordered text-nowrap">
                                                    <tbody>
                                                        <tr>
                                                            <td class="text-right"><span style="font-size:16px;font-weight:600">Total</span></td>
                                                            <td></td>
                                                            <td><input class="form-control" name="total" readonly value="" id="total_am"></td>
                                                        </tr>
                                                        @php $discount = false; @endphp
                                                        @isok('DISCOUNT') @php $discount = true; @endphp @endisok
                                                        <tr>
                                                            <td class="text-right"><span style="font-size:16px;font-weight:600">Discount</span></td>
                                                            <td>
                                                                <select name="discount_type" onchange="gettotal()" id="discount_type" class="form-control">
                                                                    <option value="flat">Rs</option>
                                                                    <option value="percentage">%</option>
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <input class="form-control" name="total_discount" onkeyup="gettotal()" value="" id="total_discount" {{ $discount ? '' : 'readonly' }}>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="text-right"><span style="font-size:16px;font-weight:600">Grand Total</span></td>
                                                            <td></td>
                                                            <td><input class="form-control" name="grand_total" value="" readonly id="grnd_total"></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row" style="border: 1px solid #ebecf1;margin-left: 17px;margin-right: 10px;">
                                        <div class="col-md-12">
                                            <div class="row">
                                                <div class="col-md-8">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <label for="">Finance Remarks</label>
                                                            <textarea rows="3" name="finance_remark" class="form-control"></textarea>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label for="">Party/Department Remarks</label>
                                                            <textarea rows="3" name="department_party_remark" class="form-control"></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="table-responsive mt-2">
                                                        <table class="table table-bordered text-nowrap">
                                                            <tbody>
                                                                <tr style="background-color: rgb(219, 252, 198)">
                                                                    <td class="text-right">
                                                                        <span style="font-size:21px;font-weight:600">Total Pay (₹)</span>
                                                                    </td>
                                                                    <td>
                                                                        <input class="form-control" name="total_payment" readonly id="total_payment" value="">
                                                                    </td>
                                                                </tr>
                                                                <tr style="background-color: rgb(255, 208, 208)">
                                                                    <td class="text-right">
                                                                        <span style="font-size:21px;font-weight:600">Total Due (₹)</span>
                                                                    </td>
                                                                    <td>
                                                                        <input class="form-control" readonly id="total_due" value="">
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="modal-footer">
                                        <button class="btn btn-primary btn-sm submitBtn float-right" type="submit" name="submit" value="bill">
                                            <i class="fa fa-print"></i> Save & Bill Print
                                        </button>
                                    </div>

                                </div>{{-- card --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<div id="loader-overlay">
    <div class="spinner"></div>
</div>
@endsection

@push('js')
<script>
    /* =========================================================
       ✅ FIX for Investigation Bill:
       - patient suggestion click not working (same issue)
       - use event delegation instead of inline onclick
       - prevent blur hiding before click
       ========================================================= */

    let __selectingPatient = false;

    // ✅ district with optional selected value
    function getDistrict(state_id, dist_id = 0) {
        if (state_id) {
            $('#district').html('<option vaule="">Select District</option>');
            $.ajax({
                url: "{{Route('get-district')}}",
                type: "POST",
                data: {
                    _token: '{{ csrf_token() }}',
                    state_id: state_id,
                },
                success: function(response) {
                    if (response.success && (response.districts.length > 0)) {
                        $.each(response.districts, function(key, value) {
                            $('#district').append(
                                `<option value="${value.id}" ${dist_id == value.id ? 'selected' : ''}>${value.name}</option>`
                            );
                        });
                    }
                },
                error: function(error) { console.log(error); }
            });
        }
    }

    getDistrict(35);

    function getPatient(val, col) {
        var div_data = '';
        $('#search_result').attr('style', 'display:none', true);
        $('#search_result_row').html('');

        if (val && col) {
            $.ajax({
                url: "{{ route('opd.get-patients') }}",
                type: "POST",
                data: {
                    _token: '{{ csrf_token() }}',
                    field: col,
                    value: val,
                },
                success: function(response) {
                    if (response.success && (response.patients.length > 0)) {
                        $('#search_result').removeAttr('style', true);

                        $.each(response.patients, function(key, value) {
                            // ✅ Safe encode
                            let patientData = encodeURIComponent(JSON.stringify(value));
                            div_data += `
                                <tr class="color_hover_charnge patient-row"
                                    data-patient="${patientData}"
                                    style="cursor: pointer !important;">
                                    <td>${value.uhid || value.id}</td>
                                    <td>${value.name}</td>
                                    <td>${value.dob_year || 0}Y ${value.dob_month || 0}M ${value.dob_day || 0}D</td>
                                    <td>${value.phone}</td>
                                    <td>${value.address}</td>
                                </tr>
                            `;
                        });

                        $('#search_result_row').html(div_data);
                    }
                },
                error: function(error) { console.log(error); }
            });
        }
    }

    // ✅ important: rows are dynamic
    $(document).on('mousedown', '.patient-row', function() {
        __selectingPatient = true;
    });

    $(document).on('click', '.patient-row', function() {
        const patientData = $(this).data('patient');
        selectPatient(patientData);
        __selectingPatient = false;
    });

    function selectPatient(data) {
        let patient = JSON.parse(decodeURIComponent(data));

        $('#uhid').val(patient.id);
        $('#name').val(patient.name);
        $('#patient_ph_no').val(patient.phone);
        $('#gender').val(patient.gender).trigger('change');
        $('#date_of_birth_month').val(patient.dob_month);
        $('#date_of_birth_day').val(patient.dob_day);
        $('#date_of_birth_year').val(patient.dob_year);
        $('#address').val(patient.address);
        $('#pin_no').val(patient.pin_code);

        // ✅ if patient has state/district ids
        if (patient.state || patient.state_id) {
            $('#state').val(patient.state || patient.state_id).trigger('change');
            getDistrict(patient.state || patient.state_id, patient.district || patient.district_id || 0);
        }

        $('#search_result_row').html('');
        $('#search_result').attr('style', 'display:none', true);

        $.ajax({
            url: "{{Route('find-credit-amount')}}",
            type: "POST",
            data: {
                _token: '{{ csrf_token() }}',
                patient_id: patient.id,
            },
            success: function(response) {
                if (response.success && (response.results.length > 0)) {
                    $('#credit_amount_section').attr('style', 'display:block', true);
                    $('#credit_amount_list').html('');
                    $.each(response.results, function(key, value) {
                        $('#credit_amount_list').append(`<tr>
                            <td><input class="form-control" type="text" name="credit_bill[]" value="${value.uid}" readonly></td>
                            <td><input class="form-control" type="text" name="credit_amount[]" value="${value.cradit_amount}" readonly></td>
                            <td><input class="form-control adjust_credit_amount" type="number" max="${value.cradit_amount}"
                                oninput="this.value = this.value > this.max ? this.max : this.value"
                                name="adjust_credit_amount[]" onkeyup="getPaymentTotal()"></td>
                        </tr>`);
                    });
                } else {
                    $('#credit_amount_section').attr('style', 'display:none', true);
                }
            },
            error: function(error) { console.log(error); }
        });
    }

    // ✅ stop blur hiding when clicking on suggestion
    $('#patient_ph_no, #name').on('blur', function() {
        setTimeout(function() {
            if (!__selectingPatient) $('#search_result').hide();
        }, 200);
    });

    /* ======= Your existing billing logic (unchanged) ======= */

    function validation() {
        var chargeSelect = $('#charge_name');
        var selectedOption = chargeSelect.find('option:selected');
        var chargeValue = selectedOption.val();
        var rateValue = $('#rate').val();
        var qtyValue = $('#qty').val();

        if (qtyValue == '') {
            toastr.error("Please Enter QTY !!!");
        } else if (rateValue == '') {
            toastr.error("Please Enter Rate !!!");
        } else if (chargeValue == '') {
            toastr.error("Please Select Charge Name !!!");
        } else {
            addNewrow();
        }
    }

    function addNewrow() {
        var table = document.getElementById("data-table");
        var newRow = table.insertRow(table.rows.length);
        newRow.style.backgroundColor = "#d5ffe8";
        var table_id = table.rows.length;

        var chargeSelect = $('#charge_name');
        var selectedOption = chargeSelect.find('option:selected');

        var chargeValue = selectedOption.val();
        var chargeText = selectedOption.text();

        var rateValue = $('#rate').val();
        var qtyValue = $('#qty').val();
        var discountInPerValue = $('#discount_in_per').val();
        var discountAmountValue = $('#discount_amount').val();
        var amountValue = $('#amount').val();

        var cell1 = newRow.insertCell(0);
        var cell2 = newRow.insertCell(1);
        var cell3 = newRow.insertCell(2);
        var cell4 = newRow.insertCell(3);
        var cell5 = newRow.insertCell(4);
        var cell6 = newRow.insertCell(5);
        var cell7 = newRow.insertCell(6);
        var cell8 = newRow.insertCell(7);

        cell1.innerHTML = '<select class="form-control" style="background-color: #e9e9eb;" name="charge_name[]"><option value="' + chargeValue + '">' + chargeText + '</option></select>';
        cell2.innerHTML = '<input type="text" name="rate[]" onkeyup="updateCalculations(' + table_id + ')" id="rate' + table_id + '" class="form-control" value="' + rateValue + '">';
        cell3.innerHTML = '';
        cell4.innerHTML = '<input type="text" name="qty[]" onkeyup="updateCalculations(' + table_id + ')" id="qty' + table_id + '" class="form-control" value="' + qtyValue + '">';
        cell5.innerHTML = '<input type="text" name="discount_in_per[]" onkeyup="updateCalculations(' + table_id + ')" id="discount_in_per' + table_id + '" class="form-control" value="' + discountInPerValue + '">';
        cell6.innerHTML = '<input type="text" name="discount_amount[]" onkeyup="updateCalculations(' + table_id + ')" id="discount_amount' + table_id + '" class="form-control" value="' + discountAmountValue + '">';
        cell7.innerHTML = '<input type="text" name="amount[]" id="amount' + table_id + '" readonly class="form-control" value="' + amountValue + '">';
        cell8.innerHTML = '<button type="button" class="btn btn-danger btn-sm" onclick="removeRow(this)">X</button>';

        const selectElement = document.getElementById("charge_name");
        selectElement.selectedIndex = 0;
        $('#charge_name').val('').trigger('change');
        $('#rate').val(0);
        $('#qty').val(1);
        $('#discount_in_per').val(0);
        $('#discount_amount').val(0);
        $('#amount').val(0);

        gettotal();
        $('#myInputbtn').prop('autofocus', false);
        $('#charge_name').prop('autofocus', true);
    }

    function removeRow(button) {
        var table = document.getElementById("data-table");
        var row = button.parentNode.parentNode;
        table.deleteRow(row.rowIndex);
        gettotal();
    }

    function getRateByCharge(selectElement) {
        let chargeAmount = selectElement.options[selectElement.selectedIndex].getAttribute("data-amount");
        $('#rate').val(chargeAmount == '' ? 0 : chargeAmount);
        updateCalculations('');
    }

    function updateCalculations(row_id) {
        const rateInput = $('#rate' + row_id).val();
        const qtyInput = $('#qty' + row_id).val();
        const discountInPerInput = $('#discount_in_per' + row_id).val();
        const discountAmountInput = $('#discount_amount' + row_id).val();

        let discountAmount = 0;
        const rate = parseFloat(rateInput) || 0;
        const qty = parseFloat(qtyInput) || 0;
        const discountInPer = parseFloat(discountInPerInput) || 0;
        const discountInAmount = parseFloat(discountAmountInput) || 0;

        // ✅ (fixed condition logic)
        if (discountInPer > 0) {
            discountAmount = (rate * qty * discountInPer) / 100;
        } else if (discountInAmount > 0) {
            discountAmount = discountInAmount;
        }

        const amount = (rate * qty) - discountAmount;
        $('#amount' + row_id).val(amount.toFixed(2));
        gettotal();
    }

    function gettotal() {
        var t = 0;
        $("input[name='amount[]']").each(function() {
            t += parseFloat($(this).val()) || 0;
        });

        $('#total_am').val(t.toFixed(2));

        var total_discount = parseFloat($('#total_discount').val() || 0);
        var discountType = $('#discount_type').val();

        var grnd_total = t;
        if (discountType === 'percentage') {
            grnd_total = t - (t * (total_discount / 100));
        } else {
            grnd_total = t - total_discount;
        }

        $('#grnd_total').val(parseInt(grnd_total || 0));
        getPaymentTotal();
    }

    function getPaymentTotal() {
        var rt = 0;
        var previous_recpt_amount = 0;
        var new_recept_amount = 0;

        $("input[name='payment_amount[]']").each(function() {
            new_recept_amount += parseFloat($(this).val()) || 0;
        });

        $("input[name='rcpt_amount[]']").each(function() {
            previous_recpt_amount += parseFloat($(this).val()) || 0;
        });

        $("input[name='adjust_credit_amount[]']").each(function() {
            rt += parseFloat($(this).val()) || 0;
        });

        var totalss = (parseFloat(new_recept_amount) + parseFloat(previous_recpt_amount) + parseFloat(rt));
        var grnd_total = parseFloat($('#grnd_total').val() || 0);
        var previous_credit_used = parseFloat($('#previous_credit_used').val() || 0);

        var due_amnt = 0;
        if (grnd_total > totalss) {
            due_amnt = parseFloat((grnd_total + previous_credit_used) - totalss);
        }

        $('#total_payment').val(parseInt(totalss || 0));
        $('#total_due').val(parseInt(due_amnt || 0));
    }
</script>

<script>
    $(document).ready(function() {
        let isFormSubmitting = false;
        let lastClickedSubmitButton = null;
        const $submitValueInput = $('#activeSubmitValue');
        const defaultSubmitValue = $('.submitBtn').first().val() || '';
        if (!$submitValueInput.val().trim()) {
            $submitValueInput.val(defaultSubmitValue);
        }

        $('.submitBtn').on('click', function() {
            lastClickedSubmitButton = $(this);
            $submitValueInput.val($(this).val());
        });

        function isRequired($input) { return $input.prop('required'); }

        function validatePhone() {
            let $input = $('#patient_ph_no');
            let phone = $input.val();
            if (isRequired($input) && phone.length === 0) {
                $input.addClass('is-invalid').css('border-color', '#dc3545');
                return false;
            } else if (phone.length > 0 && !/^\d{10}$/.test(phone)) {
                $input.addClass('is-invalid').css('border-color', '#dc3545');
                return false;
            } else {
                $input.removeClass('is-invalid').css('border-color', '#007bff');
                return true;
            }
        }

        function validateName() {
            let $input = $('#name');
            let name = $input.val();
            if (isRequired($input) && name.trim().length === 0) {
                $input.addClass('is-invalid').css('border-color', '#dc3545');
                return false;
            }
            if (name.trim().length > 0 && !/^[A-Za-z\s]+$/.test(name)) {
                $input.addClass('is-invalid').css('border-color', '#dc3545');
                return false;
            }
            $input.removeClass('is-invalid').css('border-color', '#007bff');
            return true;
        }

        $('#name').on('input', function() {
            this.value = this.value.replace(/[^A-Za-z\s]/g, '');
        });

        function validateAddress() {
            var $input = $('#address');
            var address = $input.val();
            var regex = /^[a-zA-Z0-9\s,.-]*$/;
            if (isRequired($input) && address.trim().length === 0) {
                $input.addClass('is-invalid').css('border-color', '#dc3545');
                return false;
            } else if (address.trim().length > 0 && !regex.test(address)) {
                $input.addClass('is-invalid').css('border-color', '#dc3545');
                return false;
            } else {
                $input.removeClass('is-invalid').css('border-color', '#007bff');
                return true;
            }
        }

        function validateYear() {
            var $input = $('#date_of_birth_year');
            var year = $input.val();
            if (isRequired($input) && year.length === 0) {
                $input.addClass('is-invalid').css('border-color', '#dc3545');
                return false;
            } else if (year.length > 0 && !/^\d+$/.test(year)) {
                $input.addClass('is-invalid').css('border-color', '#dc3545');
                return false;
            } else {
                $input.removeClass('is-invalid').css('border-color', '#007bff');
                return true;
            }
        }

        function validateMonth() {
            var $input = $('#date_of_birth_month');
            var month = $input.val();
            if (isRequired($input) && month.length === 0) {
                $input.addClass('is-invalid').css('border-color', '#dc3545');
                return false;
            } else if (month.length > 0 && !/^\d+$/.test(month)) {
                $input.addClass('is-invalid').css('border-color', '#dc3545');
                return false;
            } else {
                $input.removeClass('is-invalid').css('border-color', '#007bff');
                return true;
            }
        }

        function validateDay() {
            var $input = $('#date_of_birth_day');
            var day = $input.val();
            if (isRequired($input) && day.length === 0) {
                $input.addClass('is-invalid').css('border-color', '#dc3545');
                return false;
            } else if (day.length > 0 && !/^\d+$/.test(day)) {
                $input.addClass('is-invalid').css('border-color', '#dc3545');
                return false;
            } else {
                $input.removeClass('is-invalid').css('border-color', '#007bff');
                return true;
            }
        }

        function validatePin() {
            var $input = $('#pin_no');
            var pin = $input.val();
            if (pin.length > 0 && !/^\d{6}$/.test(pin)) {
                $input.addClass('is-invalid').css('border-color', '#dc3545');
                return false;
            } else {
                $input.removeClass('is-invalid').css('border-color', '#007bff');
                return true;
            }
        }

        function validatePaymentAmount(selector) {
            var $input = $(selector);
            var val = $input.val();
            if (isRequired($input) && val.length === 0) {
                $input.addClass('is-invalid').css('border-color', '#dc3545');
                return false;
            } else if (val.length > 0 && !/^\d+(\.\d{1,2})?$/.test(val)) {
                $input.addClass('is-invalid').css('border-color', '#dc3545');
                return false;
            } else {
                $input.removeClass('is-invalid').css('border-color', '#007bff');
                return true;
            }
        }

        function validateNumericField(selector) {
            var $input = $(selector);
            var val = $input.val();
            if (isRequired($input) && val.length === 0) {
                $input.addClass('is-invalid').css('border-color', '#dc3545');
                return false;
            } else if (val.length > 0 && !/^\d+(\.\d{1,2})?$/.test(val)) {
                $input.addClass('is-invalid').css('border-color', '#dc3545');
                return false;
            } else {
                $input.removeClass('is-invalid').css('border-color', '#007bff');
                return true;
            }
        }

        function validateIntegerField(selector) {
            var $input = $(selector);
            var val = $input.val();
            if (isRequired($input) && val.length === 0) {
                $input.addClass('is-invalid').css('border-color', '#dc3545');
                return false;
            } else if (val.length > 0 && !/^\d+$/.test(val)) {
                $input.addClass('is-invalid').css('border-color', '#dc3545');
                return false;
            } else {
                $input.removeClass('is-invalid').css('border-color', '#007bff');
                return true;
            }
        }

        function validateTotalDiscount() {
            var $input = $('#total_discount');
            var val = $input.val();
            if (isRequired($input) && val.length === 0) {
                $input.addClass('is-invalid').css('border-color', '#dc3545');
                return false;
            } else if (val.length > 0 && !/^\d+(\.\d{1,2})?$/.test(val)) {
                $input.addClass('is-invalid').css('border-color', '#dc3545');
                return false;
            } else {
                $input.removeClass('is-invalid').css('border-color', '#007bff');
                return true;
            }
        }

        $('#patient_ph_no, #date_of_birth_year, #date_of_birth_month, #date_of_birth_day, #pin_no, #discount_in_per, #discount_amount')
            .on('input', function() { this.value = this.value.replace(/[^0-9]/g, ''); });

        $('#bank_payment, input[name="payment_amount[]"], #rate, #qty, #amount, #total_discount')
            .on('input', function() {
                this.value = this.value.replace(/[^0-9.]/g, '');
                if ((this.value.match(/\./g) || []).length > 1) {
                    this.value = this.value.replace(/\.+$/, "");
                }
            });

        $('#patient_ph_no').on('input', validatePhone);
        $('#name').on('input', validateName);
        $('#address').on('input', validateAddress);
        $('#date_of_birth_year').on('input', validateYear);
        $('#date_of_birth_month').on('input', validateMonth);
        $('#date_of_birth_day').on('input', validateDay);
        $('#pin_no').on('input', validatePin);

        $('input[name="payment_amount[]"]').on('input', function() { validatePaymentAmount(this); });
        $('#rate').on('input', function() { validateNumericField('#rate'); });
        $('#qty').on('input', function() { validateNumericField('#qty'); });
        $('#amount').on('input', function() { validateNumericField('#amount'); });
        $('#discount_in_per').on('input', function() { validateIntegerField('#discount_in_per'); });
        $('#discount_amount').on('input', function() { validateIntegerField('#discount_amount'); });
        $('#total_discount').on('input', validateTotalDiscount);

        $('#yourFormId').on('submit', function(e) {
            if (isFormSubmitting) { e.preventDefault(); return false; }

            const chargeRowCount = $('select[name="charge_name[]"]').length;
            if (chargeRowCount === 0) {
                e.preventDefault();
                if (typeof toastr !== 'undefined') toastr.error('Please add at least one charge row.');
                else alert('Please add at least one charge row.');
                return false;
            }

            let valid = true;
            if (!validatePhone()) valid = false;
            if (!validateName()) valid = false;
            if (!validateAddress()) valid = false;
            if (!validateYear()) valid = false;
            if (!validateMonth()) valid = false;
            if (!validateDay()) valid = false;
            if (!validatePin()) valid = false;
            $('input[name="payment_amount[]"]').each(function() { if (!validatePaymentAmount(this)) valid = false; });
            if (!validateNumericField('#rate')) valid = false;
            if (!validateNumericField('#qty')) valid = false;
            if (!validateIntegerField('#discount_in_per')) valid = false;
            if (!validateIntegerField('#discount_amount')) valid = false;
            if (!validateNumericField('#amount')) valid = false;
            if (!validateTotalDiscount()) valid = false;

            if (!valid) {
                e.preventDefault();
                if (typeof toastr !== 'undefined') toastr.error('Please fix validation errors before submitting.');
                else alert('Please fix validation errors before submitting.');
                return false;
            }

            isFormSubmitting = true;
            const $activeSubmitBtn = lastClickedSubmitButton && lastClickedSubmitButton.length ? lastClickedSubmitButton : $('.submitBtn').first();
            if ($activeSubmitBtn.length) {
                const originalHtml = $activeSubmitBtn.data('original-html') || $activeSubmitBtn.html();
                $activeSubmitBtn.data('original-html', originalHtml);
                $activeSubmitBtn.html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Submitting...');
            }
            $('.submitBtn').prop('disabled', true);
        });
    });

    async function uploadAadhaar() {
        const input = document.getElementById('aadhaarFile');
        const file = input.files[0];
        if (!file) return;

        const formData = new FormData();
        formData.append('aadhaar_file', file);

        document.getElementById('loader-overlay').style.display = 'flex';

        try {
            const response = await fetch("{{ url('/opd/update-aadhaar-card') }}", {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: formData
            });

            const data = await response.json();

            if (data.success) {
                var f_data = data.data.data;

                $('#aadhaar_card').val(f_data.aadhaarNumber);
                $('#address').val(f_data.address ? f_data.address : '');
                $('#gender').val(f_data.gender ? f_data.gender : '');
                $('#name').val(f_data.name ? f_data.name : '');
                $('#pin_no').val(f_data.pincode ? f_data.pincode : '');

                if (f_data.dob) {
                    let dob = f_data.dob.split('/');
                    dob = new Date(dob[2], dob[1] - 1, dob[0]);
                    let today = new Date();

                    var years = today.getFullYear() - dob.getFullYear();
                    var months = today.getMonth() - dob.getMonth();
                    var days = today.getDate() - dob.getDate();

                    if (days < 0) {
                        months--;
                        var prevMonth = new Date(today.getFullYear(), today.getMonth(), 0);
                        days += prevMonth.getDate();
                    }
                    if (months < 0) {
                        years--;
                        months += 12;
                    }

                    $('#date_of_birth_year').val(years);
                    $('#date_of_birth_month').val(months);
                    $('#date_of_birth_day').val(days);
                } else {
                    $('#date_of_birth_year').val('');
                    $('#date_of_birth_month').val('');
                    $('#date_of_birth_day').val('');
                }

                getPatient(f_data.aadhaarNumber, 'identification_number');
            } else {
                alert("❌ Upload failed!");
            }
        } catch (error) {
            alert("⚠️ Error uploading file.");
        } finally {
            document.getElementById('loader-overlay').style.display = 'none';
        }
    }
</script>
@endpush
