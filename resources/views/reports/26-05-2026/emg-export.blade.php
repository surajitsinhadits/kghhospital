<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>EMG Patients Export</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            font-size: 12px;
        }

        h2 {
            text-align: center;
            margin-bottom: 5px;
        }

        .report-meta {
            text-align: center;
            margin-bottom: 15px;
            font-weight: 600;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 11px;
            table-layout: fixed;
        }

        th,
        td {
            border: 1px solid #444;
            padding: 6px 8px;
            text-align: center;
            word-break: break-word;
        }

        th {
            background: #0d6efd;
            color: #fff;
        }

        .left {
            text-align: left;
        }
    </style>
</head>
<body>
    <h2>EMG Patients Report</h2>
    <p class="report-meta">
        Period: {{ $filters['from_date'] ?? '-' }} to {{ $filters['to_date'] ?? '-' }}
        @php
            $map = [
                'visit_type' => 'Visit Type',
                'department' => 'Department',
                'doctor' => 'Doctor',
                'referral' => 'Referral',
                'market_by' => 'Market By',
                'provider' => 'Provider',
            ];
            $filterLabel = null;
            foreach ($map as $key => $label) {
                if (!empty($filters[$key])) {
                    $filterLabel = $label . ': ' . $filters[$key];
                    break;
                }
            }
        @endphp
        @if ($filterLabel)
            <br>Filter: {{ $filterLabel }}
        @endif
    </p>

    <table>
        <thead>
            <tr>
                <th>SN</th>
                <th>EMG ID</th>
                <th class="left">Patient (UHID)</th>
                <th>Gender</th>
                <th>Age</th>
                <th>Mobile</th>
                <th>Visit Type</th>
                <th>Appointment Date</th>
                <th>Department</th>
                <th>Doctor</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($records as $index => $row)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $row->id }}</td>
                    <td class="left">{{ $row->patient_name }} ({{ $row->patient_uhid ?? $row->patient_id }})</td>
                    <td>{{ $row->gender }}</td>
                    <td>{{ ($row->dob_year ?? 0) . 'Y ' . ($row->dob_month ?? 0) . 'M ' . ($row->dob_day ?? 0) . 'D' }}</td>
                    <td>{{ $row->phone }}</td>
                    <td>{{ ucfirst($row->type ?? '-') }}</td>
                    <td>{{ dateFor($row->appointment_date, true) }}</td>
                    <td>{{ $row->department_name }}</td>
                    <td>{{ $row->doctor_name ? 'Dr. ' . $row->doctor_name : '-' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="10">No records found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
