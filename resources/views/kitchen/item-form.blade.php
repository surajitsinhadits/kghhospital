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
            <form action="{{ route('kt.update-item', @$response->id ?? 0) }}" method="POST" id="yourFormId">
                @csrf
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
                                                     <div class="col-md-2">
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
                                                            <label class="inventoryitemedit">Item Name<span class="required"> *</span></label>
                                                            <input type="text" id="item_name" name="item_name" value="{{ old('item_name', @$response->item_name) }}" >
                                                            @error('item_name')
                                                            <small class="text-danger">{{ $message }}</small>
                                                            @enderror
                                                        </div>
                                                    </div>
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
        });

    });
    </script>
@endpush

