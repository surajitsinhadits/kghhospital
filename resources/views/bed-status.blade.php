@extends('layouts.structure')
@push('title')
    <title>Bed Status</title>
@endpush
@push('css')
@endpush
@section('main-content')
    <div class="row">
        <div class="card">
            <div class="card-header d-block card_hearder_mimi">
                <div class="row">
                    <div class="col-md-6 card-title ">
                        <h4 class="card-title card_hearder_mimi_text">BED STATUS </h4>
                    </div>
                </div>
            </div>
            <div class="card-header" style="background-color: #f1f1f1">
                <div class="row justify-content-between w-100">
                    <div class="text-left">
                        <div class="d-flex">
                            {{-- <div style="height: 15px;width:15px;background-color:#ff9191; margin-right:10px;"></div> BOOKED BED --}}
                            <div style="height: 15px;width:15px;background-color:#ffcc90;margin-right:10px;"></div> USED BED (IPD PATIENT)
                            <div style="height: 15px;width:15px;background-color:#8fff8f;margin-right:10px; margin-left: 55px;"></div> USED BED (DAYCARE/DIALYSIS PATIENT)
                            <div style="height: 15px;width:15px;background-color:#86d8ff;margin-right:10px;margin-left: 55px;"></div> FREE BED
                        </div>
                    </div>
                    <form class="text-right" method="GET">
                        <div class="form-inline d-flex">
                            <input name="bed" type="text" class="w-50" placeholder="Search By Bed No...">
                            <button type="submit" class="btn btn-primary btn-sm py-2 ml-1"><i class="fa fa-search"></i> Search</button>
                            <a href="{{ route('bed-status') }}" class="btn btn-warning btn-sm py-2 ml-1">Reset</a>
                        </div>
                    </form>
                </div>
            </div>
            @foreach ($wards as $item)
            <div class="card-header" style="background-color: rgb(38 116 94);color: yellow;">
                <h4 class="card-title">{{ $item->ward_name }}</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    @foreach ($item->beds as $bed)
                        <div class="col-md-1">
                            <div class="hospital_cardarea" style="background-color: {{ $bed->is_used == 'yes' ? ($bed->type == 'IPD' ? '#ffcc90' : '#8fff8f') : '#86d8ff' }}" @if($bed->is_used == 'yes') data-placement="left" data-toggle="tooltip" data-original-title="{{ @$bed->info }}" @endif>
                                @if ($bed->is_used == 'no')
                                <a href="#" onclick="booking_model('{{ $bed->bed_name }}','{{ $bed->id }}')">
                                    <i class="fas fa-calendar-check" style="position: absolute; top: 5px; right: 15px; color: #ff0000; cursor: pointer;"></i>
                                </a>
                                @endif
                                <a href="{{ $bed->is_used == 'yes' ? @$bed->route : '#' }}">
                                    <i class="fa fa-bed text-white fa-3x"></i>
                                    <h6 style="color: #45487a;font-weight: 600;font-size: 15px;text-align: center;">{{ $bed->bed_name }}</h6>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            @endforeach
        </div>
    </div>
    <div class="modal" id="modaldemo1">
        <div class="modal-dialog" style="width:700px" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header">
                    <h6 class="modal-title">Booking</h6>
                    <span id="bed_name" style="font-size: 16px;margin-left: 12px; color: #ff9191;"></span>
                    <button aria-label="Close" class="close" data-dismiss="modal" type="button">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="#" method="POST">
                        @csrf
                        <input type="hidden" id="bed_id" name="bed_id" value="">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="form-group">
                            <label for="phone">Phone</label>
                            <input type="text" class="form-control" id="phone" name="phone" required>
                        </div>
                        <div class="form-group">
                            <label for="address">Address</label>
                            <textarea class="form-control" id="address" name="address" rows="3" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="date_of_booking">Date of Booking</label>
                            <input type="text" class="form-control datePickr" placeholder="Choose Date" id="date_of_booking" name="date_of_booking" required>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-indigo" type="submit">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
<script>
    function booking_model(bed_name, bed_id) {
        $('#bed_name').text(bed_name);
        $('#bed_id').val(bed_id);
        // $("#modaldemo1").modal('show');
    }
</script>
@endpush
