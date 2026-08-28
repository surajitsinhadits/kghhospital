<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Death Report Export</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; padding: 20px; font-size: 12px; }
        h2 { text-align: center; margin-bottom: 5px; }
        .report-meta { text-align: center; margin-bottom: 15px; font-weight: 600; }
        table { width: 100%; border-collapse: collapse; font-size: 11px; table-layout: fixed; }
        th, td { border: 1px solid #444; padding: 6px 8px; text-align: center; word-break: break-word; }
        th { background: #0d6efd; color: #fff; }
        .left { text-align: left; }
    </style>
</head>
<body>
    <h2>Death Report</h2>
    <p class="report-meta">
        Period: {{ $filters['from_date'] ?? '-' }} to {{ $filters['to_date'] ?? '-' }}
    </p>

    <table>
        <thead>
            <tr>
                <th>SN</th>
                <th class="left">Patient (UHID)</th>
                <th>Admission Date</th>
                <th>Under Doctor</th>
                <th>Death Date</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($records as $index => $row)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td class="left">{{ $row->patient_name }} ({{ $row->patient_uhid ?? $row->patient_id }})</td>
                    <td>{{ dateFor($row->admission_date, true) }}</td>
                    <td>{{ $row->doctor_name }}</td>
                    <td>{{ dateFor($row->discharge_date, true) }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5">No records found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
