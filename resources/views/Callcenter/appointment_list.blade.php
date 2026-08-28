@extends('layouts.structure')
@push('title')
    <title>CALL LIST</title>
@endpush
@push('css')
@endpush
@section('main-content')
<div class="row">
    <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12">
        <div class="card">
            <div class="card-header card_hearder_mimi justify-content-between">
                <h4 class="card-title card_hearder_mimi_text">CALL LIST</h4>
            </div>
            <div class="card-header d-block">
                <form method="POST" id="filterForm">
                    @csrf
                    <div class="row">
                        <div class="col-sm-2">
                            <div class="form-group">
                                <input type="text" value="" class="form-control datePickr" id="fromDate" name="from_date" placeholder="Choose From Date">
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group">
                                <input type="text" value="" class="form-control datePickr" id="toDate" name="to_date" placeholder="Choose To Date">
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group d-flex">
                                <button type="submit" class="btn btn-primary px-3 mr-2">Filter</button>
                                <button type="button" class="btn btn-warning px-3" id="resetBtn">Reset</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="card-body">
                <div class="table-responsive" id="table-responsive">
                    <table class="table table-hover table-striped table-bordered data-table w-100">
                        <thead></thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('js')
<script type="text/javascript">
    var table;
   $(function () {
    // Leave filters empty on page load
    $('#fromDate').val('');
    $('#toDate').val('');

    // Initialize DataTable
    table = $('.data-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{ route('callcenter.appointment-list') }}",
            data: function (d) {
                d.from_date = $('#fromDate').val();
                d.to_date = $('#toDate').val();
            }
        },
        columns: [
            {
                data: null,
                name: 'sl_no',
                title: 'SN',
                render: function (data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1;
                },
                orderable: false,
                searchable: false
            },
            {
                data: null,
                name: 'patient_id',
                title: 'UHID',
                render: function (data, type, row) {
                    return `${row.patient_uhid || row.patient_id || ''}`;
                },
                orderable: false,
                searchable: true
            },
            {
                data: 'patient_name',
                name: 'patient_name',
                title: 'Patient Name',
            },
            {
                data: 'department',
                name: 'department',
                title: 'Department',
            },
            {
                data: null,
                name: 'phone',
                title: 'Mobile',
                render: function (data, type, row) {
                    return `${row.phone}`;
                },
                orderable: false,
                searchable: true
            },
            {
                data: 'appointment_date',
                name: 'appointment_date',
                title: 'Appointment Date',
                render: function (data, type, row) {
                    return `${formatDateTime(row.appointment_date)}`;
                },
                orderable: false,
                searchable: true
            },
            {
                data: 'action',
                name: 'action',
                title: 'Action'
            },
        ],
    });

    // Reset button clears fields and reloads all data
    $('#resetBtn').on('click', function () {
        $('#fromDate').val('');
        $('#toDate').val('');
        table.draw();
    });

    // Filter form submit
    $('#filterForm').on('submit', function(e) {
        e.preventDefault();
        table.draw();
    });
});

</script>
@endpush
