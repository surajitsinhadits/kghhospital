@extends('layouts.structure')
@push('title')
    <title>Receipt List</title>
@endpush
@push('css')
@endpush
@section('main-content')
    <div class="row">
        <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12">
            <div class="card">
                <div class="card-header card_hearder_mimi justify-content-between">
                    <h4 class="card-title card_hearder_mimi_text">RECEIPT LIST</h4>
                </div>
                <div class="">
                    <div class="">
                        <form method="POST" id="filterForm">
                            @csrf
                            <div class="whitebackground">
                                <div class="row">
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <select class="form-control" name="field_name" id="fieldName"
                                                onchange="changeField()">
                                                <option value="">SELECT FIELD</option>
                                                <option value="p.name">PATIENT NAME</option>
                                                <option value="payments.patient_id">UHID</option>
                                                <option value="p.phone">MOBILE</option>
                                                <option value="payments.section">SECTION</option>
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
                    {{-- PIE CHART --}}
                    <div class="row mb-4" id="receiptModePieContainer" style="display:none;">
                        <div class="col-3"></div>
                        <div class="col-6">

                            <div>
                                <div id="receiptModePieChart" style="height: 370px;"></div>
                            </div>

                        </div>
                        <div class="col-3"></div>
                    </div>
                    {{-- END PIE CHART --}}
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
        var receiptModePieChart = null;

        function renderReceiptModePieChart(labels, series) {
            var options = {
                chart: {
                    type: 'pie',
                    height: 350
                },
                labels: labels,
                series: series,
                legend: {
                    position: 'bottom'
                },
                dataLabels: {
                    enabled: true,
                    formatter: function(val, opts) {
                        return opts.w.config.series[opts.seriesIndex] + " (₹)";
                    }
                },
                tooltip: {
                    y: {
                        formatter: function(val) {
                            return "₹" + val.toLocaleString();
                        }
                    }
                }
            };

            if (receiptModePieChart) {
                receiptModePieChart.updateOptions(options, true, true);
            } else {
                receiptModePieChart = new ApexCharts(document.querySelector("#receiptModePieChart"), options);
                receiptModePieChart.render();
            }
        }

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
                pageLength: 100,
                lengthMenu: [
                    [50, 100, 200, 300, 400],
                    [50, 100, 200, 300, 400]
                ],
                ajax: {
                    url: "{{ route('reports.receipt') }}",
                    data: function(d) {
                        d.field_name = $('#fieldName').val();
                        d.field_value = $('#fieldValue').val();
                        d.select_value = $('#selectValue').val();
                        d.from_date = $('#fromDate').val();
                        d.to_date = $('#toDate').val();

                        if (d.field_name === 'payments.section') {
                            d.field_value = d.select_value;
                        }
                    },
                    beforeSend: function() {
                        $('#receiptModePieContainer').hide();
                    },
                    dataSrc: function(json) {
                        // Group and sum by payment_mode
                        // console.log(json);
                        var modeTotals = {};
                        var mode_Totals = 0;
                        json.data.forEach(function(row) {
                            
                            // console.log(mode_Totals++);
                            var mode = row.payment_mode || 'Unknown';
                            var amt = parseFloat(row.payment_amount) || 0;
                            if (!modeTotals[mode]) modeTotals[mode] = 0;
                            modeTotals[mode] += amt;
                            // mode_Totals += amt;
                        });
                        // console.log(mode_Totals);
                        var labels = Object.keys(modeTotals);
                        var series = labels.map(function(mode) {
                            return modeTotals[mode];
                        });

                        if (labels.length > 0) {
                            $('#receiptModePieContainer').show();
                            renderReceiptModePieChart(labels, series);
                        } else {
                            $('#receiptModePieContainer').hide();
                        }
                        return json.data;
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
                        data: null,
                        name: 'id',
                        title: 'Receipt ID',
                        render: function(data, type, row) {
                            return `R${row.id} <span class="badge badge-gradient-primary ml-3">${row.section}</span>`;
                        },
                    },
                    {
                        data: 'patient_name',
                        name: 'p.name',
                        title: 'Patient (UHID)',
                        render: function(data, type, row) {
                            return row.patient_name + ' (' + row.patient_id + ')';
                        },
                    },
                    {
                        data: 'phone',
                        name: 'p.phone',
                        title: 'Phone',
                    },
                    {
                        data: 'cre_date',
                        name: 'created_at',
                        title: 'Date & Time',
                    },
                    {
                        data: 'payment_amount',
                        name: 'payment_amount',
                        title: 'Amount (₹)',
                    },
                    {
                        data: 'payment_mode',
                        name: 'payment_mode',
                        title: 'Receipt Mode',
                    },
                    {
                        data: 'payment_bank',
                        name: 'payment_bank',
                        title: 'Bank',
                    },
                    {
                        data: 'created_name',
                        name: 'u.name',
                        title: 'Collected By',
                    },
                    {
                        data: 'action',
                        name: 'action',
                        title: 'Action'
                    },
                ],
                rowCallback: function(row, data) {
                    $(row).css('background-color', '#d3fdf7');
                }
            });
        });

        changeField();

        function changeField() {
            var field = $('#fieldName').val();
            if (field == 'payments.section') {
                $('#selcetInput').removeClass('d-none');
                $('#textInput').addClass('d-none');
            } else {
                $('#textInput').removeClass('d-none');
                $('#selcetInput').addClass('d-none');
            }
        }
    </script>
@endpush
