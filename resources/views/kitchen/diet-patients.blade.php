@extends('layouts.structure')
@push('title')
    <title>{{ $title }}</title>
@endpush
@push('css')
@endpush
@section('main-content')
<div class="row">
    <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12">
        <div class="card">
            <div class="card-header card_hearder_mimi justify-content-between">
                <h4 class="card-title card_hearder_mimi_text">{{ $title }}</h4>
                <a class="btn btn-warning btn-sm px-3" href="{{ route('kt.diet-charts-assign') }}">Add Diet Patient</a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered datatable">
                        <thead>
                            <tr>
                                <th>Sl. No.</th>
                                <th>Patient Name</th>
                                <th>Gender</th>
                                <th>Age</th>
                                <th>Diet Type</th>
                                <th>Note</th>
                                <th>Restrictions</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($diet_patients as $diet)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $diet->name }}</td>
                                <td>{{ $diet->gender }}</td>
                                <td>{{ $diet->dob_year ?? 0 }}Y {{ $diet->dob_month ?? 0 }}M {{ $diet->dob_day ?? 0 }}D</td>
                                <td>{{ $diet->diet_types }}</td>
                                <td>{{ $diet->note }}</td>
                                <td>{{ $diet->restrictions }}</td>
                                <td>
                                    <button class="btn btn-sm btn-outline-primary mx-1" title="View" onclick="viewModel('{{ $diet->id }}')"><i class="fa fa-eye"></i></button>
                                    <a href="{{ route('kt.edit-charts-assign', ed($diet->id, true)) }}" class="btn btn-sm btn-outline-warning mx-1" title="Edit"><i class="bx bxs-edit"></i></a>
                                    <a href="{{ route('kt.delete-charts-assign', ed($diet->id, true)) }}" onclick="return confirm('Are you sure?')" class="btn btn-sm btn-outline-danger mx-1" title="Delete"><i class="bx bxs-trash"></i></a>
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

<!-- Diet Info Modal -->
<div class="modal fade" id="dietInfoModal" tabindex="-1" aria-labelledby="dietInfoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="dietInfoModalLabel">Patient Diet Chart</h5>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close">X</button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <h4 class="mb-3">Patient Details</h4>
                    <div class="row">
                        <div class="col-md-4"><strong>Name :</strong> <span id="patientName"></span></div>
                        <div class="col-md-4"><strong>Gender :</strong> <span id="patientGender"></span></div>
                        <div class="col-md-4"><strong>Age :</strong> <span id="patientDOB"></span></div>
                        <div class="col-md-4"><strong>Diet Type :</strong> <span id="dietType"></span></div>
                        <div class="col-md-4"><strong>From Date :</strong> <span id="fromDate"></span></div>
                        <div class="col-md-4"><strong>To Date :</strong> <span id="toDate"></span></div>
                        <div class="col-md-12 mt-2"><strong>Note :</strong> <span id="note"></span></div>
                        <div class="col-md-12"><strong>Restrictions :</strong> <span id="restrictions"></span></div>
                    </div>
                </div>

                <hr>

                <div class="mb-3">
                    <h4 class="mb-3">Meals</h4>
                    <div class="row">
                        <div class="col-md-6"><strong>Breakfast :</strong> <span id="breakfast"></span></div>
                        <div class="col-md-6"><strong>Lunch :</strong> <span id="lunch"></span></div>
                        <div class="col-md-6"><strong>Dinner :</strong> <span id="dinner"></span></div>
                        <div class="col-md-6"><strong>Snack :</strong> <span id="snack"></span></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
@push('js')
<script>
    function viewModel(id){
        $.ajax({
            url: "{{ route('kt.get-diet-info') }}",
            type: 'POST',
            data: {
                id: id,
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                if(response.status === 'success') {
                    let data = response.data;

                    // Fill modal content
                    $('#patientName').text(data.name);
                    $('#patientGender').text(data.gender);
                    $('#patientDOB').text(data.dob_year+' Y');
                    $('#dietType').text(data.diet_types);
                    $('#fromDate').text(formatDateTime(data.from_date, 'date'));
                    $('#toDate').text(formatDateTime(data.to_date, 'date'));
                    $('#note').text(data.note);
                    $('#restrictions').text(data.restrictions);

                    $('#breakfast').text(data.breakfast);
                    $('#lunch').text(data.lunch);
                    $('#dinner').text(data.dinner);
                    $('#snack').text(data.snack);

                    // Show modal
                    $('#dietInfoModal').modal('show');
                }
            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
            }
        });
    }
</script>
@endpush
