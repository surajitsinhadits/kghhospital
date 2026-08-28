@extends('layouts.structure')
@push('title')
    <title>Create Bill</title>
@endpush
@push('css')
@endpush

@section('main-content')
    <div class="row">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3 leftside_fixarea">
                        <x-billbar section="{{ $section }}" id="{{ $ipd_id }}" type="sec" />
                    </div>

                    <div class="col-md-9 rightside_fixarea" style="border:2px solid black">
                        <form method="POST" action="{{ Route('bill.insert-bill', $section) }}" id="yourFormId">
                            @csrf
                            <input type="hidden" name="section_id" value="{{ $ipd_id }}">
                            <input type="hidden" name="previous_credit_used" id="previous_credit_used" value="0">
                            <input type="hidden" name="save" id="activeSubmitValue" value="">

                            {{-- ✅ Dynamic TDS percent value from backend --}}
                            {{-- You said: tds_value variable already has value, so using it directly --}}
                            <input type="hidden" name="tds_percent" id="tds_percent" value="{{ $tds_value ?? 0 }}">

                            <div class="row mt-6 mb-3">
                                <div class="col-lg-12 ">
                                    <div class="main-profile-contact-list">
                                        <div class="row">
                                            <div class="form-group col-md-6 newuserchangee" style="margin-top:11px;">
                                                <label class="date-format">Billing Date </label>
                                                <input type="text" name="bill_date" value="{{ date('d-m-Y h:i A') }}"
                                                    class="dateTimePickr" required>
                                            </div>

                                            <div class="form-group col-md-6 newaddappon">
                                                <label for="packages">Packages </label>
                                                <select name="packages" class="form-control select2-show-search"
                                                    id="packages" onchange="applypackage(this.value)">
                                                    <option value="">Select</option>
                                                    @foreach ($packages as $doc)
                                                        <option value="{{ $doc->id }}">{{ $doc->package_name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- CHARGES TABLE --}}
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="table-responsive">
                                        <table class="table table-bordered text-nowrap" id="data-table">
                                            <thead class="bg-primary text-white">
                                                <tr>
                                                    <th scope="col" style="width: 10%" class="text-white">Date <span class="text-danger">*</span></th>
                                                    <th scope="col" style="width: 20%" class="text-white">Charge Name <span class="text-danger">*</span></th>
                                                    <th scope="col" style="width: 10%" class="text-white">Reffer Doctor</th>
                                                    <th scope="col" style="width: 10%" class="text-white">Rate (₹) <span class="text-danger">*</span></th>
                                                    <th scope="col" style="width: 2%" class="text-white"># / <span class="text-danger">Cancel</span></th>
                                                    <th scope="col" style="width: 10%" class="text-white">Qty <span class="text-danger">*</span></th>
                                                    <th scope="col" style="width: 10%" class="text-white">Dis (%) <span class="text-danger">*</span></th>
                                                    <th scope="col" style="width: 10%" class="text-white">Dis Amount (₹) <span class="text-danger">*</span></th>
                                                    <th scope="col" style="width: 10%" class="text-white">Amount (₹) <span class="text-danger">*</span></th>
                                                    <th scope="col" style="width: 2%" class="text-white"></th>
                                                </tr>
                                            </thead>

                                            <tbody id="chargeTable">
                                                <tr id="row">
                                                    <td>
                                                        <input class="form-control datePickr" type="text" id="date_and_time" value="{{ date('d-m-Y') }}">
                                                    </td>
                                                    <td>
                                                        <select class="form-control select2-show-search" id="charge_name" onchange="getRateByCharge(this)">
                                                            <option value="">Select</option>
                                                            @foreach ($charges as $cha)
                                                                <option value="{{ $cha->id }}" data-amount="{{ $cha->charge_amount }}">
                                                                    {{ $cha->charge_name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <select class="form-control select2-show-search" id="doctor_name">
                                                            <option value="">Select</option>
                                                            @foreach ($doctor as $ref)
                                                                <option value="{{ $ref->id }}">Dr. {{ $ref->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <input class="form-control" id="rate" onkeyup="updateCalculations('')" value="0">
                                                    </td>
                                                    <td>
                                                        <button class="btn btn-success btn-sm" onclick="validation()" type="button" id="myInputbtn">
                                                            <i class="fa fa-plus"></i>
                                                        </button>
                                                    </td>
                                                    <td>
                                                        <input class="form-control" id="qty" onkeyup="updateCalculations('')" value="1">
                                                    </td>
                                                    <td>
                                                        <input class="form-control" id="discount_in_per" onkeyup="updateCalculations('')" value="0">
                                                    </td>
                                                    <td>
                                                        <input class="form-control" id="discount_amount" onkeyup="updateCalculations('')" value="0">
                                                    </td>
                                                    <td>
                                                        <input class="form-control" readonly id="amount" value="0">
                                                    </td>
                                                    <td>
                                                        <button class="btn btn-success btn-sm" onclick="validation()" type="button" id="buttonId">+</button>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            {{-- PAYMENTS + TOTALS --}}
                            <div class="col-md-12">
                                <div class="row justify-content-between">
                                    <div class="col-md-6">
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
                                                        <td><input type="text" name="payment_date[]" value="{{ date('d-m-Y h:i A') }}" readonly></td>
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
                                                        <td><input type="text" name="payment_date[]" value="{{ date('d-m-Y h:i A') }}" readonly></td>
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
                                                            <select class="form-control" name="bank_name">
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

                                    <div class="col-md-5">
                                        <div class="row">
                                            <div class="table-responsive">
                                                <table class="table table-bordered text-nowrap">
                                                    <tbody>
                                                        <tr>
                                                            <td class="text-right"><span style="font-size:16px;font-weight:600">Sub Total</span></td>
                                                            <td></td>
                                                            <td>
                                                                <input class="form-control" name="sub_total" readonly value="" id="sub_total">
                                                            </td>
                                                        </tr>

                                                        @php
                                                            $miscellaneous = false;
                                                            $discount = false;
                                                        @endphp
                                                        @isok('MISCELLANEOUS EDIT')
                                                            @php $miscellaneous = true; @endphp
                                                        @endisok
                                                        @isok('DISCOUNT EDIT')
                                                            @php $discount = true; @endphp
                                                        @endisok

                                                        <tr>
                                                            <td class="text-right"><span style="font-size:16px;font-weight:600">Miscellaneous</span></td>
                                                            <td>
                                                                <select name="miscellaneous_charge_type" onchange="gettotal()" id="miscellaneous_charge_type" class="form-control">
                                                                    <option value="percentage" selected>%</option>
                                                                    <option value="flat">Rs.</option>
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <input class="form-control" name="miscellaneous_charge" onkeyup="gettotal()" value=""
                                                                    id="miscellaneous_charge" {{ $miscellaneous ? '' : 'readonly' }}>
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <td class="text-right"><span style="font-size:16px;font-weight:600">Total</span></td>
                                                            <td></td>
                                                            <td>
                                                                <input class="form-control" name="total" readonly value="" id="total_am">
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <td class="text-right"><span style="font-size:16px;font-weight:600">Discount</span></td>
                                                            <td>
                                                                <select name="discount_type" onchange="gettotal()" id="discount_type" class="form-control">
                                                                    <option value="flat">Rs</option>
                                                                    <option value="percentage">%</option>
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <input class="form-control" name="total_discount" onkeyup="gettotal()" value=""
                                                                    id="total_discount" {{ $discount ? '' : 'readonly' }}>
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <td class="text-right"><span style="font-size:16px;font-weight:600">Grand Total</span></td>
                                                            <td></td>
                                                            <td>
                                                                <input class="form-control" name="grand_total" value="" readonly id="grnd_total">
                                                            </td>
                                                        </tr>

                                                        {{-- ✅ TDS (DYNAMIC %) --}}
                                                        {{-- @if( !empty($section) && ($section == 'ipd' || $section == 'dialysis') )
                                                        <tr>
                                                            <td class="text-right">
                                                                <span style="font-size:16px;font-weight:600">
                                                                    TDS Amount (<span id="tds_percent_label">{{ $tds_value ?? 0 }}</span>%)
                                                                </span>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox"
                                                                    name="tds_active"
                                                                    id="tds_active"
                                                                    class="form-control"
                                                                    value="1">
                                                            </td>
                                                            <td>
                                                                <input class="form-control" name="tds_amount" id="tds_amount" value="0.00" readonly>
                                                            </td>
                                                        </tr>
                                                        @endif --}}
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            {{-- REMARKS + DUE --}}
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
                                        <div class="row">
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

                            {{-- SUBMIT --}}
                            <div class="modal-footer justify-content-center">
                                <button class="btn btn-primary btn-sm submitBtn" type="submit" name="save" value="1">
                                    <i class="fa fa-file"></i> Bill Save in Draft
                                </button>
                            </div>

                            <div class="row">
                                <div class="col-md-6 text-left text-blue"></div>
                                <div class="col-md-6 text-right text-blue">
                                    Editing : {{ Auth::user()->name }} || Date : {{ date('d-m-Y') }}
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
<script>
    // ✅ Read dynamic % from hidden input (tds_value from backend)
    function getTdsPercent() {
        return parseFloat($('#tds_percent').val()) || 0;
    }

    // ✅ TDS: (Grand Total * dynamic%) when checked, else 0
    function calculateTDS() {
        const hasTdsCheckbox = $('#tds_active').length > 0;
        if (!hasTdsCheckbox) return 0;

        const isChecked  = $('#tds_active').is(':checked');
        const grandTotal = parseFloat($('#grnd_total').val()) || 0;
        const percent    = getTdsPercent();

        // also update label (in case percent changes by backend)
        $('#tds_percent_label').text(percent);

        if (!isChecked || grandTotal <= 0 || percent <= 0) {
            $('#tds_amount').val('0.00');
            return 0;
        }

        const tds = (grandTotal * percent) / 100;
        $('#tds_amount').val(tds.toFixed(2));
        return tds;
    }

    // checkbox toggle => recalc
    $(document).on('change', '#tds_active', function () {
        calculateTDS();
        getPaymentTotal();
    });

    // page load => calc
    $(function () {
        calculateTDS();
    });

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
            getCredit();
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

        var doctorSelect = $('#doctor_name');
        var selectedDoctor = doctorSelect.find('option:selected');
        var doctorValue = selectedDoctor.val();
        var doctorText = selectedDoctor.text();

        var dateValue = $('#date_and_time').val();
        var rateValue = $('#rate').val();
        var qtyValue = $('#qty').val();
        var discountInPerValue = $('#discount_in_per').val();
        var discountAmountValue = $('#discount_amount').val();
        var amountValue = $('#amount').val();

        var cell0 = newRow.insertCell(0);
        var cell1 = newRow.insertCell(1);
        var cell2 = newRow.insertCell(2);
        var cell3 = newRow.insertCell(3);
        var cell4 = newRow.insertCell(4);
        var cell5 = newRow.insertCell(5);
        var cell6 = newRow.insertCell(6);
        var cell7 = newRow.insertCell(7);
        var cell8 = newRow.insertCell(8);
        var cell9 = newRow.insertCell(9);

        cell0.innerHTML = '<input class="form-control datePickr" type="text" id="date_and_time" name="date[]" value="' + dateValue + '">';
        cell1.innerHTML = '<select class="form-control" style="background-color: #e9e9eb;" name="charge_name[]"><option value="' + chargeValue + '">' + chargeText + '</option></select>';
        cell2.innerHTML = '<select class="form-control" style="background-color: #e9e9eb;" name="doctor_name[]"><option value="' + doctorValue + '">' + doctorText + '</option></select>';
        cell3.innerHTML = '<input type="text" name="rate[]" onkeyup="updateCalculations(' + table_id + ')" id="rate' + table_id + '" class="form-control" value="' + rateValue + '">';
        cell4.innerHTML = '';
        cell5.innerHTML = '<input type="text" name="qty[]" onkeyup="updateCalculations(' + table_id + ')" id="qty' + table_id + '" class="form-control" value="' + qtyValue + '">';
        cell6.innerHTML = '<input type="text" name="discount_in_per[]" onkeyup="updateCalculations(' + table_id + ')" id="discount_in_per' + table_id + '" class="form-control" value="' + discountInPerValue + '">';
        cell7.innerHTML = '<input type="text" name="discount_amount[]" onkeyup="updateCalculations(' + table_id + ')" id="discount_amount' + table_id + '" class="form-control" value="' + discountAmountValue + '">';
        cell8.innerHTML = '<input type="text" name="amount[]" id="amount' + table_id + '" readonly class="form-control" value="' + amountValue + '">';
        cell9.innerHTML = '<button type="button" class="btn btn-danger btn-sm" onclick="removeRow(this)">X</button>';

        document.getElementById("charge_name").selectedIndex = 0;
        $('#charge_name').val('').trigger('change');
        $('#doctor_name').val('').trigger('change');

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

    function applypackage(package_id) {
        if (package_id) {
            $.ajax({
                url: "{{ route('hr.get-package-details') }}",
                type: "POST",
                data: { package_id: package_id, _token: '{{ csrf_token() }}' },
                dataType: 'json',
                success: function(data) {
                    $.each(data, function(i, obj) {
                        var table = document.getElementById("data-table");
                        var newRow = table.insertRow(table.rows.length);
                        var table_id = table.rows.length;
                        newRow.style.backgroundColor = "#d5ffe8";

                        var chargeValue = obj.id;
                        var chargeText = obj.charge_name;

                        var rateValue = obj.charge_amount;
                        var qtyValue = 1;
                        var discountInPerValue = 0;
                        var discountAmountValue = 0;
                        var amountValue = obj.charge_amount;
                        var dateValue = formatDateTime(new Date().toISOString().split('T')[0], 'date');

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

                        cell1.innerHTML = '<input type="text" name="date[]" id="date_and_time' + table_id + '" class="form-control datePickr" value="' + dateValue + '">';
                        cell2.innerHTML = '<select class="form-control" style="background-color: #e9e9eb;" name="charge_name[]"><option value="' + chargeValue + '">' + chargeText + '</option></select>';
                        cell3.innerHTML = '<select class="form-control" id="doctor_name' + table_id + '" name="doctor_name[]"><option value=""></option>@foreach ($referral as $value)<option value="{{ $value->id }}">{{ $value->referral_name }}</option>@endforeach</select>';
                        cell4.innerHTML = '<input type="text" name="rate[]" id="rate' + table_id + '" onkeyup="updateCalculations(' + table_id + ')" class="form-control" value="' + rateValue + '">';
                        cell5.innerHTML = '';
                        cell6.innerHTML = '<input type="text" name="qty[]" id="qty' + table_id + '" onkeyup="updateCalculations(' + table_id + ')" class="form-control" value="' + qtyValue + '">';
                        cell7.innerHTML = '<input type="text" name="discount_in_per[]" onkeyup="updateCalculations(' + table_id + ')" id="discount_in_per' + table_id + '" class="form-control" value="' + discountInPerValue + '">';
                        cell8.innerHTML = '<input type="text" name="discount_amount[]" onkeyup="updateCalculations(' + table_id + ')" id="discount_amount' + table_id + '" class="form-control" value="' + discountAmountValue + '">';
                        cell9.innerHTML = '<input type="text" name="amount[]" id="amount' + table_id + '" readonly class="form-control" value="' + amountValue + '">';
                        cell10.innerHTML = '<button type="button" class="btn btn-danger btn-sm" onclick="removeRow(this)">X</button>';
                    });

                    getCredit();
                    gettotal();
                },
                error: function(e) {
                    console.log(e);
                }
            });
        }
    }

    function getRateByCharge(selectElement) {
        let chargeAmount = selectElement.options[selectElement.selectedIndex].getAttribute("data-amount");
        $('#rate').val(chargeAmount == '' ? 0 : chargeAmount);
        updateCalculations('');
    }

    function updateCalculations(rowNo) {
        const rateInput = $('#rate' + rowNo).val();
        const qtyInput = $('#qty' + rowNo).val();
        const discountInPerInput = $('#discount_in_per' + rowNo).val();
        const discountAmountInput = $('#discount_amount' + rowNo).val();

        const rate = parseFloat(rateInput) || 0;
        const qty = parseFloat(qtyInput) || 0;
        const discountInPer = parseFloat(discountInPerInput) || 0;
        const discountInAmount = parseFloat(discountAmountInput) || 0;

        let discountAmount = 0;

        if (discountInPer && discountInPer !== 0) {
            discountAmount = (rate * qty * discountInPer) / 100;
        }

        if ((!discountInPer || discountInPer === 0) && discountInAmount) {
            discountAmount = discountInAmount;
        }

        const amount = (rate * qty) - discountAmount;
        $('#amount' + rowNo).val(amount.toFixed(2));
        gettotal();
    }

    function gettotal() {
        var t = 0;
        var m = 0;
        var m_a = 0;

        $("input[name='amount[]']").each(function() {
            t += parseFloat($(this).val()) || 0;
        });
        $('#sub_total').val(t.toFixed(2));

        m = $('#miscellaneous_charge').val() || 0;
        var miscellaneous_chargeType = $('#miscellaneous_charge_type').val()

        if (miscellaneous_chargeType === 'percentage') {
            m_a = t * (parseFloat(m) / 100);
        } else {
            m_a = parseFloat(m);
        }

        var t_m = (parseFloat(t) + parseFloat(m_a));
        $('#total_am').val(t_m.toFixed(2));

        var total_discount = $('#total_discount').val() || 0;
        var discountType = $('#discount_type').val();

        var r;
        if (discountType === 'percentage') {
            r = t_m - (t_m * (parseFloat(total_discount) / 100));
        } else {
            r = t_m - parseFloat(total_discount);
        }

        $('#grnd_total').val(parseInt(r));

        // ✅ IMPORTANT: recalc dynamic TDS whenever grand total changes
        calculateTDS();

        getPaymentTotal();
    }

    function getPaymentTotal() {
        var rt = 0;
        var previous_recpt_amount = 0;
        var advance_pay = 0;
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

        $("input[name='adjust_advance_amount[]']").each(function() {
            advance_pay += parseFloat($(this).val()) || 0;
        });

        var totalss = (parseInt(new_recept_amount) + parseInt(previous_recpt_amount) + parseInt(rt) + parseInt(advance_pay));

        // ✅ if you want due to consider TDS deduction, you can subtract it here.
        // Your current logic is keeping behavior same: due is based on grand total only.
        // If you want TDS reduce payable => uncomment next 2 lines:
        // const tds = parseFloat($('#tds_amount').val()) || 0;
        // totalss = totalss + tds; // (depends on your business rule)

        var grnd_total = parseInt($('#grnd_total').val() || 0);
        var previous_credit_used = parseInt($('#previous_credit_used').val() || 0);

        var due_amnt = 0;
        if (grnd_total > totalss) {
            due_amnt = parseInt((grnd_total + previous_credit_used) - totalss);
        }

        $('#total_payment').val(totalss);
        $('#total_due').val(due_amnt);
    }

    function getCredit() {
        let patient_id = $('#patient_uhid').text();

        $.ajax({
            url: "{{ Route('find-credit-amount') }}",
            type: "POST",
            data: {
                _token: '{{ csrf_token() }}',
                patient_id: patient_id,
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
            error: function(error) {
                console.log(error);
            }
        });
    }

    $(function() {
        let isBillSubmitting = false;
        let lastClickedSubmitButton = null;

        const $submitValueInput = $('#activeSubmitValue');
        const defaultSubmitValue = $('.submitBtn').first().val() || '';
        if (!$submitValueInput.val().trim()) $submitValueInput.val(defaultSubmitValue);

        $('.submitBtn').on('click', function() {
            lastClickedSubmitButton = $(this);
            $submitValueInput.val($(this).val());
        });

        $('#yourFormId').on('submit', function(e) {
            if (isBillSubmitting) {
                e.preventDefault();
                return false;
            }

            const chargeRowCount = $('select[name="charge_name[]"]').length;
            if (chargeRowCount === 0) {
                e.preventDefault();
                const msg = 'Please add at least one charge row.';
                if (typeof toastr !== 'undefined') toastr.error(msg);
                else alert(msg);
                return false;
            }

            isBillSubmitting = true;

            const $activeSubmitBtn = lastClickedSubmitButton && lastClickedSubmitButton.length
                ? lastClickedSubmitButton
                : $('.submitBtn').first();

            if ($activeSubmitBtn.length) {
                const originalHtml = $activeSubmitBtn.data('original-html') || $activeSubmitBtn.html();
                $activeSubmitBtn.data('original-html', originalHtml);
                $activeSubmitBtn.html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Submitting...');
            }

            $('.submitBtn').prop('disabled', true);
            return true;
        });

        // ensure TDS initial calc
        calculateTDS();
    });
</script>
@endpush
