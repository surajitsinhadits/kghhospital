@extends('layouts.structure')
@push('title')
    <title>Refund Lists</title>
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
                        <h3>*<u>All REFUND LIST</u> </h3>
                        <div class="row mt-5">
                            <div class="table-responsive">
                                <table id="example1" class="table table-bordered text-nowrap key-buttons datatable no-footer">
                                    <thead class="bg-primary text-white">
                                        <tr>
                                            <th>Refund ID</th>
                                            <th>From Bill ID</th>
                                            <th>Amount (₹)</th>
                                            <th>Date</th>
                                            <th>Refund By</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($refund_list as $item)
                                        <tr role="row">
                                            <td class="sorting_1">
                                                RF{{$item->refund_id}}
                                            </td>
                                            <td>{{$item->uid}}</td>
                                            <td>{{$item->amount}}</td>
                                            <td>{{dateFor($item->refund_at, true)}}</td>
                                            <td>{{$item->refund_name}}</td>
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
