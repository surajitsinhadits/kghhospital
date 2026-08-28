@extends('layouts.structure')
@push('title')
    <title>Create Bill</title>
@endpush
@push('css')
@endpush
@section('main-content')
<div class="row">
    <div class="card">

        <div class="card-body">
            <div class="row">
                <div class="col-md-3 leftside_fixarea">
                    <x-billbar section="{{ $section }}" id="{{ $section_id }}" type="sec" />
                </div>
                <div class="col-md-9 rightside_fixarea" style="border:2px solid black">
                    <form action="{{ route('ipd.save-advance-amount') }}" method="POST">
                        @csrf
                        <input type="hidden" name="patient_id" value="{{ $ipd_details->patient_id }}" />
                        <input type="hidden" name="section" value="{{ @$section }}" />
                        <input type="hidden" name="section_id" value="{{ $ipd_details->id }}" />


                        <h5 class="text-blue"> <i class="fa fa-cash text-orange"></i>Advance Cash : </h5>
                        <div class="row">
                            <div class="col-lg-12 ">
                                <div class="row">
                                    <div class="col-md-3" style="margin: 16px 0px 0px 0px">
                                        <label for="payment_date" class="form-label">Date <span
                                                class="text-danger">*</span></label>
                                        <input type="text" class="form-control dateTimePickr" id="payment_date"
                                            name="payment_date" required value="{{ date('d-m-Y h:i A') }}">
                                        @error('payment_date')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-3" style="margin: 16px 0px 0px 0px">
                                        <label class="form-label">Payment Mode</label>
                                        <select id="payment_mode" class="form-control select2-show-search"
                                            name="payment_mode">
                                            <option value="Cash">Cash </option>
                                            <option value="UPI"> UPI</option>
                                            <option value="Transfer to Bank Account"> Transfer to Bank Account</option>
                                            <option value="Cheque"> Cheque</option>
                                            <option value="Other"> Other</option>
                                            <option value="Online"> Online</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3" style="margin: 16px 0px 0px 0px">
                                        <label class="form-label"> Amount </label>
                                        <input type="text" name="payment_amount" id="payment_amount"
                                            class="form-control" />
                                    </div>
                                    <div class="col-md-3" style="margin: 16px 0px 0px 0px">
                                        <label class="form-label">Bank </label>
                                        <select class="form-control select2-show-search" name="bank_name">
                                            <option value="">Select</option>
                                            <option value="Axis Bank"> Axis Bank</option>
                                            <option value="Canara Bank"> Canara Bank</option>
                                            <option value="State Bank"> State Bank</option>
                                        </select>
                                    </div>

                                </div>
                            </div>
                        </div>




                        <div class="modal-footer justify-content-center">
                            <button class="btn btn-primary btn-sm" type="submit" name="save" value="save"><i
                                    class="fa fa-file text-success"></i> Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('js')

@endpush
