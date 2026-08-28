<!DOCTYPE html>
<html>

<head>
    <title>Discharge Summary</title>
    <link href="{{ asset('public/assets/plugins/datatable/css/buttons.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ asset('public/assets/plugins/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('public/assets/css/icons.css') }}" rel="stylesheet" />

    <style>
        body {
            font-family: 'verdana';
        }

        p {
            font-size: 15px;
            font-weight: normal;
        }

        .pmjay-repeat-header td {
            border: 0 !important;
            outline: 0 !important;
        }

        .annexure-table tbody td {
            border: 1px solid #000;
        }

        .annexure-table .annexure-title {
            border: 0 !important;
        }

        @media print {

            /* hide buttons on print */
            #printButton {
                display: none;
            }

            #contDiv {
                display: none;
            }

            /* overall text smaller & tighter */
            body {
                font-size: 13px !important;
                line-height: 1.2 !important;
                margin: 5mm;
            }

            /* remove big gaps between paragraphs from Bootstrap */
            p {
                font-size: 13px !important;
                margin: 0 0 2px 0 !important;
                line-height: 1.2 !important;
            }

            /* tighten all table content */
            table {
                border-collapse: collapse !important;
            }

            td,
            th {
                font-size: 13px !important;
                padding-top: 1px !important;
                padding-bottom: 1px !important;
                padding-left: 2px !important;
                padding-right: 2px !important;
                line-height: 1.2 !important;
            }

            /* allow content to break inside these tables (avoid empty space) */
            .page2 table {
                page-break-inside: auto !important;
                page-break-after: auto !important;
            }

            .annexure-table td,
            .annexure-table th {
                text-align: left !important;
                vertical-align: top !important;
                white-space: nowrap !important;
                overflow-wrap: normal !important;
                word-break: normal !important;
                padding: 4px 6px !important;
                line-height: 1.35 !important;
            }

            .annexure-label {
                display: inline-block;
                width: 42%;
                font-weight: 600;
                vertical-align: top;
            }

            .annexure-header-label {
                display: inline-block;
                min-width: 100px;
            }

            .annexure-title {
                text-align: center !important;
            }

            .pmjay-repeat-header {
                display: table-header-group;
            }

            .pmjay-repeat-header,
            .pmjay-repeat-header tr,
            .pmjay-repeat-header td {
                border: 0 !important;
                outline: 0 !important;
                box-shadow: none !important;
            }

            .pmjay-repeat-header td {
                padding: 25px 0 12px 0 !important;
            }

            .pmjay-blank-header {
                height: 200px;
            }
        }
    </style>
</head>



<body onload="window.print()">
    <div style="margin: 10px 0px 0px 503px" id="printButton">
        <button class="btn btn-primary btn-sm" onclick="printpage()"><i class="fa fa-print"></i> Print</button>
        <a class="btn btn-danger btn-sm" onclick="window.close()"><i class="fa fa-times"></i> Close</a>
    </div>
    @php
        $showPmjayDischarge = in_array($section, ['ipd', 'dialysis'], true)
            && in_array((int) @$ipd_details->insurance_id, [16, 21], true);
        $packageBooked = $section === 'dialysis'
            ? @$ipd_details->dialysis_type
            : @$ipd_details->package_type;
    @endphp
    @if ($showPmjayDischarge)
        <table class="annexure-table" style="width:100%; table-layout:fixed; border-collapse:collapse; font-size:14px; text-align:left;" cellspacing="0" cellpadding="6">
            <thead class="pmjay-repeat-header">
                <tr>
                    <td colspan="2" style="border:0 !important;">
                        @if (@$header_image->logo)
                            <img src="{{ asset('public/assets/images/header') }}/{{ $header_image->logo }}"
                                alt="logo" style="width: 100%;">
                        @else
                            <div class="pmjay-blank-header"></div>
                        @endif
                    </td>
                </tr>
            </thead>
            <tbody>
            <tr>
                <td colspan="2" class="annexure-title" style="border:0; text-align:center; padding:0 0 12px;">
                    <div style="width:100%; text-align:center;"> <strong style="font-size:20px;">Discharge Summary</strong></div>
                </td>
            </tr>
            <tr style="color:#000;">
                <td style="width:50%; text-align:left; font-weight:normal; border:1px solid #000; padding:6px;"><span style="display:inline-block; width:110px; padding-right:10px;">Hospital Name:</span>KALYANI GENERAL HOSPITAL</td>
                <td style="width:50%; text-align:left; font-weight:normal; border:1px solid #000; padding:6px;"><span style="display:inline-block; width:110px; padding-right:10px;">Hospital Code:</span>HOSP19P26228853</td>
            </tr>
            <tr><td>Hospital Address: Plot No. A-2,3,4,5, Kalyani, Nadia, Pin-741235, W.B.</td><td>Hospital District: Nadia</td></tr>
            <tr><td>Patient Name: {{ @$patient->name }}</td><td>PMJAY ID: {{ @$ipd_details->insurance_no }}</td></tr>
            <tr><td>Patient Address: {{ @$patient->address }}</td><td>Age: {{ @$patient->dob_year == null ? '' : @$patient->dob_year . 'Y' }} {{ @$patient->dob_month == null ? '' : @$patient->dob_month . 'M' }} {{ @$patient->dob_day == null ? '' : @$patient->dob_day . 'D' }}</td></tr>
            <tr><td></td><td>Sex: {{ @$patient->gender }}</td></tr>
            <tr><td></td><td>Patient contact number: {{ @$patient->phone }}</td></tr>
            <tr><td colspan="2"><span class="annexure-label">IPD number (free text):</span>{{ @$ipd_details->id }}</td></tr>
            <tr><td colspan="2"><span class="annexure-label">PMJAY case Id:</span></td></tr>
            <tr><td colspan="2"><span class="annexure-label">Package booked:</span>{{ $packageBooked }}</td></tr>
            <tr><td colspan="2"><span class="annexure-label">Treating Consultant's name:</span>{{ @$ipd_details->doctor_name }}</td></tr>
            <tr><td colspan="2"><span class="annexure-label">Treating Consultant's contact number:</span></td></tr>
            <tr><td colspan="2"><span class="annexure-label">Treating Consultant's Qualification:</span>{{ @$ipd_details->qualification }}</td></tr>
            <tr><td colspan="2"><span class="annexure-label">Registration No:</span>{{ @$ipd_details->doctor_registration_no }}</td></tr>
            <tr><td colspan="2"><span class="annexure-label">Treating Consultant's Specialty:</span>{{ @$ipd_details->specialization }}</td></tr>
            <tr><td colspan="2"><span class="annexure-label">Date of Admission with time:</span>{{ @$ipd_details->admission_date ? dateFor($ipd_details->admission_date, true) : '' }}</td></tr>
            <tr><td colspan="2"><span class="annexure-label">Date of Discharge with time:</span>{{ @$discharge->discharge_date ? dateFor($discharge->discharge_date, true) : '' }}</td></tr>
            <tr><td colspan="2"><span class="annexure-label">Date of Operation (if surgical package):</span></td></tr>
            <tr><td colspan="2"><span class="annexure-label">Presenting complaints with duration*:</span>{!! @$discharge->complaiints_duraiton !!}</td></tr>
            <tr><td colspan="2"><span class="annexure-label">Initial assessment (Text):</span>{!! @$discharge->physical_examinaiton_at_admission !!}</td></tr>
            <tr><td colspan="2"><span class="annexure-label">Significant Past Medical and Surgical History, if any:</span>{{ @$ipd_details->medical_surgical_history }}</td></tr>
            <tr><td colspan="2"><span class="annexure-label">Primary Diagnosis at the time of Admission:</span>{{ @$ipd_details->diagonasis_name }}</td></tr>
            <tr><td colspan="2"><span class="annexure-label">Final Diagnosis at the time of Discharge*:</span>{!! @$discharge->icd_code !!}</td></tr>
            <tr><td colspan="2"><span class="annexure-label">ICD - 10 code(s) for Final diagnosis:</span></td></tr>
            <tr><td colspan="2"><span class="annexure-label">Key investigations:</span>{!! @$discharge->summary_inves_during_hos !!}</td></tr>
            <tr><td colspan="2"><span class="annexure-label">Investigation findings (Text):</span></td></tr>
            <tr><td colspan="2"><span class="annexure-label">Treatment given during hospitalization*:</span>{!! @$discharge->course_complications !!}</td></tr>
            <tr><td colspan="2"><span class="annexure-label">Operative Findings (Only for surgical cases) *:</span></td></tr>
            <tr><td colspan="2"><span class="annexure-label">Complications if any*:</span></td></tr>
            <tr><td colspan="2"><span class="annexure-label">Status at the time of discharge*:</span>{{ @$discharge->discharge_type }}</td></tr>
            <tr><td colspan="2"><span class="annexure-label">Next follow-up date (calendar, dd/mm/yyyy):</span>{{ @$discharge->next_appointment_date ? dateFor($discharge->next_appointment_date) : '' }}</td></tr>
            <tr><td colspan="2"><span class="annexure-label">Advice on discharge* (free text):</span>{!! @$discharge->dischage_advice !!}</td></tr>
            <tr><td colspan="2" style="height:55px;">Name &amp; Signature of treating Consultant / Authorized Team Doctor*:</td></tr>
            <tr><td colspan="2" style="height:55px;">Name &amp; Signature of treating PMAM*:</td></tr>
            <tr><td colspan="2" style="height:55px;">Name &amp; Signature/thumb impression of Patient / Attendant*</td></tr>
            </tbody>
        </table>
    @else
    <table style="width:100%;">
        <thead>
            <tr>
                <td style="padding-bottom:5px;">
                    <div id="header" style="width: 100%;float: left;">
                        <table style="margin:0px 0px 0px 0px; width:100%;">
                            <tr>
                                @if (@$header_image->logo)
                                    <td>
                                        <img src="{{ asset('public/assets/images/header') }}/{{ $header_image->logo }}"
                                            alt="logo" style="width: 100%;">
                                    </td>
                                @else
                                    <td style="height: 200px;"></td>
                                @endif
                            </tr>
                        </table>
                    </div>
                </td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    <table style="width:100%;font-size:14px;" cellspacing="0" cellpadding="0">
                        <tr>
                            <td colspan="4" style="text-align: center;padding-top:25px;">
                                <span style="text-align: center; font-size: 19px; font-weight: bold; color:#0072b7 ">
                                    DISCHARGE SUMMARY </span>
                            </td>
                        </tr>
                        <tr style="padding-inline: 15px">
                            <td colspan="4">
                                <table style="width: 100%;">
                                    <tr style="border: 1px solid #000;">
                                        <td
                                            style="width:50%;font-size:17px;vertical-align:top;padding-left:2%;border-right: 1px solid #000;">
                                            <table style="width: 100%; line-height: 1 !important;" cellpadding="3"
                                                align="right">
                                                <tr>
                                                    <td>
                                                        <span><b style="font-weight:500;">Patient's Name : </b>
                                                            {{ @$patient->name }}</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <b style="font-weight:500;">UHID : </b> {{ @$patient->uhid }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <span><b style="font-weight:500;"> Mobile No : </b>
                                                            {{ @$patient->phone }}
                                                            {{ @$patient->guardian_contact_no ? ' / ' . $patient->guardian_contact_no : '' }}</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <b style="font-weight:500;">Sex : </b>{{ @$patient->gender }},
                                                        <b style="font-weight:500;">Age : </b>
                                                        {{ @$patient->dob_year == null ? '' : @$patient->dob_year . 'Y' }}
                                                        {{ @$patient->dob_month == null ? '' : @$patient->dob_month . 'M' }}
                                                        {{ @$patient->dob_day == null ? '' : @$patient->dob_day . 'D' }}<br>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td>
                                                        <span><b style="font-weight:500;">Guardian Name :
                                                            </b>{{ @$patient->guardian_name }}</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <span><b style="font-weight:500;">Guardian Relation :
                                                            </b>{{ @$patient->guardian_realation }}</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <b style="font-weight:500;">Address : </b>
                                                        {{ @$patient->address }}, {{ @$patient->district_name }},
                                                        {{ @$patient->state_name }}, {{ @$patient->pin_code }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <b style="font-weight:500;">Aadhar Card No : </b>
                                                        {{ @$patient->identification_number }}
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                        <td
                                            style="width:50%;font-size:17px;padding-left:2%;border-right:1px solid #000;vertical-align:top;">
                                            <table style="width: 100%; line-height: 1 !important;" cellpadding="3">
                                                <tr>
                                                    <td>
                                                        <b style="font-weight:500;">Admission Date : </b>
                                                        {{ dateFor($ipd_details->admission_date, true) }}
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td>
                                                        <b style="font-weight:500;">Patient Type : </b>
                                                        {{ @$ipd_details->tpa_name }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <b style="font-weight:500;"> Bed :
                                                        </b>{{ @$ipd_details->bed_name }}
                                                        <b style="font-weight:500;"> Ward :
                                                        </b>{{ @$ipd_details->ward_name }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <b style="font-weight:500;">Under Doctor : </b> DR.
                                                        {{ @$ipd_details->doctor_name }}
                                                    </td>
                                                </tr>
                                                @if (@$ipd_details->other_doctor_id)
                                                    <tr>
                                                        <td>
                                                            <b style="font-weight:500;"> Others Under Doctor : </b>DR.
                                                            {{ @$ipd_details->other_doctor_name }}<br>
                                                        </td>
                                                    </tr>
                                                @endif
                                                {{-- <tr>
                                                    <td>
                                                        <b style="font-weight:500;"> Package Type : </b>{{ @$ipd_details->package_name }}<br>
                                                    </td>
                                                </tr> --}}
                                                @if (@$ipd_details->diagnosis_id)
                                                    <tr>
                                                        <td>
                                                            <b style="font-weight:500;">Admission Time Diagnosis :
                                                            </b>{{ @$ipd_details->diagonasis_name }}
                                                        </td>
                                                    </tr>
                                                @endif
                                                @if (@$discharge->discharge_date)
                                                    <tr>
                                                        <td>
                                                            <b style="font-weight:500;"> Discharged Date : </b>
                                                            {{ dateFor($discharge->discharge_date, true) }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <b style="font-weight:500;">Discharged Type :
                                                            </b>{{ @$discharge->discharge_type }}
                                                        </td>
                                                    </tr>
                                                @endif
                                            </table>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <div class="page2">
                                                <table style="width:100%;margin-top:30px">
                                                    <tr>
                                                        <td>
                                                            <table class="discharge-table"
                                                                style="width:100%;font-size:12px;" cellpadding="0"
                                                                cellspacing="0" border="0">

                                                                @if (@$discharge->icd_code)
                                                                    <tr>
                                                                        <td
                                                                            style="vertical-align:top; padding-left:10px; padding-right:10px; font-size:15px; font-weight:600;">
                                                                            <img src="{{ asset('public/assets/images/filled-circle.png') }}"
                                                                                width="12px" style="margin-right:8px">
                                                                            Final Diagnosis at the time of Discharge
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td
                                                                            style="vertical-align:top; padding-left:40px; padding-right:10px;">
                                                                            {!! @$discharge->icd_code !!}
                                                                        </td>
                                                                    </tr>
                                                                @endif

                                                                @if (@$discharge->complaiints_duraiton)
                                                                    <tr>
                                                                        <td
                                                                            style="vertical-align:top; padding-left:10px; padding-right:10px;font-size:15px; font-weight:600;">
                                                                            <img src="{{ asset('public/assets/images/filled-circle.png') }}"
                                                                                width="12px" style="margin-right:8px">
                                                                            Presenting Complaints with Duration and
                                                                            Reason for Admission
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td
                                                                            style="vertical-align:top; padding-left:40px; padding-right:10px;">
                                                                            {!! @$discharge->complaiints_duraiton !!}
                                                                        </td>
                                                                    </tr>
                                                                @endif

                                                                @if (@$discharge->presenting_illness)
                                                                    <tr>
                                                                        <td
                                                                            style="vertical-align:top; padding-left:10px; padding-right:10px;font-size:15px; font-weight:600;">
                                                                            <img src="{{ asset('public/assets/images/filled-circle.png') }}"
                                                                                width="12px" style="margin-right:8px">
                                                                            Summary of Presenting Illness
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td
                                                                            style="vertical-align:top; padding-left:40px; padding-right:10px;">
                                                                            {!! @$discharge->presenting_illness !!}
                                                                        </td>
                                                                    </tr>
                                                                @endif

                                                                @if (@$discharge->physical_examinaiton_at_admission)
                                                                    <tr>
                                                                        <td
                                                                            style="vertical-align:top; padding-left:10px; padding-right:10px;font-size:15px; font-weight:600;">
                                                                            <img src="{{ asset('public/assets/images/filled-circle.png') }}"
                                                                                width="12px" style="margin-right:8px">
                                                                            Key findings, on physical examination at the
                                                                            time of admission
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td
                                                                            style="vertical-align:top; padding-left:40px; padding-right:10px;">
                                                                            {!! @$discharge->physical_examinaiton_at_admission !!}
                                                                        </td>
                                                                    </tr>
                                                                @endif


                                                                @if (@$discharge->summary_inves_during_hos)
                                                                    <tr>
                                                                        <td
                                                                            style="vertical-align:top; padding-left:10px; padding-right:10px;font-size:15px; font-weight:600;">
                                                                            <img src="{{ asset('public/assets/images/filled-circle.png') }}"
                                                                                width="12px" style="margin-right:8px">
                                                                            Summary of key invesigations during
                                                                            Hospitalization
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td
                                                                            style="vertical-align:top; padding-left:40px; padding-right:10px;">
                                                                            {!! @$discharge->summary_inves_during_hos !!}
                                                                        </td>
                                                                    </tr>
                                                                @endif

                                                                @if (@$discharge->course_complications)
                                                                    <tr>
                                                                        <td
                                                                            style="vertical-align:top; padding-left:10px; padding-right:10px;font-size:15px; font-weight:600;">
                                                                            <img src="{{ asset('public/assets/images/filled-circle.png') }}"
                                                                                width="12px" style="margin-right:8px">
                                                                            Course in the Hospital including
                                                                            complicaiotns if any
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td
                                                                            style="vertical-align:top; padding-left:40px; padding-right:10px;">
                                                                            {!! @$discharge->course_complications !!}
                                                                        </td>
                                                                    </tr>
                                                                @endif

                                                                @if (@$discharge->dischage_advice)
                                                                    <tr>
                                                                        <td
                                                                            style="vertical-align:top; padding-left:10px; padding-right:10px;font-size:15px; font-weight:600;">
                                                                            <img src="{{ asset('public/assets/images/filled-circle.png') }}"
                                                                                width="12px"
                                                                                style="margin-right:8px"> Advice on
                                                                            Discharge
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td
                                                                            style="vertical-align:top; padding-left:40px; padding-right:10px;">
                                                                            {!! @$discharge->dischage_advice !!}
                                                                        </td>
                                                                    </tr>
                                                                @endif

                                                                @if (@$discharge->next_appointment_date)
                                                                    <tr>
                                                                        <td
                                                                            style="vertical-align:top; padding-left:10px; padding-right:10px;">
                                                                            <img src="{{ asset('public/assets/images/filled-circle.png') }}"
                                                                                width="12px"
                                                                                style="margin-right:8px"> <b>Next
                                                                                Followup Date :
                                                                                {{ dateFor($discharge->next_appointment_date, true) }}
                                                                            </b>
                                                                        </td>
                                                                    </tr>
                                                                @endif

                                                            </table>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            {{-- <tr>
                <td>
                    <div class="page2">
                        <table style="width:100%;">
                            <tr>
                                <td>
                                    <table
                                        style="width:100%;font-size:12px; page-break-inside: avoid;page-break-after: avoid;"
                                        cellpadding="0" cellspacing="0" border="0">

                                        @if (@$dischargd_details->icd_code != null)
                                            <tr>
                                                <td
                                                    style="vertical-align:top; padding-left:10px; padding-right:10px; font-size:20px; font-weight:600;">
                                                    <img src="{{ asset('public/filled-circle.png') }}"> Final Diagnosis at the
                                                    time of Discharge
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="vertical-align:top; padding-left:10px; padding-right:10px; ">
                                                    {!! @$dischargd_details->icd_code !!}
                                                </td>
                                            </tr>
                                        @endif

                                        @if (@$dischargd_details->complaiints_duraiton != null)
                                            <tr>
                                                <td
                                                    style="vertical-align:top; padding-left:10px; padding-right:10px;font-size:20px; font-weight:600;">
                                                    <img src="{{ asset('public/filled-circle.png') }}"> Presenting Complaints
                                                    with Duration and Reason for Admission
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="vertical-align:top; padding-left:10px; padding-right:10px;">
                                                    {!! @$dischargd_details->complaiints_duraiton !!}
                                                </td>
                                            </tr>
                                        @endif

                                        @if (@$dischargd_details->presenting_illness != null)
                                            <tr>
                                                <td
                                                    style="vertical-align:top; padding-left:10px; padding-right:10px;font-size:20px; font-weight:600;">
                                                    <img src="{{ asset('public/filled-circle.png') }}"> Summary of Presenting
                                                    Illness
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="vertical-align:top; padding-left:10px; padding-right:10px;">
                                                    {!! @$dischargd_details->presenting_illness !!}
                                                </td>
                                            </tr>
                                        @endif

                                        @if (@$dischargd_details->physical_examinaiton_at_admission != null)
                                            <tr>
                                                <td
                                                    style="vertical-align:top; padding-left:10px; padding-right:10px;font-size:20px; font-weight:600;">
                                                    <img src="{{ asset('public/filled-circle.png') }}"> Key findings, on
                                                    physical examination at the time of admission
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="vertical-align:top; padding-left:10px; padding-right:10px;">
                                                    {!! @$dischargd_details->physical_examinaiton_at_admission !!}
                                                </td>
                                            </tr>
                                        @endif


                                        @if (@$dischargd_details->summary_inves_during_hos != null)
                                            <tr>
                                                <td
                                                    style="vertical-align:top; padding-left:10px; padding-right:10px;font-size:20px; font-weight:600;">
                                                    <img src="{{ asset('public/filled-circle.png') }}"> Summary of key
                                                    invesigations during Hospitalization
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="vertical-align:top; padding-left:10px; padding-right:10px;">
                                                    {!! @$dischargd_details->summary_inves_during_hos !!}
                                                </td>
                                            </tr>
                                        @endif

                                        @if (@$dischargd_details->course_complications != null)
                                            <tr>
                                                <td
                                                    style="vertical-align:top; padding-left:10px; padding-right:10px;font-size:20px; font-weight:600;">
                                                    <img src="{{ asset('public/filled-circle.png') }}"> Course in the Hospital
                                                    including complicaiotns if any
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="vertical-align:top; padding-left:10px; padding-right:10px;">
                                                    {!! @$dischargd_details->course_complications !!}
                                                </td>
                                            </tr>
                                        @endif

                                        @if (@$dischargd_details->dischage_advice != null)
                                            <tr>
                                                <td
                                                    style="vertical-align:top; padding-left:10px; padding-right:10px;font-size:20px; font-weight:600;">
                                                    <img src="{{ asset('public/filled-circle.png') }}"> Advice on Discharge
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="vertical-align:top; padding-left:10px; padding-right:10px;">
                                                    {!! @$dischargd_details->dischage_advice !!}
                                                </td>
                                            </tr>
                                        @endif

                                        @if (@$dischargd_details->next_appointment_date != null)
                                            <tr>
                                                <td style="vertical-align:top; padding-left:10px; padding-right:10px;">
                                                    <img src="{{ asset('public/filled-circle.png') }}"
                                                        width="10px"> <b>Next followup Date :
                                                        {{ date('d-m-Y', strtotime($dischargd_details->next_appointment_date)) }}
                                                    </b>
                                                </td>
                                            </tr>
                                        @endif
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </div>
                </td>
            </tr> --}}
        </tbody>

        <tr>
            <td>
                <div id="footer" style="width: 100%;float: left;">
                    <table style="width: 100%; font-size: 14px;margin-top: 50px;">
                        <tbody>
                            <tr>
                                <td colspan="2"></td>
                            </tr>
                            <tr>
                                <td style="width: 20%; border-top:1px dashed #000;text-align:center">Patient/Gurdian
                                    Signature</td>
                                <td style="width: 60%;"></td>
                                <td style="width: 20%; border-top:1px dashed #000;text-align:center">Signed by Doctor
                                </td>
                            </tr>
                            <tr>
                                <td style="width: 50%; vertical-align:top;font-size:10px" colspan="2"> PREPARED BY
                                    : {{ Auth::user()->name }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </td>
        </tr>
    </table>
    @endif
</body>

</html>
<script>
    // Disable the browser's back button
    history.pushState(null, null, location.href);
    window.addEventListener('popstate', function(event) {
        history.pushState(null, null, location.href);
    });
    window.addEventListener('keydown', function(event) {
        if (event.keyCode === 116 || (event.ctrlKey && event.keyCode === 82)) {
            event.preventDefault();
        }
    });

    function printpage() {
        window.print();
    }
</script>
