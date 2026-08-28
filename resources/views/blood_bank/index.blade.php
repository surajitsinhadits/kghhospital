@extends('layouts.structure')
@push('title')
    <title>Dashboard</title>
@endpush
@push('css')
    <link href="{{ url('public/assets') }}/css/dashboard.css" rel="stylesheet" />
    <style>
        .card {
            margin: 0px !important;
        }
    </style>
    <style>
        /* Example badge styles, adjust as needed */
        .status-badge {
            padding: 2px 8px;
            border-radius: 12px;
            font-size: 12px;
            color: #fff;
            margin-left: 8px;
        }

        .status-badge.info {
            background: #17a2b8;
        }

        .status-badge.primary {
            background: #007bff;
        }

        .status-badge.success {
            background: #28a745;
        }

        .status-badge.danger {
            background: #dc3545;
        }

        .status-badge.secondary {
            background: #6c757d;
        }
    </style>
@endpush
@section('main-content')
    <main class="main-content">
        <div class="container">
            <!-- Stats Cards -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-content">
                        <div class="stat-info">
                            <p class="stat-title">Total Donors</p>
                            <p class="stat-value">{{ $total_doners }}</p>
                            {{-- <p class="stat-change positive">
                                <span>+12%</span>
                                <span class="change-text">from last month</span>
                            </p> --}}
                        </div>
                        <div class="stat-icon blue">
                            <i class="fas fa-users"></i>
                        </div>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-content">
                        <div class="stat-info">
                            <p class="stat-title">Blood Available</p>
                            <p class="stat-value">{{ $available_blood_unit }}</p>
                            {{-- <p class="stat-change positive">
                                <span>+5%</span>
                                <span class="change-text">from last month</span>
                            </p> --}}
                        </div>
                        <div class="stat-icon red">
                            <i class="fas fa-tint"></i>
                        </div>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-content">
                        <div class="stat-info">
                            <p class="stat-title">Donations</p>
                            <p class="stat-value">{{ $blood_donated_today }}</p>
                            {{-- <p class="stat-change positive">
                                <span>+18%</span>
                                <span class="change-text">from last month</span>
                            </p> --}}
                        </div>
                        <div class="stat-icon green">
                            <i class="fas fa-calendar"></i>
                        </div>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-content">
                        <div class="stat-info">
                            <p class="stat-title">Issued</p>
                            <p class="stat-value">{{ $issued_blood }}</p>
                            {{-- <p class="stat-change negative">
                                <span>-3%</span>
                                <span class="change-text">from last month</span>
                            </p> --}}
                        </div>
                        <div class="stat-icon purple">
                            <i class="fas fa-chart-line"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content Grid -->
            <div class="content-grid">
                <!-- Blood Inventory -->
                <div class="blood-inventory">
                    <div class="card">
                        <div class="card-header">
                            <h3>Blood Inventory <span class="subtitle">(Units Available)</span></h3>
                        </div>
                        <div class="card-content">
                            <div class="blood-types-grid">
                                @foreach ($bloodGroupSummary as $item)
                                    <div class="blood-type">
                                        <div class="blood-type-header">
                                            <span class="blood-type-name">{{ $item['blood_group'] }}</span>
                                            <span
                                                class="blood-count">{{ $item['available_blood'] }}/{{ $item['total_blood'] }}</span>
                                        </div>
                                        <div class="progress-bar">
                                            <div class="progress-fill" style="width: {{ $item['available_percentage'] }}%">
                                            </div>
                                        </div>
                                        <div class="blood-type-footer">
                                            <span class="percentage">{{ $item['available_percentage'] }}% available</span>
                                        </div>
                                    </div>
                                @endForeach
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Urgent Requests -->
                {{-- <div class="urgent-requests">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="urgent-title">Urgent Requests</h3>
                        </div>
                        <div class="card-content">
                            <div class="request-item">
                                <div class="request-header">
                                    <h4>City General Hospital</h4>
                                    <span class="urgency-badge critical">Critical</span>
                                </div>
                                <div class="request-info">
                                    <span class="blood-need">O- • 3 units needed</span>
                                </div>
                                <div class="request-details">
                                    <div class="detail-item">
                                        <i class="fas fa-clock"></i>
                                        <span>2 hours</span>
                                    </div>
                                    <div class="detail-item">
                                        <i class="fas fa-map-marker-alt"></i>
                                        <span>1.2 km</span>
                                    </div>
                                </div>
                                <button class="fulfill-btn">Fulfill Request</button>
                            </div>

                            <div class="request-item">
                                <div class="request-header">
                                    <h4>Memorial Medical Center</h4>
                                    <span class="urgency-badge high">High</span>
                                </div>
                                <div class="request-info">
                                    <span class="blood-need">A+ • 5 units needed</span>
                                </div>
                                <div class="request-details">
                                    <div class="detail-item">
                                        <i class="fas fa-clock"></i>
                                        <span>6 hours</span>
                                    </div>
                                    <div class="detail-item">
                                        <i class="fas fa-map-marker-alt"></i>
                                        <span>3.5 km</span>
                                    </div>
                                </div>
                                <button class="fulfill-btn">Fulfill Request</button>
                            </div>

                            <div class="request-item">
                                <div class="request-header">
                                    <h4>Children's Hospital</h4>
                                    <span class="urgency-badge medium">Medium</span>
                                </div>
                                <div class="request-info">
                                    <span class="blood-need">B- • 2 units needed</span>
                                </div>
                                <div class="request-details">
                                    <div class="detail-item">
                                        <i class="fas fa-clock"></i>
                                        <span>12 hours</span>
                                    </div>
                                    <div class="detail-item">
                                        <i class="fas fa-map-marker-alt"></i>
                                        <span>2.8 km</span>
                                    </div>
                                </div>
                                <button class="fulfill-btn">Fulfill Request</button>
                            </div>
                        </div>
                    </div>
                </div> --}}
            </div>

            <!-- Bottom Section -->
            <div class="bottom-grid">
                <!-- Recent Donations -->
                <!-- ... other code ... -->
                <div class="recent-donations">
                    <div class="card m-0">
                        <div class="card-header">
                            <h3>Recent Donations</h3>
                        </div>
                        <div class="card-content">
                            @foreach ($recentDonations as $item)
                                <div class="donation-item">
                                    <div class="donor-avatar">
                                        {{ strtoupper(substr($item['name'], 0, 1)) }}{{ strtoupper(substr(explode(' ', $item['name'])[1] ?? '', 0, 1)) }}
                                    </div>
                                    <div class="donation-info">
                                        <p class="donor-name">{{ $item['name'] }}</p>
                                        <p class="donation-details">
                                            1 Unit • {{ @$item['blood_group'] }}
                                            @if (!empty($item['status']))
                                                @php
                                                    // Map statuses to badge classes
                                                    $statusClassMap = [
                                                        'collected' => 'info',
                                                        'tested' => 'primary',
                                                        'approved' => 'success',
                                                        'rejected' => 'danger',
                                                    ];
                                                    $statusKey = strtolower($item['status']);
                                                    $badgeClass = $statusClassMap[$statusKey] ?? 'secondary';
                                                @endphp
                                                <span
                                                    class="status-badge {{ $badgeClass }}">{{ ucwords($item['status']) }}</span>
                                            @endif
                                        </p>
                                    </div>
                                    <div class="donation-status">
                                        <p class="donation-time">
                                            {{ \Carbon\Carbon::parse($item['created_at'])->diffForHumans() }}
                                        </p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <!-- ... other code ... -->

                <!-- Analytics Chart -->
                <div class="analytics-chart">
                    <div class="card m-0">
                        <div class="card-header">
                            <h3>Donation Analytics</h3>
                        </div>
                        <div class="card-content">
                            <div class="chart-section">
                                <h4>Monthly Donations</h4>
                                <div class="chart-placeholder">
                                    <div class="chart-bars">
                                        @foreach ($total_month_wise as $month => $percentage)
                                            <div class="chart-bar" style="height: {{ $percentage }}%"></div>
                                        @endforeach
                                    </div>
                                    <div class="chart-labels">
                                        @foreach ($total_month_wise as $month => $percentage)
                                            <span>{{ \Illuminate\Support\Str::substr($month, 0, 3) }}</span>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            <div class="chart-section">
                                <h4>Blood Type Distribution</h4>
                                <div class="distribution-grid">
                                    @foreach ($total_blood_wise as $group => $percentage)
                                        <div class="distribution-item">
                                            <div class="color-dot red"></div>
                                            <span>{{ $group }}: {{ $percentage }}%</span>
                                        </div>
                                    @endforeach                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
@push('js')
@endpush
