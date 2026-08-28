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
                <form method="POST" action="{{ route('kt.update-purchase', @$edit->id) }}" id="yourFormId">
                    @csrf
                    <div class="card-body">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-3">
                                    <label class="date-format">Date<span class="text-danger">*</span></label>
                                    <input type="text" class="dateTimePickr" name="date" id="date"
                                        value="{{ old('date', dateFor(@$edit->date, true) ?? date('d-m-Y h:i A')) }}"
                                        required />
                                    @error('date')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-3" id="vendor_id">
                                    <label class="form-label">Vendor <span class="text-danger">*</span></label>
                                    <select class="form-control select2-show-search" name="vendor_id">
                                        <option value="">Select Vendor</option>
                                        @foreach ($vendor as $value)
                                            <option value="{{ @$value->id }}"
                                                {{ old('vendor_id', @$edit->vendor_id) == $value->id ? 'selected' : '' }}>
                                                {{ @$value->supplier }}</option>
                                        @endforeach
                                    </select>
                                    @error('vendor_id')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Invoice No <span class="text-danger">*</span></label>
                                    <input type="text" placeholder="Invoice No" name="invoice_no" class="form-control"
                                        value="{{ old('invoice_no', @$edit->invoice_no) }}">
                                    @error('invoice_no')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Purchase Order ID</label>
                                    <select class="form-control select2-show-search" name="po_id">
                                        <option value="">Select PO</option>
                                        @foreach ($po as $val)
                                            <option value="{{ @$val->id }}"
                                                {{ old('po_id', @$edit->po_id) == $val->id ? 'selected' : '' }}>
                                                KTPO#{{ @$val->id }}</option>
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
                                        <th class="text-white" style="padding-left: 20px; padding-right:20px">Item <span
                                                class="text-danger">*</span></th>
                                        <th class="text-white" style="padding-left: 10px; padding-right:10px">Exp. Date</th>
                                        <th class="text-white" style="padding-left: 10px; padding-right:10px">Unit Qty <span
                                                class="text-danger">*</span></th>
                                        <th class="text-white" style="padding-left: 10px; padding-right:10px">Unit <span
                                                class="text-danger">*</span></th>
                                        <th class="text-white" style="padding-left: 20px; padding-right:20px">MRP/QTY </th>
                                        <th class="text-white" style="padding-left: 20px; padding-right:20px">Rate/QTY <span
                                                class="text-danger">*</span></th>
                                        <th class="text-white" style="padding-left: 20px; padding-right:20px">Net Amt. <span
                                                class="text-danger">*</span></th>
                                        <th class="text-white" style="padding-left: 10px; padding-right:10px">Dis(%) </th>
                                        <th class="text-white" style="padding-left: 10px; padding-right:10px">Dis(₹) </th>
                                        <th class="text-white" style="padding-left: 10px; padding-right:10px">GST </th>
                                        <th class="text-white" style="padding-left: 10px; padding-right:10px">Amount <span
                                                class="text-danger">*</span></th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td style="width: 200px">
                                            <select class="form-control select2-show-search" id="item_name0"
                                                onchange="getItemDetails(this.value,'{{ 0 }}')">
                                                <option value="">Select</option>
                                                @foreach ($item_list as $value)
                                                    <option value="{{ $value->id }}">{{ $value->item_name }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <input class="form-control datePickr" type="text" id="exp_date0"
                                                placeholder="Choose Date" />
                                        </td>
                                        <td>
                                            <input class="form-control" type="text" id="unit_qty0"
                                                onkeyup="getamount({{ 0 }})" value="0" />
                                        </td>
                                        <td>
                                            <input class="form-control" readonly type="text" id="unit0" />
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
                                                onkeyup="Caluculate({{ 0 }})" id="gst0"
                                                value="{{ 0 }}" />
                                            <input class="form-control" type="hidden" id="gst_amount0" readonly />
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
                                                <input class="form-control" type="hidden" name="uppid[]"
                                                    value="{{ $item->id }}" />
                                                <select class="form-control" name="item_name[]">
                                                    <option value="{{ $item->item_id }}">{{ $item->item_name }}</option>
                                                </select>
                                            </td>
                                            <td>
                                                <input class="form-control datePickr" type="text" name="exp_date[]"
                                                    value="{{ dateFor($item->exp_date) }}" />
                                            </td>
                                            <td>
                                                <input class="form-control" type="text" name="unit_qty[]"
                                                    value="{{ $item->unit_qty }}" readonly />
                                            </td>
                                            <td>
                                                <input class="form-control" type="text" name="unit[]"
                                                    value="{{ $item->unit }}" readonly />
                                            </td>
                                            <td>
                                                <input class="form-control" type="text" name="mrp[]"
                                                    value="{{ $item->mrp }}" readonly />
                                            </td>
                                            <td>
                                                <input class="form-control" type="text" name="rate[]"
                                                    value="{{ $item->rate }}" readonly />
                                            </td>
                                            <td>
                                                <input class="form-control" type="text" name="net_amount[]"
                                                    value="{{ $item->net_amount }}" readonly />
                                            </td>
                                            <td>
                                                <input class="form-control" type="text" name="discount_percentage[]"
                                                    value="{{ $item->discount_percentage }}" readonly />
                                            </td>
                                            <td>
                                                <input class="form-control" type="text" name="discount_amount[]"
                                                    value="{{ $item->discount_amount }}" readonly />
                                            </td>
                                            <td>
                                                <input class="form-control" type="text" name="gst[]"
                                                    value="{{ $item->gst }}" readonly />
                                                <input class="form-control" type="hidden" name="gst_amount[]"
                                                    value="{{ $item->gst_amount }}" />
                                            </td>
                                            <td>
                                                <input class="form-control" type="text" name="amount[]"
                                                    value="{{ $item->amount }}" readonly />
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-danger btn-sm"
                                                    onclick="removeRow(this)">X</button>
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
                                            <option value="Advance"
                                                {{ old('payment_terms', @$edit->payment_terms) == 'Advance' ? 'selected' : '' }}>
                                                Advance</option>
                                            <option value="After Billing"
                                                {{ old('payment_terms', @$edit->payment_terms) == 'After Billing' ? 'selected' : '' }}>
                                                After Billing</option>
                                            <option value="Payment Done"
                                                {{ old('payment_terms', @$edit->payment_terms) == 'Payment Done' ? 'selected' : '' }}>
                                                Paymen Done</option>
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
                                        <input type="text" value="{{ @$edit->sub_total }}" name="sub_total" readonly
                                            id="sub_total" class="form-control myfld">
                                    </div>
                                    <div class="d-flex justify-content-end">
                                        <span class="biltext">GST Amount</span>
                                        <input type="text" value="{{ @$edit->total_gst_amount }}"
                                            name="total_gst_amount" readonly id="total_gst_amount"
                                            class="form-control myfld">
                                    </div>
                                    <div class="d-flex justify-content-end thrdarea">
                                        <span class="biltext">Discount</span>
                                        <select name="discount_type" id="discount_type" onchange="gettotal()"
                                            class="form-control" style="width: 10%">
                                            <option value="rs" {{ @$edit->discount_type == 'rs' ? 'selected' : '' }}>
                                                Rs.</option>
                                            <option value="percentage"
                                                {{ @$edit->discount_type == 'percentage' ? 'selected' : '' }}>%</option>
                                        </select>
                                        <input type="text" name="total_discount_amount" onkeyup="gettotal()"
                                            id="total_discount_amount" value="{{ @$edit->discount_amount }}"
                                            class="form-control myfld">
                                        @error('total_discount_amount')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="d-flex justify-content-end thrdarea">
                                        <span class="biltext"> Total</span>
                                        <input type="text" name="total" readonly id="total"
                                            value="{{ @$edit->total }}" class="form-control myfld">
                                        @error('total')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="text-center">
                            <button class="btn btn-primary submitBtn" type="submit" name="action_type"
                                value="0"><i class="fa fa-send"></i> Save</button>
                            <button class="btn btn-success submitBtn" onclick="setConfirmFlag(true)" type="submit"
                                name="action_type" value="1"><i class="fa fa-send"></i> Save & Stock Update</button>
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
        document.getElementById('yourFormId').addEventListener('submit', function(e) {
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
            const rate = parseFloat($('#rate' + i).val()) || 0;

            // Calculate rate
            const total_rate = (unit_qty * rate);
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

            const gst = $('#gst' + i).val();
            let gst_amount = amount_with_discount * (gst / 100);
            console.log(gst_amount);

            $('#gst_amount' + i).val(gst_amount);
            mainmaount(i, amount_with_discount);
        }

        function getItemDetails(item_id, i) {
            if (item_id) {
                $.ajax({
                    url: "{{ route('kt.item-unit') }}",
                    type: "post",
                    data: {
                        itemId: item_id,
                        _token: '{{ csrf_token() }}',
                    },
                    dataType: 'json',
                    success: function(res) {
                        $('#unit' + i).val(res.unit);
                    }
                });
            }
        }

        function mainmaount(i, amount_with_discount) {
            var gst_amount = $('#gst_amount' + i).val();
            var net_amount = $('#net_amount' + i).val();
            var amount = amount_with_discount + gst_amount;
            $('#amount' + i).val((parseFloat(gst_amount) + parseFloat(amount_with_discount)).toFixed(2));
        }

        function validation() {
            var itemSelect = $('#item_name0').val();
            if (itemSelect == '') {
                alert('Please Select a Item !!!');
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
            var exp_date = $('#exp_date0').val() ?? null;
            var unit_qty = $('#unit_qty0').val();
            var rate = $('#rate0').val();
            var net_amount = $('#net_amount0').val();
            // var discount_amount = $('#discount_per0').val();
            var discount_percentage = $('#discount_percentage0').val();
            var discount_amount = $('#discount_amount0').val();
            var gst = $('#gst0').val();
            var mrp = $('#mrp0').val();
            var gst_amount = $('#gst_amount0').val();
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
            var selectHTML = '<select class="form-control" name="item_name[]"><option value="' + itemValue + '">' +
                itemText +
                '</option></select>';
            cell1.innerHTML = selectHTML;

            var inputHTML1 = '<input type="text" name="exp_date[]" class="form-control datePickr" value="' + exp_date +
                '" />';
            cell2.innerHTML = inputHTML1;

            var inputHTML2 = '<input type="text" name="unit_qty[]" readonly class="form-control" value="' + unit_qty +
                '" />';
            cell3.innerHTML = inputHTML2;

            var inputHTML3 = '<input type="text" name="unit[]" readonly class="form-control" value="' + unit + '" />';
            cell4.innerHTML = inputHTML3;

            var inputHTML4 = '<input type="text" name="mrp[]" readonly class="form-control" value="' + mrp + '" />';
            cell5.innerHTML = inputHTML4;

            var inputHTML5 = '<input type="text" name="rate[]" readonly class="form-control" value="' + rate + '" />';
            cell6.innerHTML = inputHTML5;

            var inputHTML6 = '<input type="text" name="net_amount[]" readonly class="form-control" value="' + net_amount +
                '" />';
            cell7.innerHTML = inputHTML6;

            var inputHTML7 = '<input type="text" name="discount_percentage[]" readonly class="form-control" value="' +
                discount_percentage + '" />';
            cell8.innerHTML = inputHTML7;

            var inputHTML8 = '<input type="text" name="discount_amount[]" readonly class="form-control" value="' +
                discount_amount + '" />';
            cell9.innerHTML = inputHTML8;

            var inputHTML9 = '<input type="text" name="gst[]" readonly class="form-control" value="' + gst +
                '" /><input type="hidden" name="gst_amount[]" readonly class="form-control" value="' + gst_amount +
                '" />';
            cell10.innerHTML = inputHTML9;

            var inputHTML10 = '<input type="text" name="amount[]" readonly class="form-control" value="' + amount + '" />';
            cell11.innerHTML = inputHTML10;

            var inputHTML11 = '<button type="button" class="btn btn-danger btn-sm" onclick="removeRow(this)">X</button>';
            cell12.innerHTML = inputHTML11;

            const selectElement = document.getElementById("item_name0");
            selectElement.selectedIndex = 0;
            $('#item_name0').val('').trigger('change');

            $('#unit0').val('');
            $('#unit_qty0').val(0);
            $('#exp_date0').val(0);
            $('#rate0').val(0);
            $('#amount0').val(0);
            $('#discount_percentage0').val(0);
            $('#discount_amount0').val(0);
            $('#gst0').val(0);
            $('#gst_amount0').val(0);
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
            var gst_amount = 0;
            var amount_with_discount = 0;
            $("input[name='amount[]']").each(function() {
                amount_with_discount += parseFloat($(this).val()) || 0;
            });
            $("input[name='gst_amount[]']").each(function() {
                gst_amount += parseFloat($(this).val()) || 0;
            });
            var t = amount_with_discount;
            var gwhyy = amount_with_discount - gst_amount;
            $('#sub_total').val(gwhyy.toFixed(2));
            $('#total_gst_amount').val(gst_amount.toFixed(2));
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

    <script>
        $(document).ready(function() {
            // Utility: Show error (toastr if available, else alert)
            function showError(msg) {
                if (typeof toastr !== 'undefined') {
                    toastr.error(msg);
                } else {
                    alert(msg);
                }
            }

            // Restrict numeric fields to numbers and one dot (for decimals)
            $(document).on('input',
                'input[id^="unit_qty"], input[id^="rate"], input[id^="mrp"], input[id^="discount_percentage"], input[id^="discount_amount"], input[id^="gst"], input[id^="amount"], input[id^="net_amount"], input[id^="gst_amount"], input[name="unit_qty[]"], input[name="rate[]"], input[name="mrp[]"], input[name="discount_percentage[]"], input[name="discount_amount[]"], input[name="gst[]"], input[name="amount[]"], input[name="net_amount[]"], input[name="gst_amount[]"], #total_discount_amount',
                function() {
                    this.value = this.value.replace(/[^0-9.]/g, '');
                    // Only one dot allowed
                    let parts = this.value.split('.');
                    if (parts.length > 2) {
                        this.value = parts[0] + '.' + parts.slice(1).join('');
                    }
                });

            // Prevent negative numbers on paste for numeric fields
            $(document).on('paste', 'input[type="text"]', function(e) {
                let paste = (e.originalEvent || e).clipboardData.getData('text');
                if (paste.match(/-/)) {
                    e.preventDefault();
                }
            });

            // Live validation for date
            $('#date').on('input change', function() {
                let $el = $(this);
                if (!$el.val().trim()) {
                    $el.addClass('border border-danger').css('border-color', '#dc3545');
                } else {
                    $el.removeClass('border-danger').addClass('border-primary').css('border-color',
                        '#007bff');
                }
            });

            // Live validation for vendor
            $('select[name="vendor_id"]').on('change', function() {
                let $el = $(this);
                if (!$el.val() || $el.val() === '') {
                    $el.addClass('border border-danger').css('border-color', '#dc3545');
                } else {
                    $el.removeClass('border-danger').addClass('border-primary').css('border-color',
                        '#007bff');
                }
            });

            // Live validation for invoice no
            $('input[name="invoice_no"]').on('input change', function() {
                let $el = $(this);
                if (!$el.val().trim()) {
                    $el.addClass('border border-danger').css('border-color', '#dc3545');
                } else {
                    $el.removeClass('border-danger').addClass('border-primary').css('border-color',
                        '#007bff');
                }
            });

            // Live validation for payment terms
            $('select[name="payment_terms"]').on('change', function() {
                let $el = $(this);
                if (!$el.val() || $el.val() === '') {
                    $el.addClass('border border-danger').css('border-color', '#dc3545');
                } else {
                    $el.removeClass('border-danger').addClass('border-primary').css('border-color',
                        '#007bff');
                }
            });

            // Live validation for item select in first row
            $('#item_name0').on('change', function() {
                let $el = $(this);
                if (!$el.val() || $el.val() === '') {
                    $el.addClass('border border-danger').css('border-color', '#dc3545');
                } else {
                    $el.removeClass('border-danger').addClass('border-primary').css('border-color',
                        '#007bff');
                }
            });

            // Live validation for unit_qty0 and rate0 in first row
            $('#unit_qty0, #rate0').on('input change', function() {
                let $el = $(this);
                let val = $el.val().trim();
                if (!val || isNaN(val) || Number(val) <= 0) {
                    $el.addClass('border border-danger').css('border-color', '#dc3545');
                } else {
                    $el.removeClass('border-danger').addClass('border-primary').css('border-color',
                        '#007bff');
                }
            });

            // Live validation for dynamically added rows
            $(document).on('change', 'select[name="item_name[]"]', function() {
                let $el = $(this);
                if (!$el.val() || $el.val() === '') {
                    $el.addClass('border border-danger').css('border-color', '#dc3545');
                } else {
                    $el.removeClass('border-danger').addClass('border-primary').css('border-color',
                        '#007bff');
                }
            });
            $(document).on('input change', 'input[name="unit_qty[]"], input[name="rate[]"]', function() {
                let $el = $(this);
                let val = $el.val().trim();
                if (!val || isNaN(val) || Number(val) <= 0) {
                    $el.addClass('border border-danger').css('border-color', '#dc3545');
                } else {
                    $el.removeClass('border-danger').addClass('border-primary').css('border-color',
                        '#007bff');
                }
            });

            // Live validation for total_discount_amount (must be number, can be 0 or positive)
            $('#total_discount_amount').on('input change', function() {
                let $el = $(this);
                let val = $el.val().trim();
                if (val !== '' && (isNaN(val) || Number(val) < 0)) {
                    $el.addClass('border border-danger').css('border-color', '#dc3545');
                } else {
                    $el.removeClass('border-danger').addClass('border-primary').css('border-color',
                        '#007bff');
                }
            });

            // On submit, validate all fields
            $('#yourFormId').on('submit', function(e) {
                let valid = true;
                let firstInvalid = null;

                // 1. Validate date
                let $date = $('#date');
                if (!$date.val().trim()) {
                    showError('Date is required.');
                    $date.addClass('border border-danger').css('border-color', '#dc3545');
                    valid = false;
                    firstInvalid = firstInvalid || $date;
                } else {
                    $date.removeClass('border-danger').addClass('border-primary').css('border-color',
                        '#007bff');
                }

                // 2. Validate vendor
                let $vendor = $('select[name="vendor_id"]');
                if (!$vendor.val() || $vendor.val() === '') {
                    showError('Vendor is required.');
                    $vendor.addClass('border border-danger').css('border-color', '#dc3545');
                    valid = false;
                    firstInvalid = firstInvalid || $vendor;
                } else {
                    $vendor.removeClass('border-danger').addClass('border-primary').css('border-color',
                        '#007bff');
                }

                // 3. Validate invoice no
                let $invoice = $('input[name="invoice_no"]');
                if (!$invoice.val().trim()) {
                    showError('Invoice No is required.');
                    $invoice.addClass('border border-danger').css('border-color', '#dc3545');
                    valid = false;
                    firstInvalid = firstInvalid || $invoice;
                } else {
                    $invoice.removeClass('border-danger').addClass('border-primary').css('border-color',
                        '#007bff');
                }

                // 4. Validate payment terms
                let $payment = $('select[name="payment_terms"]');
                if (!$payment.val() || $payment.val() === '') {
                    showError('Payment Terms is required.');
                    $payment.addClass('border border-danger').css('border-color', '#dc3545');
                    valid = false;
                    firstInvalid = firstInvalid || $payment;
                } else {
                    $payment.removeClass('border-danger').addClass('border-primary').css('border-color',
                        '#007bff');
                }

                // 5. Validate at least one item row (including first row)
                let itemRows = 0;
                // First row
                let $item0 = $('#item_name0');
                if ($item0.length && $item0.val() && $item0.val() !== '') {
                    itemRows++;
                }
                // Dynamic rows
                $('select[name="item_name[]"]').each(function() {
                    if ($(this).val() && $(this).val() !== '') {
                        itemRows++;
                    }
                });
                if (itemRows === 0) {
                    showError('Please add at least one item.');
                    $('#item_name0').addClass('border border-danger').css('border-color', '#dc3545');
                    valid = false;
                    firstInvalid = firstInvalid || $('#item_name0');
                }

                // 6. Validate unit_qty and rate for all item rows
                // First row
                let $unit_qty0 = $('#unit_qty0');
                let $rate0 = $('#rate0');
                if ($item0.length && $item0.val() && $item0.val() !== '') {
                    if (!$unit_qty0.val() || isNaN($unit_qty0.val()) || Number($unit_qty0.val()) <= 0) {
                        showError('Unit Qty is required and must be a positive number.');
                        $unit_qty0.addClass('border border-danger').css('border-color', '#dc3545');
                        valid = false;
                        firstInvalid = firstInvalid || $unit_qty0;
                    } else {
                        $unit_qty0.removeClass('border-danger').addClass('border-primary').css(
                            'border-color', '#007bff');
                    }
                    if (!$rate0.val() || isNaN($rate0.val()) || Number($rate0.val()) <= 0) {
                        showError('Rate is required and must be a positive number.');
                        $rate0.addClass('border border-danger').css('border-color', '#dc3545');
                        valid = false;
                        firstInvalid = firstInvalid || $rate0;
                    } else {
                        $rate0.removeClass('border-danger').addClass('border-primary').css('border-color',
                            '#007bff');
                    }
                }
                // Dynamic rows
                $('#data-table tbody tr').each(function() {
                    let $row = $(this);
                    let $itemSelect = $row.find('select[name="item_name[]"]');
                    let $unitQty = $row.find('input[name="unit_qty[]"]');
                    let $rate = $row.find('input[name="rate[]"]');
                    if ($itemSelect.length && $itemSelect.val() && $itemSelect.val() !== '') {
                        if (!$unitQty.val() || isNaN($unitQty.val()) || Number($unitQty.val()) <=
                            0) {
                            showError('Unit Qty is required and must be a positive number.');
                            $unitQty.addClass('border border-danger').css('border-color',
                            '#dc3545');
                            valid = false;
                            firstInvalid = firstInvalid || $unitQty;
                        } else {
                            $unitQty.removeClass('border-danger').addClass('border-primary').css(
                                'border-color', '#007bff');
                        }
                        if (!$rate.val() || isNaN($rate.val()) || Number($rate.val()) <= 0) {
                            showError('Rate is required and must be a positive number.');
                            $rate.addClass('border border-danger').css('border-color', '#dc3545');
                            valid = false;
                            firstInvalid = firstInvalid || $rate;
                        } else {
                            $rate.removeClass('border-danger').addClass('border-primary').css(
                                'border-color', '#007bff');
                        }
                    }
                });

                // 7. Validate total_discount_amount (must be number, can be 0 or positive)
                let $discount = $('#total_discount_amount');
                let discountVal = $discount.val().trim();
                if (discountVal !== '' && (isNaN(discountVal) || Number(discountVal) < 0)) {
                    showError('Discount Amount must be a number and not negative.');
                    $discount.addClass('border border-danger').css('border-color', '#dc3545');
                    valid = false;
                    firstInvalid = firstInvalid || $discount;
                } else {
                    $discount.removeClass('border-danger').addClass('border-primary').css('border-color',
                        '#007bff');
                }

                if (!valid) {
                    e.preventDefault();
                    if (firstInvalid) firstInvalid.focus();
                }
            });

            // Remove error highlight on input/change
            $('#yourFormId input, #yourFormId select').on('input change', function() {
                $(this).removeClass('border-danger').css('border-color', '');
            });
        });
    </script>
@endpush
