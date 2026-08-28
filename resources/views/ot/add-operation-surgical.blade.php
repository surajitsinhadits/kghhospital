@extends('layouts.structure')
@push('title')
    <title>Add Operation Details</title>
@endpush
@push('css')
    <style>
        .enquiry {
            background-image: url('{{ url('public/assets/images/operation-new.jpg') }}');
            background-size: cover;
            background-repeat: no-repeat;
            width: 100vw;
            height: 100vh;
            object-fit: cover;
            position: absolute;
            top: 0;
            left: 0;
        }

        .enquiry-card {
            width: 90%;
            margin: auto;
            margin-top: 9%;
            box-shadow: 1px 3px 17px 9px rgb(83 84 7);



            height: 520px;
            overflow: scroll;
            border: 1px solid #ccc;
            background-color: #fcf5f5;
        }

        .newuserlisttchange,
        .newdesignadd {
            margin: 10px 0px 0px 0px;
        }
    </style>
@endpush
@section('main-content')
    <div class="row">
        <div class="col-md-12 enquiry">
            <div class="enquiry-card">
                <div class="card-header d-block card_hearder_mimi">
                    <div class="row">
                        <div class="col-md-6 card-title card_hearder_mimi_text">OT Details </div>
                        <div class="col-md-6 text-right">
                            <div class="d-block">
                                <a href="{{ route('ot.ot-info', ed($ot_registration->id, true)) }}"
                                    class="btn btn-danger btn-sm">
                                    <i class="fa fa-times"></i> Close
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="opdneedit">
                        <div class="row no-gutters">
                            <div class="row no-gutters">
                                <div class="col-lg-12 col-xl-12">
                                    <form method="POST" id="yourFormId" action="{{ @$edit_request ? route('ot.update-operation-request') : route('ot.save-operation-request') }}">
                                        @csrf
                                        <input type="hidden" name="ot_reg_id" value="{{ @$ot_registration->id }}">
                                        <input type="hidden" name="patient_id" value="{{ @$ot_registration->patient_id }}">
                                        <input type="hidden" name="id" value="{{ @$edit_request->id }}">

                                        <div class="options px-5 pt-1 pb-3">
                                            <div class="row">
                                                <div class="form-group col-md-3">
                                                    <label for="department">Procedure Code<span
                                                            class="text-danger">*</span></label>
                                                    <select name="procedure_code" class="form-control select2-show-search"
                                                        id="procedure_code" required onchange="getProcedureName(this.value)">
                                                        <option value="">All</option>
                                                        @foreach ($procedure as $data)
                                                            <option {{ old('procedure_code') == $data->id ? 'selected' : '' }} value="{{ $data->id }}"{{ @$edit_request->procedure_code == $data->id ? 'selected' : '' }}>
                                                                {{ $data->code }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    @error('procedure_code')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>

                                                <div class="form-group col-md-3">
                                                    <label for="doctor">Procedure Name<span
                                                            class="text-danger">*</span></label>
                                                    <select name="procedure_name" class="form-control select2-show-search"
                                                        id="procedure_name" required>
                                                        <option value="">Select</option>
                                                    </select>
                                                    @error('cons_doc')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                                <div class="form-group col-md-2 ">
                                                    <label class="date-format">Proposed OT Date <span
                                                            class="text-danger">*</span></label>
                                                    <input type="text" name="proposed_date" id="proposed_date"
                                                        class="form-control datePickr"
                                                        value="{{ old('proposed_date', dateFor(@$edit_request->proposed_ot_date)) }}" required>
                                                    @error('proposed_date')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                                <div class="form-group col-md-2">
                                                    <label class="date-format">From Time <span
                                                            class="text-danger">*</span></label>
                                                    <input type="text" name="from_time" id="from_time"
                                                        class="form-control timePickr"
                                                        value="{{ old('from_time', @$edit_request->from_time) }}" required>
                                                    @error('from_time')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                                <div class="form-group col-md-2">
                                                    <label class="date-format">To Time <span
                                                            class="text-danger">*</span></label>
                                                    <input type="text" name="to_time" id="to_time"
                                                        class="form-control timePickr"
                                                        value="{{ old('to_time', @$edit_request->to_time) }}" required>
                                                    @error('to_time')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                                 <div class="form-group col-md-3">
                                                    <label for="doctor">OT Room<span class="text-danger">*</span></label>
                                                    <select name="ot_room" class="form-control select2-show-search"
                                                        id="ot_room" required>
                                                        <option value="">Select</option>
                                                        @foreach ($ot_rooms as $data)
                                                            <option value="{{ $data->id }}"
                                                                {{ old('ot_room', @$edit_request->ot_room) == $data->id ? 'selected' : '' }}>{{ $data->name }}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('ot_room')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                                <div class="form-group col-md-3">
                                                    <label for="department">Department<span class="text-danger">*</span></label>
                                                    <select name="department_id" class="form-control select2-show-search"
                                                        id="department_id" onchange="getDoctor(this.value)" required>
                                                        <option value="all">All</option>
                                                        @foreach ($department as $data)
                                                            <option value="{{ $data->id }}"
                                                                {{ old('department_id', (@$edit_request->department) ? @$edit_request->department : @$ot_registration->department_id) == $data->id ? 'selected' : '' }}>
                                                                {{ $data->department_name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    @error('department_id')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                                <div class="form-group col-md-3">
                                                    <label for="doctor">Surgent Name</label>
                                                    <select name="surgeon_name[]" class="form-control select2-show-search"
                                                        id="surgeon_name" multiple>
                                                        <!-- <option value="" disabled>Select</option> -->
                                                    </select>
                                                </div>

                                                <div class="form-group col-md-3">
                                                    <label for="doctor">Anaesthetist Name</label>
                                                    <select name="anaesthetist_name[]"
                                                        class="form-control select2-show-search" id="anaesthetist_name"
                                                        multiple>
                                                        <!-- <option value="" disabled>Select</option> -->
                                                    </select>
                                                </div>

                                                <div class="form-group col-md-3">
                                                    <label for="doctor">Nurse</label>
                                                    <select name="nurse_name[]" class="form-control select2-show-search"
                                                        id="nurse_name" multiple>
                                                        @foreach ($nurse as $data)
                                                            <option
                                                                value="{{ $data->id }}"{{ in_array($data->id, explode(',', @$edit_request->nurse_name ?? '')) ? 'selected' : '' }}>
                                                                {{ $data->salutation }} {{ $data->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    @error('nurse_name')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>

                                                <div class="form-group col-md-3">
                                                    <label for="doctor">OT Technician</label>
                                                    <select name="ot_technician[]"
                                                        class="form-control select2-show-search" id="ot_technician"
                                                        multiple>
                                                        @foreach ($ot_technician as $data)
                                                            <option
                                                                value="{{ $data->id }}"{{ in_array($data->id, explode(',', @$edit_request->ot_technician ?? '')) ? 'selected' : '' }}>
                                                                {{ $data->salutation }} {{ $data->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    @error('ot_technician')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>

                                                <div class="form-group col-md-3">
                                                    <label for="anaesthesia_type">Anaesthesia Type</label>
                                                    <select name="anaesthesia_type"
                                                        class="form-control select2-show-search" id="anaesthesia_type">
                                                        <option value="">Select Anaesthesia Type</option>
                                                        <option value="General Anaesthesia"
                                                            {{ @$edit_request->anesthesia_type == 'General Anaesthesia' ? 'selected' : '' }}>
                                                            General Anaesthesia
                                                        </option>
                                                        <option value="Local Anaesthesia"
                                                            {{ @$edit_request->anesthesia_type == 'Local Anaesthesia' ? 'selected' : '' }}>
                                                            Local Anaesthesia
                                                        </option>
                                                        <option value="Regional Anaesthesia"
                                                            {{ @$edit_request->anesthesia_type == 'Regional Anaesthesia' ? 'selected' : '' }}>
                                                            Regional Anaesthesia
                                                        </option>
                                                        <option value="Sedation"
                                                            {{ @$edit_request->anesthesia_type == 'Sedation' ? 'selected' : '' }}>
                                                            Sedation
                                                        </option>
                                                        <option value="Spinal Anaesthesia"
                                                            {{ @$edit_request->anesthesia_type == 'Spinal Anaesthesia' ? 'selected' : '' }}>
                                                            Spinal Anaesthesia
                                                        </option>
                                                        <option value="Epidural Anaesthesia"
                                                            {{ @$edit_request->anesthesia_type == 'Epidural Anaesthesia' ? 'selected' : '' }}>
                                                            Epidural Anaesthesia
                                                        </option>
                                                    </select>
                                                    @error('anaesthesia_type')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                                <div class="form-group col-md-3">
                                                    <label for="package_id">Operation Package <span
                                                            class="text-danger">*</span></label>
                                                    <select name="package_id" class="form-control select2-show-search"
                                                        id="package_id" onchange="applypackage(this.value)" required>
                                                        <option value="">Select</option>
                                                        @foreach ($otpackages as $doc)
                                                            <option value="{{ $doc->id }}"
                                                                {{ old('package_id', (@$edit_request->ot_package) ? @$edit_request->ot_package : @$ot_registration->package_id) == $doc->id ? 'selected' : '' }}>
                                                                {{ $doc->package_name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="package_id">Tests Needed</label>
                                                    <select class="form-control select2-show-search" name="test_name[]"
                                                        multiple>
                                                        <option value="">Select</option>
                                                        @foreach ($tests as $value)
                                                            <option value="{{ $value->id }}"
                                                                {{ in_array($value->id, explode(',', @$edit_request->test_name ?? '')) ? 'selected' : '' }}>
                                                                {{ $value->charge_name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <div class="form-group col-md-2">
                                                    <label class="date-format">Estimated Blood (Units)</label>
                                                    <input type="number" name="blood_unit" id="blood_unit"
                                                        class="form-control" value="{{ old('blood_unit', @$edit_request->blood_unit) }}">
                                                    @error('blood_unit')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>

                                                <div class="form-group col-md-2">
                                                    <label>Consent From Patient Party <span
                                                            class="text-danger">*</span></label>
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input"
                                                            id="operation_consent" name="operation_consent"
                                                            value="yes"
                                                            {{ old('operation_consent', @$edit_request->consent) == 'yes' ? 'checked' : '' }}
                                                            required>
                                                        <label for="operation_consent">
                                                            I Agree
                                                        </label>
                                                    </div>
                                                    @error('operation_consent')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>

                                                <div class="col-md-12" id="chargeSection" style="display: none;">
                                                    <div class="row">
                                                        <div class="table-responsive">
                                                            <table class="table table-bordered text-nowrap"
                                                                id="data-table">
                                                                <thead class="bg-primary text-white">
                                                                    <tr>
                                                                        <th scope="col" style="width: 20%"
                                                                            class="text-white">Charge Name <span
                                                                                class="text-danger">*</span></th>
                                                                        <th scope="col" style="width: 10%"
                                                                            class="text-white">Amount (₹) <span
                                                                                class="text-danger">*</span></th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody id="chargeTable">
                                                                    <tr id="row">
                                                                        <td>
                                                                            <select
                                                                                class="form-control select2-show-search"
                                                                                id="charge_name"
                                                                                onchange="getRateByCharge(this)">
                                                                                <option value="">Select</option>

                                                                            </select>
                                                                        </td>
                                                                        <td>
                                                                            <input class="form-control" readonly=""
                                                                                id="amount" value="0">
                                                                        </td>
                                                                        <td>
                                                                            <button class="btn btn-success btn-sm"
                                                                                onclick="validation()" type="button"
                                                                                id="buttonId">+</button>
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                    <div class="text-right">TOTAL wewewe<input style="width: 150px;"
                                                            type="text" id="total_amount" name="total_amount"
                                                            value="" readonly></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="text-center mt-2 mb-3">
                                            @if( $ot_registration->status != 'Completed' )

                                                @if( !empty($edit_request) && $ot_registration->status == 'Planned' )
                                                    <button class="btn btn-primary submitBtn" type="submit" name="save" value="confirm">
                                                        <i class="fa fa-file text-success"></i> Update & Confirm
                                                    </button>
                                                    <button class="btn btn-primary submitBtn" type="submit" name="save" value="draft">
                                                        <i class="fa fa-file text-success"></i> Save Draft
                                                    </button>
                                                @elseif( empty($edit_request) )
                                                <button class="btn btn-primary submitBtn" type="submit" name="save" value="confirm">
                                                    <i class="fa fa-file text-success"></i> Save & Confirm
                                                </button>
                                                <button class="btn btn-primary submitBtn" type="submit" name="save" value="draft">
                                                    <i class="fa fa-file text-success"></i> Save Draft
                                                </button>
                                                @endif

                                            @endif
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script>
        $(document).ready(function() {

            setTimeout(function() {
                
                var dept_id = $('#department_id').val();
                const selectedSurgeons = "{{ @$edit_request->surgeon ?? '' }}".split(',');
                const selectedAnaesthetists = "{{ @$edit_request->anaesthetist ?? '' }}".split(',');
                if (dept_id && selectedSurgeons && selectedAnaesthetists) {
                    getDoctor(dept_id, selectedSurgeons, selectedAnaesthetists);
                } else if (dept_id) {
                    getDoctor(dept_id);
                }
                
                const selectedProcedureCode = "{{ @$edit_request->procedure_code }}";
                const selectedProcedureName = "{{ @$edit_request->procedure_name }}";

                if (selectedProcedureCode) {
                    getProcedureName(selectedProcedureCode, selectedProcedureName);
                }

            }, 1000);

        });

        function getPatient(val, col) {
            var div_data = '';
            $('#search_result').attr('style', 'display:none', true);
            $('#search_result_row').html('');
            if (val && col) {
                $.ajax({
                    url: "{{ route('opd.get-patients') }}",
                    type: "POST",
                    data: {
                        _token: '{{ csrf_token() }}',
                        field: col,
                        value: val,
                    },
                    success: function(response) {
                        if (response.success && (response.patients.length > 0)) {
                            $('#search_result').removeAttr('style', true);
                            $.each(response.patients, function(key, value) {
                                let patientData = encodeURIComponent(JSON.stringify(value));
                                div_data += `<tr class="color_hover_charnge" onclick="selectPatient('${patientData}')" style="cursor: pointer !important;">
                                <td>${value.uhid || value.id}</td>
                                <td>${value.name}</td>
                                <td>${value.dob_year || 0}Y ${value.dob_month || 0}M ${value.dob_day || 0}D</td>
                                <td>${value.phone}</td>
                                <td>${value.address}</td>
                            </tr>`;
                            });
                            $('#search_result_row').html(div_data);
                        }
                    },
                    error: function(error) {
                        console.log(error);
                    }
                });
            }
        }

        function selectPatient(data) {
            let patient = JSON.parse(decodeURIComponent(data));
            $('#uhid').val(patient.id);
            $('#name').val(patient.name);
            $('#patient_ph_no').val(patient.phone);
            $('#gender').val(patient.gender).trigger('change');
            $('#date_of_birth_month').val(patient.dob_month);
            $('#date_of_birth_day').val(patient.dob_day);
            $('#date_of_birth_year').val(patient.dob_year);
            $('#address').val(patient.address);
            $('#search_result_row').html('');
            $('#search_result').attr('style', 'display:none', true);
        }

        function removeRow(button) {

            var table = document.getElementById("data-table");
            var row = button.parentNode.parentNode;
            table.deleteRow(row.rowIndex);
            updateCalculations();
        }
        applypackage('{{ (@$edit_request->ot_package) ? @$edit_request->ot_package : @$ot_registration->package_id }}');

        function applypackage(package_id) {
            const chargeSection = document.getElementById('chargeSection');


            if (package_id) {
                chargeSection.style.display = 'block';

                $.ajax({
                    url: "{{ route('ot.get-package-details') }}",
                    type: "POST",
                    data: {
                        package_id: package_id,
                        // section: 'IPD',
                        _token: '{{ csrf_token() }}',
                    },
                    dataType: 'json',
                    success: function(data) {
                        $('#data-table').html(`<thead class="bg-primary text-white">
                        <tr>
                            <th scope="col" style="width: 20%" class="text-white">Charge Name <span class="text-danger">*</span></th>
                            <th scope="col" style="width: 10%" class="text-white">Amount (₹) <span class="text-danger">*</span></th>
                        </tr>
                    </thead>`);
                        $.each(data, function(i, obj) {
                            var table = document.getElementById("data-table");
                            var newRow = table.insertRow(table.rows.length);
                            var table_id = table.rows.length;
                            newRow.style.backgroundColor = "#d5ffe8"; // Add background color

                            var chargeValue = obj.id; // Get the value of the selected option
                            var chargeText = obj.charge_name; // Get the text of the selected option

                            var rateValue = obj.charge_amount; // Get value from rate input
                            var qtyValue = 1; // Get value from qty input
                            var discountInPerValue = 0; // Get value from discount_in_per input
                            var discountAmountValue = 0; // Get value from discount_amount input
                            var amountValue = obj.charge_amount; // Get value from amount input
                            var dateValue = new Date().toISOString().split('T')[0];
                            var cell1 = newRow.insertCell(0);
                            var cell2 = newRow.insertCell(1);
                            // var cell3 = newRow.insertCell(2);


                            var selectHTML =
                                '<select class="form-control" style="background-color: #e9e9eb;"  name="charge_name[]"><option value="' +
                                chargeValue + '">' + chargeText + '</option></select>';
                            cell1.innerHTML = selectHTML;

                            var inputHTML1 = '<input type="text" name="rate[]" id="amount' +
                                table_id + '" readonly class="form-control" readonly value="' +
                                amountValue + '">';
                            cell2.innerHTML = inputHTML1;

                            // var inputHTML2 =
                            //     '<button type="button" class="btn btn-danger btn-sm" onclick="removeRow(this)">X</button>';
                            // cell3.innerHTML = inputHTML2;
                        });

                        updateCalculations();
                    },
                    error: function(e) {
                        console.log(e);
                    }
                });

                setTimeout(() => {
                    document.getElementById('chargeSection').scrollIntoView({
                        behavior: 'smooth'
                    });
                }, 500);
            } else {

                chargeSection.style.display = 'none';
            }
        }

        function updateCalculations() {
            var t = 0;
            $("input[name='rate[]']").each(function() {
                t += parseFloat($(this).val()) || 0;
            });
            $('#total_amount').val(t);
        }

        function getDoctor(department_id, selectedSurgeons = [], selectedAnaesthetists = []) {
            // console.log(department_id +' => '+ selectedSurgeons +' => '+ selectedAnaesthetists);
            if (department_id) {

                // $('#surgeon_name').val('').trigger('change');
                // $('#anaesthetist_name').val('').trigger('change');

                $('#surgeon_name').html('');
                $('#anaesthetist_name').html('');

                $.ajax({
                    url: "{{ Route('opd.get-doctors') }}",
                    type: "POST",
                    data: {
                        _token: '{{ csrf_token() }}',
                        dept_id: department_id,
                    },
                    success: function(response) {
                        if (response.success && response.doctors.length > 0) {
                            $.each(response.doctors, function(key, value) {

                                const isSurgeonSelected = selectedSurgeons.includes(value.id.toString()) ? 'selected' : '';
                                const isAnaesthetistSelected = selectedAnaesthetists.includes(value.id.toString()) ? 'selected' : '';

                                $('#surgeon_name').append(
                                    `<option value="${value.id}" ${isSurgeonSelected}>${value.salutation} ${value.name}</option>`
                                );

                                $('#anaesthetist_name').append(
                                    `<option value="${value.id}" ${isAnaesthetistSelected}>${value.salutation} ${value.name}</option>`
                                );
                            });
                        }
                    },
                    error: function(error) {
                        console.log(error);
                    }
                });
            }
        }

        function getProcedureName(procedure_code, selectedProcedureNameId = null) {
            if (procedure_code) {
                $('#procedure_name').html('<option value="">Select Name</option>');
                $.ajax({
                    url: "{{ Route('ot.get-ot-procedure') }}",
                    type: "POST",
                    data: {
                        _token: '{{ csrf_token() }}',
                        procedure_code: procedure_code,
                    },
                    success: function(response) {
                        if (response.success && response.procedures.length > 0) {
                            $.each(response.procedures, function(key, value) {
                                let selected = (selectedProcedureNameId && selectedProcedureNameId == value.id) ? 'selected' : '';
                                $('#procedure_name').append(`<option value="${value.id}" ${selected}>${value.name}</option>`);
                            });
                        }
                    },
                    error: function(error) {
                        console.log(error);
                    }
                });
            }
        }
    </script>
@endpush
