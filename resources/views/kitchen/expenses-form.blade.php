@extends('layouts.structure')
@push('title')
    <title>{{ $title }}</title>
@endpush
@push('css')
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
                <form method="POST" id="myForm" action="{{ route('kt.update-daily-expenses', @$edit->id) }}">
                    @csrf
                    <div class="card-body">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-2 mt-3">
                                    <label class="form-label">Date <span class="text-danger">*</span></label>
                                    <input type="text" class="datePickr" name="date" id="date"
                                        value="{{ old('date', @$edit->date ? dateFor($edit->date, true) : date('d-m-Y h:i A')) }}" />
                                    @error('date')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="col-md-2 mt-3">
                                    <label class="form-label">Approximate Meal Number</label>
                                    <input type="text" class="form-control" name="total_meal"
                                        value="{{ old('total_meal', @$edit->total_meal) }}" />
                                    @error('total_meal')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-8 mt-3">
                                    <label class="form-label">Note</label>
                                    <textarea class="form-control" rows="1" name="note">{{ old('note', @$edit->note) }}</textarea>
                                    @error('note')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="border-bottom mt-4">
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
                                            <th class="text-white" style="width: 18%">Avi. Qty<span
                                                    class="text-danger">*</span></th>
                                            <th class="text-white" style="width: 2%"></th>
                                        </tr>
                                    </thead>
                                    <tbody id="chargeTable">
                                        <tr id="row">
                                            <td>
                                                <select class="form-control select2-show-search" id="item_name"
                                                    onchange="getItemDetails(this.value)">
                                                    <option value="">Select One.....</option>
                                                    @foreach ($item_list as $value)
                                                        <option value="{{ $value->id }}">{{ $value->item_name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td>
                                                <input class="form-control" type="text" id="unit_qty" value="0" />
                                            </td>
                                            <td>
                                                <input class="form-control" readonly type="text" id="unit" />
                                            </td>
                                            <td>
                                                <input class="form-control" type="text" id="avi_qty" readonly />
                                            </td>
                                            <td>
                                                <button class="btn btn-success btn-sm" onclick="validation()"
                                                    type="button">+</button>
                                            </td>
                                        </tr>
                                        @foreach (@$edit_info ?? [] as $info)
                                            <tr>
                                                <td>
                                                    <input class="form-control" type="hidden" name="uppid[]"
                                                        value="{{ $info->id }}" />
                                                    <select class="form-control select2-show-search" name="item_name[]">
                                                        <option value="{{ $info->item_id }}">{{ $info->item_name }}
                                                        </option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <input class="form-control" type="text" name="unit_qty[]"
                                                        value="{{ $info->unit_qty }}" />
                                                </td>
                                                <td>
                                                    <input class="form-control" type="text" name="unit[]"
                                                        value="{{ $info->unit }}" readonly />
                                                </td>
                                                <td></td>
                                                <td>
                                                    <button type="button" class="btn btn-danger btn-sm"
                                                        onclick="removeRow(this)">X</button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="text-center mb-4">
                        <button type="submit" class="btn btn-primary" name="action_type" value="0">Save</button>
                        <button type="submit" onclick="setConfirmFlag(true)" class="btn btn-success" name="action_type"
                            value="1">Save & Issue</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script>
        let requireConfirm = false;

        function setConfirmFlag(flag) {
            requireConfirm = flag;
        }
        document.getElementById('myForm').addEventListener('submit', function(e) {
            if (requireConfirm) {
                const confirmed = confirm("Are you sure? After Issue you can't Edit or Delete!");
                if (!confirmed) {
                    e.preventDefault();
                }
            }
        });
        document.querySelector('#data-table').addEventListener('input', function(event) {
            if (event.target && event.target.id === 'unit_qty') {
                var row = event.target.closest('tr');
                validateQty(row);
            }
        });

        function validateQty(row) {
            var unit_qty = parseFloat(row.querySelector('#unit_qty').value) || 0;
            var avi_qty = parseFloat(row.querySelector('#avi_qty').value) || 0;
            if (unit_qty > avi_qty) {
                row.querySelector('#unit_qty').value = 0;
            }
        }

        function getItemDetails(part_no) {
            var item_id = $('#item_name').val();
            $.ajax({
                url: "{{ route('kt.get-item-unit') }}",
                type: "POST",
                data: {
                    _token: '{{ csrf_token() }}',
                    itemId: item_id,
                },
                success: function(response) {
                    $('#unit').val(response.unit);
                    $('#avi_qty').val(response.avi_qty);
                },
                error: function(error) {
                    console.log(error);
                }
            });
        }

        function validation() {
            var itemSelect = $('#item_name').val();
            var unitqty = $('#unit_qty').val();

            if (itemSelect == '') {
                alert('Please Select a Item !!!');
            }
            if (unitqty == '' || unitqty == 0) {
                alert('Please Enter Quantity !!!');
                return;
            } else {
                addNewrow();
            }
        }

        function addNewrow() {
            var table = document.getElementById("data-table");
            var newRow = table.insertRow(table.rows.length);

            var ItemSelect = $('#item_name');
            var selectedOption = ItemSelect.find('option:selected');
            var itemValue = selectedOption.val();
            var itemText = selectedOption.text();

            var unit = $('#unit').val();
            var unit_qty = $('#unit_qty').val();

            var cell1 = newRow.insertCell(0);
            var cell2 = newRow.insertCell(1);
            var cell3 = newRow.insertCell(2);
            var cell4 = newRow.insertCell(3);


            var selectHTML = '<select class="form-control" name="item_name[]"><option value="' + itemValue + '">' +
                itemText + '</option></select>';
            cell1.innerHTML = selectHTML;

            var inputHTML1 = '<input type="text" name="unit_qty[]" readonly class="form-control" value="' + unit_qty +
                '" />';
            cell2.innerHTML = inputHTML1;

            var inputHTML2 = '<input type="text" name="unit[]" readonly class="form-control" value="' + unit + '" />';
            cell3.innerHTML = inputHTML2;

            var inputHTML3 = '<button type="button" class="btn btn-danger btn-sm" onclick="removeRow(this)">X</button>';
            cell4.innerHTML = inputHTML3;

            const selectElement = document.getElementById("item_name");
            selectElement.selectedIndex = 0;
            $('#item_name').val('').trigger('change');

            $('#unit').val('');
            $('#unit_qty').val(0);
            $('#avi_qty').val('');
        }

        function removeRow(button) {
            var table = document.getElementById("data-table");
            var row = button.parentNode.parentNode;
            table.deleteRow(row.rowIndex);
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

            // Restrict total_meal and all unit_qty fields to numbers only (no alphabets, no special chars except dot)
            $('input[name="total_meal"], #unit_qty, input[name="unit_qty[]"]').on('input', function() {
                this.value = this.value.replace(/[^0-9.]/g, '');
                // Only one dot allowed
                let parts = this.value.split('.');
                if (parts.length > 2) {
                    this.value = parts[0] + '.' + parts.slice(1).join('');
                }
            });

            // Prevent negative numbers on paste
            $('input[name="total_meal"], #unit_qty, input[name="unit_qty[]"]').on('paste', function(e) {
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

            // Live validation for total_meal (optional, but must be positive if filled)
            $('input[name="total_meal"]').on('input change', function() {
                let $el = $(this);
                let val = $el.val().trim();
                if (val && (isNaN(val) || Number(val) < 0)) {
                    $el.addClass('border border-danger').css('border-color', '#dc3545');
                } else if (val) {
                    $el.removeClass('border-danger').addClass('border-primary').css('border-color',
                        '#007bff');
                } else {
                    $el.removeClass('border-danger border-primary').css('border-color', '');
                }
            });

            // Live validation for item_name select in main row
            $('#item_name').on('change', function() {
                let $el = $(this);
                if (!$el.val() || $el.val() === '') {
                    $el.addClass('border border-danger').css('border-color', '#dc3545');
                } else {
                    $el.removeClass('border-danger').addClass('border-primary').css('border-color',
                        '#007bff');
                }
            });

            // Live validation for unit_qty in main row
            $('#unit_qty').on('input change', function() {
                let $el = $(this);
                let val = $el.val().trim();
                let avi_qty = parseFloat($('#avi_qty').val()) || 0;
                if (!val || isNaN(val) || Number(val) <= 0 || Number(val) > avi_qty) {
                    $el.addClass('border border-danger').css('border-color', '#dc3545');
                } else {
                    $el.removeClass('border-danger').addClass('border-primary').css('border-color',
                        '#007bff');
                }
            });

            // Live validation for dynamically added item rows
            $(document).on('change', 'select[name="item_name[]"]', function() {
                let $el = $(this);
                if (!$el.val() || $el.val() === '') {
                    $el.addClass('border border-danger').css('border-color', '#dc3545');
                } else {
                    $el.removeClass('border-danger').addClass('border-primary').css('border-color',
                        '#007bff');
                }
            });
            $(document).on('input change', 'input[name="unit_qty[]"]', function() {
                let $el = $(this);
                let val = $el.val().trim();
                if (!val || isNaN(val) || Number(val) <= 0) {
                    $el.addClass('border border-danger').css('border-color', '#dc3545');
                } else {
                    $el.removeClass('border-danger').addClass('border-primary').css('border-color',
                        '#007bff');
                }
            });

            // On submit, validate all fields
            $('#myForm').on('submit', function(e) {
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

                // 2. Validate at least one item row (including main row and dynamic rows)
                let itemRows = 0;
                // Main row
                let $item0 = $('#item_name');
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
                    $('#item_name').addClass('border border-danger').css('border-color', '#dc3545');
                    valid = false;
                    firstInvalid = firstInvalid || $('#item_name');
                }

                // 3. Validate unit_qty for all item rows
                // Main row
                let $unit_qty0 = $('#unit_qty');
                let avi_qty0 = parseFloat($('#avi_qty').val()) || 0;
                if ($item0.length && $item0.val() && $item0.val() !== '') {
                    if (!$unit_qty0.val() || isNaN($unit_qty0.val()) || Number($unit_qty0.val()) <= 0 ||
                        Number($unit_qty0.val()) > avi_qty0) {
                        showError('Unit Qty is required, must be positive, and not exceed available qty.');
                        $unit_qty0.addClass('border border-danger').css('border-color', '#dc3545');
                        valid = false;
                        firstInvalid = firstInvalid || $unit_qty0;
                    } else {
                        $unit_qty0.removeClass('border-danger').addClass('border-primary').css(
                            'border-color', '#007bff');
                    }
                }
                // Dynamic rows
                $('#chargeTable tr').each(function() {
                    let $row = $(this);
                    let $itemSelect = $row.find('select[name="item_name[]"]');
                    let $unitQty = $row.find('input[name="unit_qty[]"]');
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
                    }
                });

                // 4. Validate total_meal (optional, but must be positive if filled)
                let $total_meal = $('input[name="total_meal"]');
                let total_meal_val = $total_meal.val().trim();
                if (total_meal_val && (isNaN(total_meal_val) || Number(total_meal_val) < 0)) {
                    showError('Approximate Meal Number must be a positive number.');
                    $total_meal.addClass('border border-danger').css('border-color', '#dc3545');
                    valid = false;
                    firstInvalid = firstInvalid || $total_meal;
                } else if (total_meal_val) {
                    $total_meal.removeClass('border-danger').addClass('border-primary').css('border-color',
                        '#007bff');
                }

                if (!valid) {
                    e.preventDefault();
                    if (firstInvalid) firstInvalid.focus();
                }
            });

            // Remove error highlight on input/change
            $('#myForm input, #myForm select').on('input change', function() {
                $(this).removeClass('border-danger').css('border-color', '');
            });
        });
    </script>
@endpush
