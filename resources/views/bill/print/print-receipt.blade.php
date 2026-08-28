<!DOCTYPE html>
<html>
<meta charset="utf-8">

<head>
    <title>Money Receive Copy</title>
    <link href="{{ asset('public/assets/plugins/datatable/css/buttons.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ asset('public/assets/plugins/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('public/assets/css/icons.css') }}" rel="stylesheet" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lobster&display=swap" rel="stylesheet">
</head>

<body>
    <script>
        window.print();
    </script>
    <style>
        @page {
            size: A4 portrait;
            margin: 0;
            / change the margins as you want them to be. /
        }

        @media print {

            html,
            body {
                width: 25cm;
                height: 33cm;
                margin: 0 !important;
                padding: 5px !important;
                overflow: hidden;
            }
        }

        body {
            font-family: 'verdana';
            background: #ffffff;
            margin: 0 auto;
            height: 33cm;
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
    </style>
    <div style="padding: 0px 7px 0px 7px;">
        <div style="margin: 10px 0px 0px 503px" id="printButton">
            <button class="btn btn-primary btn-sm" onclick="printpage()"><i class="fa fa-print"></i> Print</button>
            <button class="btn btn-danger btn-sm" onclick="window.close()"> Close</button>
        </div>
        <!-- ==========================================code here================================== -->
        <table style="width: 100%;border-collapse: collapse">
            <tr style="text-align: center;">
                <td>
                    <img src="{{ asset('public/assets/images/header') }}/{{ $header_image->logo }}" alt=""
                        style="width: 80%;">
                </td>
            </tr>
            <tr style="text-align: center;">
                <td>
                    <span style="font-weight: 600;font-size:21px">Money Receipt</span>
                </td>
            </tr>

            <table style="width: 96%; border-collapse: collapse;margin: 10px 0px 0px 19px;">

                <td style="border:2px solid #000; font-size: 18px;padding: 5px 5px 5px 5px;font-weight:800;">
                    <span style="padding:20px 0px 0px 5px; margin-bottom: 10px;">UHID NO : <b
                            style="font-weight:800;">{{ @$patient_details->id }}</b></span><br>
                    <span style="padding:20px 0px 0px 5px;">PATIENT NAME : <b
                            style="font-weight:800;">{{ @$patient_details->name }}</b></span><br>
                    <span style="padding:20px 10px 10px 5px;line-height: 20px;">GENDER : <b
                            style="font-weight:800;">{{ @$patient_details->gender }}</b>
                        &nbsp; &nbsp; &nbsp; &nbsp;AGE : <b
                            style="font-weight:800;">{{ @$patient_details->dob_year == null ? '' : @$patient_details->dob_year . 'Y' }}
                            {{ @$patient_details->dob_month == null ? '' : @$patient_details->dob_month . 'M' }}
                            {{ @$patient_details->dob_day == null ? '' : @$patient_details->dob_day . 'D' }}</b></span><br>
                    <span style="padding:20px 0px 0px 5px;">MOB NO : <b
                            style="font-weight:800;">{{ @$patient_details->phone }}</b></span>

                </td>
                <td style="border: 2px solid #000; font-size: 18px;padding: 5px 5px 5px 5px;font-weight:800;">

                    @php
                        $generatorPNG = new Picqer\Barcode\BarcodeGeneratorPNG();
                    @endphp
                    <img src="data:image/png;base64,{{ base64_encode($generatorPNG->getBarcode('@$PaymentDetails->id', $generatorPNG::TYPE_CODE_128)) }}"
                        style="width: 270px;height: 40px;">
                    &nbsp;<span style="padding:20px 10px 10px 5px;line-height: 20px;">Transaction ID :
                        {{ @$PaymentDetails->id }}</span>
                    <br>
                    <span style="padding:20px 10px 10px 5px;line-height: 20px;">Date :
                        {{ dateFor($PaymentDetails->payment_date, true) }}</span><br>


                    <span style="padding:20px 10px 10px 5px;line-height: 20px;">Address :
                        {{ @$patient_details->address }},{{ @$patient_details->district_name }},{{ @$patient_details->state_name }},{{ @$patient_details->pin_code }}</span>

                </td>
            </table>

            <div style="border-radius: 20px;border: 1px solid black;margin: 20px 0px 0px 19px;width:96%; ">
                <table style="border-collapse: collapse;border: none; border-radius:10px; padding: 0px 0px 0px 19px; ">
                    <tr>
                        <td style="text-align: left;font-size: 13px; padding: 10px 10px 10px 10px;">
                            <img src="{{ asset('public/assets/images/thank_you.png') }}" alt=""
                                style="width: 50%;">
                        </td>
                        <td style="text-align: left;">
                            <span style="font-size: 30px; "><b>Amount :
                                    {{ @$PaymentDetails->payment_amount }}/-</b></span><br>
                            <span style="font-size: 15px;">{{ @$amount }} Rupees Only</span>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" style="text-align: center;font-size: 11px;">
                            *** {{ @$PaymentDetails->payment_for }} ***
                        </td>
                    </tr>
                </table>
            </div>
            <table
                style="width: 100%;border-collapse: collapse;border: none; border-radius:10px; margin: 20px 0px 0px 0px">
                <tr>
                    <th style="text-align: left;font-size: 17px;padding: 10px 10px 10px 10px;">
                        Payment Received By : {{ @$PaymentDetails->created_name }}
                    </th>

                    <th style="text-align: left;font-size: 17px;padding: 10px 10px 10px 10px;">
                        Authorized Signature
                    </th>
                </tr>
            </table>

        </table>
        <!-- ==========================================code here================================== -->
    </div>
</body>
<script>
    function printpage() {
        window.print();
    }
</script>

</html>
