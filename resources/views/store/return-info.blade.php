@extends('layouts.structure')
@push('title')
    <title>Return Details</title>
@endpush
@push('css')
@endpush
@section('main-content')
<div class="row">
    <div class="card">
        <div class="card-header d-block card_hearder_mimi">
            <div class="row">
                <div class="col-md-6 card-title card_hearder_mimi_text">
                   Return Details
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="col-md-12" style="float: left;">
                <div class="row">
                    <div class="col-md-4">
                        <span class="requisition_header">Return ID : </span><span
                            class="requisition_text">{{@$data->id}}
                        </span>
                    </div>
                    <div class="col-md-4">
                        <span class="requisition_header">Return Date : </span><span
                            class="requisition_text">
                            {{dateFor($data->return_date, true)}}
                        </span>
                    </div>
                    <div class="col-md-4">
                        <span class="requisition_header">Request By : </span><span
                            class="requisition_text">{{@$data->created_by}}
                        </span>
                    </div>
                    <div class="col-md-4">
                        <span class="requisition_header">Remarks : </span><span class="requisition_text"
                            style="color:blue">{{@$data->remarks}}
                        </span>
                    </div>
                    @if(@$data->department_name)
                    <div class="col-md-4">
                        <span class="requisition_header">Department : </span><span class="requisition_text"
                            style="color:blue"> {{@$data->department_name }}
                        </span>
                    </div>
                    @elseif(@$data->vendor_name)
                    <div class="col-md-4">
                        <span class="requisition_header">Vendor : </span><span class="requisition_text"
                            style="color:blue"> {{@$data->vendor_name }}
                        </span>
                    </div>
                    @endif
                    <div class="col-md-4">
                        {!! @$data->status == 0 ? '<span style="color :#534adf ;font-size: 18px; font-weight: 600;">Pending</span>' : (@$data->status == 1 ? '<span style="color:#158f34;font-size: 18px; font-weight: 600;">Approved</span>' : '<span style="color :#c01e1e ;font-size: 18px; font-weight: 600;">Rejected</span>') !!}
                    </div>
                </div>

            </div>
            <div class="table-responsive mt-4">
                <table class="table table-striped card-table table-vcenter text-nowrap border">
                    <thead class="bg-primary text-white">
                        <tr class="border">
                            <th  class="text-white border">#</th>
                            <th  class="text-white border">Item Name</th>
                            <th  class="text-white border">Type</th>
                            <th  class="text-white border">Batch No</th>
                            <th  class="text-white border">Note</th>
                            <th  class="text-white border">Unit</th>
                            <th  class="text-white border">Sub-Unit</th>
                            <th  class="text-white border">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($item_list ?? [] as $list)
                        <tr>
                            <th scope="row" class="border">{{ $loop->iteration }}</th>
                            <td class="border">{{$list->item_name}} </td>
                            <td class="border">{{ucwords($list->type)}} </td>
                            <td class="border">{{$list->part_no}} </td>
                            <td class="border">{{$list->note}} </td>
                            <td class="border">{{$list->unit_qty}} {{$list->unit}}</td>
                            <td class="border">{{$list->sub_unit_qty}} {{$list->sub_unit}}</td>
                            <td class="border">{!! $list->status == 0 ? '<span class="badge badge-primary">Pending</span>' : ($list->status == 1 ? '<span class="badge badge-success">Completed</span>' : '<span class="badge badge-danger">Rejected</span>') !!}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
@push('js')
@endpush

