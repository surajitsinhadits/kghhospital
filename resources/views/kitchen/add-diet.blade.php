
@extends('layouts.structure')
@push('title')
    <title>Diet Charts Assign</title>
@endpush
@push('css')
@endpush
@section('main-content')
    <div class="row">
        <div class="card" id="tabs-style4">
            <div class="card-header card_hearder_mimi">
                <div class="card-title card_hearder_mimi_text">
                    Diet Charts Assign
                </div>
            </div>
            <div class="card-body">
                <form action="{{ route('kt.update-charts_assign', @$edit->id) }}" method="POST">
                    @csrf
                    <div class="row justify-content-center">
                        <div class="col-md-5">
                            <div class="form-group">
                                <label for="doctor">Patient <span class="text-danger">*</span></label>
                                <select id="diet-type" class="form-control select2-show-search" name="patient">
                                    <option value="">Select Patient</option>
                                    @foreach ($patients as $item)
                                        <option value="{{ $item->id }}" {{ old('patient', @$edit->patient_id) == $item->id ? 'selected' : '' }}>{{ $item->name }} ({{ $item->gender }}, {{ $item->dob_year }}Y)</option>
                                    @endforeach
                                </select>
                                @error('patient')
                                <small class="text-danger">{{$message}}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="form-group">
                                <label for="doctor">Diet Type <span class="text-danger">*</span></label>
                                <select id="diet-type" class="form-control select2-show-search" name="diet_type">
                                    <option value="">Select Diet Type</option>
                                    @foreach ($diet_types as $item)
                                        <option value="{{ $item->id }}" {{ old('diet_type', @$edit->diet_id) == $item->id ? 'selected' : '' }}>{{ $item->diet_types }}</option>
                                    @endforeach
                                </select>
                                @error('diet_type')
                                <small class="text-danger">{{$message}}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="form-group">
                                <label for="">From Date <span class="text-danger">*</span></label>
                                <input type="text" name="from_date" class="form-control datePickr" value="{{dateFor(old('from_date', @$edit->from_date))}}" />
                                @error('from_date')
                                <small class="text-danger">{{$message}}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="form-group">
                                <label for="">To Date <span class="text-danger">*</span></label>
                                <input type="text" name="to_date" class="form-control datePickr" value="{{dateFor(old('to_date', @$edit->to_date))}}" />
                                @error('to_date')
                                <small class="text-danger">{{$message}}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="form-group">
                                <label for="">Note</label>
                                <textarea name="note" class="form-control" rows="8">{{old('node', @$edit->note)}}</textarea>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="form-group">
                                <label for="">Restrictions</label>
                                <textarea name="restrictions" class="form-control" rows="8">{{old('restrictions', @$edit->restrictions)}}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-md-2 text-center">
                            <button class="btn btn-primary" type="submit">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('js')
@endpush
