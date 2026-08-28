@extends('layouts.structure')
@push('title')
    <title>{{$title}}</title>
@endpush
@push('css')
@endpush
@section('main-content')
    <div class="row">
        <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12">
            <div class="card">
                <div class="card-header card_hearder_mimi justify-content-between">
                    <h4 class="card-title card_hearder_mimi_text">{{$title}}</h4>
                </div>
                <div class="card-header d-block">
                    <form method="POST" id="filterForm">
                        @csrf
                        <div class="row justify-content-center">
                            <div class="col-sm-2">
                                <div class="form-group">
                                    <select class="form-control" name="field_name" id="fieldName" onchange="changeField()">
                                        <option value="">SELECT FIELD</option>
                                        <option value="p.name">PATIENT NAME</option>
                                        <option value="p.uhid">UHID</option>
                                        <option value="p.phone">Phone No</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-3" id="textInput">
                                <div class="form-group">
                                    <input type="text" value="" class="form-control" id="fieldValue" name="field_value" placeholder="Field Value">
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <select class="form-control" name="status_name" id="statusName">
                                        @foreach ($status['key'] as $key => $sts)
                                        <option value="{{ $status['value'][$key] }}" {{ $key == 2 ? 'selected' : '' }}>{{ $sts }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-4" id="selcetInput">
                                <div class="form-group">
                                    <select class="form-control select2-show-search" multiple name="select_value[]" id="selectValue">
                                        @foreach ($charge as $doc)
                                        <option value="{{ $doc->id }}">{{ $doc->charge_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
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
                                    <button type="button" class="btn btn-success px-3 mr-2" id="todayBtn">Today</button>
                                    <button type="button" class="btn btn-warning px-3" id="resetBtn">Reset</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="card-body">
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
@endsection
@push('js')
<script type="text/javascript">
    var table;
    $('#filterForm').on('submit', function(e) {
        e.preventDefault();
        table.draw();
    });
    $('#todayBtn').on('click', function () {
        const today = moment().format('DD-MM-YYYY');
        $('#fieldName').val('');
        $('#fieldValue').val('');
        $('#selectValue').val([]).trigger('change');
        $('#fromDate').val(today);
        $('#toDate').val(today);
        table.draw();
    });
    $('#resetBtn').on('click', function () {
        // Clear all filters
        $('#fieldName').val('');
        $('#fieldValue').val('');
        $('#selectValue').val([]).trigger('change');
        $('#fromDate').val('');
        $('#toDate').val('');

        // Redraw the DataTable (will trigger serverSide AJAX reload)
        table.draw();
    });
    function check_all_row(bill_id, checkbox) {
        $(".activeRow"+bill_id).prop("checked", $(checkbox).prop("checked"));
    }
    function validateBulkReportPrint(form) {
        const checkedRows = $(form).find("input[name='test_row[]']:checked");
        if (checkedRows.length === 0) {
            alert("Please checkbox check before submit");
            return false;
        }
        return true;
    }
    $(function() {
        const today = moment().format('DD-MM-YYYY');
        $('#fromDate').val(today);
        $('#toDate').val(today);
        table = $('.data-table').DataTable({
            processing: true,
            serverSide: true,
            pageLength: 20,
            lengthMenu: [
                [20, 50, 100, 500],
                [20, 50, 100, 500]
            ],
            ajax: {
                url: "{{ route('investigation.ready-report') }}",
                data: function(d) {
                    d.field_name = $('#fieldName').val();
                    d.field_value = $('#fieldValue').val();
                    d.select_value = $('#selectValue').val();
                    d.status_value = $('#statusName').val();
                    d.from_date = $('#fromDate').val();
                    d.to_date = $('#toDate').val();

                    let patient_id = @json($_GET['patient_id'] ?? null);
                    let charge_id = @json($_GET['charge_id'] ?? null);
                    if (patient_id && charge_id) {
                        d.field_name = 'p.uhid';
                        d.field_value = patient_id;
                        d.select_value = 'investigations.charge_id';
                    }
                }
            },
            columns: [
                {
                    data: null,
                    title: '#',
                    orderable: false,
                    searchable: false,
                    className: 'dt-control',
                    render: function(data, type, row) {
                        return `<button class="btn btn-sm btn-success add-btn" data-id="${row.bill_id}">
                            <i class="fa fa-plus"></i>
                        </button>`;
                    }
                },
                {
                    data: 'uid',
                    name: 'b.uid',
                    title: 'Bill NO',
                    render: function(data, type, row) {
                        return `${row.uid} <span class="badge badge-gradient-primary mx-2">${row.section}</span>`;
                    }
                },
                { data: 'cre_date', name: 'investigations.bill_created_date', title: 'Bill Date' },
                {
					data: 'patient_name',
					name: 'p.name',
					title: 'Patient Name',
					render: function(data, type, row) {
                        return `${row.patient_name} (${row.patient_uhid || row.patient_id})`;
                    }
				},
                { data: 'phone', name: 'p.phone', title: 'Mobile' },
                {
                    data: 'dob_year',
                    name: 'p.dob_year',
                    title: 'Age',
                    render: function(data, type, row) {
                        return `${row.dob_year ?? 0}Y ${row.dob_month ?? 0}M ${row.dob_day ?? 0}D`;
                    },
                },
                { data: 'gender', name: 'p.gender', title: 'Gender' },
                { data: 'bed_name', name: 'beds.bed_name', title: 'Bed' },
                {
                    data: 'referral_name',
                    name: 'r.referral_name',
                    title: 'Ref. Doctor/Under Doctor',
                    render: function(data, type, row) {
                        return `${row.referral_name ?? '---'} || ${row.doctor_name ? 'Dr. ' + row.doctor_name : '---'}`;
                    }
                }
            ],
            rowCallback: function(row, data) {
                $(row).css('background-color', '#d3fdf7');
            }
        });

        // Event delegation for expandable row
        $('.data-table tbody').on('click', '.add-btn', function () {
            var tr = $(this).closest('tr');
            var row = table.row(tr);

            if (row.child.isShown()) {
                // Close the row
                row.child.hide();
                tr.removeClass('shown');
                $(this).find('i').removeClass('fa-minus').addClass('fa-plus');
            } else {
                const data = row.data();
                const button = $(this);

                // Call AJAX to fetch test details
                $.ajax({
                    url: '{{ route("investigation.investigation-deatils") }}',
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        bill_id: data.bill_id,
                        status: $('#statusName').val(),
                        type: null,
                    },
                    success: function (response) {
                        let detailHtml = `<div class="p-2" style="background-color: #f8d7da;">
                            <form method="POST" action="${response.route}" onsubmit="return validateBulkReportPrint(this)">
                                <input type="hidden" value="{{ csrf_token() }}" name="_token"/>
                                <table class="table table-bordered mb-0">
                                    <thead class="thead-dark">
                                        <tr class="text-center">
                                            <th>#</th>
                                            <th>
                                                <input style="width: 10%" type="checkbox" onchange="check_all_row(${data.id}, this)">
                                                <button class="badge badge-info" type="submit">Bulk Report Print</button>
                                            </th>
                                            <th>Attachment</th>
                                            <th>Date</th>
                                            <th>Test Name</th>
                                        </tr>
                                    </thead>
                                    <tbody>`;

                        response.results.forEach(function (test) {
                            detailHtml += `<tr class="text-center">
                                <td><a href="{{ route('investigation.report-deliverd') }}/${test.id_ed}"><i class="fa fa-receipt"></i></a></td>
                                <td><input type="checkbox" class="activeRow${data.id}" name="test_row[]" value="${test.id}"></td>
                                <td>${test.attach_document ? '<a href="'+test.attach_document+'" download><i class="fa fa-download"></i></a>' : ''}</td>
                                <td>${formatDateTime(test.bill_created_date)}</td>
                                <td>${test.charge_name ?? '--'}</td>
                            </tr>`;
                        });

                        detailHtml += `</tbody>
                                </table>
                            </form>
                        </div>`;

                        // Show the row
                        row.child(detailHtml).show();
                        tr.addClass('shown');
                        button.find('i').removeClass('fa-plus').addClass('fa-minus');
                    },
                    error: function () {
                        alert('Failed to fetch test details.');
                    }
                });
            }
        });
    });
</script>
@endpush
