<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Billing Report Export</title>
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
    <h2>Billing Report</h2>
    <p class="report-meta">
        Period: {{ $filters['from_date'] ?? '-' }} to {{ $filters['to_date'] ?? '-' }}
    </p>

    <table>
        <thead>
            <tr>
                <th>SN</th>
                <th>Date</th>
                <th>Bill ID</th>
                <th>Section</th>
                <th class="left">Patient (UHID)</th>
                <th>Mobile</th>
                <th>Doctor</th>
                <th>Referral</th>
                <th>Net Amt</th>
                <th>Disc Amt</th>
                <th>Paid</th>
                <th>Due</th>
                <th>Refund</th>
                <th>Adj.</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($records as $index => $row)
                @php
                    $adj = 0;
                    if (!empty($row->cradituse_bill_amount)) {
                        $adj = array_sum(explode('_', trim($row->cradituse_bill_amount, '_')));
                    }
                @endphp
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ dateFor($row->bill_date, true) }}</td>
                    <td>{{ $row->uid }}</td>
                    <td>{{ $row->section }}</td>
                    <td class="left">{{ $row->patient_name }} ({{ $row->patient_uhid ?? $row->patient_id }})</td>
                    <td>{{ $row->phone }}</td>
                    <td>{{ $row->doctor_name ? 'Dr. ' . $row->doctor_name : '---' }}</td>
                    <td>{{ $row->ref_by ?? '---' }}</td>
                    <td>{{ number_format($row->grand_total ?? 0, 2) }}</td>
                    <td>{{ number_format($row->discount_amount ?? 0, 2) }}</td>
                    <td>{{ number_format($row->total_payment ?? 0, 2) }}</td>
                    <td>{{ number_format($row->due_amount ?? 0, 2) }}</td>
                    <td>{{ number_format($row->refund_amount ?? 0, 2) }}</td>
                    <td>{{ number_format($adj, 2) }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="14">No records found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
