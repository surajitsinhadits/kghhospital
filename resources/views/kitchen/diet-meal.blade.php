@extends('layouts.structure')
@push('title')
    <title>Diet Meal Setup</title>
@endpush
@push('css')
@endpush
@section('main-content')
    <div class="row">
        <div class="card" id="tabs-style4">
            <div class="card-header card_hearder_mimi">
                <div class="card-title card_hearder_mimi_text">
                    DIET MEAL SETUP
                </div>
            </div>
            <div class="card-body">
                <form action="{{Route('kt.diet-meal')}}" method="POST">
                    @csrf
                    <div class="row justify-content-center">
                        <div class="form-group col-md-3">
                            <label for="doctor">Diet Type <span class="text-danger">*</span></label>
                            <select id="diet-type" class="form-control select2-show-search" name="diet_type">
                                <option value="">Select Diet Type</option>
                                @foreach ($diet_types as $item)
                                    <option value="{{ $item->id }}" {{ @$diet_meal->diet_id == $item->id ? 'selected' : '' }}>{{ $item->diet_types }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-2 appoinmentdays">
                            <button type="submit" class="btn btn-primary" style="margin-top: 28px"><i class="fa fa-search"></i> Search</button>
                            <a href="{{Route('kt.diet-meal')}}" class="btn btn-warning mx-2" style="margin-top: 28px;">Reset</a>
                        </div>
                    </div>
                </form>
            </div>
            @if(@$diet_meal)
            <div class="card-body">
                <form action="{{ route('kt.update-diet-meal', $diet_meal->id) }}" method="post">
                    @csrf
                    <div class="row justify-content-center">
                        <div class="col-md-5">
                            <div class="form-group">
                                <label for="">Breakfast</label>
                                <textarea name="breakfast" class="form-control" rows="8">{{ $diet_meal->breakfast }}</textarea>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="form-group">
                                <label for="">Lunch</label>
                                <textarea name="lunch" class="form-control" rows="8">{{ $diet_meal->lunch }}</textarea>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="form-group">
                                <label for="">Dinner</label>
                                <textarea name="dinner" class="form-control" rows="8">{{ $diet_meal->dinner }}</textarea>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="form-group">
                                <label for="">Snack</label>
                                <textarea name="snack" class="form-control" rows="8">{{ $diet_meal->snack }}</textarea>
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
            @endif
        </div>
    </div>
@endsection
@push('js')
@endpush
