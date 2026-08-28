<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Admission form</title>
    <link href="{{ asset('public/assets/plugins/datatable/css/buttons.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ asset('public/assets/plugins/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('public/assets/css/icons.css') }}" rel="stylesheet" />
</head>
<style>
    @page {
        size: A4 portrait;
        margin: 0;
    }

    @media print {

        html,
        body {
            width: 25cm;
            font-family: 'verdana';
            margin: 0 !important;
            padding: 5px !important;
            overflow: hidden;
        }


    }

    body {
        font-family: sans-serif;
        background: #ffffff;
        margin: 0 auto;

        width: 100%;
    }

    table,
    th,
    td {

        border-collapse: collapse;
    }

    tr {
        width: 100%;
        height: auto;
    }

    @media print {
        #printButton {
            display: none;
        }
    }

    .info-container {
        position: relative;
        font-size: 12px;
        margin-top: 40px;
    }

    .name-overlay {
        position: absolute;
        top: -5px;
        left: 100px;
    }

    .father-name-overlay {
        position: absolute;
        top: 20px;
        left: 200px;
    }

    .age-overlay {
        position: absolute;
        top: -5px;
        left: 500px;
    }

    .address-overlay {
        position: absolute;
        top: -5px;
        left: 800px;
    }

    .relation-overlay {
        position: absolute;
        top: 50px;
        left: 200px;
    }

    .contact-overlay {
        position: absolute;
        top: 50px;
        left: 500px;
    }

    @media print {
        .pagebreak {
            clear: both;
            page-break-after: always;
        }
    }
</style>

<body>
    <div style="padding: 0px 7px 0px 7px;">
        <div style="margin: 10px 0px 0px 503px" id="printButton">
            <button class="btn btn-primary btn-sm" onclick="printpage()"><i class="fa fa-print"></i> Print</button>
            <a class="btn btn-danger btn-sm" onclick="window.close()"><i class="fa fa-times"></i> Close</a>
        </div>
        <!-- ==========================================code here================================== -->
        <div style="width:96%; padding-left:50px;">
            <table style="width: 100%; border:1px soild black;border-collapse: collapse">
                @if (@$header_image->logo)
                <tr>
                    <td>
                        <img src="{{ asset('public/assets/images/header') }}/{{ $header_image->logo }}" alt="logo" style="width: 850px;">
                    </td>
                </tr>
                @else
                <br><br><br><br><br><br><br><br><br>
                @endif
                <tr style="width: 100%">
                    <td style="width: 100%">
                        <h1 style="text-align:center;font-size: 20px;font-weight:600; color: #000;  width: 100%;">
                            {{ @$ipd_details->admission_type }} ADMISSION FORM
                        </h1>
                    </td>
                </tr>
            </table>
            <table style="width: 100%;">
                <tr>
                    <td
                        style="text-align: left;font-size: 17px;font-weight:500; padding: 5px 10px 5px 10px;border: 1px solid #899499;width:280px;">
                        <b>UHID No. : {{ @$patient->uhid }}</b>
                    </td>
                    <td rowspan="2" style="text-align: center;border: 1px solid #899499;width: 250px;height:60px">
                        @php
                            $generatorPNG = new Picqer\Barcode\BarcodeGeneratorPNG();
                        @endphp
                        <img src="data:image/png;base64,{{ base64_encode($generatorPNG->getBarcode('@$ipd_details->id', $generatorPNG::TYPE_CODE_128)) }}" style="width: 220px;height:40px">
                    </td>
                    <td
                        style="text-align: left; font-size: 17px;font-weight:500; padding: 5px;border: 1px solid #899499;">
                        <b>Admission Date : {{ dateFor($ipd_details->admission_date, true) }}</b>
                    </td>
                </tr>
                <tr>
                    <td
                        style="text-align: left;font-size: 17px;font-weight:500; padding: 5px 10px 5px 10px;border: 1px solid #899499;">
                        <b> IPD No. : {{ $ipd_details->id }}</b>
                    </td>
                    <td
                        style="text-align: left;font-size: 17px;font-weight:500; padding: 5px 5px 5px 5px;border: 1px solid #899499;">
                        <b>Patient Type :</b> {{ @$ipd_details->tpa_name }},
                        <b>No : </b> {{ @$ipd_details->insurance_no }}
                    </td>
                </tr>
            </table>
            <table style="width:100%; border-collapse: collapse; margin-top: 10px; margin: 10px 0px 0px 0px; border:1px solid #000;">
                <tr>
                    <th style="text-align: center;font-size: 13px;font-weight:700; padding: 5px 5px 5px 5px; border: 1px solid #000; width:50%;">
                        PATIENT DETAILS
                    </th>
                    <th style="text-align: center;font-size: 13px;font-weight:700; padding: 5px 5px 5px 5px;border: 1px solid #000;width:50%;">
                        PATIENT ADMISSION INFORMATION
                    </th>
                </tr>
                <tr>
                    <td style="text-align: left;font-size: 17px;font-weight:600; padding: 5px 5px 5px 5px;border: 1px solid #000; text-transform: capitalize;">
                        <b>Patient's Name : </b>{{ @$patient->name }}<br>
                        <b> Mobile No : </b>{{ @$patient->phone }} / {{ @$patient->guardian_contact_no }}<br>
                        <b>Sex : </b>{{ @$patient->gender }}, <b> Age : </b>
                        {{ @$patient->dob_year == null ? '' : @$patient->dob_year . 'Y' }}
                        {{ @$patient->dob_month == null ? '' : @$patient->dob_month . 'M' }}
                        {{ @$patient->dob_day == null ? '' : @$patient->dob_day . 'D' }}<br>
                        <span><b>Guardian Name : </b>{{ $patient->guardian_name }}</span><br>
                        {!! @$patient->guardian_realation ? '<b>Guardian Relation : </b>' . $patient->guardian_realation . '<br>' : '' !!}
                        <b>Address : </b>{{ @$patient->address }}, {{ @$patient->district_name }}, {{ @$patient->state_name }}, {{ @$patient->pin_code }}<br>
                        <b>Aadhar Card No : </b>{{ @$patient->identification_number }}
                    </td>
                    <td style="text-align: left;font-size: 17px;font-weight:600; padding: 5px 5px 5px 5px;border: 1px solid #000; text-transform: capitalize;">
                        <b> Package Type : </b>{{ @$ipd_details->package_type }}<br>
                        <b> Bed : </b>{{ @$ipd_details->bed_name }},
                        <b> Ward : </b>{{ @$ipd_details->ward_name }}<br>
                        <b> Under Doctor : </b> DR. {{ @$ipd_details->doctor_name }}<br>

                        @if (@$ipd_details->other_doctor_id)
                            <b> Others Under Doctor : </b> DR. {{ @$ipd_details->other_doctor_name }}<br>
                        @endif

                        @if (@$ipd_details->diagnosis_id)
                            <b>Admission Time Diagnosis : </b>{{ @$ipd_details->diagonasis_name }}<br>
                        @endif
                        <b> Patient Type : </b>{{ @$ipd_details->tpa_name }}<br>
                    </td>
                </tr>
            </table>
            <h3 style="text-align: center;font-weight: 600;font-size: 22px;margin-top: 15px;"> CONSENT</h3>
            <p style="font-size: 13px; margin-top: 10px;">
                1. I, <b>{{strtoupper(@$ipd_details->responsible_person)}}</b> hereby acknowledge that I have incurred all charges mentioned in this form upon admission to

                {{ hospital('title') }} Hospital And Diagnostic Service. I fully understand and agree to the payment terms specified by the
                hospital,
                from the time of admission to discharge. I pledge to settle all outstanding bills, including any charges
                incurred during my stay, prior to discharge.<br>
                2.I am aware of and fully comprehend the rules and regulations regarding patient discharge as outlined
                by the
                hospital. Specifically:
                (2.1) If I am unable to escort the patient by 11 AM on the day of discharge, I commit to making the full
                payment
                for that day.<br>
                (2.2) I promise that no undue pressure will be created by me to the hospital staff for the patient's
                discharge.
                The hospital has explained that certain tasks, such as creating the MRD file, preparing a discharge
                summary, and
                ensuring the patient is ready for departure, may take time. Completing all these tasks simultaneously
                may cause
                delays in the patient's discharge.
                <br>
                (2.3) acknowledge that visitors, including family members or others, are not allowed to stay with the
                patient in
                the ward. Furthermore, I understand that I cannot visit the patient during visiting hours without
                presenting the
                hospital's visiting card to the hospital authorities or security.
                <br>
                3. I understand that the hospital will not be responsible for any loss of valuable belongings, jewelry,
                or cash
                belonging to the patient or their relatives. I will personally ensure the safekeeping of all such
                items.<br>
                4. I consent to the hospital's requirement for various blood tests and other necessary tests for the
                patient's
                medical treatment from the time of admission. I authorize the hospital to conduct all required
                tests.<br>
                5. . In the event of a referral to another hospital for medical reasons, I understand that I will be
                responsible
                for settling the entire bill before transferring the patient.<br>
                6. The doctors and staff at the hospital have explained to me about the critical condition of the
                patient. They
                have also stated that in the event of any deterioration in the patient's physical condition or death for
                any
                reason, the hospital authorities will not hold any responsibility.<br>

                I have heard and understood all of this and admitting the patient with the understanding that I will not
                hold
                the hospital staff responsible in any way if there is a decline in the patient's physical condition or
                in the
                unfortunate event of death.<br>
                I hereby provide my consent to the terms and conditions mentioned above and affirm my commitment to
                fulfilling
                all financial obligations related to the patient's admission and treatment.
            </p>

            <table style="font-size:15px;margin:0px 0px 0px 0px;width:100%; border: 1px solid #000; padding:0px 10px;">
                <tr>
                    <td>
                        <span
                            style="display:inline-block;line-height:10px;font-size:15px;margin-bottom: 20px; padding:11px 11px 11px 11px;"
                            class="student-name">Name
                        </span>
                        <span
                            style="width:33%;display:inline-block;text-transform:uppercase;line-height:normal;text-indent:15px;font-size:15px;font-family:'Font Awesome 5 Free';font-style:normal;font-weight:600;border-bottom:1px dashed #000;">
                            {{ @$ipd_details->responsible_person }}
                        </span>

                        <span style="display:inline-block;line-height:10px;font-size: 15px;margin-bottom: 20px;"
                            class="student-name">
                            Age
                        </span>
                        <span
                            style="width:20%;display:inline-block;text-transform:uppercase;line-height:normal;text-indent:15px;font-size:15px;font-family:'Font Awesome 5 Free';font-style:normal;font-weight:600;border-bottom:1px dashed #000;">
                            {{ @$ipd_details->responsible_person_age }}
                        </span>
                        <span
                            style="display:inline-block;line-height:10px;font-size: 15px;margin-bottom: 20px; padding:11px 11px 11px 11px;"
                            class="student-name">
                            Contact No
                        </span>
                        <span
                            style="width:20%;display:inline-block;text-transform:uppercase;line-height:normal;text-indent:15px;font-size:15px;font-family:'Font Awesome 5 Free';font-style:normal;font-weight:600;border-bottom:1px dashed #000;">
                            {{ @$ipd_details->responsible_person_ph_no }}
                        </span>
                    </td>
                </tr>
                <tr>
                    <td>
                        <span
                            style="display:inline-block;line-height:10px;font-size:15px;margin-bottom: 20px; padding:11px 11px 11px 11px;"
                            class="student-name">Address
                        </span>
                        <span
                            style="width:40%;display:inline-block;text-transform:uppercase;line-height:normal;text-indent:15px;font-size:15px;font-family:'Font Awesome 5 Free';font-style:normal;font-weight:600;border-bottom:1px dashed #000;">
                            {{ @$ipd_details->responsible_person_address }}
                        </span>
                        <span style="display:inline-block;line-height:10px;font-size: 15px;margin-bottom: 20px;"
                            class="student-name">
                            Relation With Patients
                        </span>
                        <span
                            style="width:20%;display:inline-block;text-transform:uppercase;line-height:normal;text-indent:15px;font-size:15px;font-family:'Font Awesome 5 Free';font-style:normal;font-weight:600;border-bottom:1px dashed #000;">
                            {{ @$ipd_details->responsible_person_relation }}
                        </span>
                    </td>
                </tr>
                <tr>
                    <td style="width: 22%;text-align: right;vertical-align: bottom;">
                        <span style="border-top: 1px dotted #1e1d1d;    margin: 4px 104px 0px 0px;">Guardian Signature</span>
                    </td>
                </tr>
            </table>

            <table cellspacing="0" border="0" width="96%" style="width:90%; margin-top: 10px; padding-left: 1100%;">
                <tr>
                    <th style="text-align: left;">
                        <h2 style="margin: 40px 0px 0px 0px;font-size: 13px;font-weight: 800;padding: 10px 0px 0px 0px;">
                            Next of Kin/Accompanying person Signature & Date
                        </h2>
                    </th>
                    <th style="text-align: right;">
                        <h2 style="margin: 40px 0px 0px 0px;font-size: 13px;font-weight: 800;padding: 10px 0px 0px 0px;">
                            Admitting Officer Signature & Date
                        </h2>
                    </th>
                </tr>
            </table>
        </div>
        <!-- =================================================================================================== -->
    </div>
</body>
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

</html>
