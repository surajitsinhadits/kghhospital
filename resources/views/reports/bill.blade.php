@extends('layouts.structure')
@push('title')
    <title>Bill List</title>
@endpush
@push('css')
@endpush
@section('main-content')
    <div class="row">
        <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12">
            <div class="card">
                <div class="card-header card_hearder_mimi">
                    <h4 class="card-title card_hearder_mimi_text">BILL LIST</h4>
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
                                                <option value="p.uhid">UHID</option>
                                                <option value="p.phone">MOBILE</option>
                                                <option value="billings.uid">Billing No</option>
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
                                    <div class="col-sm-2 d-none" id="selcetInput">
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
                                        <div class="form-group d-flex flex-wrap">
                                            <button type="submit" class="btn btn-primary px-3 mr-2"><i
                                                    class="fas fa-filter"></i> Filter</button>
                                            <button type="button" class="btn btn-success px-3 mr-2" id="todayBtn"><i
                                                    class="fas fa-calendar-week"></i> Today</button>
                                            <button type="button" class="btn btn-warning px-3 mr-2" id="resetBtn"> <i
                                                    class="fas fa-history"></i> Reset</button>
                                            <a href="{{ route('reports.bill.export', ['format' => 'pdf']) }}"
                                                id="billPdfExport"
                                                data-base-url="{{ route('reports.bill.export', ['format' => 'pdf']) }}"
                                                class="btn btn-danger px-3 mr-2"><i class="fas fa-file-pdf"></i> PDF</a>
                                            <a href="{{ route('reports.bill.export', ['format' => 'excel']) }}"
                                                id="billExcelExport"
                                                data-base-url="{{ route('reports.bill.export', ['format' => 'excel']) }}"
                                                class="btn btn-success px-3"><i class="fas fa-file-excel"></i> Excel</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    {{-- SECTION BAR CHART --}}
                    <div class="row mb-4 justify-content-between" id="sectionBarGraphContainer" style="display:none;">
                        <div class="col-3"></div>
                        <div class="col-6">


                            <!-- Chart container is hidden by default, shown after AJAX -->
                            <div>
                                <div id="sectionBarGraph" style="height: 390px;"></div>
                            </div>


                        </div>
                        <div class="col-3"></div>
                    </div>
                    {{-- END SECTION BAR CHART --}}
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
        var sectionBarChart = null;

        // Helper to extract numbers from payment HTML
        function extractPaymentValues(paymentHtml) {
            // Example: <span>Total : 1300</span><br><span>Payment : 1900</span><br><span>Due : 100</span>
            var total = 0,
                paid = 0,
                due = 0;
            if (!paymentHtml) return {
                total,
                paid,
                due
            };
            var totalMatch = paymentHtml.match(/Total\s*:\s*([\d.]+)/i);
            var paidMatch = paymentHtml.match(/Payment\s*:\s*([\d.]+)/i);
            var dueMatch = paymentHtml.match(/Due\s*:\s*([\d.]+)/i);
            if (totalMatch) total = parseFloat(totalMatch[1]);
            if (paidMatch) paid = parseFloat(paidMatch[1]);
            if (dueMatch) due = parseFloat(dueMatch[1]);
            return {
                total,
                paid,
                due
            };
        }

        function renderSectionBarChart(sections, totalData, paidData, dueData) {
            var options = {
                chart: {
                    type: 'bar',
                    height: 350,
                    toolbar: {
                        show: false
                    }
                },
                plotOptions: {
                    bar: {
                        horizontal: false,
                        columnWidth: '45%',
                        endingShape: 'rounded'
                    },
                },
                dataLabels: {
                    enabled: true
                },
                stroke: {
                    show: true,
                    width: 2,
                    colors: ['transparent']
                },
                series: [{
                        name: 'Total',
                        data: totalData
                    },
                    {
                        name: 'Paid',
                        data: paidData
                    },
                    {
                        name: 'Due',
                        data: dueData
                    }
                ],
                xaxis: {
                    categories: sections
                },
                yaxis: {
                    title: {
                        text: 'Amount (₹)'
                    }
                },
                fill: {
                    opacity: 1
                },
                colors: ['#2196f3', '#4caf50', '#f44336'],
                tooltip: {
                    y: {
                        formatter: function(val) {
                            return "₹" + val.toLocaleString();
                        }
                    }
                }
            };

            if (sectionBarChart) {
                sectionBarChart.updateOptions(options, true, true);
            } else {
                sectionBarChart = new ApexCharts(document.querySelector("#sectionBarGraph"), options);
                sectionBarChart.render();
            }
        }

        function setDefaultDatesIfBlank() {
            let fromDate = $('#fromDate').val();
            let toDate = $('#toDate').val();
            if (!fromDate && !toDate) {
                let today = moment();
                let sixMonthsAgo = moment().subtract(1, 'months');
                $('#fromDate').val(sixMonthsAgo.format('DD-MM-YYYY'));
                $('#toDate').val(today.format('DD-MM-YYYY'));
            }
        }

        var table;
        $(function() {
            setDefaultDatesIfBlank();
            updateBillExportLinks();
            table = $('.data-table').DataTable({
                processing: true,
                serverSide: true,
                pageLength: 50,
                lengthMenu: [
                    [50, 100, 200, 300, 400],
                    [50, 100, 200, 300, 400]
                ],
                ajax: {
                    url: "{{ route('reports.bill') }}",
                    data: function(d) {
                        d.field_name = $('#fieldName').val();
                        d.field_value = $('#fieldValue').val();
                        d.select_value = $('#selectValue').val();
                        d.from_date = $('#fromDate').val();
                        d.to_date = $('#toDate').val();
                    },
                    beforeSend: function() {
                        // Hide chart while loading
                        $('#sectionBarGraphContainer').hide();
                    },
                    dataSrc: function(json) {
                        // Group and sum by section
                        var sectionTotals = {};
                        var sectionList = [];
                        json.data.forEach(function(row) {
                            var section = row.section || 'UNKNOWN';
                            if (!sectionTotals[section]) {
                                sectionTotals[section] = {
                                    total: 0,
                                    paid: 0,
                                    due: 0
                                };
                                sectionList.push(section);
                            }
                            var vals = extractPaymentValues(row.payment);
                            sectionTotals[section].total += vals.total;
                            sectionTotals[section].paid += vals.paid;
                            sectionTotals[section].due += vals.due;
                        });

                        // Prepare data for chart
                        var totalData = [],
                            paidData = [],
                            dueData = [];
                        sectionList.forEach(function(section) {
                            totalData.push(sectionTotals[section].total);
                            paidData.push(sectionTotals[section].paid);
                            dueData.push(sectionTotals[section].due);
                        });

                        // Only show and render the chart after data is loaded
                        if (sectionList.length > 0) {
                            $('#sectionBarGraphContainer').show();
                            renderSectionBarChart(sectionList, totalData, paidData, dueData);
                        } else {
                            $('#sectionBarGraphContainer').hide();
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
                        data: 'patient',
                        name: 'p.name',
                        title: 'Patient (UHID)',
                    },
                    {
                        data: 'phone',
                        name: 'p.phone',
                        title: 'Phone',
                    },
                    {
                        data: 'billing',
                        name: 'billings.uid',
                        title: 'Bill No',
                    },
                    {
                        data: 'section',
                        name: 'billings.section',
                        title: 'Section',
                    },
                    {
                        data: 'cre_date',
                        name: 'billings.bill_date',
                        title: 'Date & Time',
                    },
                    {
                        data: 'payment',
                        name: 'payment',
                        title: 'Amount (₹)',
                    },
                    {
                        data: 'created_name',
                        name: 'u.name',
                        title: 'Generated By',
                    },
                    {
                        data: 'action',
                        name: 'action',
                        title: 'Action'
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

        $('#filterForm').on('submit', function(e) {
            e.preventDefault();
            updateBillExportLinks();
            table.draw();
        });
        $('#todayBtn').on('click', function() {
            const today = moment().format('DD-MM-YYYY');
            $('#fromDate').val(today);
            $('#toDate').val(today);
            table.draw();
            updateBillExportLinks();
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
            updateBillExportLinks();
        });

        changeField();
        $('#fieldName, #fieldValue, #selectValue, #fromDate, #toDate').on('keyup change', updateBillExportLinks);

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

        function updateBillExportLinks() {
            const params = new URLSearchParams();
            const fieldName = $('#fieldName').val();
            const fieldValue = $('#fieldValue').val();
            const selectValue = $('#selectValue').val();
            const fromDate = $('#fromDate').val();
            const toDate = $('#toDate').val();

            if (fieldName) {
                params.set('field_name', fieldName);
            }
            if (fieldValue) {
                params.set('field_value', fieldValue);
            }
            if (fieldName === 'billings.section' && selectValue) {
                params.set('select_value', selectValue);
            }
            if (fromDate) {
                params.set('from_date', fromDate);
            }
            if (toDate) {
                params.set('to_date', toDate);
            }

            const query = params.toString();
            ['#billPdfExport', '#billExcelExport'].forEach(function(selector) {
                const link = $(selector);
                if (!link.length) {
                    return;
                }
                const baseUrl = link.data('base-url') || link.attr('href');
                link.attr('href', query ? `${baseUrl}?${query}` : baseUrl);
            });
        }
    </script>
@endpush
