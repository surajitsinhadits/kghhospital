@extends('layouts.structure')
@push('title')
    <title>Purchase</title>
@endpush
@push('css')
<style>
    .myfld {
        width: 18% !important;
        margin-bottom: 5px;
    }
    .form-control_new {
        display: block;
        padding: 0.375rem 0.75rem;
        font-size: 12px;
        line-height: 1.6;
        color: #15020a;
        background-clip: padding-box;
        transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        border-radius: 6px;
        border: 1px solid #83a1a1e0;
    }
    input:read-only {
        background-color: lightgray;
        border: 1px solid #83a1a1e0;
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
                <form method="POST" action="{{ route('optical.update-purchase', @$edit->id) }}" id="yourFormId">
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
                                <div class="col-md-3">
                                    <label class="form-label">Vendor <span class="text-danger">*</span></label>
                                    <select class="form-control select2-show-search" id="vendor_id" name="vendor_id" required>
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
                                <div class="col-md-2">
                                    <label class="form-label">Invoice No <span class="text-danger">*</span></label>
                                    <input type="text" placeholder="Invoice No" name="invoice_no" class="form-control"
                                        value="{{ old('invoice_no', @$edit->invoice_no) }}" required>
                                    @error('invoice_no')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label">GRN Status <span class="text-danger">*</span></label>
                                    <select name="grn_status" class="form-control" id="grn_status">
                                        <option value="0">Incomplete</option>
                                        <option value="1">Completed</option>
                                    </select>
                                    @error('grn_status')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label">Purchase Order Id</label>
                                    {{-- <input type="text" placeholder="Purchase Order" name="po_id" class="form-control" value="{{ old('po_id', @$edit->po_id) }}"> --}}
                                    <select class="form-control select2-show-search" id="po_no" name="po_id" onchange="getpo()" required>
                                        <option value="">Select PO</option>
                                        @foreach ($po as $val)
                                            <option value="{{ @$val->id }}" {{ old('po_id', @$edit->po_id) == $val->id ? 'selected' : '' }}>PO#{{ @$val->id }}</option>
                                        @endforeach
                                    </select>
                                    @error('po_id')
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
                                        <th class="text-white">Item <span class="text-danger">*</span></th>
                                        <th class="text-white">Batch No<span class="text-danger">*</span></th>
                                        <th class="text-white">Exp. Date</th>
                                        <th class="text-white">Unit Qty <span class="text-danger">*</span></th>
                                        <th class="text-white">Unit <span class="text-danger">*</span></th>
                                        <th class="text-white">Sub Unit Qty</th>
                                        <th class="text-white">Sub Unit <span class="text-danger">*</span></th>
                                        <th class="text-white">Test QTY</th>
                                        <th class="text-white">MRP/QTY <span class="text-danger">*</span></th>
                                        <th class="text-white">Rate/QTY <span class="text-danger">*</span></th>
                                        <th class="text-white">Net Amt. <span class="text-danger">*</span></th>
                                        <th class="text-white">Dis(%)</th>
                                        <th class="text-white">Dis(₹)</th>
                                        <th class="text-white">CGST </th>
                                        <th class="text-white">SGST </th>
                                        <th class="text-white">IGST </th>
                                        <th class="text-white">Amount <span class="text-danger">*</span></th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody id="item_table">
                                    @if(!@$edit->po_id)
                                    <tr>
                                        <td>
                                            <select class="form-control select2-show-search" id="item_name0"
                                                onchange="getItemDetails(this.value,'{{ 0 }}')">
                                                <option value="">Select One.....</option>
                                                @foreach ($item_list as $value)
                                                    <option value="{{ $value->id }}">{{ $value->item_name }}</option>
                                                @endforeach
                                            </select>
                                            <input class="form-control" type="hidden" id="unit_details0" readonly />
                                        </td>
                                        <td>
                                            <input class="form-control" type="text" id="part_no0" />
                                        </td>
                                        <td>
                                            <input class="form-control datePickr" type="text" id="exp_date0" placeholder="Choose Date" />
                                        </td>
                                        <td>
                                            <input class="form-control" type="number" id="unit_qty0"
                                                onkeyup="getamount({{ 0 }})" value="0" min="0" step="0.1" />
                                        </td>
                                        <td>
                                            <input class="form-control" readonly type="text" id="unit0" />
                                        </td>
                                        <td>
                                            <input class="form-control" type="number" id="sub_unit_qty0"
                                                onkeyup="getamount({{ 0 }})" value="0" min="0" step="0.1" />
                                        </td>
                                        <td>
                                            <input class="form-control" readonly type="text" id="sub_unit0" />
                                        </td>
                                        <td>
                                            <input class="form-control" type="text" id="test_qty0" />
                                        </td>
                                        <td>
                                            <input class="form-control" type="text" id="mrp0" value="" />
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
                                    @endif
                                    @foreach (@$edit_info ?? [] as $key => $item)
                                    @php $key++; @endphp
                                    <tr>
                                        <td>
                                            <input class="form-control" type="hidden" name="uppid[]" value="{{ $item->id }}"/>
                                            <select class="form-control" name="item_name[]">
                                                <option value="{{ $item->item_id }}">{{ $item->item_name }}</option>
                                            </select>
                                            <input class="form-control" type="hidden" name="unit_details[]" id="unit_details{{ $key }}" value="{{ $item->sub_unit_no }}"/>
                                        </td>
                                        <td>
                                            <input class="form-control" type="text" name="part_no[]" value="{{ $item->part_no }}" />
                                        </td>
                                        <td>
                                            <input class="form-control datePickr" type="text" name="exp_date[]" value="{{ dateFor($item->exp_date) }}" />
                                        </td>
                                        <td>
                                            <input class="form-control" type="number" name="unit_qty[]" onkeyup="getamount({{ $key }})" id="unit_qty{{ $key }}" value="{{ $item->unit_qty }}" min="0" step="0.1" />
                                        </td>
                                        <td>
                                            <input class="form-control" type="text" name="unit[]" value="{{ $item->unit }}" readonly />
                                        </td>
                                        <td>
                                            <input class="form-control" type="number" name="sub_unit_qty[]" onkeyup="getamount({{ $key }})" id="sub_unit_qty{{ $key }}" value="{{ $item->sub_unit_qty }}" min="0" max="{{ $item->sub_unit_no - 1 }}" step="0.1" />
                                        </td>
                                        <td>
                                            <input class="form-control" type="text" name="sub_unit[]" value="{{ $item->sub_unit }}" readonly />
                                        </td>
                                        <td>
                                            <input class="form-control" type="text" name="test_qty[]" value="{{ $item->test_qty }}" />
                                        </td>
                                        <td>
                                            <input class="form-control" type="text" name="mrp[]" value="{{ $item->mrp }}" />
                                        </td>
                                        <td>
                                            <input class="form-control" type="text" name="rate[]" onkeyup="getamount({{ $key }})" id="rate{{ $key }}" value="{{ $item->rate }}" />
                                        </td>
                                        <td>
                                            <input class="form-control" type="text" name="net_amount[]" id="net_amount{{ $key }}" value="{{ $item->net_amount }}" readonly />
                                        </td>
                                        <td>
                                            <input class="form-control" type="text" name="discount_percentage[]" onkeyup="getamount({{ $key }})" id="discount_percentage{{ $key }}" value="{{ $item->discount_percentage }}" />
                                        </td>
                                        <td>
                                            <input class="form-control" type="text" name="discount_amount[]" onkeyup="getamount({{ $key }})" id="discount_amount{{ $key }}" value="{{ $item->discount_amount }}" />
                                        </td>
                                        <td>
                                            <input class="form-control" type="text" name="cgst[]" id="cgst{{ $key }}" onkeyup="getamount({{ $key }})" value="{{ $item->cgst }}" />
                                            <input class="form-control" type="hidden" name="cgst_amount[]" id="cgst_amount{{ $key }}" value="{{ $item->cgst_amount }}" />
                                        </td>
                                        <td>
                                            <input class="form-control" type="text" name="sgst[]" id="sgst{{ $key }}" onkeyup="getamount({{ $key }})" value="{{ $item->sgst }}" />
                                            <input class="form-control" type="hidden" name="sgst_amount[]" id="sgst_amount{{ $key }}" value="{{ $item->sgst_amount }}" />
                                        </td>
                                        <td>
                                            <input class="form-control" type="text" name="igst[]" id="igst{{ $key }}" onkeyup="getamount({{ $key }})" value="{{ $item->igst }}" />
                                            <input class="form-control" type="hidden" name="igst_amount[]" id="igst_amount{{ $key }}" value="{{ $item->igst_amount }}" />
                                        </td>
                                        <td>
                                            <input class="form-control" type="text" name="amount[]" id="amount{{ $key }}" value="{{ $item->amount }}" readonly />
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
                                            <option value="Payment Done" {{ old('payment_terms', @$edit->payment_terms) == 'Payment Done' ? 'selected' : '' }}>Payment Done</option>
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
                            <button class="btn btn-primary submitBtn1" type="submit" name="action_type" value="0"><i class="fa fa-send"></i> Save</button>
                            <button class="btn btn-success submitBtn1" onclick="setConfirmFlag(true)" type="submit" name="action_type" value="1"><i class="fa fa-send"></i> Save & Stock Update</button>
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
        // Replace 'yourFormId' with the actual form ID
        document.getElementById('yourFormId').addEventListener('submit', function (e) {
            const partNoInputs = document.querySelectorAll('input[name="part_no[]"]');
            const rateInputs = document.querySelectorAll('input[name="rate[]"]');
            let allFilled = true;
            partNoInputs.forEach(function(input) {
                if (!input.value.trim()) {
                    allFilled = false;
                    input.classList.add('is-invalid'); // Optionally add a class for styling
                } else {
                    input.classList.remove('is-invalid');
                }
            });
            rateInputs.forEach(function(input1) {
                if (input1.value.trim() <= 0) {
                    allFilled = false;
                    input1.classList.add('is-invalid'); // Optionally add a class for styling
                } else {
                    input1.classList.remove('is-invalid');
                }
            });

            if (!allFilled) {
                alert('Please fill in all Part No & Rate fields.');
                e.preventDefault();
                return;
            }

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
            gettotal();
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
        function getItemDetails(item_id, i) {
            if (item_id) {
                $.ajax({
                    url: "{{ route('optical.get-item-unit-and-sub-unit') }}",
                    type: "post",
                    data: {
                        itemId: item_id,
                        _token: '{{ csrf_token() }}',
                    },
                    dataType: 'json',
                    success: function(res) {
                        $('#unit' + i).val(res.unit);
                        $('#sub_unit' + i).val(res.sub_unit);
                        $('#unit_details' + i).val(res.sub_unit_no || 1);
                        $('#sub_unit_qty' + i).attr('max', res.sub_unit_no - 1);
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
            var batchValue = $('#part_no0').val();
            var subUnitQty = $('#sub_unit_qty0').val();
            var maxSubUnitQty = $('#sub_unit_qty0').attr('max');
            if (itemSelect == '') {
                alert('Please Select a Item !!!');
            } else if (batchValue == '') {
                alert('Please Enter Batch !!!');
            } else if (!isNaN(maxSubUnitQty) && subUnitQty > maxSubUnitQty) {
                alert('Sub Unit Qty cannot exceed the maximum allowed value (' + maxSubUnitQty + ')!');
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
            var batch_no = $('#part_no0').val();
            var exp_date = $('#exp_date0').val();
            var unit_qty = $('#unit_qty0').val();
            var rate = $('#rate0').val();
            var sub_unit_qty = $('#sub_unit_qty0').val();
            var sub_unit = $('#sub_unit0').val();
            var test_qty = $('#test_qty0').val();
            var net_amount = $('#net_amount0').val();
            // var discount_amount = $('#discount_per0').val();
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
            var cell15 = newRow.insertCell(14);
            var cell16 = newRow.insertCell(15);
            var cell17 = newRow.insertCell(16);
            var cell18 = newRow.insertCell(17);
            var selectHTML = '<select class="form-control" name="item_name[]"><option value="' + itemValue + '">' +
                itemText +
                '</option></select><input type="hidden" name="unit_details[]" readonly class="form-control" value="' +
                unit_details + '" />';
            cell1.innerHTML = selectHTML;

            var inputHTML1 = '<input type="text" name="part_no[]" class="form-control" value="' + batch_no + '" />';
            cell2.innerHTML = inputHTML1;

            var inputHTML2 = '<input type="date" name="exp_date[]" class="form-control datePickr" value="' + exp_date + '" />';
            cell3.innerHTML = inputHTML2;

            var inputHTML3 = '<input type="number" min="0" name="unit_qty[]" readonly class="form-control" value="' + unit_qty +
                '" />';
            cell4.innerHTML = inputHTML3;

            var inputHTML4 = '<input type="text" name="unit[]" readonly class="form-control" value="' + unit + '" />';
            cell5.innerHTML = inputHTML4;

            var inputHTML5 = '<input type="number" min="0" name="sub_unit_qty[]" readonly class="form-control" value="' + sub_unit_qty +
                '" />';
            cell6.innerHTML = inputHTML5;

            var inputHTML6 = '<input type="text" name="sub_unit[]" readonly class="form-control" value="' + sub_unit +
                '" />';
            cell7.innerHTML = inputHTML6;

            var inputHTML7 = '<input type="text" name="test_qty[]" readonly class="form-control" value="' + test_qty +
                '" />';
            cell8.innerHTML = inputHTML7;

            var inputHTML8 = '<input type="text" name="mrp[]" readonly class="form-control" value="' + mrp + '" />';
            cell9.innerHTML = inputHTML8;

            var inputHTML9 = '<input type="text" name="rate[]" readonly class="form-control" value="' + rate + '" />';
            cell10.innerHTML = inputHTML9;

            var inputHTML10 = '<input type="text" name="net_amount[]" readonly class="form-control" value="' + net_amount +
                '" />';
            cell11.innerHTML = inputHTML10;

            var inputHTML11 = '<input type="text" name="discount_percentage[]" readonly class="form-control" value="' +
                discount_percentage + '" />';
            cell12.innerHTML = inputHTML11;

            var inputHTML12 = '<input type="text" name="discount_amount[]" readonly class="form-control" value="' +
                discount_amount + '" />';
            cell13.innerHTML = inputHTML12;

            var inputHTML13 = '<input type="text" name="cgst[]" readonly class="form-control" value="' + cgst +
                '" /><input type="hidden" name="cgst_amount[]" readonly class="form-control" value="' + cgst_amount +
                '" />';
            cell14.innerHTML = inputHTML13;

            var inputHTML14 = '<input type="text" name="sgst[]" readonly class="form-control" value="' + sgst +
                '" /><input type="hidden" name="sgst_amount[]" readonly class="form-control" value="' + sgst_amount +
                '" />';
            cell15.innerHTML = inputHTML14;

            var inputHTML15 = '<input type="text" name="igst[]" readonly class="form-control" value="' + igst +
                '" /><input type="hidden" name="igst_amount[]" readonly class="form-control" value="' + igst_amount +
                '" />';
            cell16.innerHTML = inputHTML15;

            var inputHTML16 = '<input type="text" name="amount[]" readonly class="form-control" value="' + amount + '" />';
            cell17.innerHTML = inputHTML16;

            var inputHTML17 = '<button type="button" class="btn btn-danger btn-sm" onclick="removeRow(this)">X</button>';
            cell18.innerHTML = inputHTML17;

            const selectElement = document.getElementById("item_name0");
            selectElement.selectedIndex = 0;
            $('#item_name0').val('').trigger('change');

            $('#unit0').val('');
            $('#sub_unit0').val('');
            $('#test_qty0').val('');
            $('#sub_unit_qty0').val(0);
            $('#unit_qty0').val(0);
            $('#part_no0').val('');
            $('#exp_date0').val(0);
            $('#rate0').val(0);
            $('#amount0').val(0);
            $('#discount_percentage0').val(0);
            $('#discount_amount0').val(0);
            $('#cgst0').val(0);
            $('#sgst0').val(0);
            $('#igst0').val(0);
            $('#cgst_amount0').val(0);
            $('#sgst_amount0').val(0);
            $('#igst_amount0').val(0);
            $('#net_amount0').val(0);
            $('#mrp0').val(0);
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

        function getpo(){
            $('#item_table tr:not(:first)').remove();
            var po = $('#po_no').val();
            if (po) {
                $.ajax({
                    url: "{{ route('optical.get-po-details') }}",
                    type: "post",
                    data: {
                        po_id: po,
                        _token: '{{ csrf_token() }}',
                    },
                    dataType: 'json',
                    success: function(res) {
                        if (res.status) {
                            let table = document.getElementById("data-table");
                            let rowCount = table.rows.length;
                            $('#vendor_id').val(res.data.vendor_id).trigger('change');
                            $('#item_table tr:first').hide();
                            res.data.items.forEach(item => {
                                // Extract values from each item
                                let itemValue = item.item_id;
                                let itemText = item.item_name || '';
                                let unit = item.unit_name || '';
                                let sub_unit = item.sub_unit_name || '';
                                let sub_unit_no = item.sub_unit_no || 1;
                                let tol = Number(item.unit_qty * sub_unit_no) + Number(item.sub_unit_qty);
                                let avi = Number(item.punit_qty * sub_unit_no) + Number(item.psubunit_qty);
                                let rem = tol - avi;
                                let unit_qty = Math.floor(rem / sub_unit_no);
                                let sub_unit_qty = rem % sub_unit_no;

                                if((unit_qty > 0) || (sub_unit_qty > 0)){
                                    // Create new row
                                    let newRow = table.insertRow(table.rows.length);

                                    newRow.insertCell(0).innerHTML =
                                        `<select class="form-control_new" name="item_name[]">
                                            <option value="${itemValue}">${itemText}</option>
                                        </select>
                                        <input type="hidden" name="unit_details[]" id="unit_details${rowCount}" class="form-control_new" value="${sub_unit_no}" />`;

                                    newRow.insertCell(1).innerHTML =
                                        `<input type="text" name="part_no[]" class="form-control_new" value="" />`;

                                    newRow.insertCell(2).innerHTML =
                                        `<input type="date" name="exp_date[]" class="form-control_new datePickr" value="" />`;

                                    newRow.insertCell(3).innerHTML =
                                        `<input type="number" name="unit_qty[]" id="unit_qty${rowCount}" onkeyup="getamount(${rowCount})" class="form-control_new" value="${unit_qty}" max="${unit_qty}" min="0" step="0.1" />`;

                                    newRow.insertCell(4).innerHTML =
                                        `<input type="text" name="unit[]" readonly class="form-control_new" value="${unit}" />`;

                                    newRow.insertCell(5).innerHTML =
                                        `<input type="number" name="sub_unit_qty[]" id="sub_unit_qty${rowCount}" onkeyup="getamount(${rowCount})" class="form-control_new" value="${sub_unit_qty}" max="${sub_unit_no - 1}" min="0" step="0.1" />`;

                                    newRow.insertCell(6).innerHTML =
                                        `<input type="text" name="sub_unit[]" readonly class="form-control_new" value="${sub_unit}" />`;

                                    newRow.insertCell(7).innerHTML =
                                        `<input type="text" name="test_qty[]" class="form-control_new" value="0" />`;

                                    newRow.insertCell(8).innerHTML =
                                        `<input type="text" name="mrp[]" class="form-control_new" value="" />`;

                                    newRow.insertCell(9).innerHTML =
                                        `<input type="text" name="rate[]" id="rate${rowCount}" onkeyup="getamount(${rowCount})" class="form-control_new" value="0" />`;

                                    newRow.insertCell(10).innerHTML =
                                        `<input type="text" name="net_amount[]" id="net_amount${rowCount}" readonly class="form-control_new" value="0" />`;

                                    newRow.insertCell(11).innerHTML =
                                        `<input type="text" name="discount_percentage[]" id="discount_percentage${rowCount}" onkeyup="getamount(${rowCount})" class="form-control_new" value="0" />`;

                                    newRow.insertCell(12).innerHTML =
                                        `<input type="text" name="discount_amount[]" id="discount_amount${rowCount}" onkeyup="getamount(${rowCount})" class="form-control_new" value="0" />`;

                                    newRow.insertCell(13).innerHTML =
                                        `<input type="text" name="cgst[]" id="cgst${rowCount}" onkeyup="getamount(${rowCount})" class="form-control_new" value="0" />
                                        <input type="hidden" name="cgst_amount[]" id="cgst_amount${rowCount}" class="form-control_new" value="0" />`;

                                    newRow.insertCell(14).innerHTML =
                                        `<input type="text" name="sgst[]" id="sgst${rowCount}" onkeyup="getamount(${rowCount})" class="form-control_new" value="0" />
                                        <input type="hidden" name="sgst_amount[]" id="sgst_amount${rowCount}" class="form-control_new" value="0" />`;

                                    newRow.insertCell(15).innerHTML =
                                        `<input type="text" name="igst[]" id="igst${rowCount}" onkeyup="getamount(${rowCount})" class="form-control_new" value="0" />
                                        <input type="hidden" name="igst_amount[]" id="igst_amount${rowCount}" class="form-control_new" value="0" />`;

                                    newRow.insertCell(16).innerHTML =
                                        `<input type="text" name="amount[]" id="amount${rowCount}" readonly class="form-control_new" value="0" />`;

                                    newRow.insertCell(17).innerHTML =
                                        `<button type="button" class="btn btn-danger btn-sm" onclick="removeRow(this)">X</button>`;
                                }
                                rowCount++;
                            });
                        } else {
                            alert('PO not found');
                        }
                    }
                });
            }else{
                $('#item_table tr:first').show();
            }
        }
    </script>
@endpush
