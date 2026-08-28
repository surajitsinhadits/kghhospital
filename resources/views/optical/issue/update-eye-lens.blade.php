@extends('layouts.structure')
@push('title')
    <title>Billing Details</title>
@endpush
@push('css')

@endpush
@section('main-content')
<div class="row">
    <div class="card ">
        <div class="card-body">
            <div class="row">
                <div class="col-md-3 leftside_fixarea">
                    <x-billbar section="op" id="{{$bill->id}}" type="bill" />
                </div>

                <div class="col-md-9 rightside_fixarea" style="border:2px solid black">
                    <div class="row">
        <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12">
            <form method="POST" id="myForm" action="{{ route('optical.update-eye-power', [ed($bill->section_id, true), ed($bill->patient_id, true)]) }}">
                @csrf
                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12">
                        <div class="border-0">
                            <div class="tab-content">
                                <div class="tab-pane active" id="tab-7">
                                    <div class="">
                                        <div class="card-header card_hearder_mimi">
                                            <h4 class="card_hearder_mimi_text">Eye Power</h4>
                                        </div>
                                        <div class="">
                                            <div class="opdneedit">
                                                <div class="row">
                                                    <div class="col-lg-12 ">
                                                        <div class="main-profile-contact-list ">
                                                            <div class="row">
                                                                @if($OpRecords->isNotEmpty())
                                                                <div class="table-responsive">
                                                                    <div class="card-body">
                                                                    <h4 style="text-color: #000; margin-left: 15px;">Single Vision Power</h4>
                                                                    <table class="table table-bordered border-left border-bottom border-right"
                                                                        id="data-table" style="width: 98%;margin-left:1%;">
                                                                        <thead class="bg-primary">
                                                                            <tr>
                                                                                <th scope="col" class="text-white">Rx</th>
                                                                                <th scope="col" class="text-white">Spherical</th>
                                                                                <th scope="col" class="text-white">Cylindrical</th>
                                                                                <th scope="col" class="text-white">Axis</th>
                                                                                <th scope="col" class="text-white">Pupil Distance</th>
                                                                                <th scope="col" class="text-white">Add. Power</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody id="chargeTable">
                                                                            @foreach( $OpRecords as $OpRecord )
                                                                            @if( $OpRecord->type_id == 1 )
                                                                            <tr id="row">
                                                                                <td>Right Eye</td>
                                                                                <td><input type="number" step="0.01" required class="form-control" name="records[{{ $OpRecord->id }}][]" value="{{ $OpRecord->spherical }}" /></td>
                                                                                <td><input type="number" step="0.01" required class="form-control" name="records[{{ $OpRecord->id }}][]" value="{{ $OpRecord->cylindrical }}" /></td>
                                                                                <td><input type="number" step="0.01" required class="form-control" name="records[{{ $OpRecord->id }}][]" value="{{ $OpRecord->axis }}" /></td>
                                                                                <td><input type="number" step="0.01" required class="form-control" name="records[{{ $OpRecord->id }}][]" value="{{ $OpRecord->pupil_distance }}" /></td>
                                                                                <td><input type="number" step="0.01" required class="form-control" name="records[{{ $OpRecord->id }}][]" value="{{ $OpRecord->add_power }}" /></td>
                                                                            </tr>
                                                                            @endif
                                                                            @endforeach
                                                                        </tbody>
                                                                                </table>
                                                                                </div>
                                                                                </div>

                                                                                <div class="table-responsive">
                                                                                    <div class="table-responsive card-body">
                                                                                    <h4 style="text-color: #000; margin-left: 15px;">Contact Lens Power</h4>
                                                                                    <table class="table table-bordered border-left border-bottom border-right"
                                                                                        id="data-table" style="width: 98%;margin-left:1%;">
                                                                                        <thead class="bg-primary">
                                                                                            <tr>
                                                                                                <th scope="col" class="text-white">Rx</th>
                                                                                                <th scope="col" class="text-white">Spherical</th>
                                                                                                <th scope="col" class="text-white">Cylindrical</th>
                                                                                                <th scope="col" class="text-white">Axis</th>
                                                                                                <th scope="col" class="text-white">Pupil Distance</th>
                                                                                                <th scope="col" class="text-white">Add. Power</th>
                                                                                            </tr>
                                                                                        </thead>
                                                                                        <tbody id="chargeTable">
                                                                                        @foreach( $OpRecords as $OpRecord )
                                                                                        @if( $OpRecord->type_id == 2 )
                                                                                        <tr id="row">
                                                                                            <td>Right Eye</td>
                                                                                            <td><input type="number" step="0.01" required class="form-control" name="records[{{ $OpRecord->id }}][]" value="{{ $OpRecord->spherical }}" /></td>
                                                                                            <td><input type="number" step="0.01" required class="form-control" name="records[{{ $OpRecord->id }}][]" value="{{ $OpRecord->cylindrical }}" /></td>
                                                                                            <td><input type="number" step="0.01" required class="form-control" name="records[{{ $OpRecord->id }}][]" value="{{ $OpRecord->axis }}" /></td>
                                                                                            <td><input type="number" step="0.01" required class="form-control" name="records[{{ $OpRecord->id }}][]" value="{{ $OpRecord->pupil_distance }}" /></td>
                                                                                            <td><input type="number" step="0.01" required class="form-control" name="records[{{ $OpRecord->id }}][]" value="{{ $OpRecord->add_power }}" /></td>
                                                                                        </tr>
                                                                                        @endif
                                                                                        @endforeach
                                                                                    </tbody>
                                                                                </table>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                @else
                                                                <div class="table-responsive">
                                                                    <div class="card-body">
                                                                    <h4 style="text-color: #000; margin-left: 15px;">Single Vision Power</h4>
                                                                    <table class="table table-bordered border-left border-bottom border-right"
                                                                        id="data-table" style="width: 98%;margin-left:1%;">
                                                                        <thead class="bg-primary">
                                                                            <tr>
                                                                                <th scope="col" class="text-white">Rx</th>
                                                                                <th scope="col" class="text-white">Spherical</th>
                                                                                <th scope="col" class="text-white">Cylindrical</th>
                                                                                <th scope="col" class="text-white">Axis</th>
                                                                                <th scope="col" class="text-white">Pupil Distance</th>
                                                                                <th scope="col" class="text-white">Add. Power</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody id="chargeTable">

                                                                                        <tr id="row">
                                                                                            <td>Right Eye</td>
                                                                                            <td><input type="number" step="0.01" required class="form-control" name="spherical[1][right]" value="" /></td>
                                                                                            <td><input type="number" step="0.01" required class="form-control" name="cylindrical[1][right]" value="" /></td>
                                                                                            <td><input type="number" step="0.01" required class="form-control" name="axis[1][right]" value="" /></td>
                                                                                            <td><input type="number" step="0.01" required class="form-control" name="pupil_distance[1][right]" value="" /></td>
                                                                                            <td><input type="number" step="0.01" required class="form-control" name="add_power[1][right]" value="" /></td>
                                                                                        </tr>
                                                                                        <tr id="row">
                                                                                            <td>Left Eye</td>
                                                                                            <td><input type="number" step="0.01" required class="form-control" name="spherical[1][left]" value="" /></td>
                                                                                            <td><input type="number" step="0.01" required class="form-control" name="cylindrical[1][left]" value="" /></td>
                                                                                            <td><input type="number" step="0.01" required class="form-control" name="axis[1][left]" value="" /></td>
                                                                                            <td><input type="number" step="0.01" required class="form-control" name="pupil_distance[1][left]" value="" /></td>
                                                                                            <td><input type="number" step="0.01" required class="form-control" name="add_power[1][left]" value="" /></td>
                                                                                        </tr>

                                                                                    </tbody>
                                                                                </table>
                                                                                </div>
                                                                                </div>

                                                                                <div class="table-responsive">
                                                                                    <div class="table-responsive card-body">
                                                                                    <h4 style="text-color: #000; margin-left: 15px;">Contact Lens Power</h4>
                                                                                    <table class="table table-bordered border-left border-bottom border-right"
                                                                                        id="data-table" style="width: 98%;margin-left:1%;">
                                                                                        <thead class="bg-primary">
                                                                                            <tr>
                                                                                                <th scope="col" class="text-white">Rx</th>
                                                                                                <th scope="col" class="text-white">Spherical</th>
                                                                                                <th scope="col" class="text-white">Cylindrical</th>
                                                                                                <th scope="col" class="text-white">Axis</th>
                                                                                                <th scope="col" class="text-white">Pupil Distance</th>
                                                                                                <th scope="col" class="text-white">Add. Power</th>
                                                                                            </tr>
                                                                                        </thead>
                                                                                        <tbody id="chargeTable">

                                                                                        <tr id="row">
                                                                                            <td>Right Eye</td>
                                                                                            <td><input type="number" step="0.01" required class="form-control" name="spherical[2][right]" value="" /></td>
                                                                                            <td><input type="number" step="0.01" required class="form-control" name="cylindrical[2][right]" value="" /></td>
                                                                                            <td><input type="number" step="0.01" required class="form-control" name="axis[2][right]" value="" /></td>
                                                                                            <td><input type="number" step="0.01" required class="form-control" name="pupil_distance[2][right]" value="" /></td>
                                                                                            <td><input type="number" step="0.01" required class="form-control" name="add_power[2][right]" value="" /></td>
                                                                                        </tr>
                                                                                        <tr id="row">
                                                                                            <td>Left Eye</td>
                                                                                            <td><input type="number" step="0.01" required class="form-control" name="spherical[2][left]" value="" /></td>
                                                                                            <td><input type="number" step="0.01" required class="form-control" name="cylindrical[2][left]" value="" /></td>
                                                                                            <td><input type="number" step="0.01" required class="form-control" name="axis[2][left]" value="" /></td>
                                                                                            <td><input type="number" step="0.01" required class="form-control" name="pupil_distance[2][left]" value="" /></td>
                                                                                            <td><input type="number" step="0.01" required class="form-control" name="add_power[2][left]" value="" /></td>
                                                                                        </tr>

                                                                                    </tbody>
                                                                                </table>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div class="text-center mt-4 mb-5">
                                                            <button id="saveAndNewBtn" class="btn btn-primary btn-sm submitBtn" type="submit"
                                                                name="submit" value="new"><i class="fa fa-file text-success"></i>
                                                                Save & New</button>
                                                            <button class="btn btn-primary btn-sm submitBtn" type="submit" name="submit" value="close"><i
                                                                    class="fa fa-file text-danger"></i> Save
                                                                & Close</button>
                                                            <!-- <button class="btn btn-primary btn-sm submitBtn" type="submit" name="submit" value="bill"><i
                                                                    class="fa fa-print"></i> Save & Bill
                                                                Print</button> -->
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('js')
<script>
    $(document).on("keyup", ".form-control", function () {
        $(this).val($(this).val().replace(/[^0-9]/g, ''));
    });
</script>
@endpush
