@extends('layouts.structure')
@push('title')
    <title>Dashboard</title>
    {{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"> --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endpush
@push('css')
    <style>
        .dashboard-container {
            display: flex;
        }

        .sidebar {
            width: 240px;
            background-color: #00695c;
            color: #fff;
            height: 100vh;
            padding: 20px;
        }

        .sidebar h2 {
            font-size: 22px;
            margin-bottom: 30px;
        }

        .sidebar ul {
            list-style: none;
            padding: 0;
        }

        .sidebar ul li {
            margin: 20px 0;
            font-size: 16px;
            cursor: pointer;
        }

        .main-content {
            flex: 1;
            padding: 20px;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .header h1 {
            font-size: 28px;
        }

        .cards {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
            gap: 20px;
            margin-top: -40px;


        }

        /* .card:hover {
                    transform: scale(1.05);

                } */

        .card {
            background-color: #fff;
            border-radius: 16px;
            padding: 20px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.19), 0 6px 6px rgba(0, 0, 0, 0.23);
            position: relative;
            border: none;

        }

        .card i {
            position: absolute;
            top: 20px;
            right: 20px;
            font-size: 24px;
            opacity: 0.2;
        }

        .card .label {
            font-size: 14px;
            opacity: 0.8;
        }

        .card .value {
            font-size: 24px;
            font-weight: bold;
            margin-top: 10px;
        }

        .green {
            background: linear-gradient(135deg, #26a69a, #80cbc4);
            color: white;
        }

        .teal {
            background: linear-gradient(135deg, #00897b, #4db6ac);
            color: white;
        }

        .blue {
            background: linear-gradient(135deg, #64b5f6, #1e88e5);
            color: white;
        }

        .yellow {
            background: linear-gradient(135deg, #ffee58, #fdd835);
            color: white;
        }

        .red {
            background: linear-gradient(135deg, #ef5350, #e53935);
            color: white;
        }

        .orange {
            background: linear-gradient(135deg, #FFD580, #FFD580);
            color: white;
        }

        .lightred {
            background: linear-gradient(135deg, #FF7276, #FF7276);
            color: white;
        }

        .purple {
            background: linear-gradient(135deg, #6f42c1, #6f42c1);
            color: white;
        }

        .charts {
            margin-top: 40px;

            gap: 20px;
        }

        canvas {
            width: 100% !important;
            height: 250px !important;
        }

        /* Table styling */
        .styled-table {
            /* width: 100%;
                                                                                                    border-collapse: collapse;
                                                                                                    margin: 25px 0;
                                                                                                    font-size: 0.9em;
                                                                                                    min-width: 400px;
                                                                                                    box-shadow: 0 0 20px rgba(0, 0, 0, 0.15);
                                                                                                    border-radius: 5px;
                                                                                                    overflow: hidden; */
            width: 100%;
            border-collapse: collapse;
            /* margin: 25px 0; */
            font-size: 14px;
            min-width: 400px;
            /* box-shadow: 0 0 20px rgba(0, 0, 0, 0.15); */
            /* border-radius: 5px; */
            overflow-x:auto;
        }

        .styled-table thead tr {
            background-color: #009879;
            color: #ffffff;
            text-align: left;
            font-weight: bold;
        }

        .styled-table th,
        .styled-table td {
            padding: 12px 15px;
        }

        .styled-table tbody tr {
            border-bottom: 1px solid #dddddd;
        }

        .styled-table tbody tr:nth-of-type(even) {
            background-color: #f3f3f3;
        }

        .styled-table tbody tr:last-of-type {
            border-bottom: 2px solid #009879;
        }

        .styled-table tbody tr:hover {
            background-color: #e0f7fa;
            color: #009879;
            font-weight: bold;
        }

        /* Caption styling */
        .styled-table caption {
            font-size: 1.2em;
            margin-bottom: 10px;
            font-weight: bold;
            color: #333;
        }

        .mrbottom {
            margin-bottom: 30px;
        }

        .iconnew {
            position: relative !important;
            top: 0 !important;
            right: 0 !important;
            left: 0 !important;
            color: #0283b6;
        }
        .newheightadd{
                height: 311px;
        }
    </style>
@endpush
@section('main-content')
    <div class="row">
        <div class="dashboard-container">
            <main class="main-content">
                <header class="header">
                    <h1>Pharmacy Dashboard</h1>

                </header>

                <section class="cards">
                    <a href="{{ route('pharmacy.requisition-lists') }}">
                        <div class="card green">
                            <i class="fas fa-pills"></i>
                            <div>Total Requisition</div>
                            <div class="value">{{ @$total_requisitions }}</div>
                        </div>
                    </a>
                    <a href="{{ route('pharmacy.issue-report') }}">
                        <div class="card teal">
                            <i class="fa-solid fa-user-plus"></i>
                            {{-- <i class="fas fa-truck"></i> --}}
                            <div>Total Issued</div>
                            <div class="value">{{ @$total_issued }}</div>
                        </div>
                    </a>
                    <a href="{{ route('pharmacy.medicine-lists') }}">

                        <div class="card blue">
                            {{-- <i class="fas fa-user-nurse"></i> --}}
                            <i class="fa-solid fa-prescription"></i>
                            <div>Total no of Medicines</div>
                            <div class="value">{{ @$total_medicines }}</div>
                        </div>
                    </a>
                    <a href="{{ route('pharmacy.purchase-lists') }}">

                        <div class="card yellow">
                            <i class="fas fa-capsules"></i>
                            <div>Total Purchased</div>
                            <div class="value">{{ @$total_purchase }}</div>
                        </div>
                    </a>
                    <div class="card teal">
                        {{-- <i class="fas fa-dollar-sign"></i> --}}
                        <i class="fa-solid fa-chart-line"></i>
                        <div>Total Stock Update</div>
                        <div class="value">{{ @$total_purchase_upadte }}</div>
                    </div>
                    <div class="card red">
                        {{-- <i class="fas fa-dollar-sign"></i> --}}
                        <i class="fa-solid fa-down-long"></i>
                        <div>Total Low Stock</div>
                        <div class="value">{{ @$low_stock_count }}</div>
                    </div>
                </section>
                <section class="cards">
                    <div class="card orange">
                        {{-- <i class="fas fa-dollar-sign"></i> --}}
                        <i class="fa-solid fa-money-bill"></i>
                        <div>Total Bill Done</div>
                        <div class="value">{{ @$total_bill }}</div>
                    </div>
                    <div class="card green">
                        {{-- <i class="fas fa-dollar-sign"></i> --}}
                        <i class="fa-solid fa-check"></i>
                        <div>Total Approved Bill</div>
                        <div class="value">{{ @$total_approved_bill }}</div>
                    </div>
                    <div class="card red">
                        {{-- <i class="fas fa-dollar-sign"></i> --}}
                        <i class="fa-solid fa-ban"></i>
                        <div>Total Cancelled Bill</div>
                        <div class="value">{{ @$total_cancelled_bill }}</div>
                    </div>
                    <div class="card blue">
                        {{-- <i class="fas fa-dollar-sign"></i> --}}
                        <i class="fa-solid fa-indian-rupee-sign"></i>
                        <div>Today Amount Collected</div>
                        <div class="value">{{ number_format(@$today_payment_total, 2) }}</div>
                    </div>
                    <div class="card lightred">
                        {{-- <i class="fas fa-dollar-sign"></i> --}}
                        <i class="fa-solid fa-receipt"></i>
                        <div>Total Due Amount</div>
                        <div class="value">{{ number_format(@$total_due, 2) }}</div>
                    </div>
                    <div class="card purple">
                        {{-- <i class="fas fa-dollar-sign"></i> --}}
                        <i class="fa-solid fa-money-bill-transfer"></i>
                        <div>Today Refund Amount</div>
                        <div class="value">{{ number_format(@$total_refund_today, 2) }}</div>
                    </div>
                </section>

                <section class="charts">
                    <div class="row">

                        <!-- <div class="card">
                                                                                              <div class="label">Monthly Sales</div>
                                                                                              <canvas id="monthlyPerformance"></canvas>
                                                                                            </div>
                                                                                            <div class="card">
                                                                                              <div class="label">Top-Selling Medicines</div>
                                                                                              <canvas id="patientSatisfaction"></canvas>
                                                                                            </div>
                                                                                            <div class="card">
                                                                                              <div class="label">Stock Turnover Rate</div>
                                                                                              <canvas id="turnoverRate"></canvas>
                                                                                            </div>
                                                                                            <div class="card">
                                                                                              <div class="label">Revenue vs Goal</div>
                                                                                              <canvas id="ytdGoal"></canvas>
                                                                                            </div>
                                                                                            <div class="card">
                                                                                              <div class="label">Sales Trend</div>
                                                                                              <canvas id="monthlyTrend"></canvas>
                                                                                            </div> -->
                        <div class="col-lg-6">
                            <div class="card mrbottom">
                                <div>Monthly Sales</div>
                                <canvas id="monthlyPerformance"></canvas>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="card">
                                <div>Sales Trend</div>
                                <canvas id="weeklyTrendChart"></canvas>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="card newheightadd">
                                <div>Latest Approved Bills</div>
                                <table class="styled-table">

                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Name</th>
                                            <th>Amount ₹</th>
                                            <th>Date</th>
                                            <th>Print Bill</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data as $value)
                                            <tr>
                                                <td>{{ @$value->id }}</td>
                                                <td>
                                                    @if (!is_null(@$value->internal_patient_name))
                                                        {{ @$value->internal_patient_name }}
                                                        ({{ @$value->internal_patient_uhid ?? @$value->internal_patient_id }})
                                                        <br>
                                                    @elseif (!is_null(@$value->patient_name))
                                                        {{ @$value->patient_name }}
                                                        ({{ @$value->external_patient_id }})<br>
                                                    @else
                                                        N/A
                                                    @endif
                                                </td>

                                                <td>{{ number_format(@$value->grand_total, 2) }}</td>
                                                <td>{{ dateFor(@$value->bill_date, true) }}</td>
                                                <td>
                                                    <a href="{{ route('pharmacy.med-print-bill', ed(@$value->id, true)) }}"
                                                        target="_blank" title="Print Bill">
                                                        <i class="bx bxs-printer iconnew"></i>
                                                    </a>
                                                </td>

                                            </tr>
                                        @endforeach

                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="card">
                                <div>Billing Count</div>
                                <canvas id="patientSatisfaction"></canvas>
                            </div>
                        </div>
                        {{-- <div class="col-lg-3">
                            <div class="card">
                                <div class="label">Stock Turnover Rate</div>
                                <canvas id="turnoverRate"></canvas>
                            </div>
                        </div>

                        <div class="col-lg-3">
                            <div class="card">
                                <div class="label">Revenue vs Goal</div>
                                <canvas id="ytdGoal"></canvas>
                            </div>
                        </div> --}}


                    </div>
                </section>
            </main>
        </div>
    </div>
@endsection
@push('js')
    {{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script> --}}
    <script>
        const monthlyIncome = @json($monthlyIncomeArray);
        new Chart(document.getElementById('monthlyPerformance'), {
            type: 'bar',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                datasets: [{
                    label: 'Sales (₹)',
                    data: monthlyIncome,
                    backgroundColor: '#4db6ac'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        });

        new Chart(document.getElementById('patientSatisfaction'), {
            type: 'pie',
            data: {
                labels: ['External Billing', 'Internal Billing'],
                datasets: [{
                    data: [{{ @$externalCount }}, {{ @$internalCount }}],
                    backgroundColor: ['#26a69a', '#ffa726']
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        });

        // new Chart(document.getElementById('turnoverRate'), {
        //     type: 'doughnut',
        //     data: {
        //         labels: ['Antibiotics', 'Pain Relievers', 'Supplements'],
        //         datasets: [{
        //             data: [65, 45, 30],
        //             backgroundColor: ['#66bb6a', '#42a5f5', '#ffca28']
        //         }]
        //     },
        //     options: {
        //         responsive: true,
        //         maintainAspectRatio: false
        //     }
        // });

        // new Chart(document.getElementById('ytdGoal'), {
        //     type: 'bar',
        //     data: {
        //         labels: ['Q1', 'Q2', 'Q3', 'Q4'],
        //         datasets: [{
        //                 label: '2025',
        //                 data: [18500, 21200, 19800, 22000],
        //                 backgroundColor: '#4fc3f7'
        //             },
        //             {
        //                 label: 'Goal',
        //                 data: [17000, 21000, 20000, 23000],
        //                 backgroundColor: '#ffb74d'
        //             }
        //         ]
        //     },
        //     options: {
        //         responsive: true,
        //         maintainAspectRatio: false
        //     }
        // });

        // new Chart(document.getElementById('monthlyTrend'), {
        //     type: 'line',
        //     data: {
        //         labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
        //         datasets: [{
        //                 label: 'Orders',
        //                 data: [230, 240, 250, 260, 255, 270, 280, 275, 260, 245, 250, 265],
        //                 borderColor: '#26a69a',
        //                 fill: false
        //             },
        //             {
        //                 label: 'Returns',
        //                 data: [12, 10, 9, 11, 8, 7, 6, 10, 9, 8, 6, 5],
        //                 borderColor: '#ef5350',
        //                 fill: false
        //             }
        //         ]
        //     },
        //     options: {
        //         responsive: true,
        //         maintainAspectRatio: false
        //     }
        // });

        const labels = @json($daysLabel);
        const lastWeekData = @json($lastWeek);
        const thisWeekData = @json($thisWeek);
        const lastWeekTotal = {{ $lastWeekTotal }};
        const thisWeekTotal = {{ $thisWeekTotal }};
        const thisWeekColor = thisWeekTotal < lastWeekTotal ? '#ef5350' : '#1e88e5';

        new Chart(document.getElementById('weeklyTrendChart'), {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                        label: 'Last Week',
                        data: lastWeekData,
                        borderColor: '#26a69a',
                        backgroundColor: 'rgba(38, 166, 154, 0.1)',
                        fill: false,
                        tension: 0.3
                    },
                    {
                        label: 'This Week',
                        data: thisWeekData,
                        borderColor: thisWeekColor,
                        backgroundColor: thisWeekColor + '1A',
                        fill: false,
                        tension: 0.3
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        });
    </script>
@endpush
