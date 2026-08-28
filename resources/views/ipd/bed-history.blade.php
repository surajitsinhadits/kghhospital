@extends('layouts.structure')
@push('title')
    <title>Bed Shifting History</title>
@endpush
@push('css')
@endpush
@section('main-content')
    <div class="row">
        <div class="card ">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3 leftside_fixarea">
                        <x-billbar section="{{ $section }}" id="{{$section_id}}" type="sec" />
                    </div>

                    <div class="col-md-9 rightside_fixarea" style="border:2px solid black">
                        <h3><u>Bed Shifting History</u></h3>

                        <a style="margin-left: 86%;margin-top: -60px;" href="javascript:void(0);" id="toggleShiftingForm" class="btn btn-primary btn-sm">
                            <i class="fa fa-arrow-alt-circle-left"></i>
                            <b>BED SHIFTING</b>
                        </a>

                        <div class="d-none" id="shifting-form">
                            <form action="{{ route('ipd.update-bed') }}" method="POST">
                                @csrf
                                <input type="hidden" name="section" value="{{ $section }}">
                                <input type="hidden" name="section_id" value="{{ $section_id }}">
                                <div class="row my-3 justify-content-center">
                                    <div class="form-group col-md-3">
                                        <label for="from_time" class="form-label"> Date <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control dateTimePickr" value="{{ date('d-m-Y h:i A') }}" id="new_date" name="new_date" required>
                                    </div>

                                    <div class="form-group  col-md-3">
                                        <label for="ward" class="form-label"> Ward <span class="text-danger">*</span></label>
                                        <select name="ward" onchange="getWard(this.value)" class="form-control select2-show-search" id="bed_ward" required>
                                            <option value="">Select</option>
                                            @foreach ($wards as $itm)
                                            <option value="{{$itm->id}}">{{$itm->ward_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group  col-md-3">
                                        <label class="form-label"> Bed <span class="text-danger">*</span></label>
                                        <select name="bed" class="form-control select2-show-search" id="bed" required>
                                            <option value="">Select</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-1">
                                        <div class="mt-5">
                                            <button type="submit" class="btn btn-primary">Save </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-bordered text-nowrap datatable">
                                <thead class="bg-primary text-white">
                                    <tr class="border-left">
                                        <th class="text-white">Sl. No</th>
                                        <th class="text-white">Ward</th>
                                        <th class="text-white">Bed</th>
                                        <th class="text-white">Duration</th>
                                        <th class="text-white">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($history as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->ward_name }}</td>
                                        <td>{{ $item->bed_name }}</td>
                                        <td>
                                            <b>From : </b> {{ dateFor($item->from_date, true) }} <br>
                                            <b>To : </b> {{ $item->to_date ? dateFor($item->to_date, true) : 'Present' }}
                                        </td>
                                        <td>
                                            {!! $item->to_date ? '' : '<span class="badge badge-success">Present Here</span>' !!}
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
    </div>
@endsection
@push('js')
<script>
    document.getElementById('toggleShiftingForm').addEventListener('click', function() {
        var form = document.getElementById('shifting-form');
        form.classList.toggle('d-none');
    });
    function getWard(ward_id) {
        if (ward_id) {
            $('#bed').html('<option vaule="">Select Bed</option>');
            $.ajax({
                url: "{{ Route('get-beds') }}",
                type: "POST",
                data: {
                    _token: '{{ csrf_token() }}',
                    ward_id: ward_id,
                },
                success: function(response) {
                    if (response.success && (response.beds.length > 0)) {
                        $.each(response.beds, function(key, value) {
                            $('#bed').append(`<option value="${value.id}">${value.bed_name}</option>`);
                        });
                    }
                },
                error: function(error) {
                    console.log(error);
                }
            });
        }
    }
</script>
@endpush
