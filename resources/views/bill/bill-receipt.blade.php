@extends('layouts.structure')
@push('title')
    <title>Receipt Lists</title>
@endpush
@push('css')
@endpush
@section('main-content')
    <div class="row">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3 leftside_fixarea">
                        <x-billbar section="{{ $section }}" id="{{$secid}}" type="sec" />
                    </div>

                    <div class="col-md-9 rightside_fixarea" style="border:2px solid black">
                        <h3>*<u>All RECEIPT LIST</u> </h3>
                        <div class="row mt-5">
                            <div class="table-responsive">
                                <table id="example1" class="table table-bordered text-nowrap key-buttons datatable no-footer">
                                    <thead class="bg-primary text-white">
                                        <tr>
                                            <th>Receipt ID</th>
                                            <th>Date</th>
                                            <th>Amount (₹)</th>
                                            <th>Received By</th>
                                            <th>Payment Mode</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($payments as $pay)
                                        <tr role="row" class="odd">
                                            <td class="sorting_1">
                                                R{{$pay->id}}
                                                <span class="badge badge-gradient-primary mt-2">{{$pay->section == 'OP' ? 'OPTICAL' : $pay->section}}</span>
                                            </td>
                                            <td>{{dateFor($pay->payment_date, true)}}</td>
                                            <td>{{$pay->payment_amount}}</td>
                                            <td>{{$pay->created_name}}</td>
                                            <td>{{$pay->payment_mode}}</td>
                                            <td>
                                                <a href="{{route('bill.print-payment-receipt',[$section, ed($pay->id,true)])}}" target="_blank" data-placement="left" data-toggle="tooltip" title="Print Receipt" data-original-title="Print Receipt">
                                                    <i class="fa fa-print"></i>
                                                </a>
                                                @isok('RECEIPT EDIT')
                                                <a class="mx-1"
                                                    href="{{ route('bill.edit-receipt', [strtolower($pay->section), ed($pay->id, true)]) }}"
                                                    data-placement="left" data-toggle="tooltip" title="Edit Receipt"
                                                    data-original-title="Edit Receipt">
                                                    <i class="fa fa-edit text-warning"></i>
                                                </a>
                                                @endisok
                                                @isok('RECEIPT DELETE')
                                                <a class="mx-1"
                                                    onclick="return confirm('Are you sure you want to delete this receipt?');"
                                                    href="{{ route('bill.delete-receipt', [strtolower($pay->section), ed($pay->id, true)]) }}"
                                                    data-placement="left" data-toggle="tooltip" title="Delete Receipt"
                                                    data-original-title="Delete Receipt">
                                                    <i class="fa fa-trash text-danger"></i>
                                                </a>
                                                @endisok
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
        </div>
    </div>
@endsection
@push('js')
@endpush
