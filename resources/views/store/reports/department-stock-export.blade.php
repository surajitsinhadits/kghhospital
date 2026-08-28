<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 6px;
        }

        th {
            font-weight: bold;
            text-align: center;
            background: #d9edf7;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }
    </style>
</head>
<body>
    <table>
        <tr>
            <th colspan="6">DEPARTMENT STOCK REPORT</th>
        </tr>
        <tr>
            <td colspan="2"><strong>Department</strong></td>
            <td colspan="4">{{ $departmentName ?: '-' }}</td>
        </tr>
        <tr>
            <td colspan="2"><strong>Item Name</strong></td>
            <td colspan="4">{{ $request->item_name ?: 'All' }}</td>
        </tr>
        <tr>
            <td colspan="2"><strong>Downloaded At</strong></td>
            <td colspan="4">{{ now()->format('d-m-Y h:i A') }}</td>
        </tr>
        <tr>
            <th>Sl. No.</th>
            <th>Item Name</th>
            <th>Unit Type</th>
            <th>Issue QTY</th>
            <th>Return QTY</th>
            <th>Amount</th>
        </tr>

        @forelse($pasent_stock as $stock)
            <tr>
                <td class="text-center">{{ $loop->iteration }}</td>
                <td>{{ $stock['item'] }}</td>
                <td>{{ $stock['relation'] }}</td>
                <td>{{ $stock['qty'] }} ({{ $stock['total_qty'] }})</td>
                <td>{{ $stock['return_qty'] }}</td>
                <td class="text-right">{{ number_format($stock['net_amount'], 2, '.', '') }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="6" class="text-center">No Record Found.</td>
            </tr>
        @endforelse

        <tr>
            <th colspan="5" class="text-right">Total Amount</th>
            <th class="text-right">{{ number_format($totalAmount ?? 0, 2, '.', '') }}</th>
        </tr>
    </table>
</body>
</html>
