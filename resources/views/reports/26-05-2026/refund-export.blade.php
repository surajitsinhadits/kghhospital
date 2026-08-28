<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Refund List Export</title>
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
            background: #007bff;
            color: #fff;
        }
    </style>
</head>
<body>
    <h2>Refund List</h2>
    <p class="report-meta">
        Period: {{ $filters['from_date'] ?? '-' }} to {{ $filters['to_date'] ?? '-' }}
        @php
            $filterNames = [
                'p.name' => 'Patient Name',
                'p.uhid' => 'UHID',
                'p.phone' => 'Phone',
                'billings.section' => 'Section',
            ];
            $fieldName = $filters['field_name'] ?? null;
            $fieldValue = $filters['field_value'] ?? null;
            $selectValue = $filters['select_value'] ?? null;
            $filterLabel = null;
            if ($fieldName === 'billings.section' && $selectValue) {
                $filterLabel = ($filterNames[$fieldName] ?? $fieldName) . ': ' . $selectValue;
            } elseif ($fieldName && $fieldValue) {
                $filterLabel = ($filterNames[$fieldName] ?? $fieldName) . ': ' . $fieldValue;
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
                <th>Payment ID</th>
                <th>Refund From Bill</th>
                <th>Section</th>
                <th>Patient (UHID)</th>
                <th>Phone</th>
                <th>Date &amp; Time</th>
                <th>Amount (₹)</th>
                <th>Refund By</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($records as $index => $row)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>RF{{ $row->refund_id }}</td>
                    <td>{{ $row->uid }}</td>
                    <td>{{ $row->section }}</td>
                    <td>{{ $row->patient_name }} ({{ $row->patient_uhid ?? $row->patient_id }})</td>
                    <td>{{ $row->phone }}</td>
                    <td>{{ dateFor($row->refund_at, true) }}</td>
                    <td>{{ number_format($row->refund_amount ?? 0, 2) }}</td>
                    <td>{{ $row->refund_name ?? '-' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="9">No refunds found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
