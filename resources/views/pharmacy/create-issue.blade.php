@extends('layouts.structure')

@push('title')
    <title>Medicine Issue</title>
@endpush

@section('main-content')
    <div class="row">
        <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12">
            <div class="card">

                <div class="card-header d-block card_hearder_mimi">
                    <div class="row">
                        <div class="col-md-6 card-title card_hearder_mimi_text">
                            MEDICINE ISSUE
                        </div>
                    </div>
                </div>

                <form method="POST" onsubmit="return validateCheckboxSelection()"
                    action="{{ route('pharmacy.save-medicine-issue') }}">
                    @csrf
                    <input type="hidden" name="requisition_id" value="{{ @$requisition_list->id }}">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4 mt-3">
                                <label class="form-label">Date <span class="text-danger">*</span></label>
                                <input type="text" class="form-control dateTimePickr" name="date"
                                    value="{{ date('d-m-Y h:i A') }}" class="form-control">
                                @error('date')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-md-4 mt-3">
                                <label class="form-label">Department</label>
                                <input type="text" readonly class="form-control"
                                    value="{{ $requisition_list->department_name ?? 'N/A' }}">
                                <input type="hidden" name="department_id" value="{{ $requisition_list->dept_id ?? 0 }}">
                            </div>


                            {{-- <div class="col-md-4 mt-3">
                                <label class="form-label">Status <span class="text-danger">*</span></label>
                                <select name="status"  class="form-control select2-show-search">
                                    <option value="">Select...</option>
                                    <option value="2">Issue Incomplete</option>
                                    <option value="3">Issue Complete</option>
                                </select>
                                @error('status')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div> --}}
                        </div>

                        <div class="border-bottom mt-4">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead class="bg-primary">
                                        <tr>
                                            <th style="width: 2%" class="text-white">
                                                <input type="checkbox" id="checkAll" onchange="toggleAllIssued(this)">
                                                Issue?
                                            </th>
                                            <th style="width: 15%" class="text-white">Medicine Name</th>
                                            <th style="width: 10%" class="text-white">Batch No</th>
                                            <th style="width: 10%" class="text-white">Expiry Date</th>
                                            <th style="width: 5%" class="text-white">Unit Qty</th>
                                            <th style="width: 7%" class="text-white">Unit</th>
                                            <th style="width: 5%" class="text-white">Sub Unit Qty</th>
                                            <th style="width: 5%" class="text-white">Sub Unit</th>
                                            <th style="width: 10%" class="text-white">Available Qty</th>
                                            <th style="width: 5%" class="text-white">Rate/Unit</th>
                                            <th style="width: 5%" class="text-white">MRP/unit</th>
                                            <th style="width: 7%" class="text-white">Net Amount</th>
                                            <th style="width: 5%" class="text-white">CGST</th>
                                            <th style="width: 5%" class="text-white">SGST</th>
                                            <th style="width: 6%" class="text-white">IGST</th>
                                            <th style="width: 7%" class="text-white">T Amount(₹)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($req_details as $key => $item)
                                            @php
                                                $disabled = $item->is_issued == 1 ? 'disabled' : '';
                                                @$issue = @$issue_details_data[@$item->id] ?? null;
                                            @endphp
                                            <tr>
                                                <td>
                                                    @if ($item->is_issued != 1)
                                                        <input class="form-control" type="checkbox" name="is_issued[]"
                                                            value="{{ $item->id }}">
                                                        <input type="hidden" name="req_details_ids[]"
                                                            value="{{ $item->id }}">
                                                    @else
                                                        <span class="badge badge-success">Issued</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <select class="form-control select2-show-search mt-2" name="medicine_name[]"
                                                        id="medicine_name{{ $key }}"
                                                        onchange="getMedicineBatchDetails(this.value, {{ $key }})"
                                                        {{ $disabled }}>
                                                        @foreach ($medicine_name as $value)
                                                            <option value="{{ $value->medicine_id }}"
                                                                {{ $item->medicine_name == $value->medicine_id ? 'selected' : '' }}>
                                                                {{ $value->medicine_name }}
                                                                ({{ $value->medicine_catagory_name }})
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    <input class="form-control" type="hidden"
                                                        id="unit_details{{ $key }}" readonly />
                                                </td>
                                                <td>
                                                    @if (@$issue && @$issue->batch_no)
                                                        <input type="text" value="{{ @$issue->batch_no }}"
                                                            class="form-control" readonly {{ $disabled }}>
                                                    @elseif (!@$issue && !@$issue->batch_no)
                                                        <select name="medicines_batch[]"
                                                            class="form-control select2-show-search mt-2"
                                                            onchange="getMedicineDetailsbyBatch(this.value, {{ $key }})"
                                                            id="medicine_batch{{ $key }}" {{ $disabled }}>
                                                            <option value="">Select Batch</option>

                                                            {{-- Batch options will be added dynamically via JS --}}
                                                        </select>
                                                    @endif
                                                </td>

                                                <td><input type="text" readonly name="expiry_date[]"
                                                        id="expiry_date{{ $key }}" class="form-control"
                                                        {{ $disabled }} value="{{ @$issue->expiry_date ?? '' }}"></td>
                                                <td><input type="text" name="unit_qty[]" value="{{ $item->unit_qty }}"
                                                        id="unit_qty{{ $key }}" class="form-control"
                                                        onkeyup="getamount({{ $key }})" {{ $disabled }}>
                                                </td>
                                                <td><input type="text" readonly value="{{ $item->unit }}"
                                                        class="form-control" name="unit[]" id="unit{{ $key }}"
                                                        {{ $disabled }}></td>
                                                <td><input type="text" name="sub_unit_qty[]"
                                                        value="{{ $item->sub_unit_qty }}"
                                                        id="sub_unit_qty{{ $key }}" class="form-control"
                                                        onkeyup="getamount({{ $key }})" {{ $disabled }}>
                                                </td>
                                                <td><input type="text" readonly value="{{ $item->sub_unit }}"
                                                        class="form-control" name="sub_unit[]"
                                                        id="sub_unit{{ $key }}" {{ $disabled }}></td>
                                                <td><input type="text" readonly id="avi_qty{{ $key }}"
                                                        class="form-control" {{ $disabled }} /></td>
                                                <td><input type="text" name="rate[]" id="rate{{ $key }}"
                                                        class="form-control" onkeyup="getamount({{ $key }})"
                                                        {{ $disabled }} value="{{ @$issue->rate ?? '' }}"></td>
                                                <td><input type="text" readonly name="mrp[]"
                                                        id="mrp{{ $key }}" class="form-control"
                                                        {{ $disabled }} value="{{ @$issue->mrp ?? '' }}"></td>
                                                <td><input type="text" readonly name="net_amount[]"
                                                        id="net_amount{{ $key }}" class="form-control"
                                                        {{ $disabled }} value="{{ @$issue->net_amount ?? '' }}"></td>
                                                <td><input type="text" readonly name="cgst[]"
                                                        id="cgst{{ $key }}" class="form-control"
                                                        {{ $disabled }} value="{{ @$issue->cgst ?? '' }}"></td>
                                                <td><input type="text" readonly name="sgst[]"
                                                        id="sgst{{ $key }}" class="form-control"
                                                        {{ $disabled }} value="{{ @$issue->sgst ?? '' }}"></td>
                                                <td><input type="text" readonly name="igst[]"
                                                        id="igst{{ $key }}" class="form-control"
                                                        {{ $disabled }} value="{{ @$issue->igst ?? '' }}"></td>
                                                <td>
                                                    <input type="text" readonly name="total_amount[]"
                                                        id="total_amount{{ $key }}" class="form-control"
                                                        {{ $disabled }} value="{{ @$issue->t_amount ?? '' }}">
                                                    <input class="form-control" type="hidden" name="cgst_amount[]"
                                                        id="cgst_amount{{ $key }}" {{ $disabled }} />
                                                    <input class="form-control" type="hidden" name="sgst_amount[]"
                                                        id="sgst_amount{{ $key }}" {{ $disabled }} />
                                                    <input class="form-control" type="hidden" name="igst_amount[]"
                                                        id="igst_amount{{ $key }}" {{ $disabled }} />
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>

                                </table>


                                @error('medicine_name')
                                    <span class="text-danger ml-4">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="col-md-8">
                                    <label class="form-label">Note</label>
                                    <textarea name="note" class="form-control">{{ old('note') }}</textarea>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex justify-content-end thrdarea">
                                    <span class="biltext"> Total</span>
                                    <input type="text" name="total" readonly id="total"
                                        value="{{ @$issue_details->total_amount }}" class="form-control myfld">
                                    @error('total')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="text-center mb-4">
                            <button type="submit" class="btn btn-primary btn-sm">Save Issue</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script>
        function toggleAllIssued(source) {
            $('input[name="is_issued[]"]').prop('checked', source.checked);
        }

        function validateCheckboxSelection() {
            const checkboxes = document.querySelectorAll('input[name="is_issued[]"]');
            const batchSelects = document.querySelectorAll('select[name="medicines_batch[]"]');

            let atLeastOneChecked = false;
            let allCheckedHaveBatch = true;

            checkboxes.forEach((checkbox, index) => {
                if (checkbox.checked) {
                    atLeastOneChecked = true;

                    const batchSelect = batchSelects[index];
                    if (!batchSelect || !batchSelect.value) {
                        allCheckedHaveBatch = false;
                    }
                }
            });

            if (!atLeastOneChecked) {
                alert('Please select at least one item to issue.');
                return false;
            }

            if (!allCheckedHaveBatch) {
                alert('Please select a batch number for all checked items.');
                return false;
            }

            return true;
        }


        $(document).ready(function() {
            @foreach ($req_details as $key => $item)
                var medicine_id = $('#medicine_name{{ $key }}').val();
                // var selected_batch = "{{ $item->batch_no ?? '' }}";
                if (medicine_id) {
                    getMedicineBatchDetails(medicine_id, {{ $key }});
                }
            @endforeach
        });

        function getMedicineBatchDetails(medicine_name, i) {
            $('#medicine_batch' + i).html('');
            $('#medicine_batch' + i).html('<option value="">Select One...</option>');

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
                        $('#medicine_batch' + i).append(
                            `<option value="${value.batch_no}">${value.batch_no}</option>`
                        );
                    });
                },
                error: function(error) {
                    console.log(error);
                }
            });
        }


        function getMedicineDetailsbyBatch(batch_no, i) {
            var medicine_id = $('#medicine_name' + i).val();

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

                    $('#expiry_date' + i).val(formatDateTime(response.medicine_details.exp_date, 'date'));
                    $('#rate' + i).val(response.medicine_details.p_rate);
                    $('#mrp' + i).val(response.medicine_details.mrp);
                    $('#unit_details' + i).val(response.medicine_stock.unit_details);
                    $('#avi_qty' + i).val(response.medicine_stock.available_stock);
                    $('#cgst' + i).val(response.medicine_details.cgst);
                    $('#sgst' + i).val(response.medicine_details.sgst);
                    $('#igst' + i).val(response.medicine_details.igst);

                    getamount(i);

                },
                error: function(error) {
                    console.log(error);
                }
            });
        }


        function getamount(i) {
            const unit_qty = parseFloat($('#unit_qty' + i).val()) || 0;
            const sub_unit_qty = parseFloat($('#sub_unit_qty' + i).val()) || 0;
            const rate = parseFloat($('#rate' + i).val()) || 0;
            const unit_details = parseFloat($('#unit_details' + i).val()) || 1;

            const total_qty = (unit_qty * unit_details) + sub_unit_qty;
            const total_rate = (rate / unit_details) * total_qty;
            const amount = parseFloat(total_rate).toFixed(2);

            $('#net_amount' + i).val(amount);

            // If needed, call your Caluculate function
            Caluculate(i);
            // gettotal();
        }

        function Caluculate(i) {
            const net_amount = $('#net_amount' + i).val();


            // let amount_with_discount;
            // if (discount_percentage > 0) {
            //     amount_with_discount = net_amount - (net_amount * (discount_percentage / 100));
            // } else {
            //     amount_with_discount = net_amount - discount_amount;
            // }

            const igst = $('#igst' + i).val();
            let igst_amount = net_amount * (igst / 100);
            $('#igst_amount' + i).val(igst_amount);

            const sgst = $('#sgst' + i).val();
            let sgst_amount = net_amount * (sgst / 100);
            $('#sgst_amount' + i).val(sgst_amount);

            const cgst = $('#cgst' + i).val();
            let cgst_amount = net_amount * (cgst / 100);
            $('#cgst_amount' + i).val(cgst_amount);
            mainmaount(i, net_amount);
            // gettotal();

        }

        function mainmaount(i, net_amount) {
            var sgst_amount = $('#sgst_amount' + i).val();
            var cgst_amount = $('#cgst_amount' + i).val();
            var igst_amount = $('#igst_amount' + i).val();
            var net_amount = $('#net_amount' + i).val();
            var amount = net_amount + igst_amount + sgst_amount + cgst_amount;
            $('#total_amount' + i).val((parseFloat(sgst_amount) + parseFloat(cgst_amount) + parseFloat(igst_amount) +
                parseFloat(
                    net_amount)).toFixed(2));
            gettotal();
        }

        var initialTotalAmount = parseFloat($('#total').val()) || 0;

        function gettotal() {
            var total_amount = 0;

            $("input[name='total_amount[]']").each(function() {
                // Check if this input or its row is disabled
                if (!$(this).prop('disabled')) {
                    var val = parseFloat($(this).val()) || 0;
                    total_amount += val;
                }
            });

            // Add initial amount to the sum of rows
            var new_total = initialTotalAmount + total_amount;

            $('#total').val(new_total.toFixed(2));
        }


        // function gettotal() {
        //     var total_amount = 0;

        //     $("input[name='total_amount[]']").each(function() {
        //         var val = parseFloat($(this).val()) || 0;
        //         total_amount += val;
        //     });

        //     // Add initial amount to the sum of rows
        //     var new_total = initialTotalAmount + total_amount;

        //     $('#total').val(new_total.toFixed(2));
        // }

        // function gettotal() {
        //     var total_amount = 0;

        //     $("input[name$='[total_amount]']").each(function() {
        //         var val = parseFloat($(this).val()) || 0;
        //         total_amount += val;
        //     });

        //     // Assuming initialTotalAmount is defined elsewhere as a global or passed in variable
        //     var new_total = (typeof initialTotalAmount !== 'undefined' ? initialTotalAmount : 0) + total_amount;

        //     $('#total').val(new_total.toFixed(2));
        // }
    </script>
@endpush
