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
            <th colspan="7">GENERAL STOCK REPORT</th>
        </tr>
        <tr>
            <td colspan="2"><strong>Filter By Status</strong></td>
            <td colspan="5">{{ $request->status ?: 'All' }}</td>
        </tr>
        <tr>
            <td colspan="2"><strong>Search Item</strong></td>
            <td colspan="5">{{ $request->item_name ?: 'All' }}</td>
        </tr>
        <tr>
            <td colspan="2"><strong>Downloaded At</strong></td>
            <td colspan="5">{{ now()->format('d-m-Y h:i A') }}</td>
        </tr>
        <tr>
            <th>Sl. No.</th>
            <th>Item Name</th>
            <th>Unit Type</th>
            <th>Total QTY</th>
            <th>Return QTY</th>
            <th>Amount</th>
            <th>Status</th>
        </tr>

        @forelse($pasent_stock as $stock)
            <tr>
                <td class="text-center">{{ $loop->iteration }}</td>
                <td>{{ $stock['item'] }}</td>
                <td>{{ $stock['relation'] }}</td>
                <td>{{ $stock['check_qty'] > 0 ? $stock['qty'] . ' (' . $stock['total_qty'] . ')' : $stock['total_qty'] }}</td>
                <td>{{ $stock['return_qty'] }}</td>
                <td class="text-right">{{ number_format($stock['amount'], 2, '.', '') }}</td>
                <td>{{ $stock['status'] }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="7" class="text-center">No data found.</td>
            </tr>
        @endforelse

        <tr>
            <th colspan="5" class="text-right">Total Amount</th>
            <th class="text-right">{{ number_format($totalAmount ?? 0, 2, '.', '') }}</th>
            <th></th>
        </tr>
    </table>
</body>
</html>
