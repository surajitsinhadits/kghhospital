<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Eye Test Prescription - Madhusree</title>
  <link href="{{ asset('public/assets/plugins/datatable/css/buttons.bootstrap4.min.css') }}" rel="stylesheet">
  <link href="{{ asset('public/assets/plugins/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ asset('public/assets/css/icons.css') }}" rel="stylesheet" />
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Lobster&display=swap" rel="stylesheet">
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 40px;
      background: #fafafa;
      color: #333;
    }
    h1 {
      text-align: center;
      color: #222;
    }
    .section {
      margin-bottom: 30px;
    }
    .info, .note {
      margin: 10px 0;
    }
    table {
      width: 100%;
      border-collapse: collapse;
      margin: 15px 0;
    }
    table, th, td {
      border: 1px solid #aaa;
    }
    th, td {
      padding: 8px 12px;
      text-align: center;
    }
    th {
      background: #f0f0f0;
    }
    .next-test {
      text-align: center;
      margin-top: 20px;
      padding: 15px;
      background: #f5f5f5;
      border-radius: 6px;
      font-weight: bold;
    }
  </style>
</head>
<body>

  <div style="margin: 10px 0px 20px 503px" id="printButton">
      <button class="btn btn-primary btn-sm" onclick="printpage();"><i class="fa fa-print"></i> Print</button>
      <button class="btn btn-danger btn-sm" onclick="window.close();"> Close</button>
  </div>

  <h1>Eye Test Prescription</h1>

  @if (@$header_image->logo)
      <div>
        <img src="{{ asset('public/assets/images/header') }}/{{ $header_image->logo }}" alt="logo" style="width: 850px;">
      </div>
      @else
      <br><br><br><br><br><br><br><br><br>
      @endif

  <div class="section">
    <p class="info"><strong>Customer Name:</strong> {{ $OpRegisterDetails->patient_name }}</p>
    <p class="info"><strong>Eye Test Date:</strong> {{ date('l, d M Y', strtotime($OpRegisterDetails->appointment_date)) }}</p>
    <p class="info"><strong>Store Address:</strong> {{ hospital('address') }}</p>
  </div>

  <div class="section">
    <h2>Single Vision Power</h2>
    <table>
      <tr>
        <th>Rx</th>
        <th>Spherical</th>
        <th>Cylindrical</th>
        <th>Axis</th>
        <th>Pupil Distance</th>
        <th>Add. Power</th>
      </tr>
      @if( $OpRecords->count() > 0 )
        @foreach( $OpRecords as $record )
        @if( $record->type_id == 1 )
          <tr>
            <td>{{ $record->eye }}</td>
            <td>{{ $record->spherical }}</td>
            <td>{{ $record->cylindrical }}</td>
            <td>{{ $record->axis }}</td>
            <td>{{ $record->pupil_distance }}</td>
            <td>{{ $record->add_power }}</td>
          </tr>
          @endif
        @endforeach
        @endif
    </table>
  </div>

  <div class="section">
    <h2>Contact Lens Power</h2>
    <table>
      <tr>
        <th>Rx</th>
        <th>Spherical</th>
        <th>Cylindrical</th>
        <th>Axis</th>
        <th>Pupil Distance</th>
        <th>Add. Power</th>
      </tr>
      @if( $OpRecords->count() > 0 )
        @foreach( $OpRecords as $record )
        @if( $record->type_id == 2 )
          <tr>
            <td>{{ $record->eye }}</td>
            <td>{{ $record->spherical }}</td>
            <td>{{ $record->cylindrical }}</td>
            <td>{{ $record->axis }}</td>
            <td>{{ $record->pupil_distance }}</td>
            <td>{{ $record->add_power }}</td>
          </tr>
          @endif
        @endforeach
      @endif
    </table>
  </div>

  <p class="note"><em>Note: This is a system-generated prescription.</em></p>
</body>
<script>
    function printpage() {
        window.print();
    }
</script>
</html>
