@extends('layouts.structure')
@push('title')
    <title>{{ $section . ' ' . $title }}</title>
@endpush
@push('css')
    <style>
        ul li {
            list-style: none;
            position: relative;
        }

        .block__list li {
            font-size: 15px;
            margin-bottom: 30px;
            cursor: pointer;
        }
    </style>
@endpush
@section('main-content')
    <div class="row">
        {{-- <div class="col-md-1 py-2 pr-1 pl-3">
            <div class="card vh-100">
                <div class="card-header card_hearder_mimi">
                    <h4 class="card-title card_hearder_mimi_text">SECTION</h4>
                </div>
                <div class="card-body">
                    <ul class="block__list">
                        <li><a href="{{ route('hr.approval-system', 'OPD') }}"><i class="fas fa-file-invoice mr-3"></i> OPD</li></a>
                        <li><a href="{{ route('hr.approval-system', 'EMG') }}"><i class="fas fa-file-invoice mr-3"></i> EMG</li></a>
                        <li><a href="{{ route('hr.approval-system', 'IPD') }}"><i class="fas fa-file-invoice mr-3"></i> IPD/DAYCARE</li></a>
                        <li><a href="{{ route('hr.approval-system', 'DIALYSIS') }}"><i class="fas fa-file-invoice mr-3"></i> DIALYSIS</li></a>
                        <li><a href="{{ route('hr.approval-system', 'INVESTIGATION') }}"><i class="fas fa-file-invoice mr-3"></i> INVESTIGATION</li></a>
                    </ul>
                </div>
            </div>
        </div> --}}
        <div class="col-md-12 p-2">
            <div class="card" style="min-height: 100vh">
                <div class="card-header card_hearder_mimi justify-content-between d-flex align-items-center">
                    <div class="card-title card_hearder_mimi_text">{{strtoupper($section)}} BILLING LIST</div>
                    <div>
                        @isok('APPROVAL BILL OPD')<a href="{{ route('hr.approval-system', strtolower('OPD')) }}" class="btn btn-sm btn-outline-warning px-2 mx-1"><i class="fas fa-file-invoice mr-1"></i> OPD</a>@endisok
                        @isok('APPROVAL BILL EMG')<a href="{{ route('hr.approval-system', strtolower('EMG')) }}" class="btn btn-sm btn-outline-warning px-2 mx-1"><i class="fas fa-file-invoice mr-1"></i> EMG</a>@endisok
                        @isok('APPROVAL BILL IPD')<a href="{{ route('hr.approval-system', strtolower('IPD')) }}" class="btn btn-sm btn-outline-warning px-2 mx-1"><i class="fas fa-file-invoice mr-1"></i> IPD/DAYCARE</a>@endisok
                        @isok('APPROVAL BILL DIALYSIS')<a href="{{ route('hr.approval-system', strtolower('DIALYSIS')) }}" class="btn btn-sm btn-outline-warning px-2 mx-1"><i class="fas fa-file-invoice mr-1"></i> DIALYSIS</a>@endisok
                        @isok('APPROVAL BILL INVESTIGATION')<a href="{{ route('hr.approval-system', strtolower('INVESTIGATION')) }}" class="btn btn-sm btn-outline-warning px-2 mx-1"><i class="fas fa-file-invoice mr-1"></i> INVESTIGATION</a>@endisok
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-borderless text-nowrap key-buttons no-footer">
                            <thead>
                                <tr role="row">
                                    <th>#</th>
                                    <th>Bill ID</th>
                                    <th>Bill Date</th>
                                    <th>Patient (UHID)</th>
                                    <th>Total</th>
                                    {{-- <th>Miscellaneous</th> --}}
                                    <th>Discount</th>
                                    <th>Grand Total</th>
                                    <th>Payment</th>
                                    <th>Due </th>
                                    <th>Created By</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($billing as $item)
                                    <tr role="row" class="odd">
                                        <td>{{ $loop->iteration }}</td>
                                        <td><a href="{{ route('bill.billing-details', [$item->section == 'DAYCARE' ? 'ipd' : strtolower($item->section), ed($item->id, true)]) }}" target="_blank" rel="noopener noreferrer">{{ $item->uid }} <span class="badge badge-gradient-primary mx-2">{{ $item->section }}</span></a></td>
                                        <td>{{ dateFor($item->bill_date, true) }}</td>
                                        <td>{{ strtoupper($item->patient_name) }} ({{ $item->patient_uhid ?? $item->patient_id }})</td>
                                        <td>₹{{ number_format($item->total, 2) }}</td>
                                        {{-- <td>{{ $item->miscellaneous_amount }}</td> --}}
                                        <td>₹{{ number_format($item->discount_amount, 2) }}</td>
                                        <td>₹{{ number_format($item->grand_total, 2) }}</td>
                                        <td>₹{{ number_format($item->total_payment, 2) }}</td>
                                        <td>₹{{ number_format($item->due_amount, 2) }}</td>
                                        <td>{{ $item->created_by_name }}</td>
                                        <td>
                                            <a href="{{ route('hr.approve', ed($item->id, true)) }}" onclick="return confirm('Are you sure you want to approve this bill?')" class="btn btn-sm btn-primary">Approve</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
<script>
    $('table').DataTable({
        pageLength: 25
    });
</script>
@endpush
