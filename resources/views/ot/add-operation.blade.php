@extends('layouts.structure')
@push('title')
    <title>Add Operation</title>
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



            height: 450px;
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
                        <div class="col-md-6 card-title card_hearder_mimi_text">OT Booking </div>
                        <div class="col-md-6 text-right">
                            <div class="d-block">
                                <a href="" class="btn btn-danger btn-sm">
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
                                    <form method="POST" id="operation-form" action="{{ Route('ot.save-operation') }}">
                                        @csrf
                                        <input type="hidden" name="ipd_id" id="patient_id" value="{{ @$details->id }}">
                                        <div class="options px-5 pt-1 pb-3">
                                            <div class="row">
                                                <div class="form-group col-md-4">
                                                    <label for="department">Department <span class="text-danger">*</span></label>
                                                    <select name="department_id" class="form-control select2-show-search"
                                                        id="department_id" required>
                                                        <option value="">All</option>
                                                        @foreach ($department as $dept)
                                                            <option {{ old('department_id') == $dept->id ? 'selected' : '' }} value="{{ $dept->id }}">{{ $dept->department_name }}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('department_id')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>

                                                <div class="form-group col-md-4">
                                                    <label for="doctor">Consultant Doctor <span class="text-danger">*</span></label>
                                                    <select name="cons_doc[]" class="form-control select2-show-search"
                                                        id="cons_doc" multiple required>
                                                        <option value="">Select Doctor</option>
                                                        @foreach ($doctor as $doc)
                                                            <option {{ old('cons_doc') && in_array($doc->id, old('cons_doc')) ? 'selected' : '' }} value="{{ $doc->id }}">Dr. {{ $doc->name }}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('cons_doc')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>

                                                <div class="form-group col-md-4">
                                                    <label class="date-format">Planned OT Date <span class="text-danger">*</span></label>
                                                    <input type="datetime-local" value="{{ old('planned_date', @$details->planned_date) }}" name="planned_date" id="appointment_date" required>
                                                    @error('planned_date')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>

                                                <div class="form-group col-md-3 newaddappon">
                                                    <label for="uhid">UHID</label>
                                                    <input type="number" id="uhid"
                                                        onkeyup="getPatient(this.value,'id')"
                                                        value="{{ old('uhid', @$patient_details->id) }}" name="uhid"
                                                        class="form-control" readonly>
                                                    @error('uhid')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>

                                                <div class="form-group col-md-3 newaddappon">
                                                    <label for="phone1">Mobile No. <span class="text-danger">*</span></label>
                                                    <input type="text" id="patient_ph_no"
                                                        onkeyup="getPatient(this.value,'phone')" maxlength="10"
                                                        name="phone"
                                                        oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                                                        class="form-control"
                                                        value="{{ old('phone', @$patient_details->phone) }}" required>
                                                    @error('phone')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>

                                                <div class="form-group col-md-6 custom-field" style="margin-top: 10px;">
                                                    <label for="name">Name <span class="text-danger">*</span></label>
                                                    <input type="text" id="name" class="text-capitalize"
                                                        oninput="this.value = this.value.replace(/[^a-zA-Z\s]/g, '')"
                                                        value="{{ old('name', @$patient_details->name) }}" name="name"
                                                        onkeyup="getPatient(this.value,'name')" autofocus required>
                                                    @error('name')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>

                                                <div class="col-md-12">
                                                    <div class="card-body hospital_allcardbodydesign" style="display:none"
                                                        id="search_result">
                                                        <div class="">
                                                            <div class="table-responsive">
                                                                <table
                                                                    class="table table-hover card-table table-vcenter text-nowrap border"
                                                                    style="background-color:#d9d9d9;border:1px solid black !important">
                                                                    <thead class="text-white"
                                                                        style="background-color:#5e6545">
                                                                        <tr class="border-left">
                                                                            <th class="text-white">UHID</th>
                                                                            <th class="text-white">Patient Name</th>
                                                                            <th class="text-white">Age</th>
                                                                            <th class="text-white">Phone</th>
                                                                            <th class="text-white">Address</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody id="search_result_row"></tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group col-md-3 newuserlisttchange">
                                                    <label for="gender">Gender <span class="text-danger">*</span></label>
                                                    <select name="gender" class="form-control" id="gender" required>
                                                        <option value="">Select Gender</option>
                                                        <option value="Male"
                                                            {{ old('gender', @$patient_details->gender) == 'Male' ? 'selected' : '' }}>
                                                            Male</option>
                                                        <option value="Female"
                                                            {{ old('gender', @$patient_details->gender) == 'Female' ? 'selected' : '' }}>
                                                            Female
                                                        </option>
                                                        <option value="Others"
                                                            {{ old('gender', @$patient_details->gender) == 'Others' ? 'selected' : '' }}>
                                                            Others
                                                        </option>
                                                    </select>
                                                    @error('gender')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>

                                                <div class="form-group col-md-3">
                                                    <div class="row">
                                                        <div class="col-lg-4 newdesignadd">
                                                            <label for="date_of_birth_year"> Year</label>
                                                            <input type="text" id="date_of_birth_year"
                                                                name="date_of_birth_year"
                                                                value="{{ old('date_of_birth_year', @$patient_details->dob_year) }}">
                                                            @error('date_of_birth_year')
                                                                <small class="text-danger">{{ $message }}</small>
                                                            @enderror
                                                        </div>
                                                        <div class="col-lg-4 newdesignadd">
                                                            <label for="date_of_birth_month"> Month</label>
                                                            <input type="text" id="date_of_birth_month"
                                                                name="date_of_birth_month"
                                                                value="{{ old('date_of_birth_month', @$patient_details->dob_month) }}">
                                                            @error('date_of_birth_month')
                                                                <small class="text-danger">{{ $message }}</small>
                                                            @enderror
                                                        </div>
                                                        <div class="col-lg-4 newdesignadd">
                                                            <label for="date_of_birth_day"> Day</label>
                                                            <input type="text" id="date_of_birth_day"
                                                                name="date_of_birth_day"
                                                                value="{{ old('date_of_birth_day', @$patient_details->dob_day) }}">
                                                            @error('date_of_birth_day')
                                                                <small class="text-danger">{{ $message }}</small>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-3 newdesignadd">
                                                    <label for="address"> Address <span class="text-danger">*</span></label>
                                                    <input type="text" id="address" name="address"
                                                        value="{{ old('address', @$patient_details->address) }}" required>
                                                    @error('address')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                                <div class="col-md-3 newdesignadd">
                                                    <label for="package_id">Operation Package <span
                                                            class="text-danger">*</span></label>
                                                    <select name="package_id" class="form-control select2-show-search"
                                                        id="package_id" onchange="applypackage(this.value)" required>
                                                        <option value="">Select</option>
                                                        @foreach ($otpackages as $doc)
                                                            <option {{ old('package_id') == $doc->id ? 'selected' : '' }} value="{{ $doc->id }}">{{ $doc->package_name }}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('package_id')
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
                                                                        <th scope="col" style="width: 2%"
                                                                            class="text-white"></th>
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
                                                    <div class="text-right">TOTAL <input style="width: 150px;"
                                                            type="text" id="total_amount" name="total_amount"
                                                            value="" readonly></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="text-center mt-2 mb-3">
                                            <button
                                                class="btn btn-primary submitBtn"
                                                type="submit"
                                                name="save"
                                                value="new"
                                            >
                                                <i class="fa fa-file text-success"></i> Save
                                            </button>
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
            if(table.rows.length == 1){
                removeSelection();
            }
        }

        function removeSelection() {
            $('#package_id').val('').trigger('change');
            $('#chargeSection').hide();
        }

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
                            <!--<th scope="col" style="width: 2%" class="text-white"></th>-->
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
                            // var cell4 = newRow.insertCell(3);
                            // var cell5 = newRow.insertCell(4);
                            // var cell6 = newRow.insertCell(5);
                            // var cell7 = newRow.insertCell(6);
                            // var cell8 = newRow.insertCell(7);
                            // var cell9 = newRow.insertCell(8);
                            // var cell10 = newRow.insertCell(9);

                            // var inputHTML1 = '<input type="date" name="date[]" id="date_and_time' +
                            //     table_id + '" class="form-control" value="' + dateValue + '">';
                            // cell1.innerHTML = inputHTML1;

                            var selectHTML =
                                '<select class="form-control" style="background-color: #e9e9eb;"  name="charge_name[]"><option value="' +
                                chargeValue + '">' + chargeText + '</option></select>';
                            cell1.innerHTML = selectHTML;



                            // var inputHTML1 = '<input type="text" name="rate[]" id="rate' + table_id +
                            //     '" onkeyup="updateCalculations(' + table_id +
                            //     ')" class="form-control" value="' + rateValue + '">';
                            // cell3.innerHTML = inputHTML1;

                            // var blankCellHTML = '';
                            // cell5.innerHTML = blankCellHTML;

                            // var inputHTML2 = '<input type="text" name="qty[]" id="qty' + table_id +
                            //     '" onkeyup="updateCalculations(' + table_id +
                            //     ')" class="form-control" value="' + qtyValue + '">';
                            // cell4.innerHTML = inputHTML2;

                            // var inputHTML3 =
                            //     '<input type="text" name="discount_in_per[]" onkeyup="updateCalculations(' +
                            //     table_id + ')" id="discount_in_per' + table_id +
                            //     '"  class="form-control" value="' +
                            //     discountInPerValue + '">';
                            // cell5.innerHTML = inputHTML3;

                            // var inputHTML4 =
                            //     '<input type="text" name="discount_amount[]" onkeyup="updateCalculations(' +
                            //     table_id + ')" id="discount_amount' + table_id +
                            //     '"  class="form-control" value="' +
                            //     discountAmountValue + '">';
                            // cell6.innerHTML = inputHTML4;

                            var inputHTML1 = '<input type="text" name="rate[]" id="amount' +
                                table_id + '" readonly class="form-control" readonly value="' +
                                amountValue + '">';
                            cell2.innerHTML = inputHTML1;

                            /*var inputHTML2 =
                                '<button type="button" class="btn btn-danger btn-sm" onclick="removeRow(this)">X</button>';
                            cell3.innerHTML = inputHTML2;*/
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
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const form = document.getElementById('operation-form');
            if (!form) {
                return;
            }
            const submitBtn = form.querySelector('button[type="submit"][name="save"]');
            if (!submitBtn) {
                return;
            }
            let isSubmitting = false;

            function startProcessing() {
                isSubmitting = true;
                submitBtn.dataset.submitted = 'true';
                submitBtn.disabled = true;
                const spinner = '<i class="fa fa-spinner fa-spin mr-2"></i>';
                submitBtn.innerHTML = spinner + 'Processing...';
            }

            submitBtn.addEventListener('click', function (event) {
                if (isSubmitting) {
                    event.preventDefault();
                }
            });

            form.addEventListener('submit', function (event) {
                if (isSubmitting) {
                    event.preventDefault();
                    return;
                }
                startProcessing();
            });
        });
    </script>
@endpush
