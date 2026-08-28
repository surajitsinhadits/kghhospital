@extends('layouts.structure')
@push('title')
    <title>{{ @$t }}</title>
@endpush
@push('css')
@endpush
@section('main-content')
    <div class="row">
        <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12">
            <form
                action="{{ $po_list ? route('pharmacy.save-direct-purchase', $po_list->id) : route('pharmacy.save-direct-purchase') }}"
                method="POST" id="yourFormId" onsubmit="return checkTest()">
                @csrf
                <input type="hidden" name="purchase_id" value="{{ @$po_list->id }}">
                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12">
                        <div class="border-0">
                            <div class="tab-content">
                                <div class="tab-pane active" id="tab-7">
                                    <div class="card">
                                        <div class="card-header card_hearder_mimi">
                                            <h4 class="card_hearder_mimi_text">
                                                {{ isset($po_list) ? 'EDIT MEDICINE PURCHASE' : 'CREATE MEDICINE PURCHASE' }}
                                            </h4>
                                        </div>

                                        <div class="card-body hospital_allcardbodydesign">
                                            <div class="opdneedit">
                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <div class="main-profile-contact-list">
                                                            <div class="row">
                                                                <div class="form-group col-md-2 newaddappon">
                                                                    <label class="date-format">Date <span
                                                                            class="text-danger">*</span></label>
                                                                    <input type="text" class="dateTimePickr"
                                                                        name="date"
                                                                        value="{{ old('date', @$po_list['date'] ? dateFor($po_list['date']) : '') }}"
                                                                        required>
                                                                    @error('date')
                                                                        <small class="text-danger">{{ $message }}</small>
                                                                    @enderror
                                                                </div>

                                                                <div class="form-group col-md-2 newaddappon">
                                                                    <label for="vendor">Vendor <span
                                                                            class="text-danger">*</span></label>
                                                                    <select name="vendor"
                                                                        class="form-control select2-show-search"
                                                                        id="vendor" required>
                                                                        <option value="">Select Vendor</option>
                                                                        @foreach ($vendor_list as $value)
                                                                            <option value="{{ $value->id }}"
                                                                                {{ old('vendor', @$po_list->vendor ?? '') == $value->id ? 'selected' : '' }}>
                                                                                {{ $value->vendor_name }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                    @error('vendor')
                                                                        <small class="text-danger">{{ $message }}</small>
                                                                    @enderror
                                                                </div>

                                                                <div class="form-group col-md-2 newaddappon">
                                                                    <label for="invoice_no">Invoice No <span
                                                                            class="text-danger">*</span></label>
                                                                    <input type="text" id="invoice_no"
                                                                        value="{{ old('invoice_no', @$po_list->invoice_no) }}"
                                                                        name="invoice_no" required>
                                                                    @error('invoice_no')
                                                                        <small class="text-danger">{{ $message }}</small>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        {{-- Table to add/edit medicine items --}}
                                        <div class="table-responsive">
                                            <table class="table table-bordered border-left border-bottom border-right"
                                                id="data-table" style="width: 98%;margin-left:1%;">
                                                <thead class="bg-primary">
                                                    <tr>
                                                        <th class="text-white">Medicine</th>
                                                        <th class="text-white">Unit Qty</th>
                                                        <th class="text-white">Unit</th>
                                                        <th class="text-white">Sub Unit Qty</th>
                                                        <th class="text-white">Sub Unit</th>
                                                        <th class="text-white">Free Qty</th>
                                                        <th class="text-white">Expiry Date</th>
                                                        <th class="text-white">Batch No</th>
                                                        <th class="text-white">S. Rate/QTY</th>
                                                        <th class="text-white">P. Rate/QTY</th>
                                                        <th class="text-white">Net Amt.</th>
                                                        <th class="text-white">Dis(%)</th>
                                                        <th class="text-white">Dis(₹)</th>
                                                        <th class="text-white">CGST</th>
                                                        <th class="text-white">SGST</th>
                                                        <th class="text-white">IGST</th>
                                                        <th class="text-white">Amount</th>
                                                        <th></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>
                                                            <select class="form-control select2-show-search"
                                                                id="medicine_id0"
                                                                onchange="getmedicineDetails(this.value,{{ 0 }})">
                                                                <option value="">Select One.....</option>
                                                                @foreach ($medicine_name as $value)
                                                                    <option value="{{ $value->medicine_id }}">
                                                                        {{ $value->medicine_name }}({{ $value->medicine_catagory_name }})
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                            <input class="form-control" type="hidden" id="unit_details0"
                                                                readonly />

                                                        </td>
                                                        <td>
                                                            <input class="form-control" type="text" id="unit_qty0"
                                                                onkeyup="getamount({{ 0 }})" value="0" />
                                                        </td>
                                                        <td>
                                                            <input class="form-control" value="0" readonly
                                                                type="text" id="unit0" />
                                                        </td>
                                                        <td>
                                                            <input class="form-control" type="text" id="sub_unit_qty0"
                                                                onkeyup="getamount({{ 0 }})" value="0" />
                                                        </td>
                                                        <td>
                                                            <input class="form-control" value="0" readonly
                                                                type="text" id="sub_unit0" />
                                                        </td>
                                                        <td><input type="text" class="form-control" value="0"
                                                                id="free_qty0"></td>

                                                        <td>
                                                            <input class="form-control" type="date" value="0"
                                                                id="expiry_date0" />
                                                        </td>
                                                        <td>
                                                            <input class="form-control" type="text" value="0"
                                                                id="batch0" />
                                                        </td>
                                                        <td>
                                                            <input class="form-control" type="text" id="mrp0"
                                                                value="0"
                                                                onkeyup="getamount({{ 0 }})" />
                                                        </td>
                                                        <td>
                                                            <input class="form-control" type="text" id="rate0"
                                                                value="0"
                                                                onkeyup="getamount({{ 0 }})" />
                                                        </td>
                                                        <td>
                                                            <input class="form-control" readonly type="text"
                                                                id="net_amount0" />
                                                        </td>
                                                        <td>
                                                            <input class="form-control" type="text"
                                                                onkeyup="Caluculate({{ 0 }})"
                                                                id="discount_percentage0" value="{{ 0 }}" />
                                                        </td>
                                                        <td>
                                                            <input class="form-control" type="text"
                                                                onkeyup="Caluculate({{ 0 }})"
                                                                id="discount_amount0" value="{{ 0 }}" />
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
                                                            <input class="form-control" type="hidden" id="cgst_amount0"
                                                                readonly />
                                                            <input class="form-control" type="hidden" id="sgst_amount0"
                                                                readonly />
                                                            <input class="form-control" type="hidden" id="igst_amount0"
                                                                readonly />
                                                        </td>


                                                        <td>
                                                            <input class="form-control" readonly type="text"
                                                                id="amount0" />
                                                        </td>
                                                        <td>
                                                            <button class="btn btn-success btn-sm" onclick="validation()"
                                                                type="button">+</button>
                                                        </td>
                                                    </tr>
                                                    @php $i = 0; @endphp
                                                    @if (isset($po_item) && count($po_item) > 0)
                                                        @foreach (@$po_item as $index => $item)
                                                            <tr>
                                                                <td>
                                                                    <select class="form-control select2-show-search"
                                                                        name="medicine_id[]"
                                                                        onchange="getmedicineDetails(this.value, {{ $i }})"
                                                                        required>
                                                                        <option value="">Select One.....</option>
                                                                        @foreach ($medicine_name as $value)
                                                                            <option value="{{ $value->medicine_id }}"
                                                                                {{ $item->item_id == $value->medicine_id ? 'selected' : '' }}>
                                                                                {{ $value->medicine_name }}
                                                                                ({{ $value->medicine_catagory_name }})
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                    <input class="form-control" type="hidden"
                                                                        id="unit_details0" readonly />

                                                                </td>
                                                                <td><input type="text" class="form-control"
                                                                        name="unit_qty[]" value="{{ $item->unit_qty }}"
                                                                        onkeyup="getamount({{ $i }})"></td>
                                                                <td><input type="text" class="form-control"
                                                                        name="unit[]" value="{{ $item->unit }}"
                                                                        readonly></td>
                                                                <td><input type="text" class="form-control"
                                                                        name="sub_unit_qty[]"
                                                                        value="{{ $item->sub_unit_qty }}"
                                                                        onkeyup="getamount({{ $i }})"></td>
                                                                <td><input type="text" class="form-control"
                                                                        name="sub_unit[]" value="{{ $item->sub_unit }}"
                                                                        readonly></td>
                                                                <td><input type="text" class="form-control"
                                                                        name="free_qty[]" value="{{ $item->free_qty }}">
                                                                </td>
                                                                <td><input type="date" class="form-control"
                                                                        name="expiry_date[]"
                                                                        value="{{ $item->expiry_date }}"></td>
                                                                <td><input type="text" class="form-control"
                                                                        name="batch_no[]" value="{{ $item->batch_no }}">
                                                                </td>
                                                                <td><input type="text" class="form-control"
                                                                        name="mrp[]" value="{{ $item->mrp }}"
                                                                        onkeyup="getamount({{ $i }})"></td>
                                                                <td><input type="text" class="form-control"
                                                                        name="rate[]" value="{{ $item->rate }}"
                                                                        onkeyup="getamount({{ $i }})"></td>
                                                                <td><input type="text" class="form-control"
                                                                        name="net_amount[]"
                                                                        value="{{ $item->net_amount }}" readonly></td>
                                                                <td><input type="text" class="form-control"
                                                                        name="discount_percentage[]"
                                                                        value="{{ $item->discount_per }}"
                                                                        onkeyup="Caluculate({{ $i }})"></td>
                                                                <td><input type="text" class="form-control"
                                                                        name="discount_amount[]"
                                                                        value="{{ $item->discount_amount }}"
                                                                        onkeyup="Caluculate({{ $i }})"></td>
                                                                <td><input type="text" class="form-control"
                                                                        name="cgst[]" value="{{ $item->cgst }}"
                                                                        onkeyup="Caluculate({{ $i }})"></td>
                                                                <td><input type="text" class="form-control"
                                                                        name="sgst[]" value="{{ $item->sgst }}"
                                                                        onkeyup="Caluculate({{ $i }})"></td>
                                                                <td><input type="text" class="form-control"
                                                                        name="igst[]" value="{{ $item->igst }}"
                                                                        onkeyup="Caluculate({{ $i }})">

                                                                    <input class="form-control" type="hidden"
                                                                        id="cgst_amount{{ @$key }}"
                                                                        value="{{ @$item->cgst_amount }}"
                                                                        name="cgst_amount[]" readonly />
                                                                    <input class="form-control" type="hidden"
                                                                        id="sgst_amount{{ @$key }}"
                                                                        value="{{ @$item->sgst_amount }}"
                                                                        name="sgst_amount[]" readonly />
                                                                    <input class="form-control" type="hidden"
                                                                        value="{{ @$item->igst_amount }}"
                                                                        id="igst_amount{{ @$key }}"
                                                                        name="igst_amount[]" readonly />
                                                                </td>
                                                                <td><input type="text" class="form-control"
                                                                        name="amount[]" value="{{ $item->amount }}"
                                                                        readonly></td>
                                                                <td><button type="button" class="btn btn-danger btn-sm"
                                                                        onclick="removeRow(this)">X</button></td>
                                                            </tr>
                                                            @php $i++; @endphp
                                                        @endforeach
                                                    @endif


                                                </tbody>
                                            </table>
                                        </div>

                                        <div class="col-md-12 mt-4">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label class="form-label">Note</label>
                                                    <textarea name="note" class="form-control">{{ old('note', @$po_list->note) }}</textarea>
                                                </div>
                                                <div class="col-md-4 text-center"></div>
                                                <div class="col-md-2 text-center">
                                                    <div class="row">
                                                        <span>Total</span>
                                                        <input type="text" value="{{ @$po_list->total }}"
                                                            name="total" readonly id="total" class="form-control">
                                                    </div>
                                                    <div class="row">
                                                        <span>Total CGST</span>
                                                        <input type="text" value="{{ @$po_list->total_cgst_amount }}"
                                                            name="total_cgst_amount" readonly id="total_cgst_amount"
                                                            class="form-control">
                                                    </div>
                                                    <div class="row">
                                                        <span>Total SGST</span>
                                                        <input type="text" value="{{ @$po_list->total_sgst_amount }}"
                                                            name="total_sgst_amount" readonly id="total_sgst_amount"
                                                            class="form-control">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="modal-footer">
                                            <button class="btn btn-primary btn-sm submitBtn" type="submit"
                                                name="submit" value="close">
                                                <i class="fa fa-file text-danger"></i> Save & Close
                                            </button>
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
        function getmedicineDetails(medicine_id, i) {

            if (medicine_id != '') {
                $.ajax({
                    url: "{{ route('find-medicine-unit-by-medicine-name') }}",
                    type: "post",
                    data: {
                        medicineName_id: medicine_id,
                        _token: '{{ csrf_token() }}',
                    },
                    dataType: 'json',
                    success: function(res) {
                        console.log(res);
                        $('#unit' + i).val(res.unit);
                        $('#sub_unit' + i).val(res.sub_unit);
                        $('#cgst' + i).val(res.tax / 2);
                        $('#sgst' + i).val(res.tax / 2);
                        $('#unit_details' + i).val(res.unit_details);
                    }
                });
            }


        }

        function getamount(i) {
            const unit_qty = parseFloat($('#unit_qty' + i).val()) || 0;
            const sub_unit_qty = parseFloat($('#sub_unit_qty' + i).val()) || 0;
            const unit_details = parseFloat($('#unit_details' + i).val()) || 1;
            const rate = parseFloat($('#rate' + i).val()) || 0;

            const sub_unit_rate = (rate / unit_details) * sub_unit_qty;

            // let amount = parseFloat(unit_qty * rate).toFixed(2);
            let amount = parseFloat((unit_qty * rate) + sub_unit_rate).toFixed(2);
            $('#net_amount' + i).val(amount);
            Caluculate(i);
        }

        document.addEventListener("DOMContentLoaded", function() {
            window.checkTest = function() {
                const selects = document.getElementsByName("medicine_id[]");
                if (selects.length === 0) {
                    toastr.error("Please select at least one charge name.");
                    return false;
                }

                const chargeSelect = selects[0];
                let selectedCount = 0;

                for (let i = 0; i < chargeSelect.options.length; i++) {
                    if (chargeSelect.options[i].selected) {
                        selectedCount++;
                    }
                }

                return true;
            };
        });

        function validation() {
            var itemSelect = $('#medicine_id0').val();
            if (itemSelect == '') {
                alert('Please Select a Medicine !!!');
            } else {
                addNewrow();
            }
        }

        function addNewrow() {
            var table = document.getElementById("data-table");
            var newRow = table.insertRow(table.rows.length);



            var ItemSelect = $('#medicine_id0');
            var selectedOption = ItemSelect.find('option:selected');
            var itemValue = selectedOption.val();
            var itemText = selectedOption.text();

            var unit = $('#unit0').val();
            var unit_qty = $('#unit_qty0').val();
            var sub_unit = $('#sub_unit0').val();
            var sub_unit_qty = $('#sub_unit_qty0').val();
            var rate = $('#rate0').val();
            var expiry_date = $('#expiry_date0').val();
            var batch_name = $('#batch0').val();
            var free_qty = $('#free_qty0').val();


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




            var selectHTML = '<select class="form-control" name="medicine_id[]"><option value="' + itemValue + '">' +
                itemText + '</option></select>';
            cell1.innerHTML = selectHTML;

            var inputHTML1 = '<input type="text" name="unit_qty[]" readonly class="form-control" value="' + unit_qty +
                '" />';
            cell2.innerHTML = inputHTML1;

            var inputHTML2 = '<input type="text" name="unit[]" readonly class="form-control" value="' + unit + '" />';
            cell3.innerHTML = inputHTML2;

            var inputHTML3 = '<input type="text" name="sub_unit_qty[]" readonly class="form-control" value="' +
                sub_unit_qty +
                '" />';
            cell4.innerHTML = inputHTML3;

            var inputHTML4 = '<input type="text" name="sub_unit[]" readonly class="form-control" value="' + sub_unit +
                '" />';
            cell5.innerHTML = inputHTML4;
            var inputHTML5 = '<input type="text" name="free_qty[]" readonly class="form-control" value="' + free_qty +
                '" />';
            cell6.innerHTML = inputHTML5;

            var inputHTML6 = '<input type="text" name="expiry_date[]" readonly class="form-control" value="' + expiry_date +
                '" />';
            cell7.innerHTML = inputHTML6;

            var inputHTML7 = '<input type="text" name="batch_no[]" readonly class="form-control" value="' + batch_name +
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

            const selectElement = document.getElementById("medicine_id0");
            selectElement.selectedIndex = 0;
            $('#medicine_id0').val('').trigger('change');

            $('#unit0').val('');
            $('#unit_qty0').val(0);
            $('#sub_unit0').val('');
            $('#sub_unit_qty0').val(0);
            $('#rate0').val(0);
            $('#amount0').val(0);
            $('#expiry_date0').val(0);
            $('#batch0').val(0);
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
            $('#free_qty0').val(0);


            gettotal();

        }


        function removeRow(button) {
            var table = document.getElementById("data-table");
            var row = button.parentNode.parentNode;
            table.deleteRow(row.rowIndex);
            gettotal();
        }

        function Caluculate(i) {
            // alert(i);
            const net_amount = parseFloat($('#net_amount' + i).val()) || 0;
            const discount_amount = parseFloat($('#discount_amount' + i).val()) || 0;
            const discount_percentage = parseFloat($('#discount_percentage' + i).val()) || 0;


            let amount_with_discount;
            if (discount_percentage > 0) {
                amount_with_discount = net_amount - (net_amount * (discount_percentage / 100));
            } else {
                amount_with_discount = net_amount - discount_amount;
            }


            // var anount_with_discount = (net_amount - discount_amount);

            // var anount_with_discount = net_amount + ((net_amount * discount_amount)/100);

            const igst = parseFloat($('#igst' + i).val()) || 0;
            let igst_amount = amount_with_discount * (igst / 100);
            parseFloat($('#igst_amount' + i).val(igst_amount));

            const sgst = parseFloat($('#sgst' + i).val()) || 0;
            let sgst_amount = amount_with_discount * (sgst / 100);
            parseFloat($('#sgst_amount' + i).val(sgst_amount));

            const cgst = parseFloat($('#cgst' + i).val()) || 0;
            let cgst_amount = amount_with_discount * (cgst / 100);
            parseFloat($('#cgst_amount' + i).val(cgst_amount));
            //alert(amount_with_discount);




            mainmaount(i, amount_with_discount);


        }

        function mainmaount(i, amount_with_discount) {
            // alert('ok');
            // alert(amount_with_discount);
            var sgst_amount = parseFloat($('#sgst_amount' + i).val());
            var cgst_amount = parseFloat($('#cgst_amount' + i).val());
            var igst_amount = parseFloat($('#igst_amount' + i).val());
            var net_amount = parseFloat($('#net_amount' + i).val());


            var amount = amount_with_discount + igst_amount + sgst_amount + cgst_amount;

            $('#amount' + i).val(parseFloat(sgst_amount) + parseFloat(cgst_amount) + parseFloat(igst_amount) + parseFloat(
                amount_with_discount));

            //     var amount_with_discount =  $('#amount_with_discount' + i).val();



            //    //  $('#amount' + i).val(parseInt(sgst_amount) + parseInt(cgst_amount) + parseInt(igst_amount) + parseInt(net_amount));

            //     $('#amount' + i).val(parseInt(sgst_amount) + parseInt(cgst_amount) + parseInt(igst_amount) + parseInt(amount_with_discount));


            // const igst = parseFloat($('#igst' + i).val()) || 0;
            // const sgst = parseFloat($('#sgst' + i).val()) || 0;
            // const cgst = parseFloat($('#cgst' + i).val()) || 0;

            // // Calculate the individual tax amounts
            // const igst_amount = amount_with_discount * (igst / 100);
            // const sgst_amount = amount_with_discount * (sgst / 100);
            // const cgst_amount = amount_with_discount * (cgst / 100);

            // // Calculate the total amount including taxes
            // const amount = amount_with_discount + igst_amount + sgst_amount + cgst_amount;

            // // Update the total amount in your UI or perform any other necessary actions
            // $('#amount' + i).val(amount);

            // You can add more logic here based on your specific requirements
            // ...

            // Example: Display an alert with the total amount
            //  alert('Total Amount: ' + total_amount);


        }

        function gettotal() {

            // var net_amount = 0;
            var igst_amount = 0;
            var cgst_amount = 0;
            var sgst_amount = 0;
            var amount_with_discount = 0;

            // $("input[name='net_amount[]']").each(function() {
            //     net_amount += parseFloat($(this).val()) || 0;
            // });



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

            //  console.log("Total CGST Amount:", cgst_amount);
            //  console.log("Total SGST Amount:", sgst_amount);
            //  console.log("Total IGST Amount:", igst_amount);
            //  console.log("Total Amount with Discount:", amount_with_discount);




            // var t = net_amount + igst_amount + cgst_amount + sgst_amount;
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

            console.log("Total Amount:", total);

            $('#total').val(total.toFixed(2));
        }
    </script>
@endpush
