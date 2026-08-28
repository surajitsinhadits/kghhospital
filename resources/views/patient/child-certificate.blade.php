<!DOCTYPE html>
<html>
<head>
    <link href="{{ asset('public/assets/plugins/datatable/css/buttons.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ asset('public/assets/plugins/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('public/assets/css/icons.css') }}" rel="stylesheet" />
    <title>Birth Certificate</title>
</head>
<meta charset="utf-8">
<body>
    <style>
        @page {

            margin: 0;
            size: A4 portrait;

        }
        @media print {
            body {
                width: 25cm;
                height: 33cm;
                margin: 0 !important;
                padding: 5 !important;
                overflow: hidden;
                / change the margins as you want them to be. /
            }
        }
        body {
            font-family: sans-serif;
            background: #ffffff;
            margin: 0 auto;
            height: auto;
            width: 800px;
        }
        table {}
        tr {
            /*width: 100%;*/
            /*height: auto;*/
        }

        .marksheetheading {
            background-color: #E49B0F !important;
            color: #ffffff !important;
        }
        @media print {
            #printButton {
                display: none;
            }
        }
        @media print {
            .pagebreak {
                clear: both;
                page-break-after: always;
            }
        }
    </style>
    <div style="margin: 0px 0px 0px 0px; width: 100%;">
        <div style="margin: 10px 0px 0px 503px" id="printButton">
            <button class="btn btn-primary btn-sm" onclick="printpage()"><i class="fa fa-print"></i> Print</button>
            <a class="btn btn-danger btn-sm" href="{{ route('hr.child-list') }}"><i class="fa fa-times"></i>
                Close</a>
        </div>
        <!-- ==========================heding==================================== -->
        <table style="margin:0px 0px 0px 70px;width:90%;">
            <tr>
                <th
                    style="padding-top: 30px;font-size: 27px; font-weight: 600;padding-bottom: 30px; text-align:center;">
                    BIRTH CERTIFICATE</th>
            </tr>
        </table>
        <!-- ==========================heding==================================== -->
        <!-- ==========================main-area================================= -->
        <table style="margin:0px 0px 0px 70px;width:90%;">
            <tr>
                <td colspan="2"
                    style="font-size:17px;font-weight:600;font-family:initial;font-style:italic;letter-spacing:1px;">
                    <span style="display:inline-block; font-size:19px;">Name Of The Patient</span>
                    <span
                        style="width:55%;display:inline-block;text-transform:uppercase;font-size:17px;font-family:'Font Awesome 5 Free';font-style:normal;color:#000;font-weight:600;border-bottom:1px dashed #000;text-transform:uppercase;line-height:10px;">{{ $child_details->name }}</span>
                    <span style="display:inline-block;line-height:10px; font-size:19px;">Age</span>
                    <span
                        style="width:13%;display:inline-block;text-transform:uppercase;font-size:13px;font-family:'Font Awesome 5 Free';font-style:normal;color:#000;font-weight:600;border-bottom:1px dashed #000;text-transform:uppercase;line-height:10px;">{{ $child_details->dob_day }}DAYS</span><br>
                    <span
                        style="display:inline-block;line-height:10px;margin-top: 45px;font-size:19px;">Husband's/Guardian's
                        Name</span>
                    <span
                        style="width:66%;display:inline-block;text-transform:uppercase;font-size:17px;font-family:'Font Awesome 5 Free';font-style:normal;color:#000;font-weight:600;border-bottom:1px dashed #000;line-height:10px;margin-top: 15px">{{ $child_details->guardian_name }}</span><br>
                    <span style="display:inline-block;line-height:10px;margin-top: 45px;font-size:19px;">Address</span>
                    <span
                        style="width:87%;display:inline-block;text-transform:uppercase;text-indent:15px;font-size:17px;font-family:'Font Awesome 5 Free';font-style:normal;color:#000;font-weight:600;border-bottom:1px dashed #000;line-height:10px;margin-top: 30px">
                        {{ $child_details->address }} </span><br>
                    <span
                        style="display:inline-block;line-height:10px;margin-top: 45px;font-size:19px;">Diagnosis</span>
                    <span
                        style="width:85%;display:inline-block;text-transform:uppercase;font-size:17px;font-family:'Font Awesome 5 Free';font-style:normal;color:#000;font-weight:600;border-bottom:1px dashed #000;line-height:10px;margin-top: 30px">{{ $child_details->diagnosis }}</span><br>

                    <span
                        style="display:inline-block;line-height:10px;margin-top: 45px;font-size:19px;">Operation</span>
                    <span
                        style="width:85%;display:inline-block;text-transform:uppercase;font-size:17px;font-family:'Font Awesome 5 Free';font-style:normal;color:#000;font-weight:600;border-bottom:1px dashed #000;line-height:10px;margin-top: 30px">{{ $child_details->operation }}</span><br>
                    <span style="display:inline-block;line-height:10px;margin-top: 45px;font-size:19px;">Date & Time Of
                        Bith Baby</span>
                    <span
                        style="width:69%;display:inline-block;text-transform:uppercase;font-size:17px;font-family:'Font Awesome 5 Free';font-style:normal;color:#000;font-weight:600;border-bottom:1px dashed #000;line-height:10px;margin-top: 30px">{{dateFor(@$child_details->date_of_birth,true)}}</span><br>
                    <span style="display:inline-block;line-height:10px;margin-top: 45px;font-size:19px;">Sex</span>
                    <span
                        style="width:45%;display:inline-block;text-transform:uppercase;font-size:17px;font-family:'Font Awesome 5 Free';font-style:normal;color:#000;font-weight:600;border-bottom:1px dashed #000;line-height:10px;margin-top: 30px">{{ $child_details->gender }}
                    </span>
                    <span style="display:inline-block;margin-top: 45px;font-size:19px;">Wt.</span>
                    <span
                        style="width:42%;display:inline-block;text-transform:uppercase;font-size:17px;font-family:'Font Awesome 5 Free';font-style:normal;color:#000;font-weight:600;border-bottom:1px dashed #000;line-height:10px;margin-top: 30px">{{ $child_details->weight }}</span><br>
                    <span style="display:inline-block;line-height:10px;margin-top: 45px;font-size:19px;">Mode Of
                        Delivery</span>
                    <span
                        style="width:78%;display:inline-block;text-transform:uppercase;font-size:17px;font-family:'Font Awesome 5 Free';font-style:normal;color:#000;font-weight:600;border-bottom:1px dashed #000;line-height:10px;margin-top: 30px">{{ $child_details->delivery_mode }}</span><br>
                    <span style="display:inline-block;line-height:10px;margin-top: 45px;font-size:19px;">Date Of
                        Admission: on</span>
                    <span
                        style="width:47%;display:inline-block;text-transform:uppercase;font-size:17px;font-family:'Font Awesome 5 Free';font-style:normal;color:#000;font-weight:600;border-bottom:1px dashed #000;line-height:10px;margin-top: 30px">{{dateFor(@$child_details->admission_date)}}</span>
                    <span style="display:inline-block;margin-top: 45px;font-size:19px;">At</span>
                    <span
                        style="width:23%;display:inline-block;text-transform:uppercase;font-size:17px;font-family:'Font Awesome 5 Free';font-style:normal;color:#000;font-weight:600;border-bottom:1px dashed #000;line-height:10px;margin-top: 30px">{{timeFor(@$child_details->admission_date)}}</span><br>

                    <span style="display:inline-block;line-height:10px;margin-top: 45px;font-size:19px;">Date Of
                        Discharge: on</span>
                    <span
                        style="width:47%;display:inline-block;text-transform:uppercase;font-size:17px;font-family:'Font Awesome 5 Free';font-style:normal;color:#000;font-weight:600;border-bottom:1px dashed #000;line-height:10px;margin-top: 30px">{{dateFor(@$child_details->discharge_date)}}</span>
                    <span style="display:inline-block;line-height:10px;margin-top: 45px;font-size:19px;">At</span>
                    <span
                        style="width:23%;display:inline-block;text-transform:uppercase;font-size:17px;font-family:'Font Awesome 5 Free';font-style:normal;color:#000;font-weight:600;border-bottom:1px dashed #000;line-height:10px;margin-top: 30px">{{timeFor(@$child_details->discharge_date)}}</span><br>
                    <span style="display:inline-block;line-height:10px;margin-top: 45px;font-size:19px;">Remarks:</span>
                    <span
                        style="width:72%;display:inline-block;text-transform:uppercase;font-size:17px;font-family:'Font Awesome 5 Free';font-style:normal;color:#000;font-weight:600;line-height:10px;margin-top: 30px">Both
                        Mother and Baby Doing Well</span><br>
                </td>
            </tr>

        </table>
        <!-- ==========================main-area================================= -->
        <!-- ==========================signature================================= -->
        <table cellspacing="0" border="0" width="96%" style="width:90%; margin-top: 110px;margin-left: 70px;">
            <tr>
                <th style="">
                    <span style="display:inline-block; font-weight: 500;">Date:</span>
                    <span
                        style="width:32%;display:inline-block;text-transform:uppercase;font-size:17px;font-family:'Font Awesome 5 Free';font-style:normal;color:#000;font-weight:600;border-bottom:1px solid #000;white-space:nowrap;">{{ dateFor(now(), true) }}
                    </span>
                </th>
                <td style="width: 50%;text-align: center;vertical-align: bottom;">
                    <h2
                        style="margin: 15px 40px 0px 0px;font-size: 17px;font-weight: 500;border-top: 1px dotted #1e1d1d;padding: 10px 0px 0px 0px;">
                        Signature
                    </h2>
                </td>
            </tr>
        </table>
        <!-- ==========================signature================================= -->
        <!-- ==========================text====================================== -->
        <table style="width: 100%; margin-top: 50px;">
            <tr>
                <td style="font-size: 15px; font-weight: 500;text-align: center;"><b>Please register birth at kalyani
                        Municipality within 15th Days (birth registration is mandatory)</b></td>
                <!--  <td>This is provisional certificate</td> -->
            </tr>
            <tr>
                <td style="font-size: 15px;font-weight: 500; text-align: center;"><b>This is provisional certificate</b>
                </td>
            </tr>
        </table>
        <!-- ==========================text====================================== -->
    </div>

    <script>
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

</body>

</html>
