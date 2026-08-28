@extends('layouts.structure')
@push('title')
    <title>Billing Details</title>
@endpush
@push('css')
    <style>
        body::before {
            content: "";
            background-image: url("");
            background-size: 30%;
            background-repeat: no-repeat;
            background-position: center center;
            opacity: 0.2;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: 9999;
        }
    </style>
@endpush
@section('main-content')
    <div class="row">
        <div class="card ">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3 leftside_fixarea">
                        <div class="col-md-12">
                            <div style="border:2px solid black;">
                                <p class="bill_details_patient_details">Box Name : {{ $kitboxes->name }}</p>
                                <p class="bill_details_patient_details">Box id : <span
                                        id="patient_uhid">{{ $kitboxes->box_id }}</span></p>
                                <p class="bill_details_patient_details">Total Instruments : 5</p>

                                <p class="bill_details_patient_details">Last Used Date : 16/05/2025</p>
                            </div>
                            <div class="billimagearea">
                                <div class="row mt-6">
                                    <div class="col-lg-12 my-2" style="font-size: 18px;text-align: center;">
                                        <span style="color:blue;"> Details</span>
                                    </div>

                                    {{ $kitboxes->description }}

                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-9 rightside_fixarea" style="border:2px solid black">
                        <div class="bill_details_header">
                            <p class="bill_details_header1">{{ $kitboxes->name }}<span class="mx-2">||</span>
                                {{ $kitboxes->box_id }} <span class="mx-2">||</span> </p>
                            <p class="bill_details_header2">
                            </p>
                        </div>

                        <div class="row">
                            <div class="table-responsive" style="height: 300px;">
                                <table class="table table-striped card-table table-vcenter text-nowrap border">
                                    <thead class="bg-primary text-white">
                                        <tr class="border-left">
                                            <th class="text-white">#</th>
                                            <th class="text-white">Instrumental Name</th>
                                            <th class="text-white">Quantity</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($kitboxes->kitboxInstruments as $item)
                                            <tr style="background-color: #d5ffd5">
                                                <th scope="row">1</th>
                                                <th>{{ $item->instrument->name ?? 'Unknown' }}</th>
                                                <th> {{ $item->quantity }}</th>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <span style="font-size: 20px;font-weight:600">** <u>Used History </u> :</span>
                            <div class="table-responsive">
                                <table class="table table-striped card-table table-vcenter text-nowrap border">
                                    <thead class="bg-primary text-white">
                                        <tr class="border-left">
                                            <th class="text-white">#</th>
                                            <th class="text-white">Status</th>
                                            <th class="text-white">Used By</th>
                                            <th class="text-white">Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($used_history as $index => $item)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>
                                                    @php
                                                        switch ($item->status) {
                                                            case 0:
                                                                $statusText = 'In Use';
                                                                break;
                                                            case 1:
                                                                $statusText = 'Sent for Sterilization';
                                                                break;
                                                            case 2:
                                                                $statusText = 'Sterilized';
                                                                break;
                                                            case 3:
                                                                $statusText = 'Damaged';
                                                                break;
                                                            default:
                                                                $statusText = 'Unknown';
                                                                break;
                                                        }
                                                    @endphp
                                                    {{ $statusText }}
                                                </td>
                                                <td>{{ $item->name ?? 'Unknown' }}</td>
                                                <td>{{ \Carbon\Carbon::parse($item->created_at)->format('d M Y h:i A') }}
                                                </td>
                                            </tr>
                                        @endforeach

                                        @if (count($used_history) == 0)
                                            <tr>
                                                <td colspan="4" class="text-center text-muted">No usage history available
                                                </td>
                                            </tr>
                                        @endif
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
