@extends('layouts.structure')
@push('title')
    <title>ITEM</title>
@endpush
@push('css')
<style>
</style>
@endpush
@section('main-content')
    <div class="row">
        <div class="col-12">
            <form action="{{ route('optical.update-item', @$response->id ?? 0) }}" method="POST" id="yourFormId">
                @csrf
                <input type="hidden" id="item_id" name="item_id" value="{{ @$response->id ?? 0 }}">
                <div class="tab-content">
                    <div class="tab-pane active" id="tab-7">
                        <div class="card">
                            <div class="card-header card_hearder_mimi">
                                <h4 class="card_hearder_mimi_text">ADD NEW ITEM</h4>
                            </div>
                            <div class="card-body hospital_allcardbodydesign ">
                                <div class="">
                                    <div class="row">
                                        <div class="col-lg-12 ">
                                            <div class="main-profile-contact-list ">
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <div class="input-group">
                                                            <label>Item Type<span class="required"> *</span></label>
                                                            <div class="input-group">
                                                                <select name="type_id" id="type_id" class="form-control select2-show-search">
                                                                    <option value="">Select One</option>
                                                                    @if(isset($item_type))
                                                                    @foreach($item_type as $value)
                                                                    <option value="{{$value->id}}" {{ old('type_id',@$response->type_id) == $value->id ? 'selected' : '' }}>{{$value->type_name}}</option>
                                                                    @endforeach
                                                                    @endif
                                                                </select>
                                                            </div>
                                                            @error('type_id')
                                                            <small class="text-danger">{{ $message }}</small>
                                                            @enderror
                                                        </div>
                                                    </div>

                                                     <div class="col-md-3">
                                                        <div class="input-group">
                                                            <label>Item Category<span class="required"> *</span></label>
                                                            <div class="input-group">
                                                                <select name="category_id" id="category_id" class="form-control select2-show-search">
                                                                    <option value="">-- Select One ---</option>
                                                                    @if(isset($item_category))
                                                                    @foreach($item_category as $value)
                                                                    <option value="{{$value->id}}" {{ old('category_id', @$response->category_id) == $value->id ? 'selected' : '' }}>{{$value->category_name}}</option>
                                                                    @endforeach
                                                                    @endif
                                                                </select>
                                                            </div>
                                                            @error('category_id')
                                                            <small class="text-danger">{{ $message }}</small>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="input-group">
                                                            <label>Item Sub Category</label>
                                                            <div class="input-group">
                                                                <select name="sub_category_id" id="sub_category_id" class="form-control select2-show-search">
                                                                    <option value="">-- Select Subcategory --</option>
                                                                </select>
                                                            </div>
                                                            @error('sub_category_id')
                                                            <small class="text-danger">{{ $message }}</small>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="input-group">
                                                            <label class="inventoryitemedit">Item Name<span class="required"> *</span></label>
                                                            <input type="text" id="item_name" name="item_name" value="{{ old('item_name', @$response->item_name) }}" >
                                                            @error('item_name')
                                                            <small class="text-danger">{{ $message }}</small>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4 itemeditinventory">
                                                        <div class="input-group">
                                                            <label>Low Level<span class="required"> *</span></label>
                                                            <input type="text" id="low_level" name="low_level" value="{{ old('low_level', @$response->low_level) }}" >
                                                            @error('low_level')
                                                            <small class="text-danger">{{ $message }}</small>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4 itemeditinventory" style="margin: 51px 0px 0px 0px">
                                                        <label class="form-label">Company </label>
                                                        <select name="company_id" class="form-control select2-show-search">
                                                            <option value="">Select One</option>
                                                            @foreach ($item_company as $item)
                                                            <option value="{{  $item->id }}" {{ old('company_id', @$response->company_id) == $item->id ? 'selected' : '' }}>{{ $item->company_name }}</option>
                                                            @endforeach
                                                        </select>
                                                        @error('company_id')
                                                        <small class="text-danger">{{ $message }}</small>
                                                        @enderror
                                                    </div>
                                                    <div class="col-md-4 itemeditinventory">
                                                        <div class="input-group">
                                                            <label>HSN or SAC No</label>
                                                            <input type="text" id="hsn_sac_no" name="hsn_sac_no" value="{{ old('hsn_sac_no', @$response->hsn_sac_no) }}">
                                                            @error('hsn_sac_no')
                                                            <small class="text-danger">{{ $message }}</small>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    
                                                    @if( empty($response->id) )

                                                    <div class="col-md-3 itemeditinventoryonee">
                                                        <div class="input-group">
                                                            <label>Item Unit<span class="required"> *</span></label>
                                                            <div class="input-group">
                                                                <select id="unit_id" name="unit_id" class="form-control select2-show-search" >
                                                                    <option value="">Select Unit</option>
                                                                    @foreach ($unit as $item)
                                                                    <option value="{{  $item->id }}" {{ old('unit_id', @$response->unit_id) == $item->id ? 'selected' : '' }}>{{ $item->unit }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            @error('unit_id')
                                                            <small class="text-danger">{{ $message }}</small>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 itemeditinventoryonee">
                                                        <div style="margin-top: 30px;font-size: 20px ">
                                                            <div class="row" style="background-color:#bdbdbd;border-radius: 50px">
                                                                <div class="col-md-2 mb-3 itemeditinventorytwo"
                                                                    style="margin-top: 7px;margin-left: 24%;">
                                                                    <div class="input-group">
                                                                        <span class="required"> *</span><span style="font-size: 26px">1 Unit</span>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-1 mb-3 itemeditinventorytwo" style="margin-top: 10px;">
                                                                    <div class="input-group">
                                                                        <label style="font-size: 32px"> = </label>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3 mb-3 itemeditinventory1">
                                                                    How many Sub Unit ? <input type="text" name="sub_unit_no" id="sub_unit_no" value="{{ old('sub_unit_no', @$response->sub_unit_no) }}" >
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3 mb-3 itemeditinventoryonee">
                                                        <div class="input-group">
                                                            <label>Item Sub Unit<span class="required"> *</span></label>
                                                            <div class="input-group">
                                                                <select id="sub_unit_id" name="sub_unit_id" class="form-control select2-show-search" >
                                                                    <option value="">Select Sub Unit</option>
                                                                    @foreach ($unit as $item)
                                                                    <option value="{{  $item->id }}" {{ old('sub_unit_id', @$response->sub_unit_id) == $item->id ? 'selected' : '' }}>{{ $item->unit }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            @error('sub_unit_id')
                                                            <small class="text-danger">{{ $message }}</small>
                                                            @enderror
                                                        </div>
                                                    </div>

                                                    @endif

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer w-100">
                                <button class="btn btn-primary text-center px-5" type="submit" name="submit" value="submit">
                                    <i class="fa fa-file text-success"></i> Save
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
@push('js')
<script>
    $(document).ready(function() {

        $('#yourFormId').submit(function(e) {
            e.preventDefault();

            let item_id = $('#item_id').val().trim();
            if(item_id){
                
                let type_id = $('#type_id').val().trim();
                let category_id = $('#category_id').val().trim();
                let item_name = $('#item_name').val().trim();
                let low_level = $('#low_level').val().trim();
                
                const fields = ["type_id", "category_id", "item_name", "low_level"];

                let isValid = true;

                // Validation for required fields
                fields.forEach(field => {
                    let inputField = $(`#${field}`);
                    if (inputField.val().trim()) {
                        inputField.removeClass(
                        'border border-danger'); // Remove red border if field is filled
                    } else {
                        inputField.addClass(
                        'border border-danger'); // Add red border if field is empty
                        isValid = false;
                    }
                });

                if (!isValid) {
                    alert('Please fill all required fields.');
                    return;
                }

                // If everything is valid, allow form submission
                $(this).unbind('submit').submit();

            }else{

                let type_id = $('#type_id').val().trim();
                let category_id = $('#category_id').val().trim();
                let item_name = $('#item_name').val().trim();
                let low_level = $('#low_level').val().trim();
                let unit_id = $('#unit_id').val().trim();
                let sub_unit_no = $('#sub_unit_no').val().trim();
                let sub_unit_id = $('#sub_unit_id').val().trim();

                const fields = ["type_id", "category_id", "item_name", "low_level", "unit_id","sub_unit_no", "sub_unit_id"];

                let isValid = true;

                // Validation for required fields
                fields.forEach(field => {
                    let inputField = $(`#${field}`);
                    if (inputField.val().trim()) {
                        inputField.removeClass(
                        'border border-danger'); // Remove red border if field is filled
                    } else {
                        inputField.addClass(
                        'border border-danger'); // Add red border if field is empty
                        isValid = false;
                    }
                });

                if (!isValid) {
                    alert('Please fill all required fields.');
                    return;
                }

                // If everything is valid, allow form submission
                $(this).unbind('submit').submit();

            }

        });

        $('#category_id').on('change', function () {
            let parentId = $(this).val();
            if (parentId) {
                $.ajax({
                    url: "{{ route('optical.get-subcategories', ':id') }}".replace(':id', parentId),
                    type: 'GET',
                    dataType: 'json',
                    success: function (data) {
                        $('#sub_category_id').empty().append('<option value="">-- Select Subcategory --</option>');
                        $.each(data, function (key, value) {
                            $('#sub_category_id').append('<option value="' + value.id + '">' + value.category_name + '</option>');
                        });
                    }
                });
            } else {
                $('#sub_category_id').empty().append('<option value="">-- Select Subcategory --</option>');
            }
        });

    });


    </script>
@endpush

