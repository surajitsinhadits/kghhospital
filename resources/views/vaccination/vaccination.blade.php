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
                    <h4 class="card-title card_hearder_mimi_text">{{ strtoupper($title) }}</h4>
                    <div>
                        <a class="btn btn-sm btn-warning" href="{{route('vc.vaccination-register')}}">ADD NEW VACCINATION</a>
                    </div>
                </div>
                <form method="POST" id="filterForm">
                    @csrf
                    <div class="whitebackground">
                        <div class="row">
                            <div class="col-sm-2">
                                <div class="form-group">
                                    <label for="gender">Vaccine</label>
                                    <select class="form-control select2-show-search" name="vaccine" id="vaccine">
                                        <option value="">Select Vaccine</option>
                                        @foreach ($vaccine as $vac)
                                        <option value="{{ $vac->id }}">{{ $vac->vaccine_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="form-group">
                                    <label for="status">Status</label>
                                    <select class="form-control select2-show-search" name="status" id="status">
                                        <option value="">Select Status</option>
                                        <option value="scheduled">Scheduled</option>
                                        <option value="completed">Completed</option>
                                        <option value="missed">Missed</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="form-group">
                                    <label for="scheduledDate">Scheduled Date Range</label>
                                    <input type="text" value="" class="form-control dateRangePickr" id="scheduledDate"
                                        name="scheduledDate" placeholder="Choose Date">
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="form-group">
                                    <label for="administeredDate">Administered Date Range</label>
                                    <input type="text" value="" class="form-control dateRangePickr" id="administeredDate"
                                        name="administeredDate" placeholder="Choose Date">
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="form-group d-flex mt-5">
                                    <button type="submit" class="btn btn-primary px-3 mr-2"><i
                                        class="fas fa-filter"></i> Filter</button>
                                    <button type="button" class="btn btn-warning px-3" id="resetBtn"><i
                                        class="fas fa-history"></i> Reset</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <div class="card-body">
                    <div class="table-responsive">
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
        const formatDate = (d) => {
            const day = String(d.getDate()).padStart(2, '0');
            const month = String(d.getMonth() + 1).padStart(2, '0');
            const year = d.getFullYear();
            return `${day}-${month}-${year}`;
        };
        const today = new Date();
        const dateRange = `${formatDate(today)}`;
        $('#scheduledDate').val(dateRange);

        $('#filterForm').on('submit', function(e) {
            e.preventDefault();
            table.draw();
        });
        $('#resetBtn').on('click', function () {
            // Reset all input fields (text, date, etc.)
            $('#filterForm').find('input').each(function () {
                $(this).val('');
                $(this).trigger('change');
            });

            // Reset all select fields
            $('#filterForm').find('select').each(function () {
                $(this).val('').trigger('change');
            });

            // If you use a datepicker plugin, reset it as well
            $('#filterForm').find('.datepicker').each(function () {
                $(this).datepicker('setDate', null);
            });
            $('#scheduledDate').val(dateRange);

            // Redraw the DataTable (will trigger serverSide AJAX reload)
            table.draw();
        });
        $(function() {
            table = $('.data-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{route('vc.vaccination')}}",
                    data: function(d) {
                        d.vaccine = $('#vaccine').val();
                        d.status = $('#status').val();
                        d.scheduledDate = $('#scheduledDate').val();
                        d.administeredDate = $('#administeredDate').val();
                    }
                },
                columns: [{
                        data: null,
                        name: 'sl_no',
                        title: 'SN',
                        render: function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        },
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'scheduled_date',
                        name: 'scheduled_date',
                        title: 'Scheduled Date',
                        render: function(data, type, row, meta) {
                            return formatDateTime(row.scheduled_date,'date');
                        },
                    },
                    {
                        data: 'vaccine_name',
                        name: 'v.vaccine_name',
                        title: 'Vaccine Name'
                    },
                    {
                        data: 'patient_name',
                        name: 'p.name',
                        title: 'Patient Info',
                        render: function(data, type, row) {
                            return `${row.patient_name} (${row.gender}, ${row.dob_year}Y)`;
                        },
                    },
                    {
                        data: 'phone',
                        name: 'p.phone',
                        title: 'Phone'
                    },
                    // {
                    //     data: 'gender',
                    //     name: 'p.gender',
                    //     title: 'Gender'
                    // },
                    // {
                    //     data: 'dob_year',
                    //     name: 'p.dob_year',
                    //     title: 'Age',
                    //     render: function(data, type, row, meta) {
                    //         return row.dob_year + 'Y';
                    //     },
                    // },
                    {
                        data: 'notes',
                        name: 'notes',
                        title: 'Notes'
                    },
                    {
                        data: 'administered_date',
                        name: 'administered_date',
                        title: 'Vaccined Date',
                        render: function(data, type, row) {
                            return row.administered_date ? formatDateTime(row.administered_date) : 'NA';
                        },
                    },
                    {
                        data: 'status',
                        name: 'status',
                        title: 'Status',
                        render: function(data, type, row, meta) {
                            return `<span class="badge badge-primary">${row.status.toUpperCase()}</span>`;
                        },
                    },
                    {
                        data: 'action',
                        name: 'action',
                        title: 'Action',
                        orderable: false,
                        searchable: false
                    }
                ],
            });
        });
    </script>
@endpush
