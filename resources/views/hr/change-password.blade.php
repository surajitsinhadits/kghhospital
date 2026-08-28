@extends('layouts.structure')
@push('title')
    <title>Change Password</title>
@endpush
@push('css')
@endpush
@section('main-content')
<div class="row">
    <div class="card">
        <div class="card-header card_hearder_mimi">
            <h4 class="card-title card_hearder_mimi_text">CHANGE PASSWORD</h4>
        </div>

        <!-- ================== message============================== -->

        <!-- ================== message============================== -->

        <div class="card-body">
            <form class="form-horizontal" method="POST" action="{{ route('save-change-password') }}">
                @csrf
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-4" style="margin-top: 23px;">
                            <label class="form-label">Old Password <span class="text-danger">*</span></label>
                            <input type="text" required class="form-control" value="{{old('old_password')}}"  name="old_password" placeholder="Old Password">
                            @error('old_password')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-md-4"  style="margin-top: 23px;">
                            <label class="form-label">New Password <span class="text-danger">*</span></label>
                            <input type="text" required class="form-control" value="{{old('new_password')}}"  name="new_password" placeholder="New Password">
                            @error('new_password')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-md-4"  style="margin-top: 23px;">
                            <label class="form-label">Confirm Password <span class="text-danger">*</span></label>
                            <input type="text" required class="form-control" value="{{old('confirm_password')}}" name="confirm_password" placeholder="Confirm Password">
                            @error('confirm_password')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <button type="submit" class="btn btn-primary"><i class="fa fa-key"></i> Change Password</button>
                        </div>
                    </div>
                </div>

            </form>
        </div>
    </div>
</div>
@endsection
@push('js')
@endpush
