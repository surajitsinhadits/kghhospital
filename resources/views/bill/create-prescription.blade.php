@extends('layouts.structure')
@push('title')
    <title>{{ @$t }}</title>
@endpush
@push('css')
    <style>
        .newmargintopclass {
            position: relative;
            margin-top: 19px;
            padding: 11px 10px 20px 10px;
            background-color: #d9f0ff;


        }

        .whitebackground {
            box-shadow: 0 3px 6px rgba(0, 0, 0, 0.16), 0 3px 6px rgba(0, 0, 0, 0.23);

            margin: 2px 13px;
            /* padding: 0px 17px; */
            padding: 13px 18px 25px 18px;
            margin-bottom: 20px;
            border-radius: 5px;
            margin-top: 20px;
        }

        /* .prescription-form-background {
                                                                                                            background-image: url('{{ url('public/assets/images/prescription.jpg') }}');

                                                                                                            background-repeat: no-repeat;
                                                                                                            background-size: cover;

                                                                                                            background-position: center;
                                                                                                            padding: 20px;
                                                                                                            border-radius: 10px;
                                                                                                            position:relative;
                                                                                                            height:100%;
                                                                                                        } */
        /* .overlay{
                                                                                                         position :absolute;
                                                                                                         top:0;
                                                                                                         bottom: 0;
                                                                                                         left: 0;
                                                                                                         right: 0;
                                                                                                         background-color: #000;
                                                                                                        } */
    </style>
@endpush

@section('main-content')
    <div class="row">
        <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12">
            <div class="card">
                <div class="card-header card_hearder_mimi">
                    <h4 class="card-title card_hearder_mimi_text">{{ @$emr_data ? 'Edit Prescription' : 'Add Prescription' }}
                    </h4>
                </div>
                <div class="prescription-form-background">
                    <div class="overlay">
                        <form id="prescriptionForm"
                            action="{{ @$emr_data ? route('bill.emr-update', $section) : route('bill.emr-save', $section) }}"
                            method="POST" enctype="multipart/form-data">
                            @csrf
                            <input name="section_id" value="{{ @$opd_details->id }}" type="hidden" />
                            <input name="section" value="{{ @$section }}" type="hidden" />
                            <input name="emr_master_id" value="{{ @$emr_data->id }}" type="hidden" />

                            <div class="row whitebackground">
                                <div class="col-md-1">
                                    <h4 style="text-align: left; color: #1d2c39; padding: 30px 0px 0px 18px;"><i
                                            class="fas fa-file-medical-alt"></i> {{ @$section }} </h4>
                                </div>
                                <div class="col-md-3 ">
                                    <label for="date" class="form-label">Date <span class="text-danger">*</span></label>
                                    <input type="text" class="dateTimePickr" value="{{ date('d-m-Y h:i A') }}"
                                        id="date" name="date" required>

                                    @error('date')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                @if( !empty($patient_details->id) )
                                <div class="col-md-3">
                                    <label class="form-label">Patient Name <span class="text-danger">*</span></label>
                                    <input class="form-control"
                                        value="{{ $patient_details->name }} ({{ $patient_details->id }})"
                                        name="requested_by" readonly />
                                    <input type="hidden" value="{{ $patient_details->id }}" name="patient_id" />
                                </div>
                                @endif

                                @if( !empty($doctor_details->name) )
                                <div class="col-md-5">
                                    <label class="form-label">Doctor's Name <span class="text-danger">*</span></label>
                                    <textarea class="form-control" rows="2" readonly>{{ $doctor_details->name }} ({{ $doctor_details->specialization }},{{ $doctor_details->qualification }})</textarea>

                                    <input type="hidden" value="{{ $doctor_details->id }}" name="doctor_id" />
                                </div>
                                @endif






                            </div>

                            <div class="form-group col-md-12 mt-3">
                                <div class="table-responsive">
                                    {{-- <div class="whitebackground"> --}}
                                    <div class="newmargintopclass whitebackground">
                                        <h4 style="text-align: left; color: #2571b2; padding: 0px 0px 0px 4px;"><i
                                                class="fas fa-procedures"></i> Vitals</h4>
                                        <table class="table card-table table-vcenter text-nowrap border" id="data-table">
                                            <thead class=" text-white">
                                                <tr>
                                                    <th class="text-white" style="width: 28%">Height(cm) <span
                                                            class="text-danger">*</span></th>
                                                    <th class="text-white" style="width: 10%">Weight(kg)<span
                                                            class="text-danger">*</span>
                                                    </th>
                                                    <th class="text-white" style="width: 15%">Pulse(bpm)<span
                                                            class="text-danger">*</span>
                                                    </th>
                                                    <th class="text-white" style="width: 20%">BP(mmHg)<span
                                                            class="text-danger">*</span></th>
                                                    <th class="text-white" style="width: 15%">Temperature(F)<span
                                                            class="text-danger">*</span>
                                                    </th>
                                                    <th class="text-white" style="width: 2%"></th>
                                                </tr>
                                            </thead>
                                            <tbody id="chargeTable">
                                                <tr>
                                                    <td>
                                                        <input type="number" class="form-control" value="0"
                                                            id="height">
                                                    </td>
                                                    <td><input type="number" class="form-control" value="0"
                                                            id="weight">
                                                    </td>
                                                    <td><input type="number" class="form-control" value="0"
                                                            id="pulse">
                                                    </td>
                                                    <td>
                                                        <div class="input-group">
                                                            <input type="number" class="form-control text-end"
                                                                value="0" id="bp_systolic">
                                                            <span class="input-group-text">/</span>
                                                            <input type="number" class="form-control" value="0"
                                                                id="bp_diastolic">
                                                        </div>
                                                    </td>
                                                    <td><input type="number" class="form-control" value="0"
                                                            id="temperature">
                                                    </td>
                                                    <td><button class="btn btn-success btn-sm" onclick="validation()"
                                                            type="button">+</button></td>
                                                </tr>

                                                @php
                                                    $vitals = json_decode($emr_data->vitals ?? '[]');
                                                @endphp
                                                @if (!empty($vitals))
                                                    @foreach ($vitals as $i => $vital)
                                                        <tr style="background-color: #fff8dc;">
                                                            <td>
                                                                <input type="number" class="form-control"
                                                                    name="vitals[{{ $i }}][height]"
                                                                    value="{{ $vital->height ?? 0 }}">
                                                            </td>
                                                            <td>
                                                                <input type="number" class="form-control"
                                                                    name="vitals[{{ $i }}][weight]"
                                                                    value="{{ $vital->weight ?? 0 }}">
                                                            </td>
                                                            <td>
                                                                <input type="number" class="form-control"
                                                                    name="vitals[{{ $i }}][pulse]"
                                                                    value="{{ $vital->pulse ?? 0 }}">
                                                            </td>
                                                            <td>
                                                                <div class="input-group">
                                                                    <input type="number" class="form-control text-end"
                                                                        name="vitals[{{ $i }}][bp_systolic]"
                                                                        value="{{ $vital->bp_systolic ?? 0 }}">
                                                                    <span class="input-group-text">/</span>
                                                                    <input type="number" class="form-control"
                                                                        name="vitals[{{ $i }}][bp_diastolic]"
                                                                        value="{{ $vital->bp_diastolic ?? 0 }}">
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <input type="number" class="form-control"
                                                                    name="vitals[{{ $i }}][temperature]"
                                                                    value="{{ $vital->temperature ?? 0 }}">
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

                                    {{-- <div class="whitebackground"> --}}
                                    <div class="newmargintopclass whitebackground">
                                        <h4 style="text-align: left; color: #2571b2; padding: 0px 0px 0px 4px;"><i
                                                class="fas fa-stethoscope"></i> Complaints</h4>
                                        <table class="table card-table table-vcenter text-nowrap border"
                                            id="data-table-1">
                                            <thead class="bg-primary text-white">
                                                <tr>
                                                    <th class="text-white" style="width: 15%">Date<span
                                                            class="text-danger">*</span>
                                                    </th>
                                                    <th class="text-white" style="width: 28%">Complaints <span
                                                            class="text-danger">*</span></th>
                                                    <th class="text-white" style="width: 10%">Frequency<span
                                                            class="text-danger">*</span>
                                                    </th>
                                                    <th class="text-white" style="width: 15%">Severity<span
                                                            class="text-danger">*</span>
                                                    </th>
                                                    <th class="text-white" style="width: 10%">Duration<span
                                                            class="text-danger">*</span></th>

                                                    <th class="text-white" style="width: 2%"></th>
                                                </tr>
                                            </thead>
                                            <tbody id="chargeTable">


                                                <tr>
                                                    <td><input type="date" class="form-control dateTimePickr"
                                                            value="0" id="complaints_date"></td>
                                                    <td>
                                                        <input type="text" class="form-control" value=""
                                                            id="complaints">
                                                    </td>
                                                    <td><select class="form-control select2-show-search" id="frequency">
                                                            <option value="">Select</option>

                                                            <option value="Daily">Daily</option>
                                                            <option value="Alternate Day">Alternate Day</option>
                                                            <option value="Weekly">Weekly</option>
                                                            <option value="Twice Weekly">Twice Weekly</option>
                                                            <option value="Fort Night">Fort Night</option>
                                                            <option value="Monthly">Monthly</option>



                                                        </select>
                                                    </td>
                                                    <td><select class="form-control select2-show-search" id="severity">
                                                            <option value="">Select</option>

                                                            <option value="Mild">Mild</option>
                                                            <option value="Moderate">Moderate</option>
                                                            <option value="Severe">Severe</option>
                                                            <option value="Profound">Profound</option>

                                                        </select>
                                                    </td>
                                                    <td>
                                                        <select class="form-control select2-show-search" id="duration">
                                                            <option value="">Select</option>

                                                            <option value="_Day">_Day</option>
                                                            <option value="_Week">_Week</option>
                                                            <option value="_Month">_Month</option>
                                                            <option value="_Year">_Year</option>

                                                        </select>
                                                    </td>

                                                    <td><button class="btn btn-success btn-sm"
                                                            onclick="Complaintsvalidation()" type="button">+</button>
                                                    </td>
                                                </tr>

                                                @php
                                                    $complaints = json_decode($emr_data->complaints ?? '[]');
                                                @endphp
                                                @if (!empty($complaints))
                                                    @foreach ($complaints as $c => $complaint)
                                                        <tr style="background-color: #fff8dc;">
                                                            <td>
                                                                <input type="date"
                                                                    name="complaints[{{ $c }}][complaints_date]"
                                                                    class="form-control dateTimePickr"
                                                                    value="{{ isset($complaint->complaints_date) ? \Carbon\Carbon::parse($complaint->complaints_date)->format('Y-m-d') : '' }}">
                                                            </td>
                                                            <td>
                                                                <input type="text" class="form-control"
                                                                    name="complaints[{{ $c }}][complaints]"
                                                                    value="{{ $complaint->complaints ?? '' }}">
                                                            </td>
                                                            <td>
                                                                <select name="complaints[{{ $c }}][frequency]"
                                                                    class="form-control select2-show-search">
                                                                    <option value="">Select</option>
                                                                    <option value="Daily"
                                                                        {{ ($complaint->frequency ?? '') == 'Daily' ? 'selected' : '' }}>
                                                                        Daily</option>
                                                                    <option value="Alternate Day"
                                                                        {{ ($complaint->frequency ?? '') == 'Alternate Day' ? 'selected' : '' }}>
                                                                        Alternate Day</option>
                                                                    <option value="Weekly"
                                                                        {{ ($complaint->frequency ?? '') == 'Weekly' ? 'selected' : '' }}>
                                                                        Weekly</option>
                                                                    <option value="Twice Weekly"
                                                                        {{ ($complaint->frequency ?? '') == 'Twice Weekly' ? 'selected' : '' }}>
                                                                        Twice Weekly</option>
                                                                    <option value="Fort Night"
                                                                        {{ ($complaint->frequency ?? '') == 'Fort Night' ? 'selected' : '' }}>
                                                                        Fort Night</option>
                                                                    <option value="Monthly"
                                                                        {{ ($complaint->frequency ?? '') == 'Monthly' ? 'selected' : '' }}>
                                                                        Monthly</option>
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <select name="complaints[{{ $c }}][severity]"
                                                                    class="form-control select2-show-search">
                                                                    <option value="">Select</option>
                                                                    <option value="Mild"
                                                                        {{ ($complaint->severity ?? '') == 'Mild' ? 'selected' : '' }}>
                                                                        Mild</option>
                                                                    <option value="Moderate"
                                                                        {{ ($complaint->severity ?? '') == 'Moderate' ? 'selected' : '' }}>
                                                                        Moderate</option>
                                                                    <option value="Severe"
                                                                        {{ ($complaint->severity ?? '') == 'Severe' ? 'selected' : '' }}>
                                                                        Severe</option>
                                                                    <option value="Profound"
                                                                        {{ ($complaint->severity ?? '') == 'Profound' ? 'selected' : '' }}>
                                                                        Profound</option>
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <select name="complaints[{{ $c }}][duration]"
                                                                    class="form-control select2-show-search">
                                                                    <option value="">Select</option>
                                                                    <option value="_Day"
                                                                        {{ ($complaint->duration ?? '') == '_Day' ? 'selected' : '' }}>
                                                                        _Day</option>
                                                                    <option value="_Week"
                                                                        {{ ($complaint->duration ?? '') == '_Week' ? 'selected' : '' }}>
                                                                        _Week</option>
                                                                    <option value="_Month"
                                                                        {{ ($complaint->duration ?? '') == '_Month' ? 'selected' : '' }}>
                                                                        _Month</option>
                                                                    <option value="_Year"
                                                                        {{ ($complaint->duration ?? '') == '_Year' ? 'selected' : '' }}>
                                                                        _Year</option>
                                                                </select>
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
                                    {{-- </div> --}}
                                    {{-- <div class="whitebackground"> --}}
                                    <div class="newmargintopclass whitebackground">
                                        <h4 style="text-align: left; color: #2571b2; padding: 0px 0px 0px 4px;"><i
                                                class="fas fa-diagnoses"></i> Diagnosis</h4>
                                        <table class="table card-table table-vcenter text-nowrap border"
                                            id="data-table-2">
                                            <thead class="bg-primary text-white">
                                                <tr>
                                                    <th class="text-white" style="width: 15%">Date<span
                                                            class="text-danger">*</span>
                                                    </th>
                                                    <th class="text-white" style="width: 28%">Diagnosis <span
                                                            class="text-danger">*</span></th>
                                                    <th class="text-white" style="width: 10%">Duration<span
                                                            class="text-danger">*</span>
                                                    </th>

                                                    <th class="text-white" style="width: 2%"></th>
                                                </tr>
                                            </thead>
                                            <tbody id="chargeTable">


                                                <tr>
                                                    <td><input type="date" class="form-control dateTimePickr"
                                                            value="0" id="diagnosis_date"></td>
                                                    <td>
                                                        <select class="form-control select2-show-search" id="diagnosis">
                                                            <option value="">Select</option>
                                                            @foreach ($diagonase as $value)
                                                                <option
                                                                    value="{{ $value->diagonasis_name }}({{ $value->icd_code }})">
                                                                    {{ $value->diagonasis_name }}({{ $value->icd_code }})
                                                                </option>
                                                            @endforeach


                                                        </select>
                                                    </td>
                                                    <td><select class="form-control select2-show-search"
                                                            id="diagnosis_duration">
                                                            <option value="">Select</option>

                                                            <option value="_Day">_Day</option>
                                                            <option value="_Week">_Week</option>
                                                            <option value="_Month">_Month</option>
                                                            <option value="_Year">_Year</option>

                                                        </select>
                                                    </td>



                                                    <td><button class="btn btn-success btn-sm"
                                                            onclick="diagnosisvalidation()" type="button">+</button></td>
                                                </tr>

                                                @php
                                                    $diagnoses = json_decode($emr_data->diagnosis ?? '[]');
                                                @endphp

                                                @if (!empty($diagnoses))
                                                    @foreach ($diagnoses as $d => $diag)
                                                        <tr style="background-color: #fff8dc;">
                                                            <td>
                                                                <input type="date"
                                                                    name="diagnosis[{{ $d }}][diagnosis_date]"
                                                                    class="form-control dateTimePickr"
                                                                    value="{{ isset($diag->diagnosis_date) ? \Carbon\Carbon::parse($diag->diagnosis_date)->format('Y-m-d') : '' }}">
                                                            </td>
                                                            <td>
                                                                <select class="form-control select2-show-search"
                                                                    name="diagnosis[{{ $d }}][diagnosis]">
                                                                    <option value="">Select</option>
                                                                    @foreach ($diagonase as $value)
                                                                        <option
                                                                            value="{{ $value->diagonasis_name }}({{ $value->icd_code }})"
                                                                            {{ ($diag->diagnosis ?? '') == $value->diagonasis_name . '(' . $value->icd_code . ')' ? 'selected' : '' }}>
                                                                            {{ $value->diagonasis_name }}({{ $value->icd_code }})
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            </td>

                                                            <td>
                                                                <select class="form-control select2-show-search"
                                                                    name="diagnosis[{{ $d }}][diagnosis_duration]">
                                                                    <option value="">Select</option>
                                                                    <option value="_Day"
                                                                        {{ ($diag->diagnosis_duration ?? '') == '_Day' ? 'selected' : '' }}>
                                                                        _Day</option>
                                                                    <option value="_Week"
                                                                        {{ ($diag->diagnosis_duration ?? '') == '_Week' ? 'selected' : '' }}>
                                                                        _Week</option>
                                                                    <option value="_Month"
                                                                        {{ ($diag->diagnosis_duration ?? '') == '_Month' ? 'selected' : '' }}>
                                                                        _Month</option>
                                                                    <option value="_Year"
                                                                        {{ ($diag->diagnosis_duration ?? '') == '_Year' ? 'selected' : '' }}>
                                                                        _Year</option>
                                                                </select>
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
                                    {{-- </div> --}}
                                    {{-- <div class="whitebackground"> --}}
                                    <div class="newmargintopclass whitebackground">
                                        <h4 style="text-align: left; color: #2571b2; padding: 0px 0px 0px 4px;"><i
                                                class="fas fa-pills"></i> Medicines</h4>
                                        <table class="table card-table table-vcenter text-nowrap border"
                                            id="data-table-3">
                                            <thead class="bg-primary text-white">
                                                <tr>
                                                    <th class="text-white" style="width: 15%">Composition <span
                                                            class="text-danger">*</span></th>
                                                    <th class="text-white" style="width: 15%">Medicine<span
                                                            class="text-danger">*</span>
                                                    </th>
                                                    <th class="text-white" style="width: 10%">Dose<span
                                                            class="text-danger">*</span>
                                                    </th>
                                                    <th class="text-white" style="width: 10%">When<span
                                                            class="text-danger">*</span>
                                                    </th>
                                                    <th class="text-white" style="width: 10%">Frequency<span
                                                            class="text-danger">*</span>
                                                    </th>
                                                    <th class="text-white" style="width: 10%">Duration<span
                                                            class="text-danger">*</span>
                                                    </th>
                                                    <th class="text-white" style="width: 15%">Notes/Instructions<span
                                                            class="text-danger">*</span>
                                                    </th>
                                                    <th class="text-white" style="width: 2%"></th>
                                                </tr>
                                            </thead>
                                            <tbody id="chargeTable">


                                                <tr>
                                                    <td>
                                                        <select class="form-control select2-show-search" id="composition"
                                                            onchange="fetchMedicinesByComposition(this.value)">
                                                            <option value="">Select</option>
                                                            @foreach ($compositions as $value)
                                                                <option value="{{ $value }}">
                                                                    {{ $value }}
                                                                </option>
                                                            @endforeach


                                                        </select>
                                                    </td>
                                                    <td><select class="form-control select2-show-search" id="medicine">
                                                            <option value="">Select</option>
                                                        </select>
                                                    </td>
                                                    <td><select class="form-control select2-show-search" id="dose">
                                                            <option value="">Select</option>

                                                            <option value="1-0-0">1-0-0</option>
                                                            <option value="0-0-1">0-0-1</option>
                                                            <option value="1-0-1">1-0-1</option>
                                                            <option value="1-1-1">1-1-1</option>
                                                            <option value="1-1-0">1-1-0</option>
                                                            <option value="0-1-0">0-1-0</option>
                                                            <option value="0-1-1">0-1-1</option>
                                                            <option value="0-0-0">0-0-0</option>


                                                        </select>
                                                    </td>
                                                    <td><select class="form-control select2-show-search" id="when">
                                                            <option value="">Select</option>
                                                            <option value="Before Food">Before Food</option>
                                                            <option value="After Food">After Food</option>
                                                            <option value="Before Breakfast">Before Breakfast</option>
                                                            <option value="After Breakfast">After Breakfast</option>
                                                            <option value="Before Lunch">Before Lunch</option>
                                                            <option value="After Lunch">After Lunch</option>
                                                            <option value="Before Dinner">Before Dinner</option>
                                                            <option value="After Dinner">After Dinner</option>
                                                            <option value="Empty Stomach">Empty Stomach</option>
                                                            <option value="Bed Time">Bed Time</option>
                                                            <option value="SoS">SoS</option>

                                                        </select>
                                                    </td>
                                                    <td><select class="form-control select2-show-search"
                                                            id="medicine_frequency">
                                                            <option value="">Select</option>

                                                            <option value="Daily">Daily</option>
                                                            <option value="Alternate Day">Alternate Day</option>
                                                            <option value="Weekly">Weekly</option>
                                                            <option value="Fort Night">Fort Night</option>
                                                            <option value="Monthly">Monthly</option>


                                                        </select>
                                                    </td>
                                                    <td><select class="form-control select2-show-search"
                                                            id="medicine_duration">
                                                            <option value="">Select</option>
                                                            <option value="_Day">_Day</option>
                                                            <option value="_Week">_Week</option>
                                                            <option value="_Month">_Month</option>
                                                            <option value="_Year">_Year</option>

                                                        </select>
                                                    </td>


                                                    <td><input type="text" class="form-control"
                                                            id="notes_instructions">
                                                    </td>
                                                    <td><button class="btn btn-success btn-sm"
                                                            onclick="Medicinevalidation()" type="button">+</button></td>
                                                </tr>
                                                @php
                                                    $medicines = json_decode($emr_data->medicines ?? '[]');
                                                @endphp

                                                @if (!empty($medicines))
                                                    @foreach ($medicines as $m => $medicine)
                                                        <tr style="background-color: #fff8dc;">
                                                            <td>
                                                                <select class="form-control select2-show-search"
                                                                    name="medicines[{{ $m }}][composition]">
                                                                    <option value="">Select</option>
                                                                    @foreach ($compositions as $value)
                                                                        <option value="{{ $value }}"
                                                                            {{ ($medicine->composition ?? '') == $value ? 'selected' : '' }}>
                                                                            {{ $value }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            </td>

                                                            <td>
                                                                <select class="form-control select2-show-search"
                                                                    name="medicines[{{ $m }}][medicine]">
                                                                    <option value="">Select</option>
                                                                    @if (!empty($medicine->composition))
                                                                        <option value="{{ $medicine->medicine ?? '' }}"
                                                                            selected>{{ $medicine->medicine ?? '' }}
                                                                        </option>
                                                                    @endif
                                                                </select>
                                                            </td>

                                                            <td>
                                                                <select class="form-control select2-show-search"
                                                                    name="medicines[{{ $m }}][dose]">
                                                                    <option value="">Select</option>
                                                                    @foreach (['1-0-0', '0-0-1', '1-0-1', '1-1-1', '1-1-0', '0-1-0', '0-1-1', '0-0-0'] as $dose)
                                                                        <option value="{{ $dose }}"
                                                                            {{ ($medicine->dose ?? '') == $dose ? 'selected' : '' }}>
                                                                            {{ $dose }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            </td>

                                                            <td>
                                                                <select class="form-control select2-show-search"
                                                                    name="medicines[{{ $m }}][when]">
                                                                    <option value="">Select</option>
                                                                    @foreach (['Before Food', 'After Food', 'Before Breakfast', 'After Breakfast', 'Before Lunch', 'After Lunch', 'Before Dinner', 'After Dinner', 'Empty Stomach', 'Bed Time', 'SoS'] as $when)
                                                                        <option value="{{ $when }}"
                                                                            {{ ($medicine->when ?? '') == $when ? 'selected' : '' }}>
                                                                            {{ $when }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            </td>

                                                            <td>
                                                                <select class="form-control select2-show-search"
                                                                    name="medicines[{{ $m }}][frequency]">
                                                                    <option value="">Select</option>
                                                                    @foreach (['Daily', 'Alternate Day', 'Weekly', 'Fort Night', 'Monthly'] as $freq)
                                                                        <option value="{{ $freq }}"
                                                                            {{ ($medicine->frequency ?? '') == $freq ? 'selected' : '' }}>
                                                                            {{ $freq }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            </td>

                                                            <td>
                                                                <select class="form-control select2-show-search"
                                                                    name="medicines[{{ $m }}][medicine_duration]">
                                                                    <option value="">Select</option>
                                                                    @foreach (['_Day', '_Week', '_Month', '_Year'] as $duration)
                                                                        <option value="{{ $duration }}"
                                                                            {{ ($medicine->medicine_duration ?? '') == $duration ? 'selected' : '' }}>
                                                                            {{ $duration }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            </td>

                                                            <td>
                                                                <input type="text" class="form-control"
                                                                    name="medicines[{{ $m }}][notes_instructions]"
                                                                    value="{{ $medicine->notes_instructions ?? '' }}">
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
                                    {{-- </div> --}}
                                </div>
                            </div>
                            @php
                                $selectedTests = json_decode($emr_data->test_name ?? '[]');
                            @endphp

                            <div class="row whitebackground newmargintopclass">
                                <div class="col-md-8 newuserrchange">
                                    <h4 style="text-align: left; color: #2571b2; padding: 0px 0px 0px 4px;">
                                        <i class="fas fa-vial"></i> Tests Needed
                                    </h4>

                                    <select class="form-control select2-show-search" name="test_name[]" multiple>
                                        <option value="">Select</option>
                                        @foreach ($tests as $value)
                                            <option value="{{ $value->charge_name }}"
                                                {{ in_array($value->charge_name, $selectedTests ?? []) ? 'selected' : '' }}>
                                                {{ $value->charge_name }}
                                            </option>
                                        @endforeach
                                    </select>

                                    @error('test_name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row whitebackground newmargintopclass">

                                <div class="col-md-12">
                                    <h4 style="text-align: left; color: #2571b2; padding: 0px 0px 0px 4px;"><i
                                            class="fas fa-comment-medical"></i> Advice</h4>
                                    <textarea class="text" name="advice" rows="5" cols="45">{{ old('advice', @$emr_data->advice) }}</textarea>
                                    @error('note')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="text-center m-auto">
                                <button type="button" class="btn btn-primary" onclick="confirmSubmit()">
                                    <i class="fas fa-file-prescription"></i>
                                    {{ @$emr_data ? 'Update Prescription' : 'Create Prescription' }} </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script>
        function confirmSubmit() {
            const confirmed = confirm("Are you sure you want to submit the prescription?");
            if (confirmed) {
                document.getElementById('prescriptionForm').submit();
            }
        }


        function fetchMedicinesByComposition(composition) {
            $('#medicine').html('');
            $('#medicine').html('<option value="">Select One...</option>');

            $.ajax({
                url: "{{ route('pharmacy.get-medicine-by-composition') }}",
                type: "POST",
                data: {
                    _token: '{{ csrf_token() }}',
                    composition: composition,
                },
                success: function(response) {
                    console.log(response);
                    $.each(response, function(key, value) {
                        $('#medicine').append(
                            `<option value="${value.medicine_name}(${value.medicine_catagory_name})">${value.medicine_name} (${value.medicine_catagory_name})</option>`
                        );
                    });
                },
                error: function(error) {
                    console.log(error);
                }
            });
        }

        function validation() {
            var itemSelect = $('#height').val();
            if (itemSelect == 0) {
                alert('Please Enter Height !!!');
            } else {
                addNewrow();
            }
        }

        function Complaintsvalidation() {
            var itemSelect = $('#complaints').val();
            if (itemSelect == 0) {
                alert('Please Enter Complaints !!!');
            } else {
                addNewComplaintsrow();
            }
        }

        function diagnosisvalidation() {
            var itemSelect = $('#diagnosis').val();
            if (itemSelect == 0) {
                alert('Please Select Diagnosis !!!');
            } else {
                addNewDiagnosisrow();
            }
        }

        function Medicinevalidation() {
            var itemSelect = $('#composition').val();
            if (itemSelect == 0) {
                alert('Please Select Composition !!!');
            } else {
                addNewMedicinerow();
            }
        }

        function addNewrow() {
            var table = document.getElementById("data-table");
            var newRow = table.insertRow(table.rows.length);



            var height = $('#height').val();
            var weight = $('#weight').val();
            var pulse = $('#pulse').val();
            var bpsys = $('#bp_systolic').val();
            var bpdia = $('#bp_diastolic').val();
            var temperature = $('#temperature').val();

            var cell1 = newRow.insertCell(0);
            var cell2 = newRow.insertCell(1);
            var cell3 = newRow.insertCell(2);
            var cell4 = newRow.insertCell(3);
            var cell5 = newRow.insertCell(4);
            var cell6 = newRow.insertCell(5);




            var heightInput =
                `<input type="text" name="vitals[${table.rows.length}][height]" class="form-control" value="${height}">`;
            cell1.innerHTML = heightInput;

            // Weight
            var weightInput =
                `<input type="text" name="vitals[${table.rows.length}][weight]" class="form-control" value="${weight}">`;
            cell2.innerHTML = weightInput;

            // Pulse
            var pulseInput =
                `<input type="text" name="vitals[${table.rows.length}][pulse]" class="form-control" value="${pulse}">`;
            cell3.innerHTML = pulseInput;

            // BP (Systolic / Diastolic)
            var bpInput = '<div class="input-group">' +
                `<input type="text" name="vitals[${table.rows.length}][bp_systolic]" class="form-control text-end" value="${bpsys}">` +
                '<span class="input-group-text">/</span>' +
                `<input type="text" name="vitals[${table.rows.length}][bp_diastolic]" class="form-control" value="${bpdia}">` +
                '</div>';
            cell4.innerHTML = bpInput;


            // Temperature
            var tempInput =
                `<input type="text" name="vitals[${table.rows.length}][temperature]" class="form-control" value="${temperature}">`;
            cell5.innerHTML = tempInput;

            // Remove button
            var removeBtn = '<button type="button" class="btn btn-danger btn-sm" onclick="removeRow(this)">X</button>';
            cell6.innerHTML = removeBtn;

            // const hiddenInput = document.createElement('input');
            // hiddenInput.type = 'hidden';
            // hiddenInput.name = 'vitals[]';
            // hiddenInput.value = JSON.stringify(vitals);
            // newRow.appendChild(hiddenInput);
            // const selectElement = document.getElementById("medicine_id0");
            // selectElement.selectedIndex = 0;
            $('#height').val('0').trigger('change');
            $('#weight').val('0');
            $('#pulse').val('0');
            $('#bp_systolic').val('0');
            $('#bp_diastolic').val('0');
            $('#temperature').val('0');



        }

        function addNewComplaintsrow() {
            var table = document.getElementById("data-table-1");
            var newRow = table.insertRow(table.rows.length);



            var complaints = $('#complaints').val();

            var ItemSelect = $('#frequency');
            var selectedOption = ItemSelect.find('option:selected');
            var itemValue = selectedOption.val();
            var itemText = selectedOption.text();

            var SeveritySelect = $('#severity');
            var selectedOption = SeveritySelect.find('option:selected');
            var severityValue = selectedOption.val();
            var severityText = selectedOption.text();

            var durationSelect = $('#duration');
            var selectedOption = durationSelect.find('option:selected');
            var durationValue = selectedOption.val();
            var durationText = selectedOption.text();

            var complaintsdate = $('#complaints_date').val();

            var cell1 = newRow.insertCell(0);
            var cell2 = newRow.insertCell(1);
            var cell3 = newRow.insertCell(2);
            var cell4 = newRow.insertCell(3);
            var cell5 = newRow.insertCell(4);
            var cell6 = newRow.insertCell(5);


            var inputHTML =
                `<input type="text" name="complaints[${table.rows.length}][complaints_date]" class="form-control dateTimePickr" value="${complaintsdate}">`;
            cell1.innerHTML = inputHTML;

            var inputHTML1 =
                `<input type="text" name="complaints[${table.rows.length}][complaints]" class="form-control" value="${complaints}">`;
            cell2.innerHTML = inputHTML1;

            // Weight
            var selectHTML =
                `<select class="form-control" name="complaints[${table.rows.length}][frequency]"><option value="${itemValue}">` +
                itemText + '</option></select>';
            cell3.innerHTML = selectHTML;

            // Pulse
            var selectHTML1 =
                `<select class="form-control" name="complaints[${table.rows.length}][severity]"><option value="${severityValue}">` +
                severityText + '</option></select>';
            cell4.innerHTML = selectHTML1;

            // BP (Systolic / Diastolic)
            var selectHTML2 =
                `<select class="form-control" name="complaints[${table.rows.length}][duration]"><option value="${durationValue}">` +
                durationText + '</option></select>';
            cell5.innerHTML = selectHTML2;




            // Remove button
            var removeBtn = '<button type="button" class="btn btn-danger btn-sm" onclick="removeRow(this)">X</button>';
            cell6.innerHTML = removeBtn;

            // const selectElement = document.getElementById("medicine_id0");
            // selectElement.selectedIndex = 0;
            $('#frequency').val('').trigger('change');
            $('#severity').val('').trigger('change');
            $('#duration').val('').trigger('change');
            $('#complaints').val('');
            $('#complaints_date').val('');





        }

        function addNewDiagnosisrow() {
            var table = document.getElementById("data-table-2");
            var newRow = table.insertRow(table.rows.length);

            var ItemSelect = $('#diagnosis');
            var selectedOption = ItemSelect.find('option:selected');
            var itemValue = selectedOption.val();
            var itemText = selectedOption.text();


            var durationSelect = $('#diagnosis_duration');
            var selectedOption = durationSelect.find('option:selected');
            var durationValue = selectedOption.val();
            var durationText = selectedOption.text();

            var diagnosisdate = $('#diagnosis_date').val();

            var cell1 = newRow.insertCell(0);
            var cell2 = newRow.insertCell(1);
            var cell3 = newRow.insertCell(2);
            var cell4 = newRow.insertCell(3);


            var inputHTML =
                `<input type="text" name="diagnosis[${table.rows.length}][diagnosis_date]" class="form-control dateTimePickr" value="${diagnosisdate}">`;
            cell1.innerHTML = inputHTML;

            var selectHTML =
                `<select class="form-control" name="diagnosis[${table.rows.length}][diagnosis]"><option value="${itemValue}">` +
                itemText + '</option></select>';
            cell2.innerHTML = selectHTML;


            var selectHTML1 =
                `<select class="form-control" name="diagnosis[${table.rows.length}][diagnosis_duration]"><option value="${durationValue}">` +
                durationText + '</option></select>';
            cell3.innerHTML = selectHTML1;


            // Temperature


            // Remove button
            var removeBtn = '<button type="button" class="btn btn-danger btn-sm" onclick="removeRow(this)">X</button>';
            cell4.innerHTML = removeBtn;

            // const selectElement = document.getElementById("medicine_id0");
            // selectElement.selectedIndex = 0;
            $('#diagnosis').val('').trigger('change');
            $('#diagnosis_duration').val('').trigger('change');
            $('#diagnosis_date').val('');

        }

        function addNewMedicinerow() {
            var table = document.getElementById("data-table-3");
            var newRow = table.insertRow(table.rows.length);

            var ItemSelect = $('#composition');
            var selectedOption = ItemSelect.find('option:selected');
            var itemValue = selectedOption.val();
            var itemText = selectedOption.text();


            var medicineSelect = $('#medicine');
            var selectedOption = medicineSelect.find('option:selected');
            var medicineValue = selectedOption.val();
            var medicineText = selectedOption.text();

            var doseSelect = $('#dose');
            var selectedOption = doseSelect.find('option:selected');
            var doseValue = selectedOption.val();
            var doseText = selectedOption.text();

            var timeSelect = $('#when');
            var selectedOption = timeSelect.find('option:selected');
            var timeValue = selectedOption.val();
            var timeText = selectedOption.text();

            var frequencySelect = $('#medicine_frequency');
            var selectedOption = frequencySelect.find('option:selected');
            var frequencyValue = selectedOption.val();
            var frequencyText = selectedOption.text();

            var durationSelect = $('#medicine_duration');
            var selectedOption = durationSelect.find('option:selected');
            var durationValue = selectedOption.val();
            var durationText = selectedOption.text();

            var notes_instructions = $('#notes_instructions').val();

            var cell1 = newRow.insertCell(0);
            var cell2 = newRow.insertCell(1);
            var cell3 = newRow.insertCell(2);
            var cell4 = newRow.insertCell(3);
            var cell5 = newRow.insertCell(4);
            var cell6 = newRow.insertCell(5);
            var cell7 = newRow.insertCell(6);
            var cell8 = newRow.insertCell(7);

            var selectHTML =
                `<select class="form-control" name="medicines[${table.rows.length}][composition]"><option value="${itemValue}">` +
                itemText + '</option></select>';
            cell1.innerHTML = selectHTML;


            var selectHTML1 =
                `<select class="form-control" name="medicines[${table.rows.length}][medicine]"><option value="${medicineValue}">` +
                medicineText + '</option></select>';
            cell2.innerHTML = selectHTML1;

            var selectHTML2 =
                `<select class="form-control" name="medicines[${table.rows.length}][dose]"><option value="${doseValue}">` +
                doseText + '</option></select>';
            cell3.innerHTML = selectHTML2;

            var selectHTML3 =
                `<select class="form-control" name="medicines[${table.rows.length}][when]"><option value="${timeValue}">` +
                timeText + '</option></select>';
            cell4.innerHTML = selectHTML3;

            var selectHTML4 =
                `<select class="form-control" name="medicines[${table.rows.length}][frequency]"><option value="${frequencyValue}">` +
                frequencyText + '</option></select>';
            cell5.innerHTML = selectHTML4;

            var selectHTML5 =
                `<select class="form-control" name="medicines[${table.rows.length}][medicine_duration]"><option value="${durationValue}">` +
                durationText + '</option></select>';
            cell6.innerHTML = selectHTML5;


            // Temperature
            var inputHTML =
                `<input type="text" name="medicines[${table.rows.length}][notes_instructions]" class="form-control dateTimePickr" value="${notes_instructions}">`;
            cell7.innerHTML = inputHTML;

            // Remove button
            var removeBtn = '<button type="button" class="btn btn-danger btn-sm" onclick="removeRow(this)">X</button>';
            cell8.innerHTML = removeBtn;

            // const selectElement = document.getElementById("medicine_id0");
            // selectElement.selectedIndex = 0;
            $('#composition').val('').trigger('change');
            $('#medicine').val('').trigger('change');
            $('#dose').val('').trigger('change');
            $('#when').val('').trigger('change');
            $('#medicine_frequency').val('').trigger('change');
            $('#medicine_duration').val('').trigger('change');


            $('#notes_instructions').val('');

        }



        // function removeRow(button) {
        //     var table = document.getElementById("data-table");
        //     var row = button.parentNode.parentNode;
        //     table.deleteRow(row.rowIndex);
        // }
        function removeRow(button) {
            const row = button.closest('tr');
            const table = row.closest('table');
            table.deleteRow(row.rowIndex);
        }
    </script>
@endpush
