@extends('layouts.structure')

@push('title')
    <title>View TDS Duties & Taxes Ledger Master</title>
@endpush

@section('main-content')
<style>
    .tds-view-table th,
    .tds-view-table td {
        vertical-align: middle;
    }
    .tds-view-table th {
        width: 280px;
        background: #f8f9fa;
        font-weight: 600;
    }
    .status-yes {
        background: #d4edda;
        color: #155724;
        padding: 4px 10px;
        border-radius: 4px;
        font-size: 12px;
        font-weight: 600;
        display: inline-block;
    }
    .status-no {
        background: #f8d7da;
        color: #721c24;
        padding: 4px 10px;
        border-radius: 4px;
        font-size: 12px;
        font-weight: 600;
        display: inline-block;
    }
</style>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header card_hearder_mimi d-flex justify-content-between align-items-center">
                <h4 class="card-title card_hearder_mimi_text mb-0">TDS Duties & Taxes Ledger Master Details</h4>
                <a href="{{ route('tds-duties-taxes-ledger-master.index') }}" class="btn btn-secondary btn-sm">Back</a>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered tds-view-table mb-0">
                        <tr><th>TDS Ledger Name</th><td>{{ $item->tds_ledger_name ?? '-' }}</td></tr>
                        <tr><th>Under Group</th><td>{{ $item->under_group ?? '-' }}</td></tr>
                        <tr><th>TDS Section Code</th><td>{{ $item->tds_section_code ?? '-' }}</td></tr>
                        <tr><th>TDS Section Description</th><td>{{ $item->tds_section_desc ?? '-' }}</td></tr>
                        <tr><th>Deductee Type</th><td>{{ $item->deductee_type ?? '-' }}</td></tr>
                        <tr><th>TDS Rate (%)</th><td>{{ $item->tds_rate !== null ? $item->tds_rate : '-' }}</td></tr>
                        <tr>
                            <th>Surcharge Applicable</th>
                            <td>
                                @if($item->surcharge_applicable)
                                    <span class="status-yes">Y</span>
                                @else
                                    <span class="status-no">N</span>
                                @endif
                            </td>
                        </tr>
                        <tr><th>Surcharge Rate (%)</th><td>{{ $item->surcharge_rate !== null ? $item->surcharge_rate : '-' }}</td></tr>
                        <tr>
                            <th>Cess Applicable</th>
                            <td>
                                @if($item->cess_applicable)
                                    <span class="status-yes">Y</span>
                                @else
                                    <span class="status-no">N</span>
                                @endif
                            </td>
                        </tr>
                        <tr><th>Cess Rate (%)</th><td>{{ $item->cess_rate !== null ? $item->cess_rate : '-' }}</td></tr>
                        <tr><th>TDS Payment Code</th><td>{{ $item->tds_payment_code ?? '-' }}</td></tr>
                        <tr><th>TDS Type</th><td>{{ $item->tds_type ?? '-' }}</td></tr>
                        <tr><th>Annual Threshold (INR)</th><td>{{ $item->annual_threshold !== null ? number_format((float)$item->annual_threshold, 2) : '-' }}</td></tr>
                        <tr><th>Single Txn Threshold</th><td>{{ $item->single_txn_threshold !== null ? number_format((float)$item->single_txn_threshold, 2) : '-' }}</td></tr>
                        <tr><th>Nature of Payment</th><td>{{ $item->nature_of_payment ?? '-' }}</td></tr>
                        <tr><th>Opening Balance</th><td>{{ $item->opening_balance !== null ? number_format((float)$item->opening_balance, 2) : '0.00' }}</td></tr>
                    </table>
                </div>

                <div class="mt-3">
                    <a href="{{ route('tds-duties-taxes-ledger-master.edit', $item->id) }}" class="btn btn-warning">Edit</a>
                    <a href="{{ route('tds-duties-taxes-ledger-master.index') }}" class="btn btn-secondary">Back</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
