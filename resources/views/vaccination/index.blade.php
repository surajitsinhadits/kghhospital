@extends('layouts.structure')
@push('title')
    <title>Dashboard</title>
@endpush
@push('css')
    <link href="{{ url('public/assets') }}/css/dashboard.css" rel="stylesheet" />
    <style>
        .card {
            margin-top: 0px !important;
        }
    </style>
@endpush
@section('main-content')
    <div class="vaccination">
        <div class="dashboard">
            <!-- Stats Cards -->
            <div class="stats-grid">
                <div class="stats-card">
                    <div class="stats-card-header">
                        <span class="stats-title">Total Vaccinations</span>
                        <svg class="stats-icon" width="16" height="16" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2">
                            <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
                        </svg>
                    </div>
                    <div class="stats-content">
                        <div class="stats-value">{{ $total['vaccination'] }}</div>
                    </div>
                </div>

                <div class="stats-card">
                    <div class="stats-card-header">
                        <span class="stats-title">Active Patients</span>
                        <svg class="stats-icon" width="16" height="16" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                            <circle cx="12" cy="7" r="4"></circle>
                        </svg>
                    </div>
                    <div class="stats-content">
                        <div class="stats-value">{{ $total['patients'] }}</div>
                    </div>
                </div>

                <div class="stats-card">
                    <div class="stats-card-header">
                        <span class="stats-title">Vaccine</span>
                        <svg class="stats-icon" width="16" height="16" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2">
                            <polyline points="22,12 18,12 15,21 9,3 6,12 2,12"></polyline>
                        </svg>
                    </div>
                    <div class="stats-content">
                        <div class="stats-value">{{ $total['vaccine'] }}</div>
                    </div>
                </div>

                <div class="stats-card">
                    <div class="stats-card-header">
                        <span class="stats-title">Appointments Today</span>
                        <svg class="stats-icon" width="16" height="16" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2">
                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                            <line x1="16" y1="2" x2="16" y2="6"></line>
                            <line x1="8" y1="2" x2="8" y2="6"></line>
                            <line x1="3" y1="10" x2="21" y2="10"></line>
                        </svg>
                    </div>
                    <div class="stats-content">
                        <div class="stats-value">{{ $total['today_appointment'] }}</div>
                    </div>
                </div>
            </div>

            <!-- Vaccination Goals -->
            <div class="card vaccination-goals">
                <div class="card-header d-block">
                    <h3 class="card-title">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <polyline points="22,12 18,12 15,21 9,3 6,12 2,12"></polyline>
                        </svg>
                        Available Vaccine
                    </h3>
                </div>

                <div class="card-content">
                    <div class="row">
                        @foreach ($stockSummary as $list)
                        @php
                            $total_qty = $list->total_qty;
                            $available_qty = $list->avlb_qty;
                            $percentage = round(($available_qty / $total_qty) * 100);
                        @endphp
                        <div class="col-lg-3 px-3">
                            <div class="goal-item">
                                <div class="goal-header">
                                    <span class="goal-name">{{$list->vaccine_name}}</span>
                                    <span class="goal-percentage">{{$percentage}}%</span>
                                </div>
                                <div class="progress-bar">
                                    <div class="progress-fill" style="width: {{$percentage}}%"></div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Charts -->
            <div class="charts-grid">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Monthly Vaccination Trends</h3>
                     
                    </div>
                    <div class="card-content">
                        <canvas id="monthlyChart" width="400" height="300"></canvas>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">MONTHLY PROFIT</h3>
                        <p class="card-description"></p>
                    </div>
                    <div class="card-content">
                        <canvas id="profitChart" width="100" height="300"></canvas>
                    </div>
                </div>
            </div>

            <!-- Bottom Section -->
            <div class="bottom-section">
                <!-- Recent Vaccinations Table -->
                <div class="card recent-vaccinations">
                    <div class="card-header">
                        <h3 class="card-title">Recent Vaccinations</h3>
                    </div>
                    <div class="card-content">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>Patient Name</th>
                                    <th>Vaccine Type</th>
                                    <th>Date</th>
                                    <th>Location</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($patient_details as $list)
                                    <tr>
                                        <td class="font-medium">{{ $list->patient_name }}</td>
                                        <td>{{ $list->vaccine_name }}</td>
                                        <td>{{ dateFor($list->scheduled_date) }}</td>
                                        <td>{{ $list->district_name }}</td>
                                        <td><span class="badge completed">{{ $list->status }}</span></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Sidebar Stats -->
                <div class="sidebar-stats">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2">
                                    <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                                    <circle cx="12" cy="10" r="3"></circle>
                                </svg>
                                Top Locations
                            </h3>
                        </div>
                        <div class="card-content">
                            @foreach ($topDistricts as $row)
                                <div class="stat-row">
                                    <span>{{ $row->district_name ?? 'Unknown District' }}</span>
                                    <span class="font-bold">{{ $row->district_patient_count }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2">
                                    <circle cx="12" cy="12" r="10"></circle>
                                    <polyline points="12,6 12,12 16,14"></polyline>
                                </svg>
                                Available Stocks
                            </h3>
                        </div>
                        <div class="card-content">
                            @foreach ($stockSummary as $item)
                                <div class="stat-row">
                                    <span class="text-muted">{{ $item->vaccine_name }}</span>
                                    <span class="font-bold">{{ $item->avlb_qty }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @php
        $backgroundColors = array_fill(0, count($profits), 'rgba(139, 92, 246, 0.8)');
    @endphp
@endsection
@push('js')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Chart.js configuration for the vaccination dashboard

        // Monthly Vaccination Trends Chart
       const monthlyData = {
            labels: @json($labels),  // dynamically from Laravel controller
            datasets: [
                {
                    label: 'Stock',
                    data: @json($expenseData),
                    backgroundColor: 'rgba(59, 130, 246, 0.6)',
                    borderColor: 'rgba(59, 130, 246, 1)',
                    borderWidth: 2,
                    fill: true,
                    tension: 0.4
                },
                {
                    label: 'Issue',
                    data: @json($incomeData),
                    backgroundColor: 'rgba(16, 185, 129, 0.6)',
                    borderColor: 'rgba(16, 185, 129, 1)',
                    borderWidth: 2,
                    fill: true,
                    tension: 0.4
                }
            ]
        };
        const monthlyConfig = {
            type: 'line',
            data: monthlyData,
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    title: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(0, 0, 0, 0.1)'
                        }
                    },
                    x: {
                        grid: {
                            color: 'rgba(0, 0, 0, 0.1)'
                        }
                    }
                },
                elements: {
                    point: {
                        radius: 4,
                        hoverRadius: 6
                    }
                }
            }
        };

    // Profit Chart

    const labels = @json($labels ?? []);
    const rawProfits = @json($profits ?? []);
    const backgroundColors = @json($backgroundColors ?? []);

    const sanitizedProfits = rawProfits.map(value => value < 0 ? 0 : value);

    const ageData = {
        labels: labels,
        datasets: [{
            label: 'Profit (₹)',
            data: sanitizedProfits,
            backgroundColor: backgroundColors,
            borderColor: 'rgba(139, 92, 246, 1)',
            borderWidth: 1,
            borderRadius: 4
        }]
    };

    const profitConfig = {
        type: 'bar',
        data: ageData,
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                title: { display: false }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: value => '₹' + value
                    },
                    grid: {
                        color: 'rgba(0, 0, 0, 0.1)'
                    }
                },
                x: {
                    grid: { display: false },
                    barPercentage: 0.2,
                    categoryPercentage: 0.5
                }
            }
        }
    };



    // Initialize chart
    const ctx = document.getElementById('profitChart').getContext('2d');
    new Chart(ctx, profitConfig);


        // Initialize charts when the page loads
        document.addEventListener('DOMContentLoaded', function() {
            // Monthly Chart
            const monthlyCtx = document.getElementById('monthlyChart');
            if (monthlyCtx) {
                new Chart(monthlyCtx, monthlyConfig);
            }

            // Age Group Chart
            const ageCtx = document.getElementById('profitChart');
            if (ageCtx) {
                new Chart(ageCtx, profitConfig);
            }

            // Add some interactive features
            addInteractivity();
        });

        function addInteractivity() {
            // Search functionality
            const searchInput = document.querySelector('.search-input');
            if (searchInput) {
                searchInput.addEventListener('input', function(e) {
                    // Placeholder for search functionality
                    console.log('Searching for:', e.target.value);
                });
            }

            // Export button functionality
            const exportBtn = document.querySelector('.primary-btn');
            if (exportBtn) {
                exportBtn.addEventListener('click', function() {
                    alert('Export functionality would be implemented here');
                });
            }

            // Add hover effects to stats cards
            const statsCards = document.querySelectorAll('.stats-card');
            statsCards.forEach(card => {
                card.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-2px)';
                });

                card.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(0)';
                });
            });

            // Progress bar animation
            const progressBars = document.querySelectorAll('.progress-fill');
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const progressBar = entry.target;
                        const width = progressBar.style.width;
                        progressBar.style.width = '0%';
                        setTimeout(() => {
                            progressBar.style.width = width;
                        }, 100);
                    }
                });
            });

            progressBars.forEach(bar => {
                observer.observe(bar);
            });
        }

        // Utility function to format numbers
        function formatNumber(num) {
            if (num >= 1000000) {
                return (num / 1000000).toFixed(1) + 'M';
            } else if (num >= 1000) {
                return (num / 1000).toFixed(1) + 'K';
            }
            return num.toString();
        }

        // Utility function to update stats (for real-time updates)
        function updateStats(newData) {
            const statsValues = document.querySelectorAll('.stats-value');
            const statsChanges = document.querySelectorAll('.stats-change');

            if (newData && newData.length === statsValues.length) {
                statsValues.forEach((element, index) => {
                    if (newData[index]) {
                        element.textContent = formatNumber(newData[index].value);
                        if (statsChanges[index]) {
                            statsChanges[index].textContent = newData[index].change;
                        }
                    }
                });
            }
        }
    </script>
@endpush
