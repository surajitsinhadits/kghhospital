@extends('layouts.structure')
@push('title')
    <title>{{ $section }} Collection Report</title>
@endpush
@push('css')
@endpush
@section('main-content')
    <div class="row">
        <div class="card">
            <div class="card-header card_hearder_mimi">
                <div class="card-title card_hearder_mimi_text">
                    {{ $section }} Collection Report
                    @if (!empty($branch_title))
                        <span>({{ $branch_title }})</span>
                    @elseif(!empty(@$user->name))
                        <span>({{ @$user->name }})</span>
                    @endif
                    @if (!empty($report_date))
                        <span style="margin-left: 8px;">(Date: {{ $report_date }})</span>
                    @endif
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered text-nowrap">
                        <thead class="bg-primary text-white">
                            <tr>
                                <th scope="col" class="text-white">Bill Id</th>
                                <th scope="col" class="text-white">Patient (UHID)</th>
                                <th scope="col" class="text-white">Payment Amount</th>
                                <th scope="col" class="text-white">Payment Date</th>
                                <th scope="col" class="text-white">Payment Mode</th>
                                <th scope="col" class="text-white">Account</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($payments as $item)
                            <tr>
                                <td><a target="_blank" class="text-blue" href="{{ route('bill.billing-details', [$main_section, ed($item->billing_id, true)]) }}">{{$item->uid}}</a></td>
                                <td>{{strtoupper($item->name)}} ({{ $item->patient_id }})</td>
                                <td>{{$item->payment_amount}}</td>
                                <td>{{dateFor($item->payment_date, true)}}</td>
                                <td>{{$item->payment_mode}}</td>
                                <td>{{$item->payment_bank}}</td>
                            </tr>
                            @endforeach
                            <tr style="background-color:#d1d1ff">
                                <td colspan="6" style="color:blue;font-weight:600;font-size:15px">
                                    Cash Collection : ₹{{ $payments->where('payment_mode', 'Cash')->sum('payment_amount') }} ||  Bank Collection : ₹{{ $payments->where('payment_mode', '!=', 'Cash')->sum('payment_amount') }} ||  Total : ₹{{ $payments->sum('payment_amount') }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')

@endpush
