@extends('layouts.structure')
@push('title')
    <title>Purchase</title>
@endpush
@push('css')
<style>
    .myfld {
        width: 18% !important;
    }
</style>
@endpush
@section('main-content')
    <div class="row">
        <div class="card">
            <div class="card-header d-block card_hearder_mimi">
                <div class="row">
                    <div class="col-md-6 card-title card_hearder_mimi_text">
                        {{ $title }}
                    </div>
                </div>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('vc.update-purchase', @$edit->id) }}" id="yourFormId">
                    @csrf
                    <div class="card-body">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-3">
                                    <label class="date-format">Date<span class="text-danger">*</span></label>
                                    <input type="text" class="dateTimePickr" name="date" id="date"
                                        value="{{ old('date', (dateFor(@$edit->date, true) ?? date('d-m-Y h:i A'))) }}" required />
                                    @error('date')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-3" id="vendor_id">
                                    <label class="form-label">Vendor <span class="text-danger">*</span></label>
                                    <select class="form-control select2-show-search" name="vendor_id" required>
                                        <option value="">Select Vendor</option>
                                        @foreach ($vendor as $value)
                                            <option value="{{ @$value->id }}"
                                                {{ old('vendor_id', @$edit->vendor_id) == $value->id ? 'selected' : '' }}>
                                                {{ @$value->vendor_name }}</option>
                                        @endforeach
                                    </select>
                                    @error('vendor_id')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Invoice No <span class="text-danger">*</span></label>
                                    <input type="text" placeholder="Invoice No" name="invoice_no" class="form-control"
                                        value="{{ old('invoice_no', @$edit->invoice_no) }}" required>
                                    @error('invoice_no')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="table-responsive">
                            <table class="table card-table table-vcenter text-nowrap border" id="data-table">
                                <thead class="bg-primary text-white">
                                    <tr>
                                        <th class="text-white" style="padding-left: 20px; padding-right:20px">Vccine<span
                                                class="text-danger">*</span></th>
                                        <th class="text-white" style="padding-left: 10px; padding-right:10px">Batch
                                            No<span class="text-danger">*</span></th>
                                        <th class="text-white" style="padding-left: 10px; padding-right:10px">Exp. Date
                                        </th>
                                        <th class="text-white" style="padding-left: 10px; padding-right:10px">Unit Qty
                                            <span class="text-danger">*</span>
                                        </th>
                                        <th class="text-white" style="padding-left: 10px; padding-right:10px">Unit <span
                                                class="text-danger">*</span></th>
                                        <th class="text-white" style="padding-left: 5px; padding-right:5px">Sub Unit Qty
                                        </th>
                                        <th class="text-white" style="padding-left: 10px; padding-right:10px">Sub Unit
                                            <span class="text-danger">*</span>
                                        </th>
                                        <th class="text-white" style="padding-left: 20px; padding-right:20px">S.Rate/QTY
                                        </th>
                                        <th class="text-white" style="padding-left: 20px; padding-right:20px">P.Rate/QTY
                                            <span class="text-danger">*</span>
                                        </th>
                                        <th class="text-white" style="padding-left: 20px; padding-right:20px">Net Amt.
                                            <span class="text-danger">*</span>
                                        </th>
                                        <th class="text-white" style="padding-left: 10px; padding-right:10px">Dis(%)
                                        </th>
                                        <th class="text-white" style="padding-left: 10px; padding-right:10px">Dis(₹)
                                        </th>
                                        <th class="text-white" style="padding-left: 10px; padding-right:10px">CGST </th>
                                        <th class="text-white" style="padding-left: 10px; padding-right:10px">SGST </th>
                                        <th class="text-white" style="padding-left: 10px; padding-right:10px">IGST </th>
                                        <th class="text-white" style="padding-left: 10px; padding-right:10px">Amount
                                            <span class="text-danger">*</span>
                                        </th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <select class="form-control select2-show-search" id="item_name0"
                                                onchange="getVaccineDetails(this.value,'{{ 0 }}')">
                                                <option value="">Select One.....</option>
                                                @foreach ($vaccine as $value)
                                                    <option value="{{ $value->id }}">{{ $value->vaccine_name }}</option>
                                                @endforeach
                                            </select>
                                            <input class="form-control" type="hidden" id="unit_details0" readonly />
                                        </td>
                                        <td>
                                            <input class="form-control" type="text" id="batch_no0" />
                                        </td>
                                        <td>
                                            <input class="form-control datePickr" type="text" id="exp_date0" placeholder="Choose Date" />
                                        </td>
                                        <td>
                                            <input class="form-control" type="text" id="unit_qty0"
                                                onkeyup="getamount({{ 0 }})" value="0" />
                                        </td>
                                        <td>
                                            <input class="form-control" readonly type="text" id="unit0" />
                                        </td>
                                        <td>
                                            <input class="form-control" type="text" id="sub_unit_qty0"
                                                onkeyup="getamount({{ 0 }})" value="0" />
                                        </td>
                                        <td>
                                            <input class="form-control" readonly type="text" id="sub_unit0" />
                                        </td>
                                        <td>
                                            <input class="form-control" type="text" id="mrp0" value="0" />
                                        </td>
                                        <td>
                                            <input class="form-control" type="text" id="rate0" value="0"
                                                onkeyup="getamount({{ 0 }})" />
                                        </td>
                                        <td>
                                            <input class="form-control" readonly type="text" id="net_amount0" />
                                        </td>
                                        <td>
                                            <input class="form-control" type="text"
                                                onkeyup="Caluculate({{ 0 }})" id="discount_percentage0"
                                                value="{{ 0 }}" />
                                        </td>
                                        <td>
                                            <input class="form-control" type="text"
                                                onkeyup="Caluculate({{ 0 }})" id="discount_amount0"
                                                value="{{ 0 }}" />
                                        </td>
                                        <td>
                                            <input class="form-control" type="text"
                                                onkeyup="Caluculate({{ 0 }})" id="cgst0"
                                                value="{{ 0 }}" />
                                        </td>
                                        <td>
                                            <input class="form-control" type="text"
                                                onkeyup="Caluculate({{ 0 }})" id="sgst0"
                                                value="{{ 0 }}" />
                                        </td>
                                        <td>
                                            <input class="form-control" type="text"
                                                onkeyup="Caluculate({{ 0 }})" id="igst0"
                                                value="{{ 0 }}" />
                                            <input class="form-control" type="hidden" id="cgst_amount0" readonly />
                                            <input class="form-control" type="hidden" id="sgst_amount0" readonly />
                                            <input class="form-control" type="hidden" id="igst_amount0" readonly />
                                        </td>
                                        <td>
                                            <input class="form-control" readonly type="text" id="amount0" />
                                        </td>
                                        <td>
                                            <button class="btn btn-success btn-sm" onclick="validation()"
                                                type="button">+</button>
                                        </td>
                                    </tr>
                                    @foreach (@$edit_info ?? [] as $item)
                                    <tr>
                                        <td>
                                            <input class="form-control" type="hidden" name="uppid[]" value="{{ $item->id }}"/>
                                            <select class="form-control" name="item_name[]">
                                                <option value="{{ $item->vaccine_id }}">{{ $item->vaccine_name }}</option>
                                            </select>
                                            <input class="form-control" type="hidden" name="unit_details[]" value="{{ $item->sub_unit_no }}"/>
                                        </td>
                                        <td>
                                            <input class="form-control" type="text" name="batch_no[]" value="{{ $item->batch_number }}" />
                                        </td>
                                        <td>
                                            <input class="form-control datePickr" type="text" name="exp_date[]" value="{{ dateFor($item->exp_date) }}" />
                                        </td>
                                        <td>
                                            <input class="form-control" type="text" name="unit_qty[]" value="{{ $item->unit_qty }}" readonly />
                                        </td>
                                        <td>
                                            <input class="form-control" type="text" name="unit[]" value="{{ $item->unit }}" readonly />
                                        </td>
                                        <td>
                                            <input class="form-control" type="text" name="sub_unit_qty[]" value="{{ $item->sub_unit_qty }}" readonly />
                                        </td>
                                        <td>
                                            <input class="form-control" type="text" name="sub_unit[]" value="{{ $item->sub_unit }}" readonly />
                                        </td>
                                        <td>
                                            <input class="form-control" type="text" name="mrp[]" value="{{ $item->s_rate }}" readonly />
                                        </td>
                                        <td>
                                            <input class="form-control" type="text" name="rate[]" value="{{ $item->p_rate }}" readonly />
                                        </td>
                                        <td>
                                            <input class="form-control" type="text" name="net_amount[]" value="{{ $item->net_amount }}" readonly />
                                        </td>
                                        <td>
                                            <input class="form-control" type="text" name="discount_percentage[]" value="{{ $item->discount_percentage }}" readonly />
                                        </td>
                                        <td>
                                            <input class="form-control" type="text" name="discount_amount[]" value="{{ $item->discount_amount }}" readonly />
                                        </td>
                                        <td>
                                            <input class="form-control" type="text" name="cgst[]" value="{{ $item->cgst }}" readonly />
                                            <input class="form-control" type="hidden" name="cgst_amount[]" value="{{ $item->cgst_amount }}" />
                                        </td>
                                        <td>
                                            <input class="form-control" type="text" name="sgst[]" value="{{ $item->sgst }}" readonly />
                                            <input class="form-control" type="hidden" name="sgst_amount[]" value="{{ $item->sgst_amount }}" />
                                        </td>
                                        <td>
                                            <input class="form-control" type="text" name="igst[]" value="{{ $item->igst }}" readonly />
                                            <input class="form-control" type="hidden" name="igst_amount[]" value="{{ $item->igst_amount }}" />
                                        </td>
                                        <td>
                                            <input class="form-control" type="text" name="amount[]" value="{{ $item->amount }}" readonly />
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-danger btn-sm" onclick="removeRow(this)">X</button>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="row">
                            <div class="col-md-7">
                                <div class="row mt-5">
                                    <div class="col-md-8">
                                        <label class="form-label">Note</label>
                                        <textarea name="note" class="form-control">{{ old('note', @$edit->note) }}</textarea>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Payment Terms</label>
                                        <select class="form-control" name="payment_terms">
                                            <option value="">Select One....</option>
                                            <option value="Advance" {{ old('payment_terms', @$edit->payment_terms) == 'Advance' ? 'selected' : '' }}>Advance</option>
                                            <option value="After Billing" {{ old('payment_terms', @$edit->payment_terms) == 'After Billing' ? 'selected' : '' }}>After Billing</option>
                                            <option value="Payment Done" {{ old('payment_terms', @$edit->payment_terms) == 'Payment Done' ? 'selected' : '' }}>Paymen Done</option>
                                        </select>
                                        @error('payment_terms')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="container mt-5">
                                    <div class="d-flex justify-content-end">
                                        <span class="biltext">Sub Total</span>
                                        <input type="text" value="{{ @$edit->sub_total }}" name="sub_total" readonly id="sub_total" class="form-control myfld">
                                    </div>
                                    <div class="d-flex justify-content-end">
                                        <span class="biltext">CGST Amount</span>
                                        <input type="text" value="{{ @$edit->total_cgst_amount }}" name="total_cgst_amount" readonly id="total_cgst_amount" class="form-control myfld">
                                    </div>
                                    <div class="d-flex justify-content-end">
                                        <span class="biltext">SGST Amount</span>
                                        <input type="text" value="{{ @$edit->total_sgst_amount }}" name="total_sgst_amount" readonly id="total_sgst_amount" class="form-control myfld">
                                    </div>
                                    <div class="d-flex justify-content-end">
                                        <span class="biltext">IGST Amount</span>
                                        <input type="text" name="total_igst_amount" value="{{ @$edit->total_igst_amount }}" readonly id="total_igst_amount" class="form-control myfld">
                                    </div>
                                    <div class="d-flex justify-content-end thrdarea">
                                        <span class="biltext">Discount</span>
                                        <select name="discount_type" id="discount_type" onchange="gettotal()" class="form-control" style="width: 10%">
                                            <option value="rs" {{ @$edit->discount_type == 'rs' ? 'selected' : '' }}>Rs.</option>
                                            <option value="percentage" {{ @$edit->discount_type == 'percentage' ? 'selected' : '' }}>%</option>
                                        </select>
                                        <input type="text" name="total_discount_amount" onkeyup="gettotal()" id="total_discount_amount" value="{{ @$edit->discount_amount }}" class="form-control myfld">
                                        @error('total_discount_amount')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="d-flex justify-content-end thrdarea">
                                        <span class="biltext"> Total</span>
                                        <input type="text" name="total" readonly id="total" value="{{ @$edit->total }}" class="form-control myfld">
                                        @error('total')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="text-center">
                            <button class="btn btn-primary submitBtn" type="submit" name="action_type" value="0"><i class="fa fa-send"></i> Save</button>
                            <button class="btn btn-success submitBtn" onclick="setConfirmFlag(true)" type="submit" name="action_type" value="1"><i class="fa fa-send"></i> Save & Stock Update</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script type="text/javascript">
        let requireConfirm = false;
        function setConfirmFlag(flag) {
            requireConfirm = flag;
        }
        document.getElementById('yourFormId').addEventListener('submit', function (e) {
            if (requireConfirm) {
                const confirmed = confirm("Are you sure? After Stock Update you can't Edit or Delete!");
                if (!confirmed) {
                    e.preventDefault();
                }
            }
        });
        function getamount(i) {
            // Get the values from the inputs
            const unit_qty = parseFloat($('#unit_qty' + i).val()) || 0;
            const sub_unit_qty = parseFloat($('#sub_unit_qty' + i).val()) || 0;
            const rate = parseFloat($('#rate' + i).val()) || 0;
            const unit_details = parseFloat($('#unit_details' + i).val()) || 1;
            const total_qty = (unit_qty * unit_details) + sub_unit_qty;

            // Calculate rate
            const total_rate = (rate / unit_details) * total_qty;
            let amount = parseFloat(total_rate).toFixed(2);

            // Set the net amount
            $('#net_amount' + i).val(amount);

            // Call the Caluculate function
            Caluculate(i);
        }

        function Caluculate(i) {
            const net_amount = $('#net_amount' + i).val();
            const discount_amount = $('#discount_amount' + i).val();
            const discount_percentage = $('#discount_percentage' + i).val();

            let amount_with_discount;
            if (discount_percentage > 0) {
                amount_with_discount = net_amount - (net_amount * (discount_percentage / 100));
            } else {
                amount_with_discount = net_amount - discount_amount;
            }

            const igst = $('#igst' + i).val();
            let igst_amount = amount_with_discount * (igst / 100);
            $('#igst_amount' + i).val(igst_amount);

            const sgst = $('#sgst' + i).val();
            let sgst_amount = amount_with_discount * (sgst / 100);
            $('#sgst_amount' + i).val(sgst_amount);

            const cgst = $('#cgst' + i).val();
            let cgst_amount = amount_with_discount * (cgst / 100);
            $('#cgst_amount' + i).val(cgst_amount);
            mainmaount(i, amount_with_discount);
        }

        function getVaccineDetails(vaccine_id, i) {
            if (vaccine_id) {
                $.ajax({
                    url: "{{ route('vc.get-vaccine-unit-and-sub-unit') }}",
                    type: "post",
                    data: {
                        vaccineId: vaccine_id,
                        _token: '{{ csrf_token() }}',
                    },
                    dataType: 'json',
                    success: function(res) {
                        $('#unit' + i).val(res.unit);
                        $('#sub_unit' + i).val(res.sub_unit);
                        $('#unit_details' + i).val(res.unit_subunit_relation || 1);
                    }
                });
            }
        }
    </script>

    <script>
        function mainmaount(i, amount_with_discount) {
            var sgst_amount = $('#sgst_amount' + i).val();
            var cgst_amount = $('#cgst_amount' + i).val();
            var igst_amount = $('#igst_amount' + i).val();
            var net_amount = $('#net_amount' + i).val();
            var amount = amount_with_discount + igst_amount + sgst_amount + cgst_amount;
            $('#amount' + i).val((parseFloat(sgst_amount) + parseFloat(cgst_amount) + parseFloat(igst_amount) + parseFloat(
                amount_with_discount)).toFixed(2));
        }

        function validation() {
            var itemSelect = $('#item_name0').val();
            var batchValue = $('#batch_no0').val();
            if (itemSelect == '') {
                alert('Please Select a Item !!!');
            } else if (batchValue == '') {
                alert('Please Enter Batch !!!');
            } else {
                addNewrow();
            }
        }

        function addNewrow() {
            var table = document.getElementById("data-table");
            var newRow = table.insertRow(table.rows.length);

            var ItemSelect = $('#item_name0');
            var selectedOption = ItemSelect.find('option:selected');
            var itemValue = selectedOption.val();
            var itemText = selectedOption.text();

            var unit = $('#unit0').val();
            var unit_details = $('#unit_details0').val();
            var batch_no = $('#batch_no0').val();
            var exp_date = $('#exp_date0').val();
            var unit_qty = $('#unit_qty0').val();
            var rate = $('#rate0').val();
            var sub_unit_qty = $('#sub_unit_qty0').val();
            var sub_unit = $('#sub_unit0').val();
            var net_amount = $('#net_amount0').val();
            var discount_percentage = $('#discount_percentage0').val();
            var discount_amount = $('#discount_amount0').val();
            var cgst = $('#cgst0').val();
            var igst = $('#igst0').val();
            var sgst = $('#sgst0').val();
            var mrp = $('#mrp0').val();
            var cgst_amount = $('#cgst_amount0').val();
            var sgst_amount = $('#sgst_amount0').val();
            var igst_amount = $('#igst_amount0').val();
            var amount = $('#amount0').val();

            // Insert the correct number of cells — total 17 now (after deleting one column)
            var cell1 = newRow.insertCell(0);
            var cell2 = newRow.insertCell(1);
            var cell3 = newRow.insertCell(2);
            var cell4 = newRow.insertCell(3);
            var cell5 = newRow.insertCell(4);
            var cell6 = newRow.insertCell(5);
            var cell7 = newRow.insertCell(6);
            // Skipping previous cell8
            var cell8 = newRow.insertCell(7);
            var cell9 = newRow.insertCell(8);
            var cell10 = newRow.insertCell(9);
            var cell11 = newRow.insertCell(10);
            var cell12 = newRow.insertCell(11);
            var cell13 = newRow.insertCell(12);
            var cell14 = newRow.insertCell(13);
            var cell15 = newRow.insertCell(14);
            var cell16 = newRow.insertCell(15);
            var cell17 = newRow.insertCell(16);

            cell1.innerHTML = '<select class="form-control" name="item_name[]"><option value="' + itemValue + '">' + itemText + '</option></select>' +
                            '<input type="hidden" name="unit_details[]" readonly class="form-control" value="' + unit_details + '" />';

            cell2.innerHTML = '<input type="text" name="batch_no[]" class="form-control" value="' + batch_no + '" />';
            cell3.innerHTML = '<input type="text" name="exp_date[]" class="form-control datePickr" value="' + exp_date + '" />';
            cell4.innerHTML = '<input type="text" name="unit_qty[]" readonly class="form-control" value="' + unit_qty + '" />';
            cell5.innerHTML = '<input type="text" name="unit[]" readonly class="form-control" value="' + unit + '" />';
            cell6.innerHTML = '<input type="text" name="sub_unit_qty[]" class="form-control" value="' + sub_unit_qty + '" />';
            cell7.innerHTML = '<input type="text" name="sub_unit[]" readonly class="form-control" value="' + sub_unit + '" />';

            // Skipping old cell8 (e.g., sale rate column)

            cell8.innerHTML = '<input type="text" name="mrp[]" readonly class="form-control" value="' + mrp + '" />';
            cell9.innerHTML = '<input type="text" name="rate[]" readonly class="form-control" value="' + rate + '" />';
            cell10.innerHTML = '<input type="text" name="net_amount[]" readonly class="form-control" value="' + net_amount + '" />';
            cell11.innerHTML = '<input type="text" name="discount_percentage[]" readonly class="form-control" value="' + discount_percentage + '" />';
            cell12.innerHTML = '<input type="text" name="discount_amount[]" readonly class="form-control" value="' + discount_amount + '" />';

            cell13.innerHTML = '<input type="text" name="cgst[]" readonly class="form-control" value="' + cgst + '" />' +
                            '<input type="hidden" name="cgst_amount[]" readonly class="form-control" value="' + cgst_amount + '" />';
            cell14.innerHTML = '<input type="text" name="sgst[]" readonly class="form-control" value="' + sgst + '" />' +
                            '<input type="hidden" name="sgst_amount[]" readonly class="form-control" value="' + sgst_amount + '" />';
            cell15.innerHTML = '<input type="text" name="igst[]" readonly class="form-control" value="' + igst + '" />' +
                            '<input type="hidden" name="igst_amount[]" readonly class="form-control" value="' + igst_amount + '" />';
            cell16.innerHTML = '<input type="text" name="amount[]" readonly class="form-control" value="' + amount + '" />';
            cell17.innerHTML = '<button type="button" class="btn btn-danger btn-sm" onclick="removeRow(this)">X</button>';

            // Clear the inputs for new entry
            $('#item_name0').val('').trigger('change');
            $('#unit0, #unit_details0, #batch_no0, #exp_date0, #rate0, #sub_unit_qty0, #sub_unit0, #unit_qty0, #net_amount0, #mrp0, #discount_percentage0, #discount_amount0, #cgst0, #cgst_amount0, #sgst0, #sgst_amount0, #igst0, #igst_amount0, #amount0').val(0);

            const selectElement = document.getElementById("item_name0");
            selectElement.selectedIndex = 0;

            gettotal();
        }

        function removeRow(button) {
            var table = document.getElementById("data-table");
            var row = button.parentNode.parentNode;
            table.deleteRow(row.rowIndex);
            gettotal();
        }

        function gettotal() {
            var igst_amount = 0;
            var cgst_amount = 0;
            var sgst_amount = 0;
            var amount_with_discount = 0;
            $("input[name='amount[]']").each(function() {
                amount_with_discount += parseFloat($(this).val()) || 0;
            });
            $("input[name='igst_amount[]']").each(function() {
                igst_amount += parseFloat($(this).val()) || 0;
            });
            $("input[name='cgst_amount[]']").each(function() {
                cgst_amount += parseFloat($(this).val()) || 0;
            });
            $("input[name='sgst_amount[]']").each(function() {
                sgst_amount += parseFloat($(this).val()) || 0;
            });
            var t = amount_with_discount;
            var gwhyy = amount_with_discount - (igst_amount + cgst_amount + sgst_amount);
            $('#sub_total').val(gwhyy.toFixed(2));
            $('#total_igst_amount').val(igst_amount.toFixed(2));
            $('#total_cgst_amount').val(cgst_amount.toFixed(2));
            $('#total_sgst_amount').val(sgst_amount.toFixed(2));
            var total_discount = $('#total_discount_amount').val() || 0;
            var discountType = $('#discount_type').val();
            var r;
            if (discountType == 'percentage') {
                r = t - (t * (parseFloat(total_discount) / 100));
            } else {
                r = t - parseFloat(total_discount);
            }
            var total = r;
            $('#total').val(total.toFixed(2));
        }
    </script>
@endpush
