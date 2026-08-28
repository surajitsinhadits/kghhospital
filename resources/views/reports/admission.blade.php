@extends('layouts.structure')
@push('title')
    <title>Admittion Report</title>
@endpush

@push('css')
    <style>
        @import url(https://fonts.googleapis.com/css?family=Roboto);

        body {
            font-family: Roboto, sans-serif;
        }
    </style>
@endpush

@section('main-content')
    <div class="row">
        <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12">
            <div class="card">
                <div class="card-header card_hearder_mimi justify-content-between">
                    <h4 class="card-title card_hearder_mimi_text">ADMISSION REPORT</h4>
                </div>

                <div class="">
                    <div class="">
                        <form method="POST" id="filterForm">
                            @csrf
                            <div class="whitebackground">
                                <div class="row">

                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <select class="form-control mt-1" name="patient_status" id="patient_status">
                                                <option value="1" selected>Admission</option>
                                                <option value="2">Admitted</option>
                                            </select>
                                        </div>
                                    </div>

                                    {{-- FROM DATE (ONLY for Admission now) --}}
                                    <div class="col-sm-2" id="fromWrap">
                                        <div class="form-group">
                                            <input type="text" value="" class="form-control datePickr" id="fromDate"
                                                name="from_date" placeholder="Choose From Date">
                                        </div>
                                    </div>

                                    {{-- TO DATE (always visible, single-date for Admitted) --}}
                                    <div class="col-sm-2" id="toWrap">
                                        <div class="form-group">
                                            <input type="text" value="" class="form-control datePickr" id="toDate"
                                                name="to_date" placeholder="Choose Date">
                                        </div>
                                    </div>

                                    <div class="col-sm-3">
                                        <div class="form-group d-flex flex-wrap">
                                            <button type="submit" class="btn btn-primary px-3 mr-2">
                                                <i class="fas fa-filter"></i> Filter
                                            </button>

                                            <button type="button" class="btn btn-success px-3 mr-2" id="todayBtn">
                                                <i class="fas fa-calendar-week"></i> Today
                                            </button>

                                            <button type="button" class="btn btn-warning px-3 mr-2" id="resetBtn">
                                                <i class="fas fa-history"></i> Reset
                                            </button>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="whitebackground">
                        <div class="table-responsive" id="table-responsive">
                            <table class="table table-bordered data-table">
                                <thead></thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
<script type="text/javascript">
    var table;

    function todayStr() {
        return moment().format('DD-MM-YYYY');
    }

    function last30DaysStr() {
        return moment().subtract(30, 'days').format('DD-MM-YYYY');
    }

    // ✅ Admission => show From+To (30 days range)
    // ✅ Admitted  => show only single date (To date)
    function applyPatientStatusUI() {
        const status = $('#patient_status').val();

        if (status === '1') {
            // Admission => range
            $('#fromWrap').show();
            $('#fromDate').val(last30DaysStr());
            $('#toDate').val(todayStr());

        } else if (status === '2') {
            // Admitted => single date
            $('#fromWrap').hide();
            $('#fromDate').val('');
            $('#toDate').val(todayStr());

        } else {
            // fallback
            $('#fromWrap').show();
            $('#fromDate').val('');
            $('#toDate').val('');
        }
    }

    // ✅ Prepare request dates
    // Admission (1): keep range
    // Admitted (2): from_date = to_date (single date)
    function getFinalDatesForRequest() {
        const status = $('#patient_status').val();
        let from = $('#fromDate').val();
        let to = $('#toDate').val();

        if (status === '1') {
            // Admission range
            if (!from) from = last30DaysStr();
            if (!to) to = todayStr();
        }

        if (status === '2') {
            // Admitted single day
            if (!to) to = todayStr();
            from = to;
        }

        return { from_date: from, to_date: to };
    }

    // ✅ Filter button only
    $('#filterForm').on('submit', function(e) {
        e.preventDefault();
        table.draw();
        updateAdmissionExportLinks();
    });

    // ✅ only UI change (NO auto filter)
    $('#patient_status').on('change', function() {
        applyPatientStatusUI();
        updateAdmissionExportLinks();
    });

    // ✅ Today button reloads table
    $('#todayBtn').on('click', function() {
        const status = $('#patient_status').val();

        if (status === '1') {
            $('#fromDate').val(last30DaysStr());
            $('#toDate').val(todayStr());
        } else if (status === '2') {
            $('#fromDate').val('');
            $('#toDate').val(todayStr());
        }

        table.draw();
        updateAdmissionExportLinks();
    });

    // ✅ Reset button reloads table (default Admission)
    $('#resetBtn').on('click', function() {
        $('#patient_status').val('1');
        applyPatientStatusUI();

        table.draw();
        updateAdmissionExportLinks();
    });

    $(function() {
        // ✅ default Admission on load
        $('#patient_status').val('1');
        applyPatientStatusUI();

        table = $('.data-table').DataTable({
            processing: true,
            serverSide: true,
            pageLength: 50,
            lengthMenu: [
                [50, 100, 200, 300, 400],
                [50, 100, 200, 300, 400]
            ],
            ajax: {
                url: "{{ route('reports.admission') }}",
                data: function(d) {
                    const dates = getFinalDatesForRequest();
                    d.patient_status = $('#patient_status').val();
                    d.from_date = dates.from_date;
                    d.to_date = dates.to_date;
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
                    data: 'billBtn',
                    name: 'bill.uid',
                    title: 'Bill No',
                },
                {
                    data: 'patient_name',
                    name: 'p.name',
                    title: 'Patient Name',
                    render: function(data, type, row, meta) {
                        return `${row.patient_name} (${row.patient_uhid || row.patient_id})`;
                    },
                },
                {
                    data: 'adm_date',
                    name: 'ipd_registers.admission_date',
                    title: 'Admission Date',
                },
                {
                    data: 'dis_date',
                    name: 'ipd_registers.discharge_at',
                    title: 'Discharge Date',
                },
                {
                    data: 'stay_days',
                    name: 'stay_days',
                    title: 'Stay (Days)',
                },
                {
                    data: 'doctor_name',
                    name: 'u.name',
                    title: 'Doctor Name',
                },
                {
                    data: 'type',
                    name: 'ipd_registers.type',
                    title: 'Patient Type',
                },
            ],
            rowCallback: function(row, data) {
                $(row).css('background-color', '#d3fdf7');
            }
        });

        updateAdmissionExportLinks();
    });

    function updateAdmissionExportLinks() {
        const params = new URLSearchParams();
        const dates = getFinalDatesForRequest();

        const fields = {
            patient_status: $('#patient_status').val(),
            from_date: dates.from_date,
            to_date: dates.to_date,
        };

        Object.keys(fields).forEach(function(key) {
            const value = fields[key];
            if (value) params.set(key, value);
        });

        const query = params.toString();
        ['#dischargePdfExport', '#dischargeExcelExport'].forEach(function(selector) {
            const link = $(selector);
            if (!link.length) return;
            const baseUrl = link.data('base-url') || link.attr('href');
            link.attr('href', query ? `${baseUrl}?${query}` : baseUrl);
        });
    }
</script>
@endpush
