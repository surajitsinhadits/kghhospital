@extends('layouts.structure')
@push('title')
    <title>Food Delivery</title>
@endpush
@push('css')

@endpush
@section('main-content')
<div class="row">
    <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12">
        <div class="card">
            <div class="card-header card_hearder_mimi justify-content-between">
                <h4 class="card-title card_hearder_mimi_text">Patient List</h4>
            </div>
            <div class="card-body">
                <div class="card-header d-block">
                    <form method="GET">
                        <div class="row justify-content-center mb-2">
                            <div class="form-row align-items-center">
                                <div class="col-auto">
                                    <label class="sr-only" for="inlineFormInputGroup">Username</label>
                                    <div class="input-group mb-2">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text" style="width: 130px;">Choose Date</div>
                                        </div>
                                        <input type="text" value="{{ dateFor($search_data) }}" class="form-control datePickr" name="date" placeholder="Choose Date">
                                    </div>
                                </div>
                                <div class="col-auto" style="top: -2px;">
                                    <button type="submit" class="btn btn-primary btn-sm py-2 px-4 mr-1">Search</button>
                                    <a class="btn btn-warning btn-sm py-2 px-4" href="{{ route('kt.food-delivery') }}">Reset</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered datatable-all">
                        <thead>
                            <tr class="text-center">
                                <th>Sl. No.</th>
                                <th>Patient Name (UHID)</th>
                                <th>Ward</th>
                                <th>Bed</th>
                                <th>Diet Type</th>
                                <th>Breakfast @if ($search_data->isToday())<input type="checkbox" onchange="check_all_row('breakfast', this)" />@endif</th>
                                <th>Lunch @if ($search_data->isToday())<input type="checkbox" onchange="check_all_row('lunch', this)" />@endif</th>
                                <th>Dinner @if ($search_data->isToday())<input type="checkbox" onchange="check_all_row('dinner', this)" />@endif</th>
                                <th>Snack @if ($search_data->isToday())<input type="checkbox" onchange="check_all_row('snack', this)" />@endif</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($patients as $diet)
                            <tr class="text-center">
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $diet->name }} ({{ $diet->patient_uhid ?? $diet->patient_id }})</td>
                                <td>{{ $diet->ward_name }}</td>
                                <td>{{ $diet->bed_name }}</td>
                                <td><span class="badge badge-gradient-primary mx-2">{{ $diet->diet_types }}</span></td>
                                <td>
                                    @if ($search_data->isToday())
                                    <input type="checkbox" {{ @$diet->last_delivery->breakfast == 1 ? 'checked' : '' }} value="{{ $diet->patient_id.'_'.$diet->id }}" class="breakfast" onchange="UpdateFood('breakfast', this)">
                                    @else
                                    {!! @$diet->last_delivery->breakfast == 1 ? '<i class="fas fa-check text-success"></i>' : '<i class="fas fa-times text-danger"></i>' !!}
                                    @endif
                                </td>
                                <td>
                                    @if ($search_data->isToday())
                                    <input type="checkbox" {{ @$diet->last_delivery->lunch == 1 ? 'checked' : '' }} value="{{ $diet->patient_id.'_'.$diet->id }}" class="lunch" onchange="UpdateFood('lunch', this)">
                                    @else
                                    {!! @$diet->last_delivery->lunch == 1 ? '<i class="fas fa-check text-success"></i>' : '<i class="fas fa-times text-danger"></i>' !!}
                                    @endif
                                </td>
                                <td>
                                    @if ($search_data->isToday())
                                    <input type="checkbox" {{ @$diet->last_delivery->dinner == 1 ? 'checked' : '' }} value="{{ $diet->patient_id.'_'.$diet->id }}" class="dinner" onchange="UpdateFood('dinner', this)">
                                    @else
                                    {!! @$diet->last_delivery->dinner == 1 ? '<i class="fas fa-check text-success"></i>' : '<i class="fas fa-times text-danger"></i>' !!}
                                    @endif
                                </td>
                                <td>
                                    @if ($search_data->isToday())
                                    <input type="checkbox" {{ @$diet->last_delivery->snack == 1 ? 'checked' : '' }} value="{{ $diet->patient_id.'_'.$diet->id }}" class="snack" onchange="UpdateFood('snack', this)">
                                    @else
                                    {!! @$diet->last_delivery->snack == 1 ? '<i class="fas fa-check text-success"></i>' : '<i class="fas fa-times text-danger"></i>' !!}
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('js')
<script>
    function check_all_row(val, checkbox) {
        $("."+val).prop("checked", $(checkbox).prop("checked"));
        let checkboxData = [];

        $("." + val).each(function() {
            checkboxData.push({
                value: this.value,
                checked: this.checked ? 1 : 0
            });
        });

        $.ajax({
            url: "{{ route('kt.update-multi-delivery') }}",
            type: 'POST',
            data: {
                data: checkboxData,
                type: val,
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                if(response){
                    toastr.success("Success");
                }else{
                    toastr.error("Failed");
                    setTimeout(function() {
                        window.location.reload();
                    }, 1000);
                }
            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
            }
        });
    }
    function UpdateFood(type, e){
        $.ajax({
            url: "{{ route('kt.update-delivery') }}",
            type: 'POST',
            data: {
                data_id: e.value,
                value: e.checked ? 1 : 0,
                type: type,
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                if(response){
                    toastr.success("Success");
                }else{
                    toastr.error("Failed");
                    setTimeout(function() {
                        window.location.reload();
                    }, 1000);
                }
            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
            }
        });
    }
</script>
@endpush
