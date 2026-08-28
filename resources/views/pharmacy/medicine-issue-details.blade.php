@extends('layouts.structure')
@push('title')
    <title>Issue Details</title>
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
                            <h4 class="card-title">ISSUE DETAILS </h4>
                        </div>
                    </div>
                </div>

                <div class="card-body" style="background-color:#c2e3b4">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row" style="font-size: 16px">
                                    <div class="col-md-2">
                                        <span>Issue No :
                                        </span><span>{{ @$issue_details->id }}
                                        </span>
                                    </div>
                                    <div class="col-md-3">
                                        <span>Issue Date : </span><span>
                                            <?= date('d-m-Y h:i A', strtotime($issue_details->issue_date)) ?>
                                        </span>
                                    </div>
                                    <div class="col-md-4">
                                        <span>Issued By :
                                        </span><span>{{ @$issue_details->issued_by_name }}
                                        </span>
                                    </div>
                                    <div class="col-md-3">
                                        <span>Department :
                                        </span><span>{{ @$issue_details->department_name }}
                                        </span>
                                    </div>
                                    <div class="col-md-2">
                                        <span>Requisition No of :
                                        </span><span>{{ @$issue_details->req_id }}
                                        </span>
                                    </div>
                                    <div class="col-md-3">
                                        <span>Edit By :
                                        </span><span>{{ @$issue_details->edit_by_name }}
                                        </span>
                                    </div>
                                    <div class="col-md-4">
                                           <span>Issue :
                                        </span>
                                        @if (@$issue_details->is_issued == 1)
                                            <span class="badge badge-success">Completed</span>
                                        @else
                                            <span class="badge badge-danger">Not Completed</span>
                                        @endif
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
                                    <th class="text-white">Batch No</th>
                                    <th class="text-white">Expiry Date</th>
                                    <th class="text-white">CGST</th>
                                    <th class="text-white">SGST</th>
                                    <th class="text-white">IGST</th>
                                    <th class="text-white">Unit Qty</th>
                                    <th class="text-white">Unit</th>
                                    <th class="text-white">Sub Unit Qty</th>
                                    <th class="text-white">Sub Unit</th>
                                    <th class="text-white">Rtae</th>
                                    <th class="text-white">MRP</th>
                                    <th class="text-white">Total Amount</th>

                                </tr>
                            </thead>
                            <tbody>
                                @if (isset($issued_item) && $issued_item != '')
                                    @foreach ($issued_item as $issue)
                                        <tr>
                                            <th scope="row">{{ $loop->iteration }}</th>
                                            <td>{{ @$issue->medicine_real_name }}({{ @$issue->category_name }})
                                            </td>
                                            <td>{{ @$issue->batch_no }}</td>
                                            <td>{{ @$issue->expiry_date }}</td>
                                            <td>{{ @$issue->cgst }}</td>
                                            <td>{{ @$issue->sgst }}</td>
                                            <td>{{ @$issue->igst }}</td>
                                            <td>{{ @$issue->unit_qty }}</td>
                                            <td>{{ @$issue->unit }}</td>
                                            <td>{{ @$issue->sub_unit_qty }}</td>
                                            <td>{{ @$issue->sub_unit }}</td>
                                            <td>{{ @$issue->rate }}</td>
                                            <td>{{ @$issue->mrp }}</td>
                                            <td>{{ @$issue->t_amount }}</td>

                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="row justify-content-end" style="margin-top: 20px;">
                    <div class="col-md-3 text-right">
                        <div
                            style="background-color: #f8f9fa; padding: 5px; border: 2px solid #007bff; border-radius: 8px;">
                            <span style="font-size: 20px; font-weight: bold; color: #333;">Total Issued Amount:</span>
                            <span
                                style="font-size: 24px; font-weight: bold; color: #007bff;">₹{{ number_format(@$issue_details->total_amount, 2) }}</span>
                        </div>
                    </div>
                </div>

                <!-- bd -->
            </div>

        </div>
    </div>
@endsection
