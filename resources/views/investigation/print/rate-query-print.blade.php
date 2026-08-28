<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Rate Query</title>
    <link href="{{ asset('public/assets/plugins/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('public/assets/plugins/datatable/css/buttons.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ asset('public/assets/css/icons.css') }}" rel="stylesheet">
</head>
<body>
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
            height: 33cm;
            font-family: 'verdana';
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

            <a class="btn btn-danger btn-sm" href="{{ url()->previous() }}"><i class="fa fa-times"></i>
                Close</a>
        </div>

        <!-- ==========================================code here================================== -->
        <!-- =============================logo section================= -->
        <table style="margin:0px 0px 0px 0px; width:100%;">
            <tr>
                <td style="">
                    <img src="{{ asset('public/assets/images/header') }}/{{$header_image->logo}}" alt="" style="width: 850px;">
                </td>
            </tr>
        </table>

        <!-- =======================second header section============== -->
        <!-- =======================third header section=============== -->
        <table style="width: 97%; border-collapse: collapse;margin-top: 1%;margin: 10px 0px 0px 13px; ">

            <tr>
                <td style="text-align: left;font-size: 11px; padding: 10px 10px 10px 10px;border: 1px solid #000;font-weight:600;">SL.NO</td>
                <td style="text-align: left;font-size: 11px; padding: 10px 10px 10px 10px;border: 1px solid #000;font-weight:600;">PARTICULARS</td>
                <td style="text-align: left;font-size: 11px; padding: 10px 10px 10px 10px;border: 1px solid #000;font-weight:600;">RATE</td>
                <td style="text-align: left;font-size: 11px; padding: 10px 10px 10px 10px;border: 1px solid #000;font-weight:600;">QTY</td>
                <td style="text-align: left;font-size: 11px; padding: 10px 10px 10px 10px;border: 1px solid #000;font-weight:600;">DISCOUNT</td>
                <td style="text-align: left;font-size: 11px; padding: 10px 10px 10px 10px;border: 1px solid #000;font-weight:600;">AMOUNT</td>

            </tr>

            @foreach($all_data['charge_name'] as $key=>$chargesDetails)
            <tr>
                <td style="text-align: left;font-size: 11px; padding: 10px 10px 10px 10px;border: 1px solid #000;font-weight:600;">{{ $loop->iteration }}</td>
                <td style="text-align: left;font-size: 11px; padding: 10px 10px 10px 10px;border: 1px solid #000;"> {{$all_data['charge_name'][$key]}} </td>
                <td style="text-align: left;font-size: 11px; padding: 10px 10px 10px 10px;border: 1px solid #000;">{{$all_data['rate'][$key]}}</td>
                <td style="text-align: left;font-size: 11px; padding: 10px 10px 10px 10px;border: 1px solid #000;">{{$all_data['qty'][$key]}}</td>
                <td style="text-align: left;font-size: 11px; padding: 10px 10px 10px 10px;border: 1px solid #000;">{{ ($all_data['discount_in_per'][$key] != 0) ? $all_data['discount_in_per'][$key].'%' : (($all_data['discount_amount'][$key] != 0) ? '₹'.$all_data['discount_amount'][$key] : 0) }}</td>
                <td style="text-align: left;font-size: 11px; padding: 10px 10px 10px 10px;border: 1px solid #000;">{{$all_data['amount'][$key]}}</td>
            </tr>
            @endforeach

        </table>

        <table style="border-collapse: collapse; width: 97%; margin: 10px 0px 0px 13px;border:1px solid #000;">
            <tr>

                <td style="border:1px solid #000;border-left:none; font-size: 13px;padding: 5px 5px 5px 5px; font-weight:800;text-align:right">
                    <span style="padding:20px 0px 0px 5px;">NET AMOUNT : <b>{{ @$all_data['total'] }}</b></span><br>
                    <span style="padding:20px 0px 0px 5px;">DISCOUNT : <b>{{ @$all_data['total_discount'] }} {{ @$all_data['discount_type'] == 'percentage' ? '%' : 'Rs' }}</b></span><br>
                    <span style="padding:20px 0px 0px 5px;">TOTAL AMOUNT : <b>{{ number_format($all_data['grand_total'], 2, '.', '') }}</b></span><br>

                </td>
            </tr>

        </table>
        <!-- =================================================================================================== -->
    </div>.


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
