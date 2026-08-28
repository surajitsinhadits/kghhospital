@extends('layouts.structure')
@push('title')
    <title>Billing Report</title>
@endpush
@push('css')
@endpush
@section('main-content')
    <div class="row">
        <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12">
            <div class="card">
                <div class="card-header card_hearder_mimi justify-content-between">
                    <h4 class="card-title card_hearder_mimi_text">BILLING REPORT</h4>
                    <button id="toggleBtn" class="btn btn-primary"><i class="fas fa-search" style=""></i></button>
                </div>
                <div class="">
                    <div class="" style="display: none" id="searchSection">
                        <form method="POST" id="filterForm">
                            @csrf
                            <div class="row justify-content-center mb-2">
                                <div class="col-sm-1">
                                    <div class="form-group">
                                        <label for="section_name">Section</label>
                                        <select class="form-control mt-1" name="section" id="section_name">
                                            <option value="">Select</option>
                                            @foreach ($section as $sec)
                                                <option value="{{ $sec->charges_section_name }}"
                                                    {{ request('section') == $sec->charges_section_name ? 'selected' : '' }}>
                                                    {{ $sec->charges_section_name }}
                                                </option>
                                            @endforeach
                                        </select>

                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <label for="user">User</label>
                                        <select class="form-control select2-show-search" name="user[]" id="user"
                                            multiple>
                                            <option value="">Select</option>
                                            @foreach ($users as $item)
                                                <option value="{{ $item->id }}">{{ $item->salutation }}
                                                    {{ $item->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <label for="doctor">Doctor</label>
                                        @php
                                            $selectedDoctors = (array) request('doctor');   // handles doctor or doctor[]
                                        @endphp

                                        <select class="form-control select2-show-search" name="doctor[]" id="doctor" multiple>
                                            <option value="">Select</option>
                                            @foreach ($doctor as $doc)
                                                <option value="{{ $doc->id }}"
                                                    {{ in_array($doc->id, $selectedDoctors) ? 'selected' : '' }}>
                                                    Dr. {{ $doc->name }}
                                                </option>
                                            @endforeach
                                        </select>

                                    </div>
                                </div>
                                <div class="col-sm-1">
                                    <div class="form-group">
                                        <label for="doctor_type">Doctor Type</label>
                                        <select class="form-control mt-1" name="doctor_type" id="doctor_type">
                                            <option value="">Select</option>
                                            <option value="Hospital-Doctor">Hospital Doctor</option>
                                            <option value="Outside-Doctor">Outside Doctor</option>
                                            <option value="Out-Doctor">Out Doctor</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <label for="charge">Charge</label>
                                        <select class="form-control select2-show-search" name="charge[]" id="charge"
                                            multiple>
                                            <option value="">Select</option>
                                            @foreach ($charges as $char)
                                                <option value="{{ $char->id }}">{{ $char->charge_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <label for="charge_category">Charge Category</label>
                                        <select class="form-control select2-show-search" name="charge_category[]" id="charge_category" multiple>
                                            <option value="">Select</option>
                                            @foreach ($category as $char)
                                                <option value="{{ $char->id }}">{{ $char->charges_catagories_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <label for="charge_sub_category">Charge Sub-Category</label>
                                        <select class="form-control select2-show-search" name="charge_sub_category[]" id="charge_sub_category" multiple>
                                            <option value="">Select</option>
                                            @foreach ($subcategory as $char)
                                                <option value="{{ $char->id }}">{{ $char->charges_catagories_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <label for="payment">Payment</label>
                                        <select class="form-control mt-1" name="payment" id="payment">
                                            <option value="">Select</option>
                                            <option value="FP">Full Paid</option>
                                            <option value="PP">Partial Paid</option>
                                            <option value="FD">Full Due</option>
                                        </select>
                                    </div>
                                </div>
                                {{-- <div class="col-sm-1">
                                    <div class="form-group">
                                        <label for="patient_type">Patient Type</label>
                                        <select class="form-control mt-1" name="patient_type" id="patient_type">
                                            <option value="">Select</option>
                                            <option value="new">New</option>
                                            <option value="old">Old</option>
                                        </select>
                                    </div>
                                </div> --}}
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <label for="discount">Discount</label>
                                        <select class="form-control mt-1" name="discount" id="discount">
                                            <option value="">Select</option>
                                            <option value="G">Greater then Equal</option>
                                            <option value="L">Less then Equal</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-1">
                                    <div class="form-group">
                                        <label for="discount_amount">Discount (Rs.)</label>
                                        <input type="text" class="form-control" name="discount_amount"
                                            id="discount_amount">
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <label for="referral">Referral</label>

                                        @php
                                            $selectedDoctors = (array) request('referral');   // handles doctor or doctor[]
                                        @endphp

                                        <select class="form-control select2-show-search" name="referral[]" id="referral" multiple>
                                            <option value="">Select</option>
                                            @foreach ($referral as $ref)
                                                <option value="{{ $ref->id }}" {{ in_array($ref->id, $selectedDoctors) ? 'selected' : '' }}>{{ $ref->referral_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <label for="market_by">Market By</label>
                                        <select class="form-control select2-show-search" name="market_by[]"
                                            id="market_by" multiple>
                                            <option value="">Select</option>
                                            @foreach ($market_by as $mar)
                                                <option value="{{ $mar->id }}">{{ $mar->referral_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <label for="provider">Providor</label>
                                        <select class="form-control select2-show-search" name="provider[]" id="provider"
                                            multiple>
                                            <option value="">Select</option>
                                            @foreach ($provider as $pro)
                                                <option value="{{ $pro->id }}">{{ $pro->referral_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                @php
                                    use Carbon\Carbon;

                                    $start = request('start_date');
                                    $end   = request('end_date');
                                @endphp

                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <input type="text"
                                            class="form-control datePickr"
                                            id="fromDate"
                                            name="from_date"
                                            placeholder="Choose From Date"
                                            value="{{ $start ? Carbon::parse($start)->format('d-m-Y') : '' }}">
                                    </div>
                                </div>

                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <input type="text"
                                            class="form-control datePickr"
                                            id="toDate"
                                            name="to_date"
                                            placeholder="Choose To Date"
                                            value="{{ $end ? Carbon::parse($end)->format('d-m-Y') : '' }}">
                                    </div>
                                </div>

                                <div class="col-sm-2">
                                    <div class="form-group d-flex">
                                        <button type="submit" class="btn btn-primary px-3 mr-2">Filter</button>
                                        <button type="button" class="btn btn-success px-3 mr-2"
                                            id="todayBtn">Today</button>
                                        <button type="button" class="btn btn-warning px-3" id="resetBtn">Reset</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <!-- Chart container with loader -->
                    <div class="row justify-content-center mb-3">
                        <div class="col-md-6">
                            <div id="billingSummaryChartWrapper" style="height: 370px; position: relative;">
                                <div id="billingSummaryChartLoader"
                                    style="display:none; position:absolute; left:0; top:0; width:100%; height:100%; background:rgba(255,255,255,0.7); z-index:10; align-items:center; justify-content:center;">
                                    <div style="text-align:center; margin-top:120px;">
                                        <div class="spinner-border text-primary" role="status">
                                            <span class="sr-only">Loading...</span>
                                        </div>
                                        <div>Loading chart...</div>
                                    </div>
                                </div>
                                <div id="billingSummaryChart" style="height: 370px;"></div>
                            </div>
                        </div>
                        <div class="col-md-4 py-3" id="chargeView"></div>
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
    <div id="fullPageLoader" style="display:none;position:fixed;z-index:9999;top:0;left:0;width:100vw;height:100vh;background:rgba(255,255,255,0.8);align-items:center;justify-content:center;">
        <div>
            <div class="spinner-border text-primary" role="status" style="width: 4rem; height: 4rem;margin-left: 40px;">
                <span class="sr-only">Loading...</span>
            </div>
            <div class="mt-3 text-center text-primary font-weight-bold">Loading, please wait...</div>
        </div>
    </div>
@endsection
@push('js')
    <script type="text/javascript">
        const button = document.getElementById('toggleBtn');
        const target = document.getElementById('searchSection');
        button.addEventListener('click', () => {
            target.style.display = (target.style.display === 'none') ? 'block' : 'none';
        });

        var table;
        var billingChart = null;

        // --- Add this function for default 6 months date ---
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
        // --- End addition ---

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
            $('#section').val('').trigger('change');
            $('#user').val([]).trigger('change');
            $('#charge').val([]).trigger('change');
            $('#charge_category').val([]).trigger('change');
            $('#charge_sub_category').val([]).trigger('change');
            $('#doctor').val([]).trigger('change');
            $('#doctor_type').val('').trigger('change');
            $('#payment').val('').trigger('change');
            $('#patient_type').val('').trigger('change');
            $('#discount').val('').trigger('change');
            $('#discount_amount').val('').trigger('change');
            $('#referral').val([]).trigger('change');
            $('#market_by').val([]).trigger('change');
            $('#provider').val([]).trigger('change');
            $('#fromDate').val('');
            $('#toDate').val('');
            // --- Call default date setter after reset ---
            setDefaultDatesIfBlank();
            // --- End addition ---
            table.draw();
        });

        function showChartLoader() {
            document.getElementById('billingSummaryChartLoader').style.display = 'flex';
            document.getElementById('billingSummaryChart').style.visibility = 'hidden';
        }

        function hideChartLoader() {
            document.getElementById('billingSummaryChartLoader').style.display = 'none';
            document.getElementById('billingSummaryChart').style.visibility = 'visible';
        }

        function renderBillingSummaryChart(billingSummary) {
            // Prepare data for the chart
            const sections = billingSummary.map(item => item.section);
            const total = billingSummary.map(item => Number(item.total));
            const discount = billingSummary.map(item => Number(item.discount_amount));
            const grandTotal = billingSummary.map(item => Number(item.grand_total));
            const paid = billingSummary.map(item => Number(item.total_payment));
            const due = billingSummary.map(item => Number(item.due_amount));

            const options = {
                chart: {
                    type: 'bar',
                    height: 350,
                    stacked: true,
                    toolbar: {
                        show: true
                    }
                },
                plotOptions: {
                    bar: {
                        horizontal: false
                    }
                },
                dataLabels: {
                    enabled: false
                },
                series: [{
                        name: 'Total',
                        data: total
                    },
                    {
                        name: 'Discount',
                        data: discount
                    },
                    {
                        name: 'Grand Total',
                        data: grandTotal
                    },
                    {
                        name: 'Paid',
                        data: paid
                    },
                    {
                        name: 'Due',
                        data: due
                    }
                ],
                xaxis: {
                    categories: sections,
                    title: {
                        text: 'Section'
                    }
                },
                yaxis: {
                    title: {
                        text: 'Amount'
                    }
                },
                legend: {
                    position: 'top'
                },
                fill: {
                    opacity: 1
                }
            };

            // Destroy previous chart if exists
            if (billingChart) {
                billingChart.destroy();
            }
            billingChart = new ApexCharts(document.querySelector("#billingSummaryChart"), options);
            billingChart.render();
            hideChartLoader();
        }

        $(function() {
            setDefaultDatesIfBlank();
            table = $('.data-table').DataTable({
                processing: true,
                searching: false,
                serverSide: true,
                pageLength: 50,
                lengthMenu: [
                    [50, 100, 200, 400],
                    [50, 100, 200, 400]
                ],
                ajax: {
                    url: "{{ route('reports.billing') }}",
                    data: function(d) {
                        d.section_name = $('#section_name').val();
                        d.user = $('#user').val();
                        d.charge = $('#charge').val();
                        d.charge_category = $('#charge_category').val();
                        d.charge_sub_category = $('#charge_sub_category').val();
                        d.doctor = $('#doctor').val();
                        d.doctor_type = $('#doctor_type').val();
                        d.payment = $('#payment').val();
                        d.patient_type = $('#patient_type').val();
                        d.discount = $('#discount').val();
                        d.discount_amount = $('#discount_amount').val();
                        d.referral = $('#referral').val();
                        d.market_by = $('#market_by').val();
                        d.provider = $('#provider').val();
                        d.from_date = $('#fromDate').val();
                        d.to_date = $('#toDate').val();
                    },
                    beforeSend: function() {
                        // showChartLoader();
                        $('#fullPageLoader').css('display', 'flex').hide().fadeIn(100);
                    },
                    dataSrc: function(json) {
                        let chargeViewHtml = '';
                        if (json.chargeInfo && json.chargeInfo.length > 0) {
                            chargeViewHtml += '<div>';
                            chargeViewHtml += '<table class="table table-bordered w-100">';
                            chargeViewHtml += '<thead><tr><th>Charge Name</th><th>Total Charge</th><th>Total Amount</th></tr></thead>';
                            chargeViewHtml += '<tbody>';
                            json.chargeInfo.forEach(charge => {
                                chargeViewHtml += `<tr>
                                    <td>${charge.charge_name}</td>
                                    <td>${charge.total_count}</td>
                                    <td>${charge.total_charge}</td>
                                </tr>`;
                            });
                            chargeViewHtml += '</tbody></table></div>';
                        } else {
                            chargeViewHtml = '';
                        }
                        document.getElementById('chargeView').innerHTML = chargeViewHtml;

                        renderBillingSummaryChart(json.billingSummary || []);
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
                        data: 'cre_date',
                        name: 'billings.patient_id',
                        title: 'Date',
                    },
                    {
                        data: 'billId',
                        name: 'billings.uid',
                        title: 'Bill NO',
                    },
                    {
                        data: 'patient_name',
                        name: 'p.name',
                        title: 'Patient',
                        render: function(data, type, row, meta) {
                            return `${row.patient_name} (${row.patient_id})`;
                        },
                    },
                    {
                        data: 'phone',
                        name: 'p.phone',
                        title: 'Mobile',
                    },
                    {
                        data: 'doctor_name',
                        name: 'u.name',
                        title: 'Doctor | Referral',
                        render: function(data, type, row, meta) {
                            return `${row.doctor_name ? 'Dr. '+row.doctor_name : '---'} |
                                    ${row.ref_by ? row.ref_by : '---'}`;
                        },
                    },
                    {
                        data: 'generated_by',
                        name: 'u1.name',
                        title: 'Created By',
                    },
                    // {
                    //     data: 'total',
                    //     name: 'billings.total',
                    //     title: 'Inv Amt',
                    // },
                    // {
                    //     data: 'grand_total',
                    //     name: 'billings.grand_total',
                    //     title: 'Net Amt',
                    // },
                    // {
                    //     data: 'discount_amount',
                    //     name: 'billings.discount_amount',
                    //     title: 'Disc Amt',
                    // },
                    // {
                    //     data: 'total_payment',
                    //     name: 'billings.total_payment',
                    //     title: 'Paid Amt',
                    // },
                    {
                        data: 'amount',
                        name: 'amount',
                        title: 'Amount',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'ref_section',
                        name: 'ref_section',
                        title: 'Overview',
                        orderable: false,
                        searchable: false
                    },
                    // {
                    //     data: 'ref_section',
                    //     name: 'billings.cradituse_bill_amount',
                    //     title: 'Ref/Adj Amt',
                    // },
                    // {
                    //     data: 'due_amount',
                    //     name: 'billings.due_amount',
                    //     title: 'Due Amt',
                    // },
                ],
                rowCallback: function(row, data) {
                    if (data.bill_status == 3) {
                        $(row).css('background-color', '#f1d1d1');
                    } else {
                        $(row).css('background-color', '#d3fdf7');
                    }
                }
            });

            // Show loader when table is processing (for reloads, filters, etc.)
            table.on('processing.dt', function(e, settings, processing) {
                if (processing) {
                    // showChartLoader();
                    $('#fullPageLoader').css('display', 'flex').hide().fadeIn(100);
                } else {
                    $('#fullPageLoader').css('display', 'none').hide().fadeOut(100);
                }
            });
        });
    </script>
@endpush
