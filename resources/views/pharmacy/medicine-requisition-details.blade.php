@extends('layouts.structure')
@push('title')
    <title>Requisition Details</title>
@endpush
@push('css')
@endpush
@section('main-content')

    <div class="row">
        <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12">
            <div class="card">
                <div class="card-header d-block card_hearder_mimi">
                    <div class="row">
                        <div class="col-md-6 card-title card_hearder_mimi_text">
                            <h4 class="card-title">REQUISITION DETAILS </h4>
                        </div>
                    </div>
                </div>

                <div class="card-body" style="background-color:#c2e3b4">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row" style="font-size: 16px">
                                    <div class="col-md-2">
                                        <span>Requisition No :
                                        </span><span>{{ @$requisition_details->id }}
                                        </span>
                                    </div>
                                    <div class="col-md-3">
                                        <span>Requisition Date : </span><span>
                                            <?= date('d-m-Y h:i A', strtotime($requisition_details->date)) ?>
                                        </span>
                                    </div>
                                    <div class="col-md-4">
                                        <span>Requisition Created By :
                                        </span><span>{{ @$requisition_details->requested_by_name }}
                                        </span>
                                    </div>
                                    <div class="col-md-3">
                                        <span>Department :
                                        </span><span>{{ @$requisition_details->department_name }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered text-nowrap key-buttons border-left border-right border-bottom">
                            <thead class="bg-primary text-white">
                                <tr class="border-left">
                                    <th class="text-white">#</th>
                                    <th class="text-white">Medicine Name</th>
                                    <th class="text-white">Unit Qty</th>
                                    <th class="text-white">Unit</th>
                                    <th class="text-white">Sub Unit Qty</th>
                                    <th class="text-white">Sub Unit</th>

                                </tr>
                            </thead>
                            <tbody>
                                @if (isset($requisition_item) && $requisition_item != '')
                                    @foreach ($requisition_item as $requisition)
                                        <tr>
                                            <th scope="row">{{ $loop->iteration }}</th>
                                            <td>{{ @$requisition->medicine_real_name }}({{ @$requisition->category_name }})
                                            </td>

                                            <td>{{ @$requisition->unit_qty }}</td>
                                            <td>{{ @$requisition->unit }}</td>
                                            <td>{{ @$requisition->sub_unit_qty }}</td>
                                            <td>{{ @$requisition->sub_unit }}</td>

                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- bd -->
            </div>

        </div>
    </div>

@endsection
