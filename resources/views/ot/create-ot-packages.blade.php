@extends('layouts.structure')
@push('title')
    <title>{{ $title }}</title>
@endpush
@push('css')
@endpush
@section('main-content')

    <div class="row">
        <div class="col-md-8 py-2 px-3">
            <div class="card">
                <div class="card-header card_hearder_mimi">
                    <div class="card-title card_hearder_mimi_text">{{ $t1 }}</div>
                </div>
                <div class="card-body">
                    <div class="">
                        <div class="table-responsive">
                            <div id="example1_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <table id="example1"
                                            class="table table-borderless text-nowrap key-buttons dataTable no-footer"
                                            role="grid" aria-describedby="example1_info">
                                            <thead class="bg-primary text-white">
                                                <tr role="row">
                                                    <th class="text-white sorting_asc" tabindex="0"
                                                        aria-controls="example1" rowspan="1" colspan="1"
                                                        aria-sort="ascending"
                                                        aria-label="Sl. No: activate to sort column descending"
                                                        style="width: 59.875px;">Sl. No</th>
                                                    <th class="text-white sorting" tabindex="0" aria-controls="example1"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Package Name: activate to sort column ascending"
                                                        style="width: 242.708px;">Package Name</th>
                                                    <th class="text-white sorting" tabindex="0" aria-controls="example1"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Package Name: activate to sort column ascending"
                                                        style="width: 242.708px;">Type</th>
                                                    <th class="text-white sorting" tabindex="0" aria-controls="example1"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Charges Name: activate to sort column ascending"
                                                        style="width: 353.778px;">Charges Name</th>
                                                    <th class="text-white sorting" tabindex="0" aria-controls="example1"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Total: activate to sort column ascending"
                                                        style="width: 52.0694px;">Total</th>
                                                    <th class="text-white sorting" tabindex="0" aria-controls="example1"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Action: activate to sort column ascending"
                                                        style="width: 64.1944px;">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($response as $value)
                                                    <tr role="row" class="odd">
                                                        <td class="sorting_1">{{ $loop->iteration }}</td>
                                                        <td>{{ @$value->package_name }}</td>
                                                        <td>{{ @$value->type }}</td>

                                                        <td>
                                                            @foreach ($OtPackages->where('id', $value->id) as $item)
                                                                {{ $loop->iteration }}. {{ @$item->charge_name }} -
                                                                ₹{{ @$item->rate }}<br>
                                                            @endforeach
                                                        </td>
                                                        <td>{{ @$value->package_amount }}</td>
                                                        <td>
                                                            <a class="btn btn-sm btn-outline-primary"
                                                                href="{{ $edit['url'] }}/{{ ed($value->id, true) }}">
                                                                <i class="fa fa-edit"></i> Edit
                                                            </a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 py-2 px-3">
            <div class="card">
                <div class="card-header card_hearder_mimi">
                    <h4 class="card-title card_hearder_mimi_text">{{ $t2 }}</h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ $btn['action'] }}">
                        @csrf
                        <div class="">
                            <div class="form-group">
                                <label for="requisition_section_name" class="medicinelabel">Enter Package name <span
                                        class="text-danger">*</span></label>
                                <input type="text" id="package_name" name="package_name" placeholder="Enter Package Name"
                                    value="{{ old('package_name', @$edit['data']->package_name) }}">
                                @error('package_name')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="type">Type <span class="text-danger">*</span></label>
                                <select id="type" name="type" class="form-control" onchange="toggleDurationField()">
                                    <option value="">Select..</option>
                                    <option value="normal"
                                        {{ old('type', @$edit['data']->type) == 'normal' ? 'selected' : '' }}>Normal
                                    </option>
                                    <option value="time"
                                        {{ old('type', @$edit['data']->type) == 'time' ? 'selected' : '' }}>Time</option>
                                </select>
                                @error('type')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group" id="duration-wrapper" {{ old('type', @$edit['data']->type) == 'time' ? 'style=display:block;' : 'style=display:none;' }}>
                                <label for="duration" class="medicinelabel">Duration (in mins) <span
                                        class="text-danger">*</span></label>
                                <input type="text" id="duration" name="duration" class="form-control"
                                    placeholder="Enter Duration" value="{{ old('duration', @$edit['data']->duration) }}">
                                @error('duration')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            @error('charge_id')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                            <div class="form-group">
                                <table class="table table-bordered   border-left border-bottom border-right"
                                    id="data-table" style="width: 98%;margin-left:1%;">
                                    <thead class="bg-primary">
                                        <tr>
                                            <th scope="col" style="width: 70%" class="text-white">Charge
                                                Name <span class="text-danger">*</span>
                                            </th>
                                            <th scope="col" style="width: 28%" class="text-white">Charge
                                                <span class="text-danger">*</span>
                                            </th>
                                            <th scope="col" style="width: 2%" class="text-white">#</th>
                                        </tr>
                                    </thead>
                                    <tbody id="chargeTable">
                                        <tr id="row">
                                            <td>
                                                <select
                                                    class="form-control select2-show-search charge-select select2-hidden-accessible"
                                                    onchange="getRateByCharge(this.value)" id="charge_name">
                                                    <option value="">Select One.....</option>
                                                    @foreach ($charges as $value)
                                                        <option value="{{ $value->id }}">
                                                            {{ $value->charge_name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td>
                                                <input type="text" id="rate">
                                            </td>
                                            <td>
                                                <button class="btn btn-success btn-sm" onclick="addNewRow()"
                                                    type="button"><i class="fa fa-plus"></i></button>
                                            </td>
                                        </tr>
                                        @if (@$edit['data'])
                                            @foreach ($packageDetails as $key => $detail)
                                                <?php $i = $key + 1; ?>
                                                <tr style="background-color: #d5ffe8">
                                                    <td>
                                                        <select class="form-control select2-show-search charge-select"
                                                            id="charge_id{{ $i }}"
                                                            onchange="getRateByCharge(this.value,{{ $i }})"
                                                            name="charge_id[]">
                                                            <option value=""></option>
                                                            @foreach ($charges as $value)
                                                                <option value="{{ @$value->id }}"
                                                                    @if (@$value->id == $detail->charge_id) selected @endif>
                                                                    {{ @$value->charge_name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <input type="text" id="rate{{ $i }}"
                                                            value="{{ @$detail->rate }}" name="rate[]" />
                                                    </td>

                                                    <td>
                                                        <button type="button" class="btn btn-danger btn-sm"
                                                            onclick="removeRow(this)">X</button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>
                                <div class="text-right">TOTAL <input style="width: 150px;" type="text"
                                        id="total_amount" name="total_amount"
                                        value="{{ @$edit['data']->package_amount }}"></div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary mt-4 mb-0">{{ $btn['name'] }}</button>
                        @if (@$edit['data'])
                            <a href="{{ @$edit['reset'] }}" class="btn btn-warning mt-4 mb-0">Reset</a>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        var rowCount = 1;

        function addNewRow() {
            var table = document.getElementById("data-table");
            var newRow = table.insertRow(table.rows.length);
            newRow.style.backgroundColor = "#d5ffe8";

            var chargeSelect = $('#charge_name'); // Get the select element
            var selectedOption = chargeSelect.find('option:selected'); // Get the selected option

            var chargeValue = selectedOption.val(); // Get the value of the selected option
            var chargeText = selectedOption.text(); // Get the text of the selected option

            var rateValue = $('#rate').val();

            var cell1 = newRow.insertCell(0);
            var cell2 = newRow.insertCell(1);
            var cell3 = newRow.insertCell(2);

            var selectHTML =
                '<select class="form-control select2-show-search charge-select" name="charge_id[]"><option value="' +
                chargeValue + '">' + chargeText + '</option></select>';
            cell1.innerHTML = selectHTML;
            var inputHTML1 =
                '<input type="text" name="rate[]" onkeyup="updateCalculations()" class="form-control" value="' + rateValue +
                '">';
            cell2.innerHTML = inputHTML1;
            var inputHTML2 = '<button type="button" class="btn btn-danger btn-sm" onclick="removeRow(this)">X</button>';
            cell3.innerHTML = inputHTML2;

            $('#charge_name').val('').trigger('change');
            $('#rate').val('');
            updateCalculations();

            rowCount++;
        }

        function removeRow(button) {
            var table = document.getElementById("data-table");
            var row = button.parentNode.parentNode;
            table.deleteRow(row.rowIndex);
            updateCalculations();
        }

        function getRateByCharge(charge_id) {
            if (charge_id != '') {
                $.ajax({
                    url: "{{ route('hr.package-amount') }}",
                    type: "post",
                    data: {
                        selectedCharge_Id: charge_id,
                        _token: '{{ csrf_token() }}',
                    },
                    dataType: 'json',
                    success: function(data) {
                        $('#rate').val(data);

                    },
                    error: function() {
                        // Handle error
                    }
                });
            }
        }

        function updateCalculations() {
            var t = 0;
            $("input[name='rate[]']").each(function() {
                t += parseFloat($(this).val()) || 0;
            });
            $('#total_amount').val(t);
        }


        /*function toggleDurationField() {

            const selectedType = document.getElementById('type').value;
            const durationWrapper = document.getElementById('duration-wrapper');
            const durationInput = document.getElementById('duration');

            if (selectedType === 'time') {
                durationWrapper.style.display = 'block';
            } else {
                durationInput.value = '';
                durationWrapper.style.display = 'none';
            }

        }*/

        function toggleDurationField() {

            var value = $(this).val();
            if (value === 'time') {
                $('#duration-wrapper').show();
            } else {
                $('#duration').val('');
                $('#duration-wrapper').hide();
            }

        }

        // Attach event
        document.getElementById('type').addEventListener('change', toggleDurationField);

        // Run on page load (for edit form)
        window.addEventListener('DOMContentLoaded', toggleDurationField);
    </script>
@endsection
@push('js')
@endpush
