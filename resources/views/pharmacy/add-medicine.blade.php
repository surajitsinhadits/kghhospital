@extends('layouts.structure')

@push('title')
    <title>{{ $title }} - {{ hospital('title') }}</title>
@endpush

@section('main-content')
    <div class="row">
        <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12">
            <div class="card">
                <div class="card-header card_hearder_mimi">
                    <h4 class="card-title card_hearder_mimi_text">{{@$t}}</h4>
                </div>
                <div class="card-body">
                    <form
                        action="{{ $medicine ? route('pharmacy.update-medicine', $medicine->id) : route('pharmacy.update-medicine') }}"
                        method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-3">
                                <label for="medicine_name">Medicine Name<span class="text-danger">*</span> </label>
                                <input type="text" id="medicine_name" name="medicine_name"
                                    value="{{ old('medicine_name', $medicine->medicine_name ?? '') }}" />
                                @error('medicine_name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group col-md-3">
                                <label for="medicine_catagory">Medicine Category <span class="text-danger">*</span></label>
                                <select class="form-control select2-show-search" name="medicine_catagory"
                                    id="medicine_catagory">
                                    <option value="">Select One....</option>
                                    @foreach ($medicine_category as $item)
                                        <option value="{{ $item->id }}"
                                            @if (old('medicine_catagory')) {{ old('medicine_catagory') == $item->id ? 'selected' : '' }}
                                        @elseif(isset($medicine) && $medicine->medicine_catagory == $item->id)
                                            selected @endif>
                                            {{ $item->medicine_catagory_name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('medicine_catagory')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>


                            <div class="form-group col-md-3">
                                <label for="medicine_company">Medicine Company </label>
                                <input type="text" id="medicine_company" name="medicine_company"
                                    value="{{ old('medicine_company', $medicine->medicine_company ?? '') }}" />
                                @error('medicine_company')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group col-md-3">
                                <label for="medicine_company">Medicine Composition </label>
                                <input type="text" id="medicine_composition" name="medicine_composition"
                                    value="{{ old('medicine_composition', $medicine->medicine_composition ?? '') }}" />
                                @error('medicine_composition')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group col-md-3 ">
                                <label for="medicine_company">Medicine Group</label>
                                <input type="text" id="medicine_group" name="medicine_group"
                                    value="{{ old('medicine_group', $medicine->medicine_group ?? '') }}" />
                                @error('medicine_group')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group col-md-2">
                                <label for="unit">Unit <span class="text-danger">*</span></label>
                                <select class="form-control select2-show-search" name="unit" id="unit">
                                    <option value="">Select One ....</option>
                                    @foreach ($med_unit as $item)
                                        <option value="{{ $item->medicine_unit_name }}"
                                            @if (old('unit')) {{ old('unit') == $item->medicine_unit_name ? 'selected' : '' }}
                                            @elseif(isset($medicine) && $medicine->unit == $item->medicine_unit_name)
                                                selected @endif>
                                            {{ $item->medicine_unit_name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('unit')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group col-md-2">
                                <label for="unit">Sub Unit <span class="text-danger">*</span></label>
                                <select class="form-control select2-show-search" name="sub_unit" id="unit">
                                    <option value="">Select One ....</option>
                                    @foreach ($med_unit as $item)
                                        <option value="{{ $item->medicine_unit_name }}"
                                            @if (old('sub_unit')) {{ old('sub_unit') == $item->medicine_unit_name ? 'selected' : '' }}
                                            @elseif(isset($medicine) && $medicine->sub_unit == $item->medicine_unit_name)
                                                selected @endif>
                                            {{ $item->medicine_unit_name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('unit')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>




                            <div class="form-group col-md-3 ">
                                <label for="min_level">Enter Min Level<span class="text-danger">*</span></label>
                                <input type="text" id="min_level" name="min_level"
                                    value="{{ old('min_level', $medicine->min_level ?? '') }}" />
                                @error('min_level')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>


                            <div class="form-group col-md-2">
                                <label for="tax">GST</label>
                                <input type="text" id="tax" name="tax"
                                    value="{{ old('tax', $medicine->tax ?? '') }}" />
                                @error('tax')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="instore" style="margin-top: 30px;font-size: 20px ">
                            <div class="row">
                                <div class="col-lg-8" style="margin-left: 16%">
                                    <div class="row" style="background-color:#bdbdbd;border-radius: 50px">
                                        <div class="col-md-2 mb-3 " style="margin-top: 7px;margin-left: 24%;">
                                            <div class="input-group">
                                                <span style="font-size: 26px; margin-top: 9px;">1 Unit</span>
                                            </div>
                                        </div>
                                        <div class="col-md-1 mb-3 " style="margin-top: 15px;">
                                            <div class="input-group">
                                                <label style="font-size: 45px; margin-top: -12px;"> = </label>
                                            </div>
                                        </div>
                                        <div class="col-md-3 mb-3 " style="">
                                            How many Sub Unit ? <input type="text" name="unit_details"
                                                value="{{ old('unit_details', $medicine->unit_details ?? '') }}"
                                                id="unit_details">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>



                        <button type="submit" class="btn btn-primary mt-3">Save Medicine </button>

                </div>
                </form>
            </div>

        </div>
    </div>
@endsection

@push('js')
@endpush
