@extends('layouts.structure')
@push('title')
    <title>Medicine Billing</title>
@endpush
@push('css')
@endpush
@section('main-content')
    <div class="row">
        <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12">
            <form action="{{ route('pharmacy.save-billing') }}" method="POST" id="yourFormId" onsubmit="return checkTest()">
                @csrf

                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12">
                        <div class="border-0">
                            <div class="tab-content">
                                <div class="tab-pane active" id="tab-7">
                                    <div class="card">
                                        <div class="card-header card_hearder_mimi">
                                            <h4 class="card_hearder_mimi_text">MEDICINE BILLING</h4>
                                        </div>
                                        <div class="card-body hospital_allcardbodydesign ">
                                            <div class="opdneedit">
                                                <div class="row">
                                                    <div class="col-lg-12 ">
                                                        <div class="main-profile-contact-list ">
                                                            <div class="row">
                                                                <div class="form-group col-md-2 newaddappon">
                                                                    <label class="date-format">Date <span
                                                                            class="text-danger">*</span></label>
                                                                    <input type="text" class="dateTimePickr"
                                                                        name="date"
                                                                        value="{{ old('date', date('d-m-Y h:i A')) }}"
                                                                        required>
                                                                    @error('date')
                                                                        <small class="text-danger">{{ $message }}</small>
                                                                    @enderror
                                                                </div>

                                                                <div class="form-group col-md-2 newaddappon">
                                                                    <label for="cons_doctor">Consultant Doctor <span
                                                                            class="text-danger">*</span></label>
                                                                    <select name="cons_doctor"
                                                                        class="form-control select2-show-search"
                                                                        id="cons_doctor" required>
                                                                        <option value="">Select Doctor</option>
                                                                        @foreach ($doctor as $doc)
                                                                            <option value="{{ $doc->id }}"
                                                                                {{ old('cons_doctor') == $doc->id ? 'selected' : '' }}>
                                                                                {{ $doc->salutation . ' ' . $doc->name }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                    @error('cons_doctor')
                                                                        <small class="text-danger">{{ $message }}</small>
                                                                    @enderror
                                                                </div>
                                                                <div class="form-group col-md-2 newaddappon">
                                                                    <label for="uhid">UHID</label>
                                                                    <input type="text" id="uhid"
                                                                        onkeyup="getPatient(this.value,'id')"
                                                                        class="text-capitalize" value="{{ old('uhid') }}"
                                                                        name="uhid" autofocus="">
                                                                    @error('uhid')
                                                                        <small class="text-danger">{{ $message }}</small>
                                                                    @enderror
                                                                </div>
                                                                <div class="form-group col-md-2 newaddappon">
                                                                    <label for="patient_ph_no">Phone <span
                                                                            class="text-danger">*</span></label>
                                                                    <input type="text" id="patient_ph_no"
                                                                        onkeyup="getPatient(this.value,'phone')"
                                                                        value="{{ old('phone') }}" name="phone"
                                                                        maxlength="10"
                                                                        oninput="this.value = this.value.replace(/[^0-9]/g, '');"
                                                                        required>
                                                                    @error('phone')
                                                                        <small class="text-danger">{{ $message }}</small>
                                                                    @enderror
                                                                </div>
                                                                <div class="form-group col-md-2 newaddappon">
                                                                    <label for="name"> Patient's name <span
                                                                            class="text-danger">*</span></label>
                                                                    <input type="text" id="name"
                                                                        class="text-capitalize" value="{{ old('uhid') }}"
                                                                        name="name"
                                                                        onkeyup="getPatient(this.value,'name')" required>
                                                                    @error('name')
                                                                        <small class="text-danger">{{ $message }}</small>
                                                                    @enderror
                                                                </div>
                                                                <div class="form-group col-md-2 newaddappon">
                                                                    <label for="gender">Gender <span
                                                                            class="text-danger">*</span></label>
                                                                    <select name="gender" class="form-control"
                                                                        id="gender" required>
                                                                        <option value="">Select Gender</option>
                                                                        <option value="Male"
                                                                            {{ old('gender') == 'Male' ? 'selected' : '' }}>
                                                                            Male</option>
                                                                        <option value="Female"
                                                                            {{ old('gender') == 'Female' ? 'selected' : '' }}>
                                                                            Female</option>
                                                                        <option value="Others"
                                                                            {{ old('gender') == 'Others' ? 'selected' : '' }}>
                                                                            Others</option>
                                                                    </select>
                                                                    @error('gender')
                                                                        <small class="text-danger">{{ $message }}</small>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="card-body hospital_allcardbodydesign"
                                                            style="display:none" id="search_result">
                                                            <div class="">
                                                                <div class="table-responsive">
                                                                    <table
                                                                        class="table table-hover card-table table-vcenter text-nowrap border"
                                                                        style="background-color:#d9d9d9;border:1px solid black !important">
                                                                        <thead class="text-white"
                                                                            style="background-color:#5e6545">
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
                                                </div>
                                                <div class="main-profile-bio mb-0">
                                                    <div class="row">

                                                        <div class="col-md-1 newdesignadd">
                                                            <label for="date_of_birth_year">Year</label>
                                                            <input type="text" value="{{ old('date_of_birth_year') }}"
                                                                id="date_of_birth_year" name="date_of_birth_year"
                                                                tabindex="6">
                                                            @error('date_of_birth_year')
                                                                <small class="text-danger">{{ $message }}</small>
                                                            @enderror
                                                        </div>
                                                        <div class="col-md-1 newdesignadd">
                                                            <label for="date_of_birth_month"> Month</label>
                                                            <input type="text"
                                                                value="{{ old('date_of_birth_month') }}"
                                                                id="date_of_birth_month" name="date_of_birth_month"
                                                                tabindex="7">
                                                            @error('date_of_birth_month')
                                                                <small class="text-danger">{{ $message }}</small>
                                                            @enderror
                                                        </div>
                                                        <div class="col-md-1 newdesignadd">
                                                            <label for="date_of_birth_day"> Day</label>
                                                            <input type="text" value="{{ old('date_of_birth_day') }}"
                                                                id="date_of_birth_day" name="date_of_birth_day"
                                                                tabindex="8">
                                                            @error('date_of_birth_day')
                                                                <small class="text-danger">{{ $message }}</small>
                                                            @enderror
                                                        </div>
                                                        <div class="form-group col-md-2" style="margin:25px 0px 0px 0px">
                                                            <label for="address">Address <span
                                                                    class="text-danger">*</span></label>
                                                            <input type="text" id="address"
                                                                value="{{ old('address') }}" name="address"
                                                                tabindex="9" required>
                                                            @error('address')
                                                                <small class="text-danger">{{ $message }}</small>
                                                            @enderror
                                                        </div>
                                                        <div class="form-group col-md-2" style="margin:23px 0px 0px 0px">
                                                            <label for="state">State <span
                                                                    class="text-danger">*</span></label>
                                                            <select name="state"
                                                                class="form-control select2-show-search"
                                                                onchange="getDistrict(this.value)" id="state"
                                                                required>
                                                                <option value="">Select State</option>
                                                                @foreach ($states as $s)
                                                                    <option value="{{ $s->id }}"
                                                                        {{ $s->id == 35 ? 'selected' : '' }}>
                                                                        {{ $s->name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="form-group col-md-2" style="margin:23px 0px 0px 0px">
                                                            <label for="district">District </label>
                                                            <select name="district"
                                                                class="form-control select2-show-search" id="district">
                                                                <option value="">Select District</option>
                                                            </select>
                                                        </div>
                                                        <div class="form-group col-md-2" style="margin:25px 0px 0px 0px">
                                                            <label for="pin_no">Pin No.</label>
                                                            <input type="text" id="pin_no" name="pin_no"
                                                                value="{{ old('pin_no') }}" tabindex="12">
                                                            @error('pin_no')
                                                                <small class="text-danger">{{ $message }}</small>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="table-responsive">
                                            <table class="table table-bordered border-left border-bottom border-right"
                                                id="data-table" style="width: 98%;margin-left:1%;">
                                                <thead class="bg-primary">
                                                    <tr>
                                                        {{-- <th scope="col"  class="text-white">Date</th> --}}
                                                        <th style="width: 13%" class="text-white">Med Category</th>
                                                        <th style="width: 11%" class="text-white">Med Name</th>
                                                        <th style="width: 10%" class="text-white">B. No</th>
                                                        <th style="width: 10%" class="text-white">Exp Dt</th>
                                                        <th style="width: 5%" class="text-white">Unit Qty</th>
                                                        <th style="width: 6%" class="text-white">Unit</th>
                                                        <th style="width: 5%" class="text-white">Sub Unit Qty</th>
                                                        <th style="width: 6%" class="text-white">Sub Unit</th>
                                                        <th style="width: 8%" class="text-white">Avi Qty</th>
                                                        <th style="width: 2%" class="text-white">#</th>
                                                        <th style="width: 7%" class="text-white">Mrp</th>
                                                        <th style="width: 7%" class="text-white">Dis(%)</th>
                                                        <th style="width: 8%" class="text-white">Amount(₹)</th>
                                                        <th style="width: 2%" style="width: 2%" class="text-white">#</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="chargeTable">
                                                    <tr id="row">
                                                        <td>
                                                            <select class="form-control select2-show-search"
                                                                id="medicine_category"
                                                                onchange="getMedicinesByCategory(this.value)"
                                                                tabindex="13">
                                                                <option value="">Select Category.....</option>
                                                                @if (isset($medicine_category))
                                                                    @foreach ($medicine_category as $key => $value)
                                                                        <option value="{{ $value->id }}">
                                                                            {{ $value->medicine_catagory_name }}</option>
                                                                    @endforeach
                                                                @endif
                                                            </select>
                                                            <input class="form-control" type="hidden" id="unit_details"
                                                                readonly />

                                                        </td>


                                                        <td>
                                                            <select class="form-control select2-show-search"
                                                                id="medicine_name"
                                                                onchange="getMedicineBatchDetails(this.value)"
                                                                tabindex="13">
                                                                <option value="">Select One.....</option>


                                                            </select>

                                                        </td>
                                                        <td>
                                                            <select class="form-control select2-show-search"
                                                                onchange="getMedicineDetailsbyBatch(this.value)"
                                                                id="medicine_batch">
                                                                <option value="">Select One...</option>
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <input type="text" readonly id="expiry_date"
                                                                class="form-control" />
                                                        </td>
                                                        <td><input type="text" value="0" id="unit_qty"
                                                                class="form-control" onkeyup="getamount()">
                                                        </td>
                                                        <td><input type="text" readonly value=""
                                                                class="form-control" id="unit"></td>
                                                        <td><input type="text" value="0" id="sub_unit_qty"
                                                                class="form-control" onkeyup="getamount()">
                                                        </td>
                                                        <td><input type="text" readonly value=""
                                                                class="form-control" id="sub_unit">
                                                        </td>

                                                        <td>
                                                            <input type="text" readonly id="avi_qty"
                                                                class="form-control avlqty_text" />
                                                            <input type="hidden" readonly id="total_stock_qty"
                                                                class="form-control avlqty_text" />
                                                        </td>
                                                        <td>
                                                            <button class="btn btn-success btn-sm" onclick="validation()"
                                                                type="button" id="myInputbtn"><i
                                                                    class="fa fa-plus"></i></button>
                                                        </td>
                                                        <td><input readonly id="mrp" class="form-control"
                                                                type="text" value="0"></td>
                                                        <td>
                                                            <input type="text" class="form-control"
                                                                onkeyup="getamount()" id="discount" value="0" />
                                                        </td>


                                                        <td>
                                                            <input class="form-control" readonly id="amount"
                                                                type="text" value="0" />
                                                        </td>

                                                        <td>
                                                            <button class="btn btn-success btn-sm" onclick="validation()"
                                                                type="button" id="buttonId"><i
                                                                    class="fa fa-plus"></i></button>
                                                        </td>
                                                    </tr>


                                                </tbody>
                                            </table>
                                            @error('medicine_name')
                                                <span class="text-danger ml-4">{{ $message }}</span>
                                            @enderror
                                        </div>


                                        <div class="col-md-12" style="padding: 0px 17px 0px 11px;">
                                            <div class="row">
                                                <div class="col-md-6">
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="row">
                                                        <div class="table-responsive">
                                                            <table class="table table-bordered text-nowrap">
                                                                <tr>
                                                                    <td class="text-right">
                                                                        <span
                                                                            style="font-size:17px;font-weight:600">Total</span>
                                                                    </td>
                                                                    <td></td>
                                                                    <td>
                                                                        <input class="form-control" readonly
                                                                            name="sub_total" id="sub_total"
                                                                            value="0" />
                                                                    </td>
                                                                </tr>


                                                                <tr>
                                                                    <td class="text-right">
                                                                        <span
                                                                            style="font-size:16px;font-weight:600">Discount</span>
                                                                    </td>
                                                                    <td>
                                                                        <select name="discount_type" onchange="gettotal()"
                                                                            id="discount_type" class="form-control">
                                                                            <option value="flat">Rs</option>
                                                                            <option value="percentage">%</option>
                                                                        </select>
                                                                    </td>
                                                                    <td>
                                                                        <input class="form-control" name="total_discount"
                                                                            onkeyup="gettotal()" value="0"
                                                                            id="total_discount">
                                                                    </td>
                                                                </tr>

                                                                <tr>
                                                                    <td class="text-right">
                                                                        <span style="font-size:17px;font-weight:600">Grand
                                                                            Total</span>
                                                                    </td>
                                                                    <td></td>
                                                                    <td>
                                                                        <input class="form-control" value="0"
                                                                            name="grand_total" readonly
                                                                            id="total_amount" />
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="col-md-12" style="padding: 0px 17px 0px 11px;">
                                            <div class="row">
                                                <div class="col-md-6">
                                                </div>
                                                <div class="col-md-6">

                                                    <div class="table-responsive">
                                                        <table class="table table-bordered text-nowrap">
                                                            <thead class="bg-primary text-white">
                                                                <tr>
                                                                    <th scope="col" style="width: 20%"
                                                                        class="text-white">Date
                                                                    </th>
                                                                    <th scope="col" style="width: 20%"
                                                                        class="text-white">Mode
                                                                    </th>
                                                                    <th scope="col" style="width: 20%"
                                                                        class="text-white">Bank
                                                                    </th>
                                                                    <th scope="col" style="width: 10%"
                                                                        class="text-white">
                                                                        Amount(₹)</th>

                                                                </tr>
                                                            </thead>
                                                            <tbody id="chargeTable">
                                                                <tr>
                                                                    <td><input type="datetime-local" name="payment_date[]"
                                                                            value="{{ date('Y-m-d H:i') }}" /></td>
                                                                    <td>
                                                                        <select class="form-control"
                                                                            name="payment_mode[]">
                                                                            <option value="Cash"> {{ 'Cash' }}
                                                                            </option>
                                                                        </select>
                                                                    </td>
                                                                    <td>
                                                                        --
                                                                    </td>
                                                                    <td>
                                                                        <input type="text" name="payment_amount[]"
                                                                            onkeyup="getPaymentTotal()"
                                                                            value="{{ 0 }}" id="case_payment"
                                                                            class="form-control" />
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>
                                                                        <input type="datetime-local" name="payment_date[]"
                                                                            value="{{ date('Y-m-d H:i') }}" />
                                                                    </td>
                                                                    <td>

                                                                        <select class="form-control" name="payment_mode[]"
                                                                            id="others_mode">
                                                                            <option value="UPI">UPI</option>
                                                                            <option value="Transfer to Bank Account">
                                                                                Transfer to Bank Account</option>
                                                                            <option value="Cheque">Cheque</option>
                                                                            <option value="Other">Other</option>
                                                                            <option value="Online">Online</option>
                                                                        </select>
                                                                    </td>
                                                                    <td>

                                                                        <select class="form-control" name="bank_name">
                                                                            <option value="Axis Bank">Axis Bank</option>
                                                                            <option value="Canara Bank">Canara Bank
                                                                            </option>
                                                                            <option value="State Bank">State Bank</option>
                                                                        </select>
                                                                    </td>
                                                                    <td>
                                                                        <input type="text" name="payment_amount[]"
                                                                            value="{{ 0 }}" id="bank_payment"
                                                                            onkeyup="getPaymentTotal()"
                                                                            class="form-control" />

                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-12" style="padding: 0px 17px 0px 11px;">
                                            <div class="row">
                                                <div class="col-md-8">

                                                </div>
                                                <div class="col-md-4">
                                                    <div class="row">
                                                        <div class="table-responsive">
                                                            <table class="table table-bordered text-nowrap">
                                                                <tr style="background-color: rgb(219, 252, 198)">
                                                                    <td class="text-right">
                                                                        <span style="font-size:21px;font-weight:600">Total
                                                                            Pay(₹)</span>
                                                                    </td>

                                                                    <td>
                                                                        <input class="form-control" name="total_payment"
                                                                            readonly id="total_payment" value="" />
                                                                    </td>
                                                                </tr>

                                                                <tr style="background-color: rgb(255, 208, 208)">
                                                                    <td class="text-right">
                                                                        <span style="font-size:21px;font-weight:600">Total
                                                                            Due(₹)</span>
                                                                    </td>

                                                                    <td>
                                                                        <input class="form-control" name="total_due"
                                                                            readonly id="total_due" value="" />
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="modal-footer">
                                            <button class="btn btn-primary btn-sm submitBtn" type="submit"
                                                name="submit" value="new"><i class="fa fa-file text-success"></i>
                                                Save & close</button>
                                            {{-- <button class="btn btn-primary btn-sm submitBtn" type="submit"
                                                name="submit" value="close"><i class="fa fa-file text-danger"></i> Save
                                                & Close</button>
                                            <button class="btn btn-primary btn-sm submitBtn float-right" type="submit"
                                                name="submit" value="bill"><i class="fa fa-print"></i> Save & Bill
                                                Print</button> --}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
@push('js')
    <script>
        function getamount() {
            const unit_qty = parseFloat($('#unit_qty').val()) || 0;
            const sub_unit_qty = parseFloat($('#sub_unit_qty').val()) || 0;
            const rate = parseFloat($('#mrp').val()) || 0;
            const unit_details = parseFloat($('#unit_details').val()) || 1;
            const dis_percent = parseFloat($('#discount').val()) || 0;
            const avi_qty = parseFloat($('#total_stock_qty').val()) || 0;
            const request_qty = ((unit_qty * unit_details) + sub_unit_qty);
            if (avi_qty < request_qty) {

                $('#unit_qty').val(0);
                $('#sub_unit_qty').val(0);
                $('#discount').val(0);
                // $('#mrp').val(0);
                $('#amount').val(0);
                alert('You do not have enough stock');

            } else {
                const total_qty = (unit_qty * unit_details) + sub_unit_qty;
                const total_rate = (rate / unit_details) * total_qty;
                const discount_amount = (total_rate * dis_percent) / 100;
                const total_amount = total_rate - discount_amount;
                $('#amount').val(total_amount.toFixed(2));
            }


        }

        function getMedicinesByCategory(categoryId) {
            $('#medicine_name').html('');
            $('#medicine_name').html('<option value="">Select One...</option>');

            $.ajax({
                url: "{{ route('pharmacy.get-medicines-by-category') }}",
                type: "POST",
                data: {
                    _token: '{{ csrf_token() }}',
                    category_id: categoryId,
                },
                success: function(response) {
                    console.log(response);
                    $.each(response, function(key, value) {
                        $('#medicine_name').append(
                            `<option value="${value.id}">${value.medicine_name}</option>`
                        );
                    });
                },
                error: function(error) {
                    console.log(error);
                }
            });
        }

        function getMedicineBatchDetails(medicine_name) {
            $('#medicine_batch').html('');
            $('#medicine_batch').html('<option value="">Select One...</option>');

            $.ajax({
                url: "{{ route('find-medicine-batch-by-medicine-name') }}",
                type: "POST",
                data: {
                    _token: '{{ csrf_token() }}',
                    medicine_name_id: medicine_name,
                },
                success: function(response) {
                    console.log(response);
                    $.each(response, function(key, value) {
                        $('#medicine_batch').append(
                            `<option value="${value.batch_no}">${value.batch_no}</option>`
                        );
                    });
                },
                error: function(error) {
                    console.log(error);
                }
            });
        }

        function getMedicineDetailsbyBatch(batch_no) {
            var medicine_id = $('#medicine_name').val();

            $.ajax({
                url: "{{ route('find-medicine-details-by-medicine-batch') }}",
                type: "POST",
                data: {
                    _token: '{{ csrf_token() }}',
                    medicine_batch_no: batch_no,
                    medicineId: medicine_id,
                },
                success: function(response) {
                    console.log(response);

                    $('#expiry_date').val(formatDateTime(response.medicine_details.exp_date, 'date'));
                    // $('#rate' + i).val(response.medicine_details.p_rate);
                    $('#mrp').val(response.medicine_details.mrp);
                    $('#unit_details').val(response.medicine_stock.unit_details);
                    $('#avi_qty').val(response.medicine_stock.available_stock);
                    $('#total_stock_qty').val(response.medicine_stock.total_qty);

                    $('#cgst').val(response.medicine_details.cgst);
                    $('#sgst').val(response.medicine_details.sgst);
                    $('#igst').val(response.medicine_details.igst);
                    $('#unit').val(response.medicine_details.unit);
                    $('#sub_unit').val(response.medicine_details.sub_unit);


                    // getamount(i);

                },
                error: function(error) {
                    console.log(error);
                }
            });
        }

        function validation() {
            var chargeSelect = $('#charge_name'); // Get the select element
            var selectedOption = chargeSelect.find('option:selected'); // Get the selected option
            var chargeValue = selectedOption.val(); // Get the value of the selected option
            var chargeText = selectedOption.text(); // Get the text of the selected option
            var rateValue = $('#rate').val(); // Get value from rate input
            var qtyValue = $('#qty').val(); // Get value from qty input

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

            var categorySelect = $('#medicine_category');
            var selectedOption = categorySelect.find('option:selected');
            var categoryValue = selectedOption.val();
            var categoryText = selectedOption.text();

            var medicineSelect = $('#medicine_name');
            var selectedOption = medicineSelect.find('option:selected');
            var medicineValue = selectedOption.val();
            var medicineText = selectedOption.text();

            var batchSelect = $('#medicine_batch');
            var selectedOption = batchSelect.find('option:selected');
            var batchValue = selectedOption.val();
            var batchText = selectedOption.text();

            var expiryDateValue = $('#expiry_date').val();
            var unitqtyValue = $('#unit_qty').val();
            var unitValue = $('#unit').val();
            var subUnitqtyValue = $('#sub_unit_qty').val();
            var subUnitValue = $('#sub_unit').val();
            var mrpValue = $('#mrp').val();
            var discountValue = $('#discount').val();
            var amountValue = $('#amount').val();
            var unit_details = $('#unit_details').val();

            var cell1 = newRow.insertCell(0);
            var cell2 = newRow.insertCell(1);
            var cell3 = newRow.insertCell(2);
            var cell4 = newRow.insertCell(3);
            var cell5 = newRow.insertCell(4);
            var cell6 = newRow.insertCell(5);
            var cell7 = newRow.insertCell(6);
            var cell8 = newRow.insertCell(7);
            var cell9 = newRow.insertCell(8);
            var cell10 = newRow.insertCell(9);
            var cell11 = newRow.insertCell(10);
            var cell12 = newRow.insertCell(11);
            var cell13 = newRow.insertCell(12);
            var cell14 = newRow.insertCell(13);

            //    var inputHTML1 = '<input type="text" name="date[]" readonly class="form-control" value="' + date + '" />';
            // cell1.innerHTML = inputHTML1;

            var selectHTML = '<select class="form-control" name="medicine_category[]"><option value="' + categoryValue +
                '">' + categoryText + '</option></select>';
            cell1.innerHTML = selectHTML;

            var selectHTML1 = '<select class="form-control"  name="medicine_name[]"><option value="' + medicineValue +
                '">' + medicineText + '</option></select>';
            cell2.innerHTML = selectHTML1;

            var selectHTML2 = '<select class="form-control"  name="medicine_batch[]"><option value="' + batchValue + '">' +
                batchText + '</option></select>';
            cell3.innerHTML = selectHTML2;

            var inputHTML1 = '<input type="text" name="expiry_date[]" readonly class="form-control" value="' +
                expiryDateValue + '" />';
            cell4.innerHTML = inputHTML1;

            var inputHTML2 = '<input type="text" name="unit_qty[]" readonly class="form-control" value="' + unitqtyValue +
                '" /><input type="hidden" name="unit_details[]" readonly class="form-control" value="' + unit_details +
                '" />';
            cell5.innerHTML = inputHTML2;

            var inputHTML3 = '<input type="text" name="unit[]" readonly class="form-control" value="' + unitValue + '" />';
            cell6.innerHTML = inputHTML3;

            var inputHTML4 = '<input type="text" name="sub_unit_qty[]" readonly class="form-control" value="' +
                subUnitqtyValue + '" />';
            cell7.innerHTML = inputHTML4;

            var inputHTML5 = '<input type="text" name="sub_unit[]" readonly class="form-control" value="' + subUnitValue +
                '" />';
            cell8.innerHTML = inputHTML5;

            var blankCellHTML = '';
            cell9.innerHTML = blankCellHTML;

            var blankCellHTML1 = '';
            cell10.innerHTML = blankCellHTML1;

            var inputHTML6 = '<input type="text" name="mrp[]" readonly class="form-control" value="' + mrpValue + '" />';
            cell11.innerHTML = inputHTML6;

            var inputHTML7 = '<input type="text" name="discount[]" readonly class="form-control" value="' + discountValue +
                '" />';
            cell12.innerHTML = inputHTML7;

            var inputHTML8 = '<input type="text" name="amount[]" readonly class="form-control" value="' + amountValue +
                '" />';
            cell13.innerHTML = inputHTML8;



            var inputHTML9 = '<button type="button" class="btn btn-danger btn-sm" onclick="removeRow(this)">X</button>';
            cell14.innerHTML = inputHTML9;

            const selectElement = document.getElementById("medicine_category");
            selectElement.selectedIndex = 0;
            $('#medicine_category').val('').trigger('change');

            const selectElement1 = document.getElementById("medicine_name");
            selectElement1.selectedIndex = 0;
            $('#medicine_name').val('').trigger('change');

            const selectElement2 = document.getElementById("medicine_batch");
            selectElement1.selectedIndex = 0;
            $('#medicine_batch').val('').trigger('change');

            $('#mrp').val(0);
            $('#unit_qty').val(0);
            $('#discount').val(0);
            $('#amount').val(0);
            $('#sub_unit_qty').val(0);
            $('#unit').val('');
            $('#sub_unit').val('');
            $('#expiry_date').val('');
            $('#avi_qty').val('');


            $('#myInputbtn').prop('autofocus', false);
            $('#medicine_category').prop('autofocus', true);

            gettotal();

        }

        function removeRow(button) {
            var table = document.getElementById("data-table");
            var row = button.parentNode.parentNode;
            table.deleteRow(row.rowIndex);
            gettotal();
        }

        function gettotal() {
            var t = 0;
            var m = 0;
            var m_a = 0;
            $("input[name='amount[]']").each(function() {
                t += parseFloat($(this).val()) || 0;
            });

            var t_m = (parseFloat(t) + parseFloat(m_a));
            $('#sub_total').val(t_m.toFixed(2));

            var total_discount = $('#total_discount').val() || 0;
            var discountType = $('#discount_type').val();

            var r;
            if (discountType === 'percentage') {
                r = t_m - (t_m * (parseFloat(total_discount) / 100));
            } else {
                r = t_m - parseFloat(total_discount);
            }

            var grnd_total = r;

            $('#total_amount').val(parseInt(grnd_total).toFixed(2));

            getPaymentTotal();
        }

        function getPaymentTotal() {

            var new_recept_amount = 0;

            $("input[name='payment_amount[]']").each(function() {
                new_recept_amount += parseFloat($(this).val()) || 0;
            });


            var totalss = (parseInt(new_recept_amount));
            var grnd_total = $('#total_amount').val();


            var amnt = 0;
            var due_amnt = 0;
            var credit_amnt = 0;
            if (grnd_total > totalss) {
                due_amnt = parseInt(parseInt(grnd_total - totalss));
            }

            $('#total_payment').val(totalss);
            $('#total_due').val(due_amnt);
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
                                let patientData = encodeURIComponent(JSON.stringify(value));
                                div_data += `<tr class="color_hover_charnge" onclick="selectPatient('${patientData}')" style="cursor: pointer !important;">
                                <td>${value.uhid || value.id}</td>
                                <td>${value.name}</td>
                                <td>${value.dob_year || 0}Y ${value.dob_month || 0}M ${value.dob_day || 0}D</td>
                                <td>${value.phone}</td>
                                <td>${value.address}</td>
                            </tr>`;
                            });
                            $('#search_result_row').html(div_data);
                        }
                    },
                    error: function(error) {
                        console.log(error);
                    }
                });
            }
        }

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
            $('#search_result_row').html('');
            $('#search_result').attr('style', 'display:none', true);
            getDistrict(patient.state, patient.district);
            $.ajax({
                url: "{{ Route('find-credit-amount') }}",
                type: "POST",
                data: {
                    _token: '{{ csrf_token() }}',
                    patient_id: patient.id,
                },
                success: function(response) {
                    if (response.success && (response.results.length > 0)) {
                        $('#credit_amount_section').attr('style', 'display:block', true);
                        $.each(response.results, function(key, value) {
                            $('#credit_amount_list').append(`<tr>
                            <td><input class="form-control" type="text" name="credit_bill[]" value="${value.id}" readonly></td>
                            <td><input class="form-control" type="text" name="credit_amount[]" value="${value.cradit_amount}" readonly></td>
                            <td><input class="form-control adjust_credit_amount" type="number" max="${value.cradit_amount}" oninput="this.value = this.value > this.max ? this.max : this.value"  name="adjust_credit_amount[]" onkeyup="getPaymentTotal()"></td>
                        </tr>`);
                        });
                    } else {
                        $('#credit_amount_section').attr('style', 'display:none', true);
                    }
                },
                error: function(error) {
                    console.log(error);
                }
            });
        }



        function getDistrict(state_id, dist_id = 0) {
            if (state_id) {
                $('#district').html('<option vaule="">Select District</option>');
                $.ajax({
                    url: "{{ Route('get-district') }}",
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
                    error: function(error) {
                        console.log(error);
                    }
                });
            }
        }
    </script>
@endpush
