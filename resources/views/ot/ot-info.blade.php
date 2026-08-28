@extends('layouts.structure')
@push('title')
    <title>OT Details</title>
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


        .status-bar {
            display: flex;
            align-items: center;
            justify-content: space-around;
            flex-wrap: wrap;
            width: 100%;
            position: relative;
        }

        .step {
            display: flex;
            flex-direction: column;
            align-items: center;
            position: relative;
            /* z-index: 1; */
            min-width: 80px;
            margin: 0 5px;
        }

        .step .circle {
            width: 35px;
            height: 35px;
            border-radius: 50%;
            background-color: #ccc;
            color: white;
            font-weight: bold;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-top: 17px;
        }

        .step.completed .circle {
            background-color: green;
        }

        .label {
            margin-top: -6px;
            font-size: 13px;
            font-weight: 500;
            text-align: center;
            white-space: nowrap;
            display: block !important;
            background: none !important;
        }

        .line {
            flex: 1;
            height: 3px;
            background-color: green;
            margin: 0 10px;
            position: relative;
            top: -18px;
            min-width: 30px;
        }

        .blink .circle {
            animation: blink-animation 1s steps(2, start) infinite;
            background-color: #28a745;
        }

        @keyframes blink-animation {
            to {
                visibility: hidden;
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
                        <x-billbar section="ot" id="{{ $info->id }}" type="sec" />
                    </div>

                    <div class="col-md-9 rightside_fixarea" style="border:none !important">
                        @php
                            $statusSteps = [
                                'Requested' => 1,
                                'Prepared' => 2,
                                'Scheduled' => 3,
                                'Inprogress' => 4,
                                'Completed' => 5,
                            ];

                            $currentStep = $statusSteps[$info->status] ?? 0;
                        @endphp

                        <div class="col-md-12">
                            <div class="status-bar my-3 d-flex justify-content-center">
                                 <div class="step {{ $currentStep == 1 ? 'Scheduled blink' : '' }} text-center">
                                    <div class="circle">1</div>
                                    <div class="label">Requested</div>
                                </div>
                                <div class="line"></div>

                                <div class="step {{ $currentStep == 2 ? 'Prepared blink' : '' }} text-center">
                                    <div class="circle">2</div>
                                    <div class="label">Prepared</div>
                                </div>
                                <div class="line"></div>

                                <div class="step {{ $currentStep == 3 ? 'Scheduled blink' : '' }} text-center">
                                    <div class="circle">3</div>
                                    <div class="label">Scheduled</div>
                                </div>
                                <div class="line"></div>

                                <div class="step {{ $currentStep == 4 ? 'Inprogress blink' : '' }} text-center">
                                    <div class="circle">4</div>
                                    <div class="label">In Progress</div>
                                </div>
                                <div class="line"></div>

                                <div class="step {{ $currentStep == 5 ? 'Completed blink' : '' }} text-center">
                                    <div class="circle">5</div>
                                    <div class="label">Completed</div>
                                </div>
                            </div>
                        </div>

                        <div style="border:2px solid black">
                            {{-- @if ($info->status === 'Inprogress')
                                <div style="position: absolute; top: -15px; right: 1155px; font-size: 43px; color: red;">

                                    <span style="font-size: 45px;" class="blink" title="In Progress 🚨">🚨</span>
                                </div>
                            @endif --}}
                            <h4 style="padding: 5px;"><i class="fas fa-notes-medical"></i> Booking Details</h4>
                            <div class="row no-gutters">
                                <div class="col-lg-6 col-xl-6 border-right">
                                    <div class="options px-5 pt-2   pb-1">
                                        <table class="table table_border_none ipdtable_design">
                                            <tbody>
                                                <tr>
                                                    <td class="py-2 px-0">
                                                        <i class="fas fa-yin-yang text-danger"></i>
                                                    </td>
                                                    <td class="py-2 px-0">
                                                        <span class="font-weight-semibold w-50">Gender</span>
                                                    </td>
                                                    <td class="py-2 px-0">
                                                        {{ $info->patient_info->gender }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="py-2 px-0">
                                                        <i class="fas fa-yin-yang text-danger"></i>
                                                    </td>
                                                    <td class="py-2 px-0">
                                                        <span class="font-weight-semibold w-50">Age </span>
                                                    </td>
                                                    <td class="py-2 px-0">
                                                        {{ @$info->patient_info->dob_year ? $info->patient_info->dob_year . 'Y' : '' }}
                                                        {{ @$info->patient_info->dob_month ? $info->patient_info->dob_month . 'M' : '' }}
                                                        {{ @$info->patient_info->dob_day ? $info->patient_info->dob_day . 'D' : '' }}
                                                    </td>
                                                </tr>
                                                <tr colspan="2">
                                                    <td class="py-2 px-0">
                                                        <i class="fas fa-yin-yang text-danger"></i>
                                                    </td>
                                                    <td class="py-2 px-0">
                                                        <span class="font-weight-semibold w-50">Address </span>
                                                    </td>
                                                    <td class="py-2 px-0">
                                                        {{ @$info->patient_info->address }},
                                                        {{ @$info->patient_info->district_name }},
                                                        {{ @$info->patient_info->state_name }},
                                                        {{ @$info->patient_info->country }},
                                                        {{ @$info->patient_info->pin_code }}
                                                    </td>
                                                </tr>
                                                {{-- <tr>
                                                    <td class="py-2 px-0">
                                                        <i class="fas fa-yin-yang text-danger"></i>
                                                    </td>
                                                    <td class="py-2 px-0">
                                                        <span class="font-weight-semibold w-50">Aadhar Card No </span>
                                                    </td>
                                                    <td class="py-2 px-0">
                                                        {{ $info->patient_info->identification_number }}
                                                    </td>
                                                </tr> --}}
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-xl-6 border-right">
                                    <div class="options px-5 pt-2 pb-1">
                                        <table class="table table_border_none ipdtable_design">
                                            <tbody>
                                                <tr>
                                                    <td class="py-2 px-0">
                                                        <i class="fas fa-yin-yang text-danger"></i>
                                                    </td>
                                                    <td class="py-2 px-0">
                                                        <span class="font-weight-semibold w-50"> OT ID </span>
                                                    </td>
                                                    <td class="py-2 px-0">
                                                        {{ $info->id }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="py-2 px-0">
                                                        <i class="fas fa-yin-yang text-danger"></i>
                                                    </td>
                                                    <td class="py-2 px-0">
                                                        <span class="font-weight-semibold w-50"> Booking Date </span>
                                                    </td>
                                                    <td class="py-2 px-0">
                                                        {{ dateFor($info->planned_date, true) }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="py-2 px-0">
                                                        <i class="fas fa-yin-yang text-danger"></i>
                                                    </td>
                                                    <td class="py-2 px-0">
                                                        <span class="font-weight-semibold w-50"> Department </span>
                                                    </td>
                                                    <td class="py-2 px-0">
                                                        {{ $info->department_name }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="py-2 px-0">
                                                        <i class="fas fa-yin-yang text-danger"></i>
                                                    </td>
                                                    <td class="py-2 px-0">
                                                        <span class="font-weight-semibold w-50">Consultant Doctor </span>
                                                    </td>
                                                    <td class="py-2 px-0">
                                                        {{ $info->doctor_names }}
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td class="py-2 px-0">
                                                        <i class="fas fa-yin-yang text-danger"></i>
                                                    </td>
                                                    <td class="py-2 px-0">
                                                        <span class="font-weight-semibold w-50">OT Package Name</span>
                                                    </td>
                                                    <td class="py-2 px-0">
                                                        {{ $info->operation_name }}
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        @if (@$ot_preparation)
                            <div style="border:2px solid black; margin-top:20px;">
                                <h4 style="padding: 5px;"><i class="fas fa-notes-medical"></i> OT Preparation Details</h4>

                                <div class="row no-gutters">
                                    <div class="col-lg-6 col-xl-6 border-right">
                                        <div class="options px-5 pt-2   pb-1">
                                            <table class="table table_border_none ipdtable_design">
                                                <tbody>
                                                    @php
                                                        $asaScores = [
                                                            '1' => 'I – Healthy',
                                                            '2' => 'II – Mild systemic disease',
                                                            '3' => 'III – Severe systemic disease',
                                                            '4' => 'IV – Life-threatening disease',
                                                            '5' => 'V – Moribund',
                                                        ];
                                                    @endphp
                                                    <tr>
                                                        <td class="py-2 px-0">
                                                            <i class="fas fa-yin-yang text-danger"></i>
                                                        </td>
                                                        <td class="py-2 px-0">
                                                            <span class="font-weight-semibold w-50">ASA Score</span>
                                                        </td>
                                                        <td class="py-2 px-0">
                                                            {{ $asaScores[@$ot_preparation->asa_score] ?? '' }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="py-2 px-0">
                                                            <i class="fas fa-yin-yang text-danger"></i>
                                                        </td>
                                                        <td class="py-2 px-0">
                                                            <span class="font-weight-semibold w-50">Co-morbidity</span>
                                                        </td>
                                                        <td class="py-2 px-0">
                                                            {{ @$ot_preparation->co_morbidity ?? '' }}
                                                        </td>
                                                    </tr>
                                                    @if (@$ot_preparation->test_confirmation == 'yes')
                                                        <tr>
                                                            <td class="py-2 px-0">
                                                                <i class="fas fa-yin-yang text-danger"></i>
                                                            </td>
                                                            <td class="py-2 px-0">
                                                                <span class="font-weight-semibold w-50">Test Name</span>
                                                            </td>
                                                            <td class="py-2 px-0">
                                                                @foreach (@$ot_preparation->test_names as $test)
                                                                    <li>{{ $test }}</li>
                                                                @endforeach
                                                            </td>
                                                        </tr>
                                                    @endif
                                                </tbody>
                                            </table>
                                        </div>

                                    </div>
                                    <div class="col-lg-6 col-xl-6 border-right">
                                        <div class="options px-5 pt-2   pb-1">
                                            <table class="table table_border_none ipdtable_design">
                                                <tbody>
                                                    <tr>
                                                        <td class="py-2 px-0">
                                                            <i class="fas fa-yin-yang text-danger"></i>
                                                        </td>
                                                        <td class="py-2 px-0">
                                                            <span class="font-weight-semibold w-50">Who
                                                                Validation</span>
                                                        </td>
                                                        <td class="py-2 px-0">
                                                            {{ @$ot_preparation->who_validation }}
                                                        </td>
                                                    </tr>
                                                    @if (@$ot_preparation->reschedule_check == 'yes')
                                                        <tr>
                                                            <td class="py-2 px-0">
                                                                <i class="fas fa-yin-yang text-danger"></i>
                                                            </td>
                                                            <td class="py-2 px-0">
                                                                <span class="font-weight-semibold w-50">Reschedule
                                                                    Reason</span>
                                                            </td>
                                                            <td class="py-2 px-0">
                                                                {{ @$ot_preparation->reschedule_reason ?? '' }}
                                                            </td>
                                                        </tr>
                                                    @endif
                                                    <tr>
                                                        <td class="py-2 px-0">
                                                            <i class="fas fa-yin-yang text-danger"></i>
                                                        </td>
                                                        <td class="py-2 px-0">
                                                            <span class="font-weight-semibold w-50">Created By</span>
                                                        </td>
                                                        <td class="py-2 px-0">
                                                            {{ @$ot_preparation->created_by }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="py-2 px-0">
                                                            <i class="fas fa-yin-yang text-danger"></i>
                                                        </td>
                                                        <td class="py-2 px-0">
                                                            <span class="font-weight-semibold w-50">Status</span>
                                                        </td>
                                                        <td class="py-2 px-0">
                                                            {{ @$ot_preparation->status }}
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        @endif

                        @if (@$ot_schedule_details)
                            <div style="border:2px solid black; margin-top:20px;">
                                <h4 style="padding: 5px;"><i class="fas fa-calendar-week"></i> OT Schedule Details
                                </h4>

                                <div class="row no-gutters">
                                    <div class="col-lg-6 col-xl-6 border-right">
                                        <div class="options px-5 pt-2   pb-1">
                                            <table class="table table_border_none ipdtable_design">
                                                <tbody>
                                                    <tr>
                                                        <td class="py-2 px-0">
                                                            <i class="fas fa-yin-yang text-danger"></i>
                                                        </td>
                                                        <td class="py-2 px-0">
                                                            <span class="font-weight-semibold w-50">OT Room</span>
                                                        </td>
                                                        <td class="py-2 px-0">
                                                            {{ @$ot_schedule_details->room_name }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="py-2 px-0">
                                                            <i class="fas fa-yin-yang text-danger"></i>
                                                        </td>
                                                        <td class="py-2 px-0">
                                                            <span class="font-weight-semibold w-50">OT Date</span>
                                                        </td>
                                                        <td class="py-2 px-0">
                                                            {{ dateFor(@$ot_schedule_details->ot_date) }},
                                                            {{ @$ot_schedule_details->ot_day }}
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td class="py-2 px-0">
                                                            <i class="fas fa-yin-yang text-danger"></i>
                                                        </td>
                                                        <td class="py-2 px-0">
                                                            <span class="font-weight-semibold w-50">OT Duration</span>
                                                        </td>
                                                        <td class="py-2 px-0">
                                                            {{ timeFor(@$ot_schedule_details->from_time) }} TO
                                                            {{ timeFor(@$ot_schedule_details->to_time) }}
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td class="py-2 px-0">
                                                            <i class="fas fa-yin-yang text-danger"></i>
                                                        </td>
                                                        <td class="py-2 px-0">
                                                            <span class="font-weight-semibold w-50">OT Flags</span>
                                                        </td>
                                                        <td class="py-2 px-0">
                                                            {{ implode(', ', explode(',', @$ot_schedule_details->flags)) }}

                                                        </td>
                                                    </tr>

                                                </tbody>
                                            </table>
                                        </div>

                                    </div>

                                    <div class="col-lg-6 col-xl-6 border-right">
                                        <div class="options px-5 pt-2   pb-1">
                                            <table class="table table_border_none ipdtable_design">
                                                <tbody>
                                                    <tr>
                                                        <td class="py-2 px-0">
                                                            <i class="fas fa-yin-yang text-danger"></i>
                                                        </td>
                                                        <td class="py-2 px-0">
                                                            <span class="font-weight-semibold w-50">Surgent</span>
                                                        </td>
                                                        <td class="py-2 px-0">
                                                            {{ @$ot_schedule_details->surgeon_name }}

                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="py-2 px-0">
                                                            <i class="fas fa-yin-yang text-danger"></i>
                                                        </td>
                                                        <td class="py-2 px-0">
                                                            <span class="font-weight-semibold w-50">Anaesthetist</span>
                                                        </td>
                                                        <td class="py-2 px-0">
                                                            {{ @$ot_schedule_details->anaesthesia_name }}

                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="py-2 px-0">
                                                            <i class="fas fa-yin-yang text-danger"></i>
                                                        </td>
                                                        <td class="py-2 px-0">
                                                            <span class="font-weight-semibold w-50">Assigned Nurse</span>
                                                        </td>
                                                        <td class="py-2 px-0">
                                                            {{ @$ot_schedule_details->nurse_name }}

                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="py-2 px-0">
                                                            <i class="fas fa-yin-yang text-danger"></i>
                                                        </td>
                                                        <td class="py-2 px-0">
                                                            <span class="font-weight-semibold w-50">Assigned
                                                                Technician</span>
                                                        </td>
                                                        <td class="py-2 px-0">
                                                            {{ @$ot_schedule_details->ot_technician_name }}

                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>

                                    </div>

                                </div>
                            </div>
                        @endif

                        @if (@$ot_progress)
                            <div style="border:2px solid black; margin-top:20px;">
                                <h4 style="padding: 5px;"><i class="fas fa-calendar-week"></i> OT Progress Details</h4>
                                <div class="card-body">

                                    <label for="progressBar"><strong>Progress Bar</strong></label>
                                    <div class="progress mb-4" style="height: 30px;">
                                        <div id="otProgressBar"
                                            class="progress-bar progress-bar-striped progress-bar-animated"
                                            role="progressbar"
                                            style="width: 0%; background-color: #28a745; transition: width 0.5s ease-in-out;"
                                            aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
                                            0%
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <p><strong>Operation Name:</strong> {{ @$ot_progress->operation_name }}</p>
                                            <p><strong>Procedure Code:</strong> {{ @$ot_progress->procedure_code }}</p>
                                            <p><strong>Procedure Name:</strong> {{ @$ot_progress->procedure_name }}</p>
                                            <p><strong>Incision Time:</strong> {{ timeFor(@$ot_progress->incision_time) }}
                                            </p>
                                            <p><strong>Sterilized Kit Name:</strong>
                                                {{ @$ot_progress->sterilized_kit_name ?? 'N/A' }}</p>
                                            <p><strong>Discrepancy Flag:</strong>
                                                {{ @$ot_progress->discrepency_flags ?? 'N/A' }}</p>

                                        </div>
                                        <div class="col-md-6">
                                            <p><strong>Operation:</strong> {{ @$info->status ?? 'In Progress' }}</p>
                                            <p><strong>Surgent:</strong> {{ @$ot_schedule_details->surgeon_name }}</p>
                                            <p><strong>Anaesthetist:</strong> {{ @$ot_schedule_details->anaesthesia_name }}</p>
                                            <p><strong>Closure Time:</strong> {{ timeFor(@$ot_progress->closure_time) }}</p>
                                            <p><strong>Blood Loss(in ml):</strong> {{ @$ot_progress->blood_loss }}</p>
                                        </div>
                                    </div>



                                    {{-- Four Tables --}}
                                    <div class="row">
                                        <div class="col-md-6 mb-4">
                                            <h5>Vitals Monitoring</h5>
                                            <table class="table table-bordered table-sm">
                                                <thead class="thead-light">
                                                    <tr>
                                                        <th>Time</th>
                                                        <th>BP(mmHg)</th>
                                                        <th>HR(bpm)</th>
                                                        <th>RR(/Min)</th>
                                                        <th>SpO2(%)</th>
                                                        <th>Temp(F)</th>

                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @php
                                                        $vitals = json_decode(@$ot_progress->vitals ?? '[]');
                                                    @endphp
                                                    @if (!empty($vitals))
                                                        @foreach ($vitals as $i => $vital)
                                                            <tr>
                                                                <td>{{ $vital->vital_time }}</td>
                                                                <td>{{ $vital->bp_systolic ?? '' }}/{{ $vital->bp_diastolic ?? '' }}
                                                                </td>
                                                                <td>{{ $vital->vital_hr ?? '' }}</td>
                                                                <td>{{ $vital->vital_rr ?? '' }}</td>
                                                                <td>{{ $vital->vital_spo2 ?? '' }}</td>
                                                                <td>{{ $vital->vital_temp ?? '' }}</td>

                                                            </tr>
                                                        @endforeach
                                                    @endif
                                                </tbody>
                                            </table>
                                        </div>

                                        <div class="col-md-6 mb-4">
                                            <h5>Anesthetic Drugs Usage</h5>
                                            <table class="table table-bordered table-sm">
                                                <thead class="thead-light">
                                                    <tr>
                                                        <th>Time</th>
                                                        <th>Drug</th>
                                                        <th>Dosage</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @php
                                                        $drugs = json_decode(@$ot_progress->anesthetic_drugs ?? '[]');
                                                    @endphp
                                                    @if (!empty($drugs))
                                                        @foreach ($drugs as $i => $data)
                                                            <tr>
                                                                <td>{{ $data->drug_time ?? '' }}</td>
                                                                <td>{{ $data->drug_type ?? '' }}</td>
                                                                <td>{{ $data->drug_dose ?? '' }}</td>
                                                            </tr>
                                                        @endforeach
                                                    @endif
                                                </tbody>
                                            </table>
                                        </div>

                                        <div class="col-md-6 mb-4">
                                            <h5>Fluids Administered</h5>
                                            <table class="table table-bordered table-sm">
                                                <thead class="thead-light">
                                                    <tr>
                                                        <th>Time</th>
                                                        <th>Type</th>
                                                        <th>Volume (ml)</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @php
                                                        $fluids = json_decode(
                                                            @$ot_progress->fluid_administrative ?? '[]',
                                                        );
                                                    @endphp
                                                    @if (!empty($fluids))
                                                        @foreach ($fluids as $i => $data)
                                                            <tr>
                                                                <td>{{ $data->fluid_time ?? '' }}</td>
                                                                <td>{{ $data->fluid_type ?? '' }}</td>
                                                                <td>{{ $data->fluid_volume ?? '' }}</td>
                                                            </tr>
                                                        @endforeach
                                                    @endif

                                                </tbody>
                                            </table>
                                        </div>

                                        <div class="col-md-6 mb-4">
                                            <h5>Device Used</h5>
                                            <table class="table table-bordered table-sm">
                                                <thead class="thead-light">
                                                    <tr>
                                                        <th>Device Name</th>
                                                        <th>Device Code</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @php
                                                        $devices = json_decode(@$ot_progress->device_used ?? '[]');
                                                    @endphp
                                                    @if (!empty($devices))
                                                        @foreach ($devices as $i => $device)
                                                            <tr>
                                                                <td>{{ $device->device_name ?? '' }}</td>
                                                                <td>{{ $device->device_code ?? '' }}</td>
                                                            </tr>
                                                        @endforeach
                                                    @endif
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>


                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script>
        function fetchOtProgress() {
            const otRegId = '{{ @$info->id }}';
            const url = `{{ route('ot.get-progress-percentage', ':id') }}`.replace(':id', otRegId);

            fetch(url)
                .then(response => response.json())
                .then(data => {
                    const progress = data.progress;
                    const progressBar = document.getElementById('otProgressBar');

                    progressBar.style.width = progress + '%';
                    progressBar.setAttribute('aria-valuenow', progress);
                    progressBar.innerText = progress + '%';

                    // Dynamic color change
                    if (progress < 30) {
                        progressBar.style.backgroundColor = '#dc3545';
                    } else if (progress < 70) {
                        progressBar.style.backgroundColor = '#ffc107';
                    } else if (progress < 100) {
                        progressBar.style.backgroundColor = '#17a2b8';
                    } else {
                        progressBar.style.backgroundColor = '#28a745';
                    }
                });
        }

        fetchOtProgress();
        setInterval(fetchOtProgress, 60000);
    </script>
@endpush
