@extends('layouts.structure')

@push('title')
    <title>{{ $title }} - {{ hospital('title') }}</title>
@endpush

@push('css')
<style>
    /* Keep table columns stable (important for datatable) */
    .datatable-all { table-layout: fixed; width: 100%; }

    /* Give Apply column enough width + keep content aligned */
    .datatable-all th:last-child,
    .datatable-all td:last-child{
        width: 150px !important;
        min-width: 150px !important;
        text-align: center;
        vertical-align: middle;
        white-space: nowrap;
    }

    /* Make checkbox + label inline + centered */
    .apply-wrap{
        display:flex;
        align-items:center;
        justify-content:center;
        gap:8px;
        white-space: nowrap;
    }

    .apply-wrap .form-check{
        margin:0;
        padding:0;
        display:flex;
        align-items:center;
        gap:8px;
        white-space: nowrap;
    }

    .apply-wrap .form-check-input{
        margin:0;
        width:18px;
        height:18px;
        cursor:pointer;
    }

    .apply-wrap .form-check-label{
        margin:0;
        font-weight:600;
        font-size:13px;
        cursor:pointer;
        white-space: nowrap;
    }

    /* Applied badge centered */
    .apply-badge{
        display:inline-block;
        padding:6px 10px;
        border-radius:8px;
        font-weight:700;
        font-size:12px;
        white-space: nowrap;
    }

    /* Bottom Save button area */
    .tds-footer{
        display:flex;
        justify-content:flex-end;
        margin-top:14px;
    }

    .tds-footer .btn{
        min-width:140px;
        border-radius:10px;
        font-weight:700;
    }
</style>
@endpush

@section('main-content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header card_hearder_mimi justify-content-between">
                <h4 class="card-title card_hearder_mimi_text">TDS Management</h4>
            </div>

            <div class="card-body">
                <form method="GET" action="{{ route('hr.tds-management') }}">
                    <div class="row">
                        <div class="col-lg-5 col-md-5 mb-3">
                            <label class="form-label">Section</label>
                            <select class="form-control select2-show-search" name="section">
                                <option value="">Select Section</option>
                                @foreach ($sections as $section)
                                    <option value="{{ $section->charges_section_name }}"
                                        {{ request('section') == $section->charges_section_name ? 'selected' : '' }}>
                                        {{ $section->charges_section_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-lg-5 col-md-5 mb-3">
                            <label class="form-label">Bill No</label>
                            <input type="text" class="form-control" name="bill_no" placeholder="Enter bill number"
                                   value="{{ request('bill_no') }}">
                        </div>

                        <div class="col-lg-2 col-md-2 mb-3 d-flex align-items-end">
                            <button type="submit" class="btn btn-primary w-100">Search</button>
                        </div>
                    </div>
                </form>

                @if ($records->isNotEmpty())
                    <form method="POST" action="{{ route('hr.tds-management.apply') }}" id="tdsApplyForm">
                        @csrf

                        <div class="table-responsive mt-4">
                            <table class="table table-bordered table-striped datatable-all">
                                <thead>
                                    <tr>
                                        <th style="width:60px;">#</th>
                                        <th>Bill No</th>
                                        <th>Section</th>
                                        <th>Insurance Type</th>
                                        <th>Payment Date</th>
                                        <th>Payment Mode</th>
                                        <th>Payment Amount</th>
                                        <th>Payment TDS</th>
                                        <th>Apply ({{ $tdsPercent ?? 0 }}%)</th>
                                    </tr>
                                </thead>

                                <tbody>
                                @foreach ($records as $record)
                                    @php
                                        $computedTds = number_format($record->tds_to_apply ?? 0, 2, '.', '');
                                    @endphp

                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $record->billing_uid ?? $record->billing_id }}</td>
                                        <td>{{ $record->billing_section ?? '--' }}</td>
                                        <td>{{ $record->tpa_name }}</td>
                                        <td>{{ $record->payment_date ? date('d-m-Y h:i A', strtotime($record->payment_date)) : '--' }}</td>
                                        <td>{{ $record->payment_mode ? strtoupper($record->payment_mode) : '--' }}</td>
                                        <td>₹ {{ number_format($record->payment_amount ?? 0, 2) }}</td>

                                        {{-- <td>{{ $computedTds > 0 ? '₹ ' . $computedTds : '--' }}</td> --}}

                                        <td>
                                            {{ $record->payment_tds_amount > 0 ? '₹ ' . number_format($record->payment_tds_amount, 2) : '--' }}
                                        </td>

                                        <td>
                                            @if ($record->tds_applied)
                                                <span class="badge badge-success apply-badge">Already applied</span>
                                            @else
                                                <div class="apply-wrap">
                                                    <div class="form-check">
                                                        <input
                                                            class="form-check-input tds-checkbox"
                                                            type="checkbox"
                                                            name="selected_payments[]"
                                                            value="{{ $record->id }}"
                                                            id="apply-tds-{{ $record->id }}"
                                                            data-tds-amount="{{ $computedTds }}"
                                                        >
                                                        {{-- <label class="form-check-label" for="apply-tds-{{ $record->id }}">
                                                            Select
                                                        </label> --}}
                                                    </div>
                                                </div>

                                                <input type="hidden" name="billing_ids[{{ $record->id }}]" value="{{ $record->billing_id }}">
                                                <input type="hidden" name="tds_amounts[{{ $record->id }}]" id="tds-amount-input-{{ $record->id }}">
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="tds-footer">
                            <button type="submit" id="tds-apply-btn" class="btn btn-primary" disabled>Save</button>
                        </div>
                    </form>

                @elseif(request()->filled('section') || request()->filled('bill_no'))
                    <div class="alert alert-warning mt-4">
                        No records found.
                    </div>
                @endif

            </div>
        </div>
    </div>
</div>
@endsection

@push('js')
<script>
    function initTdsBulkUI() {
        const applyButton = $('#tds-apply-btn');
        if (!applyButton.length) return;

        const checkboxes = $('.tds-checkbox');

        const handleChange = () => {
            const anyChecked = checkboxes.filter(':checked').length > 0;
            applyButton.prop('disabled', !anyChecked);
        };

        checkboxes.off('change').on('change', function () {
            const paymentId = $(this).val();
            const tdsAmount = Number($(this).data('tds-amount')) || 0;
            const hiddenInput = $(`#tds-amount-input-${paymentId}`);

            if (this.checked) hiddenInput.val(tdsAmount.toFixed(2));
            else hiddenInput.val('');

            handleChange();
        });

        handleChange();
    }

    $(function () {
        initTdsBulkUI();

        // If DataTables redraws, rebind events
        if ($.fn.DataTable && $('.datatable-all').length) {
            $('.datatable-all').on('draw.dt', function () {
                initTdsBulkUI();
            });
        }

        // prevent double submit
        $('#tdsApplyForm').on('submit', function () {
            const btn = $('#tds-apply-btn');
            btn.prop('disabled', true).text('Saving...');
        });
    });
</script>
@endpush
