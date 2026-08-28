<!DOCTYPE html>
<html>
<title>REQUISITION PRINT</title>
<meta charset="utf-8">

<head>
    <link href="{{ asset('public/assets/plugins/datatable/css/buttons.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ asset('public/assets/plugins/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('public/assets/css/icons.css') }}" rel="stylesheet" />
</head>

<body>

    <style>
        @page {
            size: A4 portrait;
            margin: 0;
            padding: 0;
        }

        @media print {

            html,
            body {
                width: 25cm;
                margin: 0 !important;
                padding: 5 !important;
                overflow: hidden;
                font-family: 'verdana';
            }
        }

        body {
            font-family: sans-serif;
            background: #ffffff;
            margin: 0 auto;
            width: 100%;
        }

        table {
            background-position: center;
            background-repeat: no-repeat;
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
    </style>

    @if (!empty($requisition_details))
        @foreach ($requisition_details as $value)
            <div style="padding: 0px 7px 0px 7px;width: 93%;">
                <div style="margin: 10px 0px 0px 503px" id="printButton">
                    <button class="btn btn-primary btn-sm" onclick="printpage()"><i class="fa fa-print"></i>
                        Print</button>

                    <a href="{{ $back }}" class="btn btn-danger btn-sm"><i class="fa fa-times"></i>
                        Close</a>
                </div>
                <!-- ==========================================code here================================== -->
                <table style="width: 100%;border-collapse: collapse">
                    <tr style="text-align: center;">
                        <td>
                            <img src="{{ asset('public/assets/images/header') }}/{{ $header_image->logo }}"
                                alt="logo" style="width: 80%;">
                        </td>
                    </tr>
                </table>
                <table style="width: 96%; border-collapse: collapse;margin: 0px 0px 0px 40px;">

                    <td style=" font-size: 15px;padding: 5px 5px 5px 5px; font-weight:800;border:2px solid #000;">
                        <span style="padding:20px 0px 0px 5px; margin-bottom: 10px;">UHID : <b
                                style="font-weight:800;">{{ @$patient_details->id }}</b></span><br>
                        <span style="padding:20px 0px 0px 5px;">PATIENT NAME:<b style="font-weight:800;">
                                {{ @$patient_details->name }}</b></span><br>
                        <span style="padding:20px 10px 10px 5px;line-height: 20px;">GENDER:<b
                                style="font-weight:800;">{{ @$patient_details->gender }}</b>
                            &nbsp; &nbsp; &nbsp; &nbsp;AGE:<b style="font-weight:800;">
                                @if (@$patient_details->dob_year != 0)
                                    {{ @$patient_details->dob_year }}Y
                                @endif
                                @if (@$patient_details->dob_month != 0)
                                    {{ @$patient_details->dob_month }}M
                                @endif
                                @if (@$patient_details->dob_day != 0)
                                    {{ @$patient_details->dob_day }}D
                                @endif
                            </b></span><br>
                        <span style="padding:20px 0px 0px 5px;">MOB NO:<b
                                style="font-weight:800;">{{ @$patient_details->phone }}</b></span><br>
                        <span style="padding:20px 10px 10px 5px;line-height: 20px;">Address:<b style="font-weight:800;">
                                {{ @$patient_details->address }},{{ @$patient_details->state_name }},{{ @$patient_details->district_name }}</span><br>

                    </td>
                    <td style=" font-size: 15px;padding: 5px 5px 5px 5px; font-weight:800;border:2px solid #000;">
                        @if (@$ipd_details->admission_date != null)
                            <span style="padding:0px 10px 10px 15px;line-height: 20px;">Admission Date : <b
                                    style="font-weight:800;">{{ dateFor(@$ipd_details->admission_date) }}</b></span><br>
                        @endif
                        <span style="padding:0px 10px 10px 15px;line-height: 20px;">Bill Date : <b
                                style="font-weight:800;">{{ dateFor(@$bill_master_details->bill_date) }}</b></span><br>
                        @if (@$ipd_details->doctor_name != null)
                            <span style="padding:20px 0px 0px 15px;">Under Doct : <b
                                    style="font-weight:800;">{{ @$ipd_details->doctor_name }}</b></span><br>
                        @endif
                        <span style="padding:20px 0px 0px 15px;">Refer By : <b
                                style="font-weight:800;">{{ @$bill_master_details->referral_name }}</b></span><br>
                        @if (@$ipd_details->bed_name != null)
                            <span style="padding:20px 0px 0px 15px;">Bed : <b
                                    style="font-weight:800;">{{ @$ipd_details->bed_name }}</b></span>
                        @endif

                    </td>
                </table>
                <table
                    style="width: 96%; border-collapse: collapse; margin-top: 10px; margin: 20px 0px 0px 40px;border:1px solid #000;">

                    <tr>
                        <td
                            style="text-align: left;font-size: 12px; padding: 5px 5px 5px 5px; font-weight: 800;border:1px solid #000;">
                            #</td>
                        <td
                            style="text-align: left;font-size: 12px; padding: 5px 5px 5px 5px;font-weight: 800;border:1px solid #000;">
                            Test</td>
                        <td
                            style="text-align: left;font-size: 12px; padding: 5px 5px 5px 5px;font-weight: 800;border:1px solid #000;">
                            Qty</td>
                        <td
                            style="text-align: left;font-size: 12px; padding: 5px 5px 5px 5px;font-weight: 800;border:1px solid #000;">
                            Test Dt. </td>
                        <td
                            style="text-align: left;font-size: 12px; padding: 5px 5px 5px 5px;font-weight: 800;border:1px solid #000;">
                            Rep Dt</td>
                        <td
                            style="text-align: left;font-size: 12px; padding: 5px 5px 5px 5px;font-weight: 800;border:1px solid #000;">
                            Sample Type
                        </td>
                        <td
                            style="text-align: left;font-size: 12px; padding: 5px 5px 5px 5px;font-weight: 800;border:1px solid #000;">
                            Sample
                            Required </td>
                        <td
                            style="text-align: left;font-size: 12px; padding: 5px 5px 5px 5px;font-weight: 800;border:1px solid #000;">
                            Sample
                            Coll. Dt
                        </td>
                        <td
                            style="text-align: left;font-size: 12px; padding: 5px 5px 5px 5px;font-weight: 800;border:1px solid #000;">
                            Lab
                            Coll.
                            Dt
                        </td>

                    </tr>

                    @foreach ($value as $item)
                        <tr>
                            <td
                                style="text-align: left;font-size: 11px; padding: 5px 5px 5px 5px;border:1px solid #000;">
                                {{ $loop->iteration }}</td>
                            <td
                                style="text-align: left;font-size: 11px; padding: 5px 5px 5px 5px;border:1px solid #000;">
                                {{ @$item['test_name'] }}</td>
                            <td
                                style="text-align: left;font-size: 11px; padding: 5px 5px 5px 5px;border:1px solid #000;">
                                {{ @$item['qty'] }}</td>
                            </td>
                            <td
                                style="text-align: left;font-size: 11px; padding: 5px 5px 5px 5px;border:1px solid #000;">
                                {{ @$item['bill_created_date'] != null ? dateFor(@$item['bill_created_date']) : '' }}
                            </td>
                            <td
                                style="text-align: left;font-size: 11px; padding: 5px 5px 5px 5px;border:1px solid #000;">
                                {{ @$item['bill_created_date'] != null ? dateFor(@$item['bill_created_date']) : '' }}
                            </td>
                            <td
                                style="text-align: left;font-size: 11px; padding: 5px 5px 5px 5px;border:1px solid #000;">
                            </td>
                            <td
                                style="text-align: left;font-size: 11px; padding: 5px 5px 5px 5px;border:1px solid #000;">
                            </td>
                            <td
                                style="text-align: left;font-size: 11px; padding: 5px 5px 5px 5px;border:1px solid #000;">
                            </td>
                            <td
                                style="text-align: left;font-size: 11px; padding: 5px 5px 5px 5px;border:1px solid #000;">
                            </td>
                        </tr>
                    @endforeach




                </table>


                <table style="width: 96%; font-size: 14px;margin: 10px 0px 0px 40px; font-weight: 800;">
                    <tr>
                        <th style="text-align: left;">Remarks:</th>
                        <td style="text-align: right;"> {{ @$bill_master_details->name }}</td>
                    </tr>
                </table>
                <!-- ==========================================code here================================== -->
            </div>
            <div style="break-after:page"></div>
        @endforeach
    @endif
</body>
<script>
    function printpage() {
        window.print();
    }
</script>

</html>
