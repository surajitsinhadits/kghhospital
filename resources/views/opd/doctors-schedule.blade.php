@extends('layouts.structure')
@push('title')
    <title>Doctor Schedule</title>
@endpush
@push('css')
@endpush
@section('main-content')
    <div class="row">
        <div class="card" id="tabs-style4">
            <div class="card-header card_hearder_mimi">
                <div class="card-title card_hearder_mimi_text">
                    DOCTOR SCHEDULE
                </div>
            </div>
            <div class="card-body">
                <form action="{{Route('opd.doctors-schedule')}}" method="POST">
                    @csrf
                    <div class="row justify-content-center">
                        <div class="form-group col-md-3">
                            <label for="doctor">Doctor <span class="text-danger">*</span></label>
                            <select id="doctor" class="form-control select2-show-search" name="doctor">
                                <option value="">Select Doctor</option>
                                @foreach ($doctor as $item)
                                    <option value="{{ $item->id }}">Dr. {{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-2 appoinmentdays">
                            <button type="submit" class="btn btn-primary" style="margin-top: 28px"><i class="fa fa-search"></i> Search</button>
                            <a href="{{Route('opd.doctors-schedule')}}" class="btn btn-warning mx-2" style="margin-top: 28px;">Reset</a>
                        </div>
                    </div>
                </form>
            </div>
            @if(count($uniqueDates) > 0)
            <div class="card-body">
                <div class="d-md-flex">
                    <div class="border" style="width: 25%;">
                        <div class="panel panel-primary tabs-style-4">
                            <div class="tabs-menu">
                                <ul class="nav panel-tabs mt-2 ml-5">
                                    @foreach ($uniqueDates as $value)
                                        @php
                                            $formattedDate = (new DateTime($value))->format('d M Y');
                                            $dayOfWeek = (new DateTime($value))->format('l');
                                        @endphp
                                        <form method="POST" action="{{Route('opd.get-all-time-schedule')}}">
                                            @csrf
                                            <input type="hidden" name="doctor_id" value="{{ $doctor_id }}" />
                                            <input type="hidden" name="date" value="{{ $value }}" />
                                            <button class="btn btn-primary" style="margin-bottom: 10px; padding:4px 14px; margin-right:7px;font-size:14px;">
                                                @if (@$p_date == $value)
                                                    <span style="color:yellow"><i class="fa fa-calendar"></i>
                                                        {{ $formattedDate }}<br>
                                                        {{ $dayOfWeek }}
                                                    </span>
                                                @else
                                                    <i class="fa fa-calendar"></i> {{ $formattedDate }}<br>
                                                    {{ $dayOfWeek }}
                                                @endif
                                            </button>
                                        </form>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="tabs-style-4" style="width: 80%;">
                        <div class="panel-body tabs-menu-body">
                            <div class="tab-content">
                                <div class="row">
                                    @if (@$uniqueDates_withtiming[0]->from_time != null)
                                        @foreach ($uniqueDates_withtiming as $value)
                                            <div class="col-xl-2 col-lg-6 col-md-12" style="margin: 5px 21px 0px 0px !important">
                                                @if ($value->booked < $value->patient_per_slot && $value->is_active == '1')
                                                    <form method="POST" action="{{ route('opd.add-enquiry') }}">
                                                        @csrf
                                                        <input name="slot_id" type="hidden" value="{{ @$value->id }}" />
                                                        <input name="from_time" type="hidden" value="{{ @$value->from_time }}" />
                                                        <input name="date" type="hidden" value="{{ @$p_date }}" />
                                                        <input name="doctor_id" type="hidden" value="{{ @$doctor_id }}" />
                                                        <button class="btn btn-success" type="submit">
                                                            <h2 class="mb-1 font-weight-bold">
                                                                {{ date('h:i A', strtotime($value->from_time)) }}
                                                                -
                                                                {{ date('h:i A', strtotime($value->to_time)) }}
                                                            </h2>
                                                            <span><b>{{ $value->booked }}</b> </span> /
                                                            <span><b>{{ $value->patient_per_slot }}</b></span>
                                                        </button>
                                                    </form>
                                                @else
                                                    <button class="btn btn-warning" type="button">
                                                        <h2 class="mb-1 font-weight-bold">
                                                            {{ date('h:i A', strtotime($value->from_time)) }}
                                                            -
                                                            {{ date('h:i A', strtotime($value->to_time)) }}
                                                        </h2>
                                                        <span><b>{{ $value->booked }}</b> </span> /
                                                        <span><b>{{ $value->patient_per_slot }}</b></span> @if($value->is_active == '0') || Deactivated @endif
                                                    </button>
                                                @endif
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
@endsection
@push('js')
@endpush
