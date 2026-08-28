<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ $title }} Export</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; padding: 20px; font-size: 12px; }
        h2 { text-align: center; margin-bottom: 5px; }
        .report-meta { text-align: center; margin-bottom: 15px; font-weight: 600; }
        table { width: 100%; border-collapse: collapse; font-size: 11px; table-layout: fixed; }
        th, td { border: 1px solid #444; padding: 6px 8px; text-align: center; word-break: break-word; }
        th { background: #0d6efd; color: #fff; }
        .left { text-align: left; }
        .group { background: #d1cbcb; color: #000; }
    </style>
</head>
<body>
    <h2>{{ $title }}</h2>
    <p class="report-meta">
        Period: {{ dateFor($request_data['from_date'] ?? null) }} to {{ dateFor($request_data['to_date'] ?? null) }}
    </p>

    @php
        $rowsFor = function($collection, $filterKey, $id) {
            return $collection->where($filterKey, (int)$id);
        };
        function labAmount($row) { return ($row->sub_total ?? 0) > 0 ? $row->sub_total : ($row->total ?? 0); }
    @endphp

    @if (!empty($request_data['referral']))
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Billing ID</th>
                    <th>Date</th>
                    <th class="left">Patient</th>
                    <th>Section</th>
                    <th>Lab Amount</th>
                </tr>
            </thead>
            <tbody>
            @foreach ($request_data['referral'] as $refId)
                @php
                    $_ref = $referral->firstWhere('id', $refId);
                    $items = $rowsFor($response, 'referred_by_id', $refId);
                @endphp
                <tr class="group">
                    <td colspan="6"><strong>{{ $_ref?->name }}</strong></td>
                </tr>
                @forelse ($items as $i => $row)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td>{{ $row->uid }}</td>
                        <td>{{ dateFor($row->bill_date, true) }}</td>
                        <td class="left">{{ $row->patient_name }} ({{ $row->patient_uhid ?? $row->patient_id }})</td>
                        <td>{{ $row->section }}</td>
                        <td>{{ number_format(labAmount($row), 2) }}</td>
                    </tr>
                @empty
                    <tr><td colspan="6">No records.</td></tr>
                @endforelse
            @endforeach
            </tbody>
        </table>
    @endif

    @if (!empty($request_data['provider']))
        <br>
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Billing ID</th>
                    <th>Date</th>
                    <th class="left">Patient</th>
                    <th>Section</th>
                    <th>Lab Amount</th>
                </tr>
            </thead>
            <tbody>
            @foreach ($request_data['provider'] as $provId)
                @php
                    $_prov = $provider->firstWhere('id', $provId);
                    $items = $rowsFor($response, 'provider_id', $provId);
                @endphp
                <tr class="group">
                    <td colspan="6"><strong>{{ $_prov?->name }}</strong></td>
                </tr>
                @forelse ($items as $i => $row)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td>{{ $row->uid }}</td>
                        <td>{{ dateFor($row->bill_date, true) }}</td>
                        <td class="left">{{ $row->patient_name }} ({{ $row->patient_uhid ?? $row->patient_id }})</td>
                        <td>{{ $row->section }}</td>
                        <td>{{ number_format(labAmount($row), 2) }}</td>
                    </tr>
                @empty
                    <tr><td colspan="6">No records.</td></tr>
                @endforelse
            @endforeach
            </tbody>
        </table>
    @endif

    @if (!empty($request_data['marketBy']))
        <br>
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Billing ID</th>
                    <th>Date</th>
                    <th class="left">Patient</th>
                    <th>Section</th>
                    <th>Lab Amount</th>
                </tr>
            </thead>
            <tbody>
            @foreach ($request_data['marketBy'] as $mktId)
                @php
                    $_mkt = $market_by->firstWhere('id', $mktId);
                    $items = $rowsFor($response, 'market_by_id', $mktId);
                @endphp
                <tr class="group">
                    <td colspan="6"><strong>{{ $_mkt?->name }}</strong></td>
                </tr>
                @forelse ($items as $i => $row)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td>{{ $row->uid }}</td>
                        <td>{{ dateFor($row->bill_date, true) }}</td>
                        <td class="left">{{ $row->patient_name }} ({{ $row->patient_uhid ?? $row->patient_id }})</td>
                        <td>{{ $row->section }}</td>
                        <td>{{ number_format(labAmount($row), 2) }}</td>
                    </tr>
                @empty
                    <tr><td colspan="6">No records.</td></tr>
                @endforelse
            @endforeach
            </tbody>
        </table>
    @endif
</body>
</html>
