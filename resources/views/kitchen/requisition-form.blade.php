@extends('layouts.structure')
@push('title')
    <title>Requisition</title>
@endpush
@push('css')
@endpush
@section('main-content')
    <div class="row">
        <div class="card">
            <div class="card-header d-block card_hearder_mimi">
                <div class="row">
                    <div class="col-md-6 card-title card_hearder_mimi_text">
                        {{ $title }} Requisition
                    </div>
                </div>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('kt.update-requisition', @$response->id ?? 0) }}" id="yourFormId">
                    @csrf
                    <div class="card-body" style="margin:-6px;">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-2 mt-3">
                                    <label class="form-label">Date <span class="text-danger">*</span></label>
                                    <input type="text" class="dateTimePickr" name="requisition_date"
                                        id="requisition_date"
                                        value="{{ old('po_date', @$response->requisition_date ? \Carbon\Carbon::parse($response->requisition_date)->format('d-m-Y h:i A') : date('d-m-Y h:i A')) }}"
                                        required />
                                    @error('requisition_date')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="col-md-10 mt-3">
                                    <label class="form-label">Note</label>
                                    <textarea class="form-control" rows="1" name="note">{{ @$response->note }}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="mt-3">
                            <div class="table-responsive">
                                <table class="table card-table table-vcenter text-nowrap border" id="data-table">
                                    <thead class="bg-primary text-white">
                                        <tr>
                                            <th class="text-white" style="width: 30%">Item Name <span
                                                    class="text-danger">*</span></th>
                                            <th class="text-white" style="width: 10%">Unit Qty<span
                                                    class="text-danger">*</span></th>
                                            <th class="text-white" style="width: 10%">Unit<span class="text-danger">*</span>
                                            </th>
                                            {{-- <th class="text-white" style="width: 10%">Sub Unit Qty<span class="text-danger">*</span></th>
                                        <th class="text-white" style="width: 10%">Sub Unit<span class="text-danger">*</span></th> --}}
                                            <th class="text-white" style="width: 2%"></th>
                                        </tr>
                                    </thead>
                                    <tbody id="chargeTable">
                                        <tr>
                                            <td>
                                                <select class="form-control select2-show-search item_id" name="item_id"
                                                    onchange="getItemDetails(this.value, this)">
                                                    <option value="">Select One.....</option>
                                                    @foreach ($item_list as $value)
                                                        <option value="{{ $value->id }}">{{ $value->item_name }}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td>
                                                <input class="form-control unit_qty" type="text" name="unit_qty"
                                                    value="0" />
                                            </td>
                                            <td>
                                                <input class="form-control unit" readonly type="text" name="unit_name"
                                                    value="0" />
                                            </td>
                                            <td>
                                                <button class="btn btn-success btn-sm" type="button"
                                                    onclick="validation()">+</button>
                                            </td>
                                            <input type="hidden" class="unit_id" name="unit_id" />
                                        </tr>
                                        @foreach (@$item_details ?? [] as $key => $item)
                                            <tr>
                                                <td>
                                                    <select class="form-control" name="item_id[]">
                                                        <option value="">Select One.....</option>
                                                        @foreach ($item_list as $value)
                                                            <option value="{{ $value->id }}"
                                                                {{ @$item->item_id == $value->id ? 'selected' : '' }}>
                                                                {{ @$value->item_name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td><input class="form-control" name="unit_qty[]" type="text"
                                                        value="{{ @$item->unit_qty }}" /></td>
                                                <td><input class="form-control" name="unit_name[]" type="text" readonly
                                                        value="{{ @$item->unit }}" /></td>
                                                <td>
                                                    <button class="btn btn-danger btn-sm" type="button"
                                                        onclick="removeRow(this)">X</button>
                                                </td>
                                                <input type="hidden" name="unit_id[]" value="{{ @$item->unit_id }}">
                                                <input type="hidden" name="item_detail_id[]" value="{{ @$item->id }}">
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="text-center mb-4">
                        <button type="submit" class="btn btn-primary px-5"> Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script type="text/javascript">
        function getItemDetails(item_id, element) {
            if (item_id !== '') {
                $.ajax({
                    url: "{{ route('kt.item-unit') }}",
                    type: "POST",
                    data: {
                        itemId: item_id,
                        _token: '{{ csrf_token() }}'
                    },
                    dataType: 'json',
                    success: function(res) {
                        let row = $(element).closest('tr');
                        row.find('.unit').val(res.unit || '');
                        row.find('.unit_id').val(res.unit_id || '');
                    },
                    error: function() {
                        let row = $(element).closest('tr');
                        row.find('.unit').val('');
                    }
                });
            }
        }

        function validation() {
            var itemSelect = $('#chargeTable').find('tr:first .item_id').val();
            if (itemSelect === '') {
                alert('Please Select an Item!');
            } else {
                addNewrow();
            }
        }

        function addNewrow() {
            let firstRow = $('#chargeTable').find('tr:first');
            let item_id = firstRow.find('.item_id').val();
            let item_text = firstRow.find('.item_id option:selected').text();
            let unit_qty = firstRow.find('.unit_qty').val();
            let unit = firstRow.find('.unit').val();
            let sub_unit_qty = firstRow.find('.sub_unit_qty').val();
            let sub_unit = firstRow.find('.sub_unit').val();
            let unit_id = firstRow.find('.unit_id').val();
            let sub_unit_id = firstRow.find('.sub_unit_id').val();

            let newRow = `
            <tr>
                <td>
                    <select class="form-control" name="item_id[]">
                        <option value="${item_id}" selected>${item_text}</option>
                    </select>
                </td>
                <td>
                    <input type="text" name="unit_qty[]" class="form-control" readonly value="${unit_qty}">
                </td>
                <td>
                    <input type="text" name="unit_name[]" class="form-control" readonly value="${unit}">
                </td>
                <td>
                    <button type="button" class="btn btn-danger btn-sm" onclick="removeRow(this)">X</button>
                </td>
                    <input type="hidden" name="unit_id[]" value="${unit_id}">
            </tr>
        `;
            $('#chargeTable').append(newRow);

            // Reset first row
            firstRow.find('.item_id').val('').trigger('change');
            firstRow.find('.unit_qty').val('0');
            firstRow.find('.unit').val('');
            firstRow.find('.unit_id').val('');
            firstRow.find('.sub_unit_id').val('');
        }

        function removeRow(button) {
            let row = button.closest('tr');
            row.remove();
        }

        $(document).ready(function() {
            $('#yourFormId').submit(function(e) {
                e.preventDefault();
                if ($('#chargeTable').find('tr').length <= 1) {
                    alert('Please add at least one item.');
                    return false;
                }
                this.submit();
            });
        });
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

            // Restrict unit_qty fields to numbers only (no alphabets, no special chars except dot)
            $(document).on('input', '.unit_qty, input[name="unit_qty[]"]', function() {
                this.value = this.value.replace(/[^0-9.]/g, '');
                // Only one dot allowed
                let parts = this.value.split('.');
                if (parts.length > 2) {
                    this.value = parts[0] + '.' + parts.slice(1).join('');
                }
            });

            // Prevent negative numbers on paste
            $(document).on('paste', '.unit_qty, input[name="unit_qty[]"]', function(e) {
                let paste = (e.originalEvent || e).clipboardData.getData('text');
                if (paste.match(/-/)) {
                    e.preventDefault();
                }
            });

            // Live validation for date
            $('#requisition_date').on('input change', function() {
                let $el = $(this);
                if (!$el.val().trim()) {
                    $el.addClass('border border-danger').css('border-color', '#dc3545');
                } else {
                    $el.removeClass('border-danger').addClass('border-primary').css('border-color',
                        '#007bff');
                }
            });

            // Live validation for unit_qty fields
            $(document).on('input change', '.unit_qty, input[name="unit_qty[]"]', function() {
                let $el = $(this);
                let val = $el.val().trim();
                if (!val || isNaN(val) || Number(val) <= 0) {
                    $el.addClass('border border-danger').css('border-color', '#dc3545');
                } else {
                    $el.removeClass('border-danger').addClass('border-primary').css('border-color',
                        '#007bff');
                }
            });

            // Live validation for item_id fields
            $(document).on('change', '.item_id, select[name="item_id[]"]', function() {
                let $el = $(this);
                if (!$el.val()) {
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
                let $date = $('#requisition_date');
                if (!$date.val().trim()) {
                    showError('Date is required.');
                    $date.addClass('border border-danger').css('border-color', '#dc3545');
                    valid = false;
                    firstInvalid = firstInvalid || $date;
                } else {
                    $date.removeClass('border-danger').addClass('border-primary').css('border-color',
                        '#007bff');
                }

                // 2. Validate at least one item row (excluding the template row)
                let $rows = $('#chargeTable tr');
                let itemRows = 0;
                $rows.each(function(i, row) {
                    // Check if this row has a select[name="item_id"] or select[name="item_id[]"]
                    let $itemSelect = $(row).find(
                        'select[name="item_id"], select[name="item_id[]"], .item_id');
                    if ($itemSelect.length && $itemSelect.val() && $itemSelect.val() !== '') {
                        itemRows++;
                    }
                });
                if (itemRows === 0) {
                    showError('Please add at least one item.');
                    valid = false;
                }

                // 3. Validate each item row for required fields and numeric quantities
                $('#chargeTable tr').each(function() {
                    let $row = $(this);
                    let $itemSelect = $row.find(
                        'select[name="item_id"], select[name="item_id[]"], .item_id');
                    let $unitQty = $row.find('.unit_qty, input[name="unit_qty[]"]');

                    // Only validate rows with an item selected
                    if ($itemSelect.length && $itemSelect.val() && $itemSelect.val() !== '') {
                        // Item required
                        if (!$itemSelect.val()) {
                            showError('Item is required.');
                            $itemSelect.addClass('border border-danger').css('border-color',
                                '#dc3545');
                            valid = false;
                            firstInvalid = firstInvalid || $itemSelect;
                            return false; // break .each
                        } else {
                            $itemSelect.removeClass('border-danger').addClass('border-primary').css(
                                'border-color', '#007bff');
                        }
                        // Unit Qty required and must be a valid number > 0
                        if (!$unitQty.val() || isNaN($unitQty.val()) || Number($unitQty.val()) <=
                            0) {
                            showError('Unit Qty is required and must be a positive number.');
                            $unitQty.addClass('border border-danger').css('border-color',
                            '#dc3545');
                            valid = false;
                            firstInvalid = firstInvalid || $unitQty;
                            return false; // break .each
                        } else {
                            $unitQty.removeClass('border-danger').addClass('border-primary').css(
                                'border-color', '#007bff');
                        }
                    }
                });

                if (!valid) {
                    e.preventDefault();
                    if (firstInvalid) firstInvalid.focus();
                }
            });

            // Optional: Remove error highlight on input/change
            $('#yourFormId input, #yourFormId select').on('input change', function() {
                $(this).removeClass('border-danger').css('border-color', '');
            });
        });
    </script>
@endpush
