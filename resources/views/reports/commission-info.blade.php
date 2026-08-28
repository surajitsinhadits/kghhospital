@extends('layouts.structure')
@push('title')
    <title>Commission Details</title>
@endpush
@push('css')
    <style>
        .commission-action-row {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
            justify-content: flex-end;
        }
    </style>
@endpush
@section('main-content')
@php
    $storedTotal = (float) ($commissionMaster->adjusted_commission_total_amount ?? 0);
    $hasStoredTotal = isset($commissionMaster) && $commissionMaster->adjusted_commission_total_amount !== null && $commissionMaster->adjusted_commission_total_amount !== '';
@endphp
<div class="row">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center card_hearder_mimi">
            <div class="card-title card_hearder_mimi_text">
                Commission Details
            </div>
            <div class="commission-action-row">
                <button type="button" id="commissionAdditionBtn" class="btn btn-sm btn-success">
                    <i class="fa fa-plus"></i> Addition
                </button>
                <button type="button" id="commissionSubtractionBtn" class="btn btn-sm btn-danger">
                    <i class="fa fa-minus"></i> Subtraction
                </button>
                <span><a class="btn btn-sm btn-warning" href="{{ route('reports.commission-report-print', $master_id) }}"><i class="fa fa-print"></i></a></span>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive mt-4">
                <table class="table table-striped card-table table-vcenter text-nowrap border">
                    <thead class="bg-primary text-white">
                        <tr class="border">
                            <th class="text-white border">#</th>
                            <th class="text-white border">Bill ID</th>
                            <th class="text-white border">Patient Name</th>
                            <th class="text-white border">Charge Name</th>
                            <th class="text-white border">User Name</th>
                            <th class="text-white border">Total Amount</th>
                            <th class="text-white border">Commission</th>
                            <th class="text-white border">Commission Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $total = 0;
                        @endphp
                        @if(isset($results) && $results != '')
                            @foreach($results as $list)
                            @php
                                $total += $list->discount_amount;
                            @endphp
                            <tr>
                                <th scope="row" class="border">{{ $loop->iteration }}</th>
                                <td class="border">{{ $list->bill_id }} </td>
                                <td class="border">{{ $list->patient_name }}</td>
                                <td class="border">{{ $list->charge_name }}</td>
                                <td class="border">
                                    @if( $list->referred_by_name )
                                        {{ $list->referred_by_name }}
                                    @elseif( $list->market_by_name )
                                        {{ $list->market_by_name }}
                                    @elseif( $list->provider_name )
                                        {{ $list->provider_name }}
                                    @endif
                                </td>
                                <td class="border">{{ $list->charge_amount }}</td>
                                <td class="border">{{ $list->discount }}</td>
                                <td class="border">{{ $list->discount_amount }}</td>
                            </tr>
                            @endforeach
                        @endif

                        <tfoot>
                            <tr>
                                <th colspan="7">Total Commission</th>
                                <th id="baseCommissionTotal">{{ number_format($total, 2, '.', '') }}</th>
                            </tr>
                            <tr id="adjustedCommissionRow">
                                <th colspan="7" class="text-success">Adjusted Total Commission</th>
                                <th id="adjustedCommissionTotal" class="text-success">{{ number_format($hasStoredTotal ? $storedTotal : $total, 2, '.', '') }}</th>
                            </tr>
                        </tfoot>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="commissionAdjustModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <form id="commissionAdjustForm">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="commissionAdjustTitle">Update Commission</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="master_id" value="{{ $master_id }}">
                    <input type="hidden" name="type" id="commissionAdjustType">
                    <div class="mb-3">
                        <label for="commissionAdjustAmount" class="form-label">Amount</label>
                        <input type="number" step="0.01" min="0.01" class="form-control" name="amount" id="commissionAdjustAmount" required>
                    </div>
                    <div class="small text-muted">
                        Current adjusted total:
                        <span id="currentAdjustedTotalText">{{ number_format($hasStoredTotal ? $storedTotal : $total, 2, '.', '') }}</span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="close-btn" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@push('js')
    <script>
        let commissionAdjustModalInstance = null;

        function getCommissionAdjustModal() {
            const modalElement = document.getElementById('commissionAdjustModal');

            if (!commissionAdjustModalInstance) {
                commissionAdjustModalInstance = new bootstrap.Modal(modalElement);
            }

            return commissionAdjustModalInstance;
        }

        function openCommissionAdjustModal(type) {
            const title = type === 'addition' ? 'Add Commission Amount' : 'Subtract Commission Amount';
            document.getElementById('commissionAdjustType').value = type;
            document.getElementById('commissionAdjustTitle').innerText = title;
            document.getElementById('commissionAdjustAmount').value = '';
            document.getElementById('currentAdjustedTotalText').innerText = document.getElementById('adjustedCommissionTotal').innerText;
            getCommissionAdjustModal().show();
        }

        $('#commissionAdditionBtn').on('click', function (e) {
            e.preventDefault();
            e.stopPropagation();
            openCommissionAdjustModal('addition');
        });

        $('#commissionSubtractionBtn').on('click', function (e) {
            e.preventDefault();
            e.stopPropagation();
            openCommissionAdjustModal('subtraction');
        });

        $('#adjustedCommissionRow, #adjustedCommissionRow th').on('click', function (e) {
            e.preventDefault();
            e.stopPropagation();
            return false;
        });

        $('#commissionAdjustForm').on('submit', function (e) {
            e.preventDefault();

            $.ajax({
                url: "{{ route('reports.commission-report-adjust-total') }}",
                type: 'POST',
                data: $(this).serialize(),
                success: function (response) {
                    if (response.status == 1) {
                        $('#adjustedCommissionTotal').text(response.updated_total);
                        $('#currentAdjustedTotalText').text(response.updated_total);
                        getCommissionAdjustModal().hide();
                    } else {
                        alert(response.message || 'Unable to update commission total.');
                    }
                },
                error: function (xhr) {
                    const message = xhr.responseJSON?.message || 'Unable to update commission total.';
                    alert(message);
                }
            });
        });
    </script>
@endpush
