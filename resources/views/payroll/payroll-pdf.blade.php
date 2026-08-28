<!DOCTYPE html>
<html>
<head>
    <title>PDF Example</title>
    <style>
        body { font-family: Arial, sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid black; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <h1>{{ $title }}</h1>

    <table>
        <thead>
            <tr>
                <th>Allowance Name</th>
                <th>Amount</th>
            </tr>
        </thead>
        <tbody>
            @php
                $salaryDetails = json_decode($salaryDetails, true); // Convert JSON string to an associative array
            @endphp
            
            @foreach($salaryDetails as $key => $value)
                <tr>
                    <td>{{ ucwords(str_replace('_', ' ', ltrim($key, '$'))) }}</td>
                    <td>{{ number_format($value, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
