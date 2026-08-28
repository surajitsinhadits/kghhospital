@extends('layouts.structure')
@push('title')
    <title>{{ @$t }}</title>
@endpush
@push('css')
@endpush
@section('main-content')
    <div class="row">
        <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12">
            <div class="card">
                <div class="card-header card_hearder_mimi">
                    <h4 class="card-title card_hearder_mimi_text">Add Requisition</h4>
                </div>
                <div class="card-body">
                    <form
                        action="{{ @$requisition_list ? route('pharmacy.update-requisition', @$requisition_list->id) : route('pharmacy.update-requisition') }}"
                        method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">

                            @if (empty($requisition_list))
                                <div class="col-md-3 newuserrchange">
                                    <label class="form-label">Requested By <span class="text-danger">*</span></label>
                                    <input class="form-control"
                                        value="{{ auth()->user()->salutation . ' ' . auth()->user()->name }}"
                                        name="requested_by" readonly />
                                </div>
                            @endif

                            <div class="col-md-3 newuserrchange ">
                                <label for="store_room" class="form-label">Department <span
                                        class="text-danger">*</span></label>
                                <select name="dept_id" class="form-control select2-show-search">
                                    <option value="">Select One</option>
                                    @if ($department)
                                        @foreach ($department as $value)
                                            <option value="{{ $value->id }}"
                                                {{ @$requisition_list && $requisition_list->dept_id == $value->id ? 'selected' : '' }}>
                                                {{ $value->department_name }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>

                            <div class="col-md-3  newuserrchange">
                                <label for="date" class="form-label">Date <span class="text-danger">*</span></label>
                                <input type="datetime-local" class="form-control"
                                    value="{{ @$requisition_list ? date('Y-m-d H:i', strtotime(@$requisition_list->date)) : date('Y-m-d H:i') }}"
                                    id="date" name="date" required>

                                @error('date')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group col-md-12 mt-3">
                            <div class="table-responsive">
                                <table class="table card-table table-vcenter text-nowrap border" id="data-table">
                                    <thead class="bg-primary text-white">
                                        <tr>
                                            <th class="text-white" style="width: 28%">Medicine Name <span
                                                    class="text-danger">*</span></th>
                                            <th class="text-white" style="width: 10%">Unit Qty<span
                                                    class="text-danger">*</span>
                                            </th>
                                            <th class="text-white" style="width: 15%">Unit<span class="text-danger">*</span>
                                            </th>
                                            <th class="text-white" style="width: 10%">Sub Unit Qty<span
                                                    class="text-danger">*</span></th>
                                            <th class="text-white" style="width: 15%">Sub Unit<span
                                                    class="text-danger">*</span>
                                            </th>
                                            <th class="text-white" style="width: 2%"></th>
                                        </tr>
                                    </thead>
                                    <tbody id="chargeTable">
                                        @if (isset($req_details) && count($req_details) > 0)
                                            @foreach ($req_details as $key => $detail)
                                                <tr>
                                                    <td>
                                                        <select class="form-control" name="medicine_name[]">
                                                            @foreach ($medicine_name as $value)
                                                                <option value="{{ $value->medicine_id }}"
                                                                    {{ $detail->medicine_name == $value->medicine_id ? 'selected' : '' }}>
                                                                    {{ $value->medicine_name }}
                                                                    ({{ $value->medicine_catagory_name }})
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                    <td><input type="text" name="unit_qty[]" class="form-control"
                                                            value="{{ $detail->unit_qty }}"></td>
                                                    <td><input type="text" name="unit[]" class="form-control"
                                                            value="{{ $detail->unit }}" readonly></td>
                                                    <td><input type="text" name="sub_unit_qty[]" class="form-control"
                                                            value="{{ $detail->sub_unit_qty }}"></td>
                                                    <td><input type="text" name="sub_unit[]" class="form-control"
                                                            value="{{ $detail->sub_unit }}" readonly></td>
                                                    <td><button type="button" class="btn btn-danger btn-sm"
                                                            onclick="removeRow(this)">X</button></td>
                                                </tr>
                                            @endforeach
                                        @endif

                                        {{-- First row for new entry --}}
                                        <tr>
                                            <td>
                                                <select class="form-control select2-show-search" id="medicine_id0"
                                                    onchange="getmedicineDetails(this.value,0)">
                                                    <option value="">Select One.....</option>
                                                    @foreach ($medicine_name as $value)
                                                        <option value="{{ $value->medicine_id }}">
                                                            {{ $value->medicine_name }}({{ $value->medicine_catagory_name }})
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td><input class="form-control" type="text" id="unit_qty0" value="0" />
                                            </td>
                                            <td><input class="form-control" value="0" readonly type="text"
                                                    id="unit0" /></td>
                                            <td><input class="form-control" type="text" id="sub_unit_qty0"
                                                    value="0" />
                                                <input class="form-control" type="hidden" id="unit_details0" />
                                            </td>
                                            <td><input class="form-control" value="0" readonly type="text"
                                                    id="sub_unit0" /></td>
                                            <td><button class="btn btn-success btn-sm" onclick="validation()"
                                                    type="button">+</button></td>
                                        </tr>
                                    </tbody>

                                </table>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3 newuserrchange">
                                <label class="form-label">Note</label>
                                <textarea name="note" rows="5" cols="45">{{ @$requisition_list->note }}</textarea>
                                @error('note')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="text-center m-auto">
                            <button type="submit" class="btn btn-primary">{{ @$requisition_list ? 'Update' : 'Save' }}
                                Requisition </button>
                        </div>
                    </form>
                </div>
            </div>
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
                        $('#unit_details' + i).val(res.unit_details);
                        // $('#cgst' + i).val(res.tax / 2);
                        // $('#sgst' + i).val(res.tax / 2);
                        // $('#unit_details' + i).val(res.unit_details);
                    }
                });
            }


        }
    </script>



    <script>
        // function validation() {
        //     var itemSelect = $('#medicine_name').val();
        //     var sub_unit_qty = $('#sub_unit_qty').val();
        //     var unit_details = $('#unit_details').val();
        //     if (sub_unit_qty > unit_details) {
        //         alert('Sub-unit quantity cannot exceed the available unit details (' + unit_details + ').');
        //     }
        //     if (itemSelect == '') {
        //         alert('Please Select Medicine !!!');
        //     } else {
        //         addNewrow();
        //     }
        // }

        function validation() {
            var itemSelect = $('#medicine_id0').val();
            var sub_unit_qty = $('#sub_unit_qty0').val();
            var unit_details = $('#unit_details0').val();
            var unit_qty = $('#unit_qty0').val();

            // Check for empty medicine selection
            if (itemSelect === '') {
                alert('Please Select Medicine !!!');
                return false;
            }

            // Check for invalid quantity
            if (parseFloat(sub_unit_qty) > parseFloat(unit_details)) {
                alert('Sub-unit quantity cannot exceed the available unit details (' + unit_details + ').');
                return false;
            }
            if (unit_qty == 0 && sub_unit_qty == 0) {
                alert('Unit Qty and Sub Unit Qty cannot both be 0');
                return false;
            }

            // If all validations pass
            addNewrow();
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

            var cell1 = newRow.insertCell(0);
            var cell2 = newRow.insertCell(1);
            var cell3 = newRow.insertCell(2);
            var cell4 = newRow.insertCell(3);
            var cell5 = newRow.insertCell(4);
            var cell6 = newRow.insertCell(5);




            var selectHTML = '<select class="form-control" name="medicine_name[]"><option value="' + itemValue + '">' +
                itemText + '</option></select>';
            cell1.innerHTML = selectHTML;

            var inputHTML1 = '<input type="text" name="unit_qty[]" readonly class="form-control" value="' + unit_qty + '">';
            cell2.innerHTML = inputHTML1;

            var inputHTML2 = '<input type="text" name="unit[]" readonly class="form-control" value="' + unit + '">';
            cell3.innerHTML = inputHTML2;

            var inputHTML3 = '<input type="text" name="sub_unit_qty[]" readonly class="form-control" value="' + sub_unit_qty + '">';
            cell4.innerHTML = inputHTML3;

            var inputHTML4 = '<input type="text" name="sub_unit[]" readonly class="form-control" value="' + sub_unit + '">';
            cell5.innerHTML = inputHTML4;

            var inputHTML5 = '<button type="button" class="btn btn-danger btn-sm" onclick="removeRow(this)">X</button>';
            cell6.innerHTML = inputHTML5;

            const selectElement = document.getElementById("medicine_id0");
            selectElement.selectedIndex = 0;
            $('#medicine_id0').val('').trigger('change');
            $('#unit0').val('');
            $('#unit_qty0').val('0');
            $('#sub_unit0').val('');
            $('#sub_unit_qty0').val('0');


        }


        function removeRow(button) {
            var table = document.getElementById("data-table");
            var row = button.parentNode.parentNode;
            table.deleteRow(row.rowIndex);
        }
    </script>
@endpush
