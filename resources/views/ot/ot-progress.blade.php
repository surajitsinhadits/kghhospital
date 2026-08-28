@extends('layouts.structure')
@push('title')
    <title>OT Progress</title>
@endpush
@push('css')
    <style>
        .blink {
            text-decoration: blink;
            -webkit-animation-name: blinker;
            -webkit-animation-duration: 0.6s;
            -webkit-animation-iteration-count: infinite;
            -webkit-animation-timing-function: ease-in-out;
            -webkit-animation-direction: alternate;
        }

        @-webkit-keyframes blinker {
            from {
                opacity: 1.0;
            }

            to {
                opacity: 0.0;
            }
        }
    </style>
@endpush
@section('main-content')
    <div class="row">
        <div class="card ">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3 leftside_fixarea">
                        <x-billbar section="ot" id="{{ $ot_registration->id }}" type="sec" />
                    </div>
                    <form action="{{ @$edit_ot_progress ? route('ot.update-ot-progress') : route('ot.save-ot-progress') }}"
                        method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="ot_reg_id" value="{{ @$ot_registration->id }}">
                        <input type="hidden" name="patient_id" value="{{ @$ot_registration->patient_id }}">
                        <input type="hidden" name="ot_progress_id" value="{{ @$edit_ot_progress->id }}">
                        <input type="hidden" name="ot_room" value="{{ @$ot_schedule_details->ot_room }}">
                        <input type="hidden" name="ot_schedule_id" value="{{ @$ot_schedule_details->id }}">

                        <div class="col-md-9 rightside_fixarea">
                            {{-- @if ($ot_registration->status === 'Inprogress')
                                <div style="position: absolute;top: -22px;right: 1158px;font-size: 42px;color: red;">

                                    <span style="font-size: 34px;" class="blink" title="In Progress 🚨">🚨</span>
                                </div>
                            @endif --}}
                            <h3><u>OT Progress</u></h3>

                            <div class="row">
                                @if (@$edit_ot_progress)
                                    <div class="form-group col-md-6">
                                        <h6>Vitals</h6>
                                        <table class="table table-bordered   border-left border-bottom border-right"
                                            id="data-table" style="width: 98%;margin-left:1%;">
                                            <thead class="bg-primary">
                                                <tr>
                                                    <th scope="col" style="width: 10%" class="text-white">HR(bpm)</th>
                                                    <th scope="col" style="width: 35%" class="text-white">BP(mmHg)</th>
                                                    <th scope="col" style="width: 10%" class="text-white">RR(/Min)</th>
                                                    <th scope="col" style="width: 8%" class="text-white">SpO2(%)</th>
                                                    <th scope="col" style="width: 8%" class="text-white">Temp(F)</th>
                                                    <th scope="col" style="width: 17%" class="text-white">Time</th>
                                                    <th scope="col" style="width: 2%" class="text-white">#</th>
                                                </tr>
                                            </thead>
                                            <tbody id="chargeTable">
                                                <tr id="row">
                                                    <td>
                                                        <input type="text" id="vital_hr">
                                                    </td>
                                                    <td>
                                                        <div class="input-group">
                                                            <input type="text" class="form-control text-end"
                                                                value="" id="bp_systolic">
                                                            <span class="input-group-text">/</span>
                                                            <input type="text" class="form-control" value=""
                                                                id="bp_diastolic">
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <input type="text" id="vital_rr">

                                                    </td>
                                                    <td>
                                                        <input type="text" id="vital_spo2">
                                                    </td>
                                                    <td>

                                                        <input type="text" id="vital_temp">
                                                    </td>
                                                    <td>
                                                        <input type="text" id="vital_time" class="timePickr">
                                                    </td>
                                                    <td>
                                                        <button class="btn btn-success btn-sm" onclick="vitalValidation()"
                                                            type="button"><i class="fa fa-plus"></i></button>
                                                    </td>
                                                </tr>
                                                @php
                                                    $vitals = json_decode(@$edit_ot_progress->vitals ?? '[]');
                                                @endphp
                                                @if (!empty($vitals))
                                                    @foreach ($vitals as $i => $vital)
                                                        <tr style="background-color: #fff8dc;">
                                                            <td>
                                                                <input type="text" id="vital_hr"
                                                                    name="vitals[{{ $i }}][vital_hr]"
                                                                    value="{{ $vital->vital_hr ?? '' }}">

                                                            </td>
                                                            <td>
                                                                <div class="input-group">
                                                                    <input type="text" class="form-control text-end"
                                                                        value="{{ $vital->bp_systolic ?? '' }}"
                                                                        id="bp_systolic"
                                                                        name="vitals[{{ $i }}][bp_systolic]">
                                                                    <span class="input-group-text">/</span>
                                                                    <input type="text" class="form-control"
                                                                        value="{{ $vital->bp_diastolic ?? '' }}"
                                                                        id="bp_diastolic"
                                                                        name="vitals[{{ $i }}][bp_diastolic]">
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <input type="text" id="vital_rr"
                                                                    name="vitals[{{ $i }}][vital_rr]"
                                                                    value="{{ $vital->vital_rr ?? '' }}">

                                                            </td>
                                                            <td>
                                                                <input type="text" id="vital_spo2"
                                                                    name="vitals[{{ $i }}][vital_spo2]"
                                                                    value="{{ $vital->vital_spo2 ?? '' }}">
                                                            </td>
                                                            <td>

                                                                <input type="text" id="vital_temp"
                                                                    name="vitals[{{ $i }}][vital_temp]"
                                                                    value="{{ $vital->vital_temp ?? '' }}">
                                                            </td>
                                                            <td>
                                                                <input type="text" id="vital_time" class="timePickr"
                                                                    name="vitals[{{ $i }}][vital_time]"
                                                                    value="{{ $vital->vital_time ?? '' }}">
                                                            </td>
                                                            <td>
                                                                <button class="btn btn-danger btn-sm" type="button"
                                                                    onclick="removeRow(this)">×</button>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @endif
                                            </tbody>
                                        </table>

                                    </div>
                                @endif

                                <div class="form-group col-md-6">
                                    <h6>Device Used</h6>
                                    <table class="table table-bordered   border-left border-bottom border-right"
                                        id="data-table-2" style="width: 98%;margin-left:1%;">
                                        <thead class="bg-primary">
                                            <tr>
                                                <th scope="col" style="width: 50%" class="text-white">Device Name</th>
                                                <th scope="col" style="width: 50%" class="text-white">Device Code</th>
                                                <th scope="col" style="width: 2%" class="text-white">#</th>
                                            </tr>
                                        </thead>
                                        <tbody id="chargeTable">
                                            <tr id="row">
                                                <td>
                                                    <input type="text" id="device_name" class="form-control">
                                                </td>
                                                <td>
                                                    <input type="text" id="device_code" class="form-control">
                                                </td>
                                                <td>
                                                    <button class="btn btn-success btn-sm" onclick="deviceValidation()"
                                                        type="button"><i class="fa fa-plus"></i></button>
                                                </td>
                                            </tr>

                                            @php
                                                $devices = json_decode(@$edit_ot_progress->device_used ?? '[]');
                                            @endphp
                                            @if (!empty($devices))
                                                @foreach ($devices as $i => $device)
                                                    <tr style="background-color: #fff8dc;">
                                                        <td>
                                                            <input type="text" id="device_name"
                                                                name="device_used[{{ $i }}][device_name]"
                                                                value="{{ $device->device_name ?? '' }}">
                                                        </td>
                                                        <td>
                                                            <input type="text" id="device_code"
                                                                name="device_used[{{ $i }}][device_code]"
                                                                value="{{ $device->device_code ?? '' }}">
                                                        </td>
                                                        <td>
                                                            <button class="btn btn-danger btn-sm" type="button"
                                                                onclick="removeRow(this)">×</button>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @endif
                                        </tbody>
                                    </table>

                                </div>

                                <div class="form-group col-md-6">
                                    <h6>Fluids Administered</h6>
                                    <table class="table table-bordered   border-left border-bottom border-right"
                                        id="data-table-3" style="width: 98%;margin-left:1%;">
                                        <thead class="bg-primary">
                                            <tr>
                                                <th scope="col" style="width: 35%" class="text-white">Fluid Type</th>
                                                <th scope="col" style="width: 35%" class="text-white">Fluid Volume(unit)</th>
                                                <th scope="col" style="width: 35%" class="text-white">Fluid Time</th>
                                                <th scope="col" style="width: 2%" class="text-white">#</th>
                                            </tr>
                                        </thead>
                                        <tbody id="chargeTable3">
                                            <tr id="row">
                                                <td>
                                                    <input type="text" id="fluid_type" class="form-control">
                                                </td>
                                                <td>
                                                    <input type="text" id="fluid_volume" class="form-control">
                                                </td>
                                                <td>
                                                    <input type="text" id="fluid_time" class="form-control timePickr">
                                                </td>
                                                <td>
                                                    <button class="btn btn-success btn-sm" onclick="fluidValidation()"
                                                        type="button"><i class="fa fa-plus"></i></button>
                                                </td>
                                            </tr>
                                            @php
                                                $fluids = json_decode(@$edit_ot_progress->fluid_administrative ?? '[]');
                                            @endphp
                                            @if (!empty($fluids))
                                                @foreach ($fluids as $i => $fluid)
                                                    <tr style="background-color: #fff8dc;">
                                                        <td>
                                                            <input type="text" id="fluid_type"
                                                                name="fluid_administrative[{{ $i }}][fluid_type]"
                                                                value="{{ $fluid->fluid_type ?? '' }}">
                                                        </td>
                                                        <td>
                                                            <input type="text" id="fluid_volume"
                                                                name="fluid_administrative[{{ $i }}][fluid_volume]"
                                                                value="{{ $fluid->fluid_volume ?? '' }}">
                                                        </td>
                                                        <td>
                                                            <input type="text" id="fluid_time"
                                                                name="fluid_administrative[{{ $i }}][fluid_time]"
                                                                value="{{ $fluid->fluid_time ?? '' }}" class="timePickr">
                                                        </td>
                                                        <td>
                                                            <button class="btn btn-danger btn-sm" type="button"
                                                                onclick="removeRow(this)">×</button>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @endif
                                        </tbody>
                                    </table>

                                </div>

                                <div class="form-group col-md-6">
                                    <h6>Anesthetic Drugs</h6>
                                    <table class="table table-bordered   border-left border-bottom border-right"
                                        id="data-table-4" style="width: 98%;margin-left:1%;">
                                        <thead class="bg-primary">
                                            <tr>
                                                <th style="width: 35%" class="text-white">Drug Type</th>
                                                <th style="width: 35%" class="text-white">Drug Dose</th>
                                                <th style="width: 35%" class="text-white">Drug Time</th>
                                                <th style="width: 2%" class="text-white">#</th>
                                            </tr>
                                        </thead>
                                        <tbody id="chargeTable4">
                                            <tr id="row">
                                                <td>
                                                    <input type="text" id="drug_type">

                                                </td>
                                                <td>
                                                    <input type="text" id="drug_dose">
                                                </td>
                                                <td>
                                                    <input type="text" id="drug_time" class="timePickr">
                                                </td>
                                                <td>
                                                    <button class="btn btn-success btn-sm" onclick="drugsValidation()"
                                                        type="button"><i class="fa fa-plus"></i></button>
                                                </td>
                                            </tr>
                                            @php
                                                $drugs = json_decode(@$edit_ot_progress->anesthetic_drugs ?? '[]');
                                            @endphp
                                            @if (!empty($drugs))
                                                @foreach ($drugs as $i => $drug)
                                                    <tr style="background-color: #fff8dc;">
                                                        <td>
                                                            <input type="text" id="drug_type"
                                                                name="anesthetic_drugs[{{ $i }}][drug_type]"
                                                                value="{{ $drug->drug_type ?? '' }}">
                                                        </td>
                                                        <td>
                                                            <input type="text" id="drug_dose"
                                                                name="anesthetic_drugs[{{ $i }}][drug_dose]"
                                                                value="{{ $drug->drug_dose ?? '' }}">
                                                        </td>
                                                        <td>
                                                            <input type="text" id="drug_time"
                                                                name="anesthetic_drugs[{{ $i }}][drug_time]"
                                                                value="{{ $drug->drug_time ?? '' }}" class="timePickr">
                                                        </td>
                                                        <td>
                                                            <button class="btn btn-danger btn-sm" type="button"
                                                                onclick="removeRow(this)">×</button>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @endif
                                        </tbody>
                                    </table>

                                </div>
                                
                                <div class="form-group col-md-6">
                                    <label for="doctor">Sterilized Kit<span class="text-danger">*</span></label>
                                    <select name="kit_id[]" class="form-control select2-show-search" multiple="multiple" id="ot_room" required>
                                        <option disabled value="">Select</option>
                                        @foreach ($cssd_instrument as $data)
                                            <option
                                                value="{{ $data->id }}"{{ old('kit_id', in_array($data->id, explode(',', @$edit_ot_progress->kit_id)) ? ' selected' : '') }}>
                                                {{ $data->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('kit_id')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                @if (@$edit_ot_progress)
                                    <div class="form-group col-md-2">
                                        <label for="doctor">Blood Loss Estimate(ml)<span
                                                class="text-danger">*</span></label>
                                        <input type="number" name="blood_loss" class="form-control"
                                            value="{{ old('blood_loss', @$edit_ot_progress->blood_loss) }}" required>
                                        @error('blood_loss')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="doctor">Incision Time<span class="text-danger">*</span></label>
                                        <input type="text" name="incision_time" class="form-control timePickr"
                                            value="{{ old('incision_time', @$edit_ot_progress->incision_time) }}" required>
                                        @error('incision_time')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-3">
                                        <label for="doctor">Closure Time<span class="text-danger">*</span></label>
                                        <input type="text" name="closure_time" class="form-control timePickr"
                                            value="{{ old('closure_time', @$edit_ot_progress->closure_time) }}" required>
                                        @error('closure_time')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-2">
                                        <label for="doctor">Discrepancy Flag<span class="text-danger">*</span></label>
                                        <select name="discrepancy_flag" class="form-control select2-show-search"
                                            id="discrepancy_flag" required>
                                            <option value="">Select</option>
                                            <option value="yes"
                                                {{ old('discrepancy_flag', @$edit_ot_progress->discrepency_flags) == 'yes' ? 'selected' : '' }}>Yes
                                            </option>
                                            <option value="no"
                                                {{ old('discrepancy_flag', @$edit_ot_progress->discrepency_flags) == 'no' ? 'selected' : '' }}>No
                                            </option>
                                        </select>
                                        @error('discrepancy_flag')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                @endif

                                @if( @$ot_registration->status != 'Completed' )
                                <div class="modal-footer" style="margin-top: 71px;">
                                    <div class="mt-5">
                                        <button type="submit" name="save" class="btn btn-success btn-sm submitBtn" value=""><i class="fa fa-file"></i> {{ @$edit_ot_progress ? 'Update & Draft' : 'Save & Draft' }} </button>
                                        <button type="submit" name="save" class="btn btn-danger btn-sm submitBtn" value = "complete"><i class="fa fa-file"></i> Complete Process</button>
                                    </div>
                                </div>
                                @endif

                            </div>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script>
        function deviceValidation() {
            var itemSelect = $('#device_name').val();
            if (itemSelect == 0) {
                alert('Please Input Device Name !!!');
            } else {
                addNewDevicerow();
            }
        }

        function addNewDevicerow() {
            var table = document.getElementById("data-table-2");
            var newRow = table.insertRow(table.rows.length);

            var devicename = $('#device_name').val();
            var devicecode = $('#device_code').val();

            var cell1 = newRow.insertCell(0);
            var cell2 = newRow.insertCell(1);
            var cell3 = newRow.insertCell(2);



            var inputHTML =
                `<input type="text" name="device_used[${table.rows.length}][device_name]" class="form-control" value="${devicename}">`;
            cell1.innerHTML = inputHTML;

            var inputHTML1 =
                `<input type="text" class="form-control" name="device_used[${table.rows.length}][device_code]" value="${devicecode}">`;
            cell2.innerHTML = inputHTML1;

            // Remove button
            var removeBtn = '<button type="button" class="btn btn-danger btn-sm" onclick="removeRow(this)">X</button>';
            cell3.innerHTML = removeBtn;

            // const selectElement = document.getElementById("medicine_id0");
            // selectElement.selectedIndex = 0;
            $('#device_name').val('');
            $('#device_code').val('');


        }

        function fluidValidation() {
            var itemSelect = $('#fluid_type').val();
            if (itemSelect == 0) {
                alert('Please Input Fluid Type !!!');
            } else {
                addNewFluidrow();
            }
        }

        function addNewFluidrow() {
            var table = document.getElementById("data-table-3");
            var newRow = table.insertRow(table.rows.length);

            var fluidType = $('#fluid_type').val();
            var fluidVolume = $('#fluid_volume').val();
            var fluidTime = $('#fluid_time').val();

            var cell1 = newRow.insertCell(0);
            var cell2 = newRow.insertCell(1);
            var cell3 = newRow.insertCell(2);
            var cell4 = newRow.insertCell(3);



            var inputHTML =
                `<input type="text" name="fluid_administrative[${table.rows.length}][fluid_type]" class="form-control" value="${fluidType}">`;
            cell1.innerHTML = inputHTML;

            var inputHTML1 =
                `<input type="text" class="form-control" name="fluid_administrative[${table.rows.length}][fluid_volume]" value="${fluidVolume}">`;
            cell2.innerHTML = inputHTML1;

            var inputHTML2 =
                `<input type="text" class="form-control" name="fluid_administrative[${table.rows.length}][fluid_time]" value="${fluidTime}">`;
            cell3.innerHTML = inputHTML2;

            // Remove button
            var removeBtn = '<button type="button" class="btn btn-danger btn-sm" onclick="removeRow(this)">X</button>';
            cell4.innerHTML = removeBtn;

            // const selectElement = document.getElementById("medicine_id0");
            // selectElement.selectedIndex = 0;
            $('#fluid_type').val('');
            $('#fluid_volume').val('');
            $('#fluid_time').val('');


        }

        function drugsValidation() {
            var itemSelect = $('#drug_type').val();
            if (itemSelect == 0) {
                alert('Please Input Drug Type !!!');
            } else {
                addDrugsrow();
            }
        }

        function addDrugsrow() {
            var table = document.getElementById("data-table-4");
            var newRow = table.insertRow(table.rows.length);

            var drugType = $('#drug_type').val();
            var drugDose = $('#drug_dose').val();
            var drugTime = $('#drug_time').val();

            var cell1 = newRow.insertCell(0);
            var cell2 = newRow.insertCell(1);
            var cell3 = newRow.insertCell(2);
            var cell4 = newRow.insertCell(3);



            var inputHTML =
                `<input type="text" name="anesthetic_drugs[${table.rows.length}][drug_type]" class="form-control" value="${drugType}">`;
            cell1.innerHTML = inputHTML;

            var inputHTML1 =
                `<input type="text" class="form-control" name="anesthetic_drugs[${table.rows.length}][drug_dose]" value="${drugDose}">`;
            cell2.innerHTML = inputHTML1;

            var inputHTML2 =
                `<input type="text" class="form-control" name="anesthetic_drugs[${table.rows.length}][drug_time]" value="${drugTime}">`;
            cell3.innerHTML = inputHTML2;

            // Remove button
            var removeBtn = '<button type="button" class="btn btn-danger btn-sm" onclick="removeRow(this)">X</button>';
            cell4.innerHTML = removeBtn;

            // const selectElement = document.getElementById("medicine_id0");
            // selectElement.selectedIndex = 0;
            $('#drug_type').val('');
            $('#drug_dose').val('');
            $('#drug_time').val('');


        }

        function vitalValidation() {
            var itemSelect = $('#vital_hr').val();
            if (itemSelect == 0) {
                alert('Please Enter Heart Rate !!!');
            } else {
                addVitalNewrow();
            }
        }

        function addVitalNewrow() {
            var table = document.getElementById("data-table");
            var newRow = table.insertRow(table.rows.length);



            var vital_hr = $('#vital_hr').val();
            var bpsys = $('#bp_systolic').val();
            var bpdia = $('#bp_diastolic').val();
            var vital_rr = $('#vital_rr').val();
            var vital_spo2 = $('#vital_spo2').val();
            var vital_temp = $('#vital_temp').val();
            var vital_time = $('#vital_time').val();

            var cell1 = newRow.insertCell(0);
            var cell2 = newRow.insertCell(1);
            var cell3 = newRow.insertCell(2);
            var cell4 = newRow.insertCell(3);
            var cell5 = newRow.insertCell(4);
            var cell6 = newRow.insertCell(5);
            var cell7 = newRow.insertCell(6);




            var vitalhrInput =
                `<input type="text" name="vitals[${table.rows.length}][vital_hr]" class="form-control" value="${vital_hr}">`;
            cell1.innerHTML = vitalhrInput;

            var bpInput = '<div class="input-group">' +
                `<input type="text" name="vitals[${table.rows.length}][bp_systolic]" class="form-control text-end" value="${bpsys}">` +
                '<span class="input-group-text">/</span>' +
                `<input type="text" name="vitals[${table.rows.length}][bp_diastolic]" class="form-control" value="${bpdia}">` +
                '</div>';
            cell2.innerHTML = bpInput;

            // Weight
            var vitalrrInput =
                `<input type="text" name="vitals[${table.rows.length}][vital_rr]" class="form-control" value="${vital_rr}">`;
            cell3.innerHTML = vitalrrInput;

            // Pulse
            var vitalspo2Input =
                `<input type="text" name="vitals[${table.rows.length}][vital_spo2]" class="form-control" value="${vital_spo2}">`;
            cell4.innerHTML = vitalspo2Input;


            var tempInput =
                `<input type="text" name="vitals[${table.rows.length}][vital_temp]" class="form-control" value="${vital_temp}">`;
            cell5.innerHTML = tempInput;

            var timeInput =
                `<input type="text" name="vitals[${table.rows.length}][vital_time]" class="form-control" value="${vital_time}">`;
            cell6.innerHTML = timeInput;

            // Remove button
            var removeBtn = '<button type="button" class="btn btn-danger btn-sm" onclick="removeRow(this)">X</button>';
            cell7.innerHTML = removeBtn;


            $('#vital_hr').val('0').trigger('change');
            $('#vital_rr').val('0');
            $('#vital_spo2').val('0');
            $('#bp_systolic').val('0');
            $('#bp_diastolic').val('0');
            $('#vital_temp').val('0');
            $('#vital_time').val('');



        }

        function removeRow(button) {
            const row = button.closest('tr');
            const table = row.closest('table');
            table.deleteRow(row.rowIndex);
        }
    </script>
@endpush
