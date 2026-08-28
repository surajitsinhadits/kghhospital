@extends('layouts.structure')

@push('title')
    <title>View Expense Ledger Master</title>
@endpush

@section('main-content')
<style>
    .expense-ledger-view-table th,
    .expense-ledger-view-table td {
        vertical-align: middle;
    }

    .expense-ledger-view-table th {
        width: 260px;
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
                <h4 class="card-title card_hearder_mimi_text mb-0">Expense Ledger Master Details</h4>
                <a href="{{ route('expense-ledger-master.index') }}" class="btn btn-secondary btn-sm">
                    Back
                </a>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered expense-ledger-view-table mb-0">
                        <tr>
                            <th>Ledger Name</th>
                            <td>{{ $item->ledger_name ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Ledger Group</th>
                            <td>{{ $item->ledger_group ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>TDS Applicable</th>
                            <td>
                                @if($item->tds_applicable)
                                    <span class="status-yes">Y</span>
                                @else
                                    <span class="status-no">N</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>TDS Nature of Payment</th>
                            <td>{{ $item->tds_nature_payment ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>TDS Rate (%)</th>
                            <td>{{ $item->tds_rate !== null ? $item->tds_rate : '-' }}</td>
                        </tr>
                        <tr>
                            <th>TDS Threshold (INR)</th>
                            <td>{{ $item->tds_threshold !== null ? $item->tds_threshold : '-' }}</td>
                        </tr>
                        <tr>
                            <th>GST Applicable</th>
                            <td>
                                @if($item->gst_applicable)
                                    <span class="status-yes">Y</span>
                                @else
                                    <span class="status-no">N</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>GST Charge Type</th>
                            <td>{{ $item->gst_charge_type ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>SAC / HSN Code</th>
                            <td>{{ $item->sac_hsn_code ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>GST Rate (%)</th>
                            <td>{{ $item->gst_rate !== null ? $item->gst_rate : '-' }}</td>
                        </tr>
                        <tr>
                            <th>IGST Ledger Name</th>
                            <td>{{ $item->igst_ledger_name ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>CGST Ledger Name</th>
                            <td>{{ $item->cgst_ledger_name ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>SGST Ledger Name</th>
                            <td>{{ $item->sgst_ledger_name ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>RCM Output GST Ledger</th>
                            <td>{{ $item->rcm_output_gst_ledger ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Cost Centre Applicable</th>
                            <td>
                                @if($item->cost_centre_applicable)
                                    <span class="status-yes">Y</span>
                                @else
                                    <span class="status-no">N</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Default Cost Centre</th>
                            <td>{{ $item->default_cost_centre ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Opening Balance</th>
                            <td>{{ $item->opening_balance !== null ? number_format((float)$item->opening_balance, 2) : '0.00' }}</td>
                        </tr>
                        <tr>
                            <th>Description</th>
                            <td>{{ $item->description ?? '-' }}</td>
                        </tr>
                    </table>
                </div>

                <div class="mt-3">
                    <a href="{{ route('expense-ledger-master.edit', $item->id) }}" class="btn btn-warning">
                        Edit
                    </a>
                    <a href="{{ route('expense-ledger-master.index') }}" class="btn btn-secondary">
                        Back
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
