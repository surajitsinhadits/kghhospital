<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Discharge Report Export</title>
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
    <h2>Discharge Report</h2>
    <p class="report-meta">
        Period: {{ $filters['from_date'] ?? '-' }} to {{ $filters['to_date'] ?? '-' }}
        @if (!empty($filters['discharge_status']))
            <br>Filter: Discharge Status: {{ $filters['discharge_status'] }}
        @endif
    </p>

    <table>
        <thead>
            <tr>
                <th>SN</th>
                <th>Bill No</th>
                <th class="left">Patient (UHID)</th>
                <th>Admission Date</th>
                <th>Discharge Date</th>
                <th>Discharge Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($records as $index => $row)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $row->uid }}</td>
                    <td class="left">{{ $row->patient_name }} ({{ $row->patient_uhid ?? $row->patient_id }})</td>
                    <td>{{ dateFor($row->admission_date, true) }}</td>
                    <td>{{ dateFor($row->discharge_date, true) }}</td>
                    <td>{{ $row->discharge_type }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6">No records found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
