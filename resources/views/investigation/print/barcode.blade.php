<!doctype html>
<html lang="en">
    <head>
        <title>Generated Barcode</title>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
    </head>

    <body>
        <h4>{{ @$report->patient_name }} ({{ @$report->patient_uhid ?? @$report->patient_id }}) ({{ @$report->dob_year ? $report->dob_year : 0 }}Y {{ @$report->dob_month ? $report->dob_month : 0 }}M {{ @$report->dob_day ? $report->dob_day : 0 }}D)</h4>
        @php
            $generatorPNG = new Picqer\Barcode\BarcodeGeneratorPNG();
        @endphp

        <img src="data:image/png;base64,{{ base64_encode($generatorPNG->getBarcode((string) (@$report->patient_uhid ?? @$report->patient_id), $generatorPNG::TYPE_CODE_128)) }}" style="margin-top:-20px;">
        <h4 style="margin-top:-1px;">{{ @$report->charge_name }}</h4>
        <script>
            window.print();
        </script>
    </body>
</html>
