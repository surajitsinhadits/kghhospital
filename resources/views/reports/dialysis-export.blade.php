<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dialysis Patients Export</title>
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
    <h2>Dialysis Patients Report</h2>
    <p class="report-meta">
        Period: {{ $filters['from_date'] ?? '-' }} to {{ $filters['to_date'] ?? '-' }}
        @php
            $map = [
                'visit_type' => 'Visit Type',
                'dialysis_type' => 'Dialysis Type',
                'machine_no' => 'Machine No',
                'patient_type' => 'Patient Type',
                'ward' => 'Ward',
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
                <th>Dialysis ID</th>
                <th>Type</th>
                <th class="left">Patient (UHID)</th>
                <th>Gender</th>
                <th>Age</th>
                <th>Mobile</th>
                <th>Admission Date</th>
                <th>Ward & Bed</th>
                <th>Department</th>
                <th>Doctor</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($records as $index => $row)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $row->id }}</td>
                    <td>{{ $row->dialysis_type }} ({{ $row->type }})</td>
                    <td class="left">{{ $row->patient_name }} ({{ $row->patient_id }})</td>
                    <td>{{ $row->gender }}</td>
                    <td>{{ ($row->dob_year ?? 0) . 'Y ' . ($row->dob_month ?? 0) . 'M ' . ($row->dob_day ?? 0) . 'D' }}</td>
                    <td>{{ $row->phone }}</td>
                    <td>{{ dateFor($row->admission_date, true) }}</td>
                    <td>{{ $row->ward_name }} || {{ $row->bed_name }}</td>
                    <td>{{ $row->department_name }}</td>
                    <td>{{ $row->doctor_name ? 'Dr. ' . $row->doctor_name : '-' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="11">No records found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
