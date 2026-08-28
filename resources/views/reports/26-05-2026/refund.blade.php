@extends('layouts.structure')
@push('title')
    <title>Refund List</title>
@endpush
@push('css')
@endpush
@section('main-content')
    <div class="row">
        <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12">
            <div class="card">
                <div class="card-header card_hearder_mimi justify-content-between">
                    <h4 class="card-title card_hearder_mimi_text">REFUND LIST</h4>
                </div>
                <div class="">
                    <div class="">
                        <form method="POST" id="filterForm">
                            @csrf
                            <div class="whitebackground">
                                <div class="row">
                                    <div class="col-sm-3">
                                        <div class="form-group" style="margin-top: 3px;">
                                            <select class="form-control" name="field_name" id="fieldName"
                                                onchange="changeField()">
                                                <option value="">SELECT FIELD</option>
                                                <option value="p.name">PATIENT NAME</option>
                                                <option value="billings.patient_id">UHID</option>
                                                <option value="p.phone">MOBILE</option>
                                                <option value="billings.section">SECTION</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-2" id="textInput">
                                        <div class="form-group">
                                            <input type="text" value="" class="form-control" id="fieldValue"
                                                name="field_value" placeholder="Field Value">
                                        </div>
                                    </div>
                                    <div class="col-sm-3 d-none" id="selcetInput">
                                        <div class="form-group">
                                            <select class="form-control" name="select_value" id="selectValue">
                                                <option value="OPD">OPD</option>
                                                <option value="EMG">EMG</option>
                                                <option value="IPD">IPD</option>
                                                <option value="DIALYSIS">DIALYSIS</option>
                                                <option value="DAYCARE">DAYCARE</option>
                                                <option value="INVESTIGATION">INVESTIGATION</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <input type="text" value="" class="form-control datePickr"
                                                id="fromDate" name="from_date" placeholder="Choose From Date">
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <input type="text" value="" class="form-control datePickr"
                                                id="toDate" name="to_date" placeholder="Choose To Date">
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group d-flex">
                                            <button type="submit" class="btn btn-primary px-3 mr-2"><i
                                                    class="fas fa-filter"></i> Filter</button>
                                            <button type="button" class="btn btn-success px-3 mr-2" id="todayBtn"><i
                                                    class="fas fa-calendar-week"></i> Today</button>
                                            <button type="button" class="btn btn-warning px-3" id="resetBtn"><i
                                                    class="fas fa-history"></i> Reset</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="whitebackground">
                        <div class="table-responsive" id="table-responsive">
                            <table class="table table-bordered text-nowrap data-table">
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
        $('#filterForm').on('submit', function(e) {
            e.preventDefault();
            table.draw();
        });
        $('#todayBtn').on('click', function() {
            const today = moment().format('DD-MM-YYYY');
            $('#fromDate').val(today);
            $('#toDate').val(today);
            table.draw();
        });
        $('#resetBtn').on('click', function() {
            // Clear all filters
            $('#fieldName').val('');
            $('#fieldValue').val('');
            $('#selectValue').val('OPD');
            $('#fromDate').val('');
            $('#toDate').val('');

            // Show text input, hide section select (if needed)
            $('#textInput').removeClass('d-none');
            $('#selcetInput').addClass('d-none');

            // Redraw the DataTable (will trigger serverSide AJAX reload)
            table.draw();
        });

        function setDefaultDatesIfBlank() {
            let fromDate = $('#fromDate').val();
            let toDate = $('#toDate').val();
            if (!fromDate && !toDate) {
                let today = moment();
                let sixMonthsAgo = moment().subtract(6, 'months');
                $('#fromDate').val(sixMonthsAgo.format('DD-MM-YYYY'));
                $('#toDate').val(today.format('DD-MM-YYYY'));
            }
        }

        $(function() {
            setDefaultDatesIfBlank();
            table = $('.data-table').DataTable({
                processing: true,
                serverSide: true,
                pageLength: 50,
                lengthMenu: [
                    [50, 100, 200, 300, 400],
                    [50, 100, 200, 300, 400]
                ],
                ajax: {
                    url: "{{ route('reports.refund') }}",
                    data: function(d) {
                        d.field_name = $('#fieldName').val();
                        d.field_value = $('#fieldValue').val();
                        d.select_value = $('#selectValue').val();
                        d.from_date = $('#fromDate').val();
                        d.to_date = $('#toDate').val();

                        // override field_value if section is selected
                        if (d.field_name === 'billings.section') {
                            d.field_value = d.select_value;
                        }
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
                        data: 'refund_id',
                        name: 'pca.id',
                        title: 'Payment ID',
                        render: function(data, type, row, meta) {
                            return `RF${row.refund_id}`;
                        },
                    },
                    {
                        data: 'billId',
                        name: 'uid',
                        title: 'Refund From Bill',
                    },
                    {
                        data: 'section',
                        name: 'billings.section',
                        title: 'Section',
                    },
                    {
                        data: 'patient',
                        name: 'p.name',
                        title: 'Patient (UHID)',
                        render: function(data, type, row, meta) {
                            return `${row.patient_name} (${row.patient_id})`;
                        },
                    },
                    {
                        data: 'phone',
                        name: 'p.phone',
                        title: 'Phone',
                    },
                    {
                        data: 'cre_date',
                        name: 'billings.refund_at',
                        title: 'Date & Time',
                    },
                    {
                        data: 'refund_amount',
                        name: 'refund_amount',
                        title: 'Amount (₹)',
                    },
                    {
                        data: 'refund_name',
                        name: 'u.name',
                        title: 'Refund By',
                    },
                ],
                rowCallback: function(row, data) {
                    if (data.due_amount > 0) {
                        $(row).css('background-color', '#f1d1d1');
                    } else {
                        $(row).css('background-color', '#d3fdf7');
                    }
                }
            });
        });

        changeField();

        function changeField() {
            var field = $('#fieldName').val();
            if (field == 'billings.section') {
                $('#selcetInput').removeClass('d-none');
                $('#textInput').addClass('d-none');
            } else {
                $('#textInput').removeClass('d-none');
                $('#selcetInput').addClass('d-none');
            }
        }
    </script>
@endpush
