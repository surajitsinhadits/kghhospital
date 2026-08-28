@extends('layouts.structure')
@push('title')
<title>Vaccination - Professional Vaccination Management System</title>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endpush
@push('css')
<link href="{{ url('public/assets') }}/css/dashboard.css" rel="stylesheet" />
<style>
.card {
    margin-top: 0px !important;
}
</style>
<style>
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
    line-height: 1.6;
    color: #1f2937;
    background: linear-gradient(135deg, #dbeafe 0%, #ffffff 50%, #dcfce7 100%);
    min-height: 100vh;
}

.header {
    background: white;
    border-bottom: 1px solid #e5e7eb;
    box-shadow: 0 1px 3px 0 rgb(0 0 0 / 0.1);
}

.header-container {
    max-width: 1280px;
    margin: 0 auto;
    padding: 0 1rem;
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding-top: 1.5rem;
    padding-bottom: 1.5rem;
}

.logo-section {
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.logo-icon {
    background: #2563eb;
    padding: 0.5rem;
    border-radius: 0.75rem;
    color: white;
    width: 48px;
    height: 48px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.logo-text h1 {
    font-size: 1.5rem;
    font-weight: bold;
    color: #111827;
}

.logo-text p {
    font-size: 0.875rem;
    color: #6b7280;
}

.header-actions {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.status-badge {
    background: #dcfce7;
    color: #166534;
    border: 1px solid #bbf7d0;
    padding: 0.5rem 0.75rem;
    border-radius: 0.375rem;
    font-size: 0.875rem;
    display: flex;
    align-items: center;
    gap: 0.25rem;
}

.btn {
    background: #2563eb;
    color: white;
    padding: 0.5rem 1rem;
    border-radius: 0.375rem;
    border: none;
    cursor: pointer;
    font-size: 0.875rem;
    font-weight: 500;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    transition: background-color 0.2s;
}

.btn:hover {
    background: #1d4ed8;
}

.btn-outline {
    background: white;
    color: #374151;
    border: 1px solid #d1d5db;
}

.btn-outline:hover {
    background: #f9fafb;
    color: #111827;
}

.btn-sm {
    padding: 0.375rem 0.75rem;
    font-size: 0.8125rem;
}

.container {
    max-width: 1280px;
    margin: 0 auto;
    padding: 2rem 1rem;
}

.tabs {
    margin-bottom: 1.5rem;
}

.tab-list {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    background: white;
    border: 1px solid #e5e7eb;
    border-radius: 0.5rem;
    box-shadow: 0 1px 3px 0 rgb(0 0 0 / 0.1);
}

.tab-button {
    padding: 0.75rem 1rem;
    border: none;
    background: transparent;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    font-size: 0.875rem;
    font-weight: 500;
    color: #6b7280;
    transition: all 0.2s;
}

.tab-button.active {
    background: #2563eb;
    color: white;
}

.tab-content {
    display: none;
}

.tab-content.active {
    display: block;
}

.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 1.5rem;
    margin-bottom: 1.5rem;
}

.stat-card {
    border-radius: 0.5rem;
    padding: 1.5rem;
    color: white;
    box-shadow: 0 10px 15px -3px rgb(0 0 0 / 0.1);
}

.stat-card.blue {
    background: linear-gradient(135deg, #3b82f6, #2563eb);
}

.stat-card.green {
    background: linear-gradient(135deg, #10b981, #059669);
}

.stat-card.orange {
    background: linear-gradient(135deg, #f59e0b, #d97706);
}

.stat-card.purple {
    background: linear-gradient(135deg, #8b5cf6, #7c3aed);
}

.stat-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 0.5rem;
}

.stat-title {
    font-size: 0.875rem;
    opacity: 0.9;
    color:#fff!important;
}

.stat-value {
    font-size: 1.5rem;
    font-weight: bold;
    margin-bottom: 0.25rem;
    color:#fff !important;
}

.stat-change {
    font-size: 0.75rem;
    opacity: 0.8;
}

.content-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
    gap: 1.5rem;
}

.card {
    background: white;
    border-radius: 0.5rem;
    box-shadow: 0 10px 15px -3px rgb(0 0 0 / 0.1);
    overflow: hidden;
}

.card-header {
    padding: 1.5rem 1.5rem 0 1.5rem;
}

.card-title {
    font-size: 1.125rem;
    font-weight: 600;
    color: #1f2937;
    margin-bottom: 0.25rem;
}

.card-description {
    font-size: 0.875rem;
    color: #6b7280;
}

.card-content {
    padding: 1.5rem;
    padding-top: 0;
}

.upcoming-list {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.upcoming-item {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 0.75rem;
    background: #f9fafb;
    border-radius: 0.5rem;
}

.upcoming-left {
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.upcoming-icon {
    width: 2.5rem;
    height: 2.5rem;
    background: #dbeafe;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #2563eb;
}

.upcoming-info h4 {
    font-weight: 500;
    color: #111827;
    margin-bottom: 0.125rem;
}

.upcoming-info p {
    font-size: 0.875rem;
    color: #6b7280;
}

.upcoming-right {
    text-align: right;
}

.upcoming-date {
    font-size: 0.875rem;
    font-weight: 500;
    color: #111827;
    margin-bottom: 0.25rem;
}

.badge {
    padding: 0.25rem 0.5rem;
    border-radius: 0.375rem;
    font-size: 0.75rem;
    font-weight: 500;
}

.badge.routine {
    background: #dbeafe;
    color: #1e40af;
}

.badge.seasonal {
    background: #f3f4f6;
    color: #374151;
}

.patient-list {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.patient-item {
    background: white;
    border: 1px solid #e5e7eb;
    border-radius: 0.5rem;
    padding: 1rem;
    transition: box-shadow 0.2s;
}

.patient-item:hover {
    box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1);
}

.patient-main {
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.patient-left {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.patient-avatar {
    width: 48px;
    height: 48px;
    background: #dbeafe;
    color: #2563eb;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 600;
}

.patient-details h3 {
    font-weight: 600;
    color: #111827;
    margin-bottom: 0.25rem;
}

.patient-meta {
    display: flex;
    align-items: center;
    gap: 1rem;
    font-size: 0.875rem;
    color: #6b7280;
}

.patient-right {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.patient-vaccine {
    text-align: right;
}

.patient-vaccine div {
    display: flex;
    align-items: center;
    gap: 0.25rem;
    font-size: 0.875rem;
    color: #6b7280;
    margin-bottom: 0.25rem;
}

.badge.due {
    background: #fef3c7;
    color: #92400e;
}

.badge.scheduled {
    background: #dbeafe;
    color: #1e40af;
}

.badge.upcoming {
    background: #dcfce7;
    color: #166534;
}

.badge.overdue {
    background: #fee2e2;
    color: #991b1b;
}

.search-filters {
    display: flex;
    flex-direction: column;
    gap: 1rem;
    margin-bottom: 1.5rem;
}

.search-input {
    flex: 1;
    position: relative;
}

.search-input input {
    width: 100%;
    padding: 0.5rem 0.75rem 0.5rem 2.5rem;
    border: 1px solid #d1d5db;
    border-radius: 0.375rem;
    font-size: 0.875rem;
}

.search-icon {
    position: absolute;
    left: 0.75rem;
    top: 50%;
    transform: translateY(-50%);
    color: #9ca3af;
}

.filter-row {
    display: flex;
    gap: 0.5rem;
    flex-wrap: wrap;
}

select {
    padding: 0.5rem 0.75rem;
    border: 1px solid #d1d5db;
    border-radius: 0.375rem;
    background: white;
    font-size: 0.875rem;
}

.progress-bar {
    width: 100%;
    height: 0.5rem;
    background: #e5e7eb;
    border-radius: 0.25rem;
    overflow: hidden;
}

.progress-fill {
    height: 100%;
    background: #3b82f6;
    transition: width 0.3s ease;
}

.age-stats {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.age-stat-item {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.age-stat-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.age-stat-header span:first-child {
    font-size: 0.875rem;
    font-weight: 500;
    color: #374151;
}

.age-stat-meta {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.875rem;
    color: #6b7280;
}

.pie-chart {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1rem;
    margin-top: 1rem;
}

.pie-legend {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.legend-item {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.75rem;
    color: #6b7280;
}

.legend-color {
    width: 0.75rem;
    height: 0.75rem;
    border-radius: 50%;
}

.reminder-tabs {
    display: flex;
    background: #f9fafb;
    border-radius: 0.5rem;
    padding: 0.25rem;
    margin-bottom: 1.5rem;
}

.reminder-tab {
    flex: 1;
    padding: 0.5rem 1rem;
    border: none;
    background: transparent;
    cursor: pointer;
    border-radius: 0.375rem;
    font-size: 0.875rem;
    font-weight: 500;
    color: #6b7280;
    transition: all 0.2s;
}

.reminder-tab.active {
    background: white;
    color: #111827;
    box-shadow: 0 1px 3px 0 rgb(0 0 0 / 0.1);
}

.reminder-queue {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.reminder-item {
    background: white;
    border: 1px solid #e5e7eb;
    border-radius: 0.5rem;
    padding: 1rem;
    transition: box-shadow 0.2s;
}

.reminder-item:hover {
    box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1);
}

.reminder-main {
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.icon {
    width: 16px;
    height: 16px;
    fill: currentColor;
}
.upcoming-icon .icon {
    width: 16px;
    height: 16px;
    fill: #2563eb;
}
.tab-list.icon {
    width: 16px;
    height: 16px;
    fill:#000 !important;
}
@media (min-width: 640px) {
    .search-filters {
        flex-direction: row;
        align-items: center;
    }

    .filter-row {
        flex-wrap: nowrap;
    }
}

@media (max-width: 768px) {
    .header-container {
        flex-direction: column;
        gap: 1rem;
        text-align: center;
    }

    .stats-grid {
        grid-template-columns: 1fr;
    }

    .content-grid {
        grid-template-columns: 1fr;
    }

    .tab-list {
        grid-template-columns: 1fr;
    }

    .patient-main,
    .reminder-main {
        flex-direction: column;
        align-items: flex-start;
        gap: 1rem;
    }

    .patient-right {
        width: 100%;
        justify-content: space-between;
    }
}
</style>
<style>
.badge {
    display: inline-block;
    padding: 2px 8px;
    border-radius: 10px;
    font-size: 12px;
    font-weight: 500;
    color: white;
    text-transform: capitalize;
}

.badge.success {
    background-color: #28a745;
}

.badge.danger {
    background-color: #dc3545;
}

.badge.warning {
    background-color: #ffc107;
    color: #212529; /* dark text for yellow */
}

.badge.secondary {
    background-color: #6c757d;
}

</style>

@endpush
@section('main-content')
<div class="vaccination">
    <div class="dashboard">
        <div class="container">
            <!-- Tabs -->
            <div class="tabs">
                <div class="tab-list">
                    <button class="tab-button active" data-tab="dashboard">
                        <svg class="icon new" viewBox="0 0 24 24">
                            <path d="M3 3v5h5" />
                            <path d="M3 12a9 9 0 0 1 9-9" />
                            <path d="m3 8 6 6 8-8" />
                        </svg>
                        Dashboard
                    </button>
                    <button class="tab-button" data-tab="patients">
                        <svg class="icon" viewBox="0 0 24 24">
                            <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2" />
                            <circle cx="9" cy="7" r="4" />
                            <path d="m22 21-3-3" />
                            <path d="m15 18 3 3" />
                        </svg>
                        Patients
                    </button>
                    <button class="tab-button" data-tab="reports">
                        <svg class="icon" viewBox="0 0 24 24">
                            <path d="M8 2v4" />
                            <path d="M16 2v4" />
                            <rect width="18" height="18" x="3" y="4" rx="2" />
                            <path d="M3 10h18" />
                        </svg>
                        Age Reports
                    </button>
                    <button class="tab-button" data-tab="reminders">
                        <svg class="icon" viewBox="0 0 24 24">
                            <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z" />
                            <polyline points="22,6 12,13 2,6" />
                        </svg>
                        Schedule
                    </button>
                </div>
            </div>

            <!-- Dashboard Tab -->
            <div class="tab-content active" id="dashboard">
                <!-- Statistics Cards -->
                <div class="stats-grid">
                    <div class="stat-card blue">
                        <div class="stat-header">
                            <div class="stat-title">Total Patients</div>
                            <svg class="icon" viewBox="0 0 24 24">
                                <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2" />
                                <circle cx="9" cy="7" r="4" />
                                <path d="m22 21-3-3" />
                                <path d="m15 18 3 3" />
                            </svg>
                        </div>
                        <div class="stat-value">{{$total['patients_one_month']}}</div>
                        <div class="stat-change">
                            @if($percentageChange !== null)
                                @if($percentageChange > 0)
                                    +{{ round($percentageChange, 2) }}% from last month
                                @elseif($percentageChange < 0)
                                    {{ round($percentageChange, 2) }}% from last month
                                @else
                                    No change from last month
                                @endif
                            @else
                                N/A
                            @endif
                        </div>
                    </div>

                    <div class="stat-card green">
                        <div class="stat-header">
                            <div class="stat-title">Vaccinated Today</div>
                            <svg class="icon" viewBox="0 0 24 24">
                                <path d="m18 2 4 4-8 8-8-8 4-4" />
                                <path d="m14.5 9.5-7 7" />
                                <path d="m7.5 16.5 7-7" />
                            </svg>
                        </div>
                        <div class="stat-value">{{ $total['vaccination_today'] }}</div>
                        <div class="stat-change">
                            <!-- +8% from yesterday -->
                        @if($vaccinationChange !== null)
                                @if($vaccinationChange > 0)
                                    +{{ round($vaccinationChange, 2) }}% from yesterday
                                @elseif($vaccinationChange < 0)
                                    {{ round($vaccinationChange, 2) }}% from yesterday
                                @else
                                    No change from last day
                                @endif
                            @else
                                N/A
                            @endif
                        </div>
                    </div>

                    <div class="stat-card orange">
                        <div class="stat-header">
                            <div class="stat-title">Pending Vaccination</div>
                            <svg class="icon" viewBox="0 0 24 24">
                                <path d="M6 8a6 6 0 0 1 12 0c0 7 3 9 3 9H3s3-2 3-9" />
                                <path d="m13.73 21a2 2 0 0 1-3.46 0" />
                            </svg>
                        </div>
                        <div class="stat-value">{{ $total['pending_reminder'] }}</div>
                        <div class="stat-change">Next week</div>
                    </div>

                    <div class="stat-card purple">
                        <div class="stat-header">
                            <div class="stat-title">Completed Vaccinations</div>
                            <svg class="icon" viewBox="0 0 24 24">
                                <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z" />
                            </svg>
                        </div>
                        <div class="stat-value">{{ $total['vaccination_year'] }}</div>
                        <div class="stat-change">This year</div>
                    </div>
                </div>

                <div class="content-grid">
                    <!-- Vaccination Chart -->
                    <div class="card">
                        <div class="card-header" style="display: flex; flex-direction: column;">
                        <div class="card-title">Monthly Vaccination Trends</div>
                        </div>
                        <div class="chart-container">
                        <div class="card-content">
                            <canvas id="monthlyChart" width="400" height="300"></canvas>
                        </div>
                        </div>
                    </div>

                    <!-- Upcoming Vaccinations -->
                    <div class="card">
                        <div class="card-header text-center">
                            <h4 class="card-title mb-1">MONTHLY PROFIT</h4>
                        </div>
                          <div class="card-content">
                        <canvas id="profitChart" width="100" height="300"></canvas>
                        </div>
                    </div>
                </div>
                <div class="content-grid">
                    <!-- Vaccination Chart -->
                     <div class="card">
                        <div class="card-header" style="display: flex; flex-direction: column;">
                               <div class="card-title">Vaccine Type Distribution</div>
                        </div>
                        <div class="chart-container">
                            <!-- <div class="card-body" style="height: 350px;">
                                <canvas id="vaccineChart" style="width: 100%; height: 100%;"></canvas>
                            </div> -->
                            <div style="max-width: 600px; margin: 0 auto;">
                                <canvas id="vaccineChart" height="400"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Patients Tab -->
            <div class="tab-content" id="patients">
                <div class="card">
                    <div class="card-header">
                        <div style="">
                            <div>
                                <div class="card-title">Patient Management</div>
                                <div class="card-description">Manage patient records and vaccination schedules</div>
                            </div>
                            <a href="{{ route('vc.vaccination-register') }}" class="btn" style="display: inline-flex; align-items: center; gap: 0.5rem;position: relative;top: -43px;left: 324%;">
                              <i class="fas fa-plus"></i>
                                Add Patient
                            </a>
                        </div>
                    </div>
                    <div class="card-content">
                        <div class="search-filters">
                            <div class="search-input">
                                <svg class="search-icon icon" viewBox="0 0 24 24">
                                    <circle cx="11" cy="11" r="8" />
                                    <path d="m21 21-4.35-4.35" />
                                </svg>
                               <input type="text" placeholder="Search patients by name or phone..." id="patientSearch" />
                            </div>
                            <div class="filter-row">
                                <select id="ageFilter">
                                    <option value="all">All Ages</option>
                                    <option value="0-12">0-12 years</option>
                                    <option value="13-18">13-18 years</option>
                                    <option value="19-49">19-49 years</option>
                                    <option value="50-64">50-64 years</option>
                                    <option value="65+">65+ years</option>
                                </select>
                            </div>
                        </div>

                        <div class="patient-list">
                            @foreach($total['patients'] as $list)
                            <div class="patient-item searchable-patient" data-age="{{ @$list->age }}">
                                <div class="patient-main">
                                    <div class="patient-left">
                                        <div class="patient-avatar">
                                            {{ strtoupper(collect(explode(' ', @$list->patient_name))->map(function($part) {
                                                return substr($part, 0, 1);
                                            })->implode('')) }}
                                        </div>
                                        <div>
                                            <div class="patient-details" >
                                                <h3>{{@$list->patient_name}}</h3>
                                                <div class="patient-meta">
                                                    <span>@if(!empty($list->age))Age: {{ $list->age }}@endif</span>
                                                    <span style="display: flex; align-items: center; gap: 0.25rem;">
                                                        <svg class="icon" viewBox="0 0 24 24"
                                                            style="width: 12px; height: 12px;">
                                                            <path
                                                                d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z" />
                                                            <polyline points="22,6 12,13 2,6" />
                                                        </svg>
                                                        {{@$list->patient_email}}
                                                    </span>
                                                    <span style="display: flex; align-items: center; gap: 0.25rem;">
                                                        <svg class="icon" viewBox="0 0 24 24"
                                                            style="width: 12px; height: 12px;">
                                                            <path
                                                                d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z" />
                                                        </svg>
                                                         {{@$list->patient_phone}}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="patient-right">
                                        <div class="patient-vaccine">
                                            <div>
                                                <svg class="icon" viewBox="0 0 24 24"
                                                    style="width: 12px; height: 12px;">
                                                    <path d="m18 2 4 4-8 8-8-8 4-4" />
                                                    <path d="m14.5 9.5-7 7" />
                                                    <path d="m7.5 16.5 7-7" />
                                                </svg>
                                                VCC NAME: {{@$list->vaccine_nm}}
                                            </div>
                                            <div>
                                                <svg class="icon" viewBox="0 0 24 24"
                                                    style="width: 12px; height: 12px;">
                                                    <path d="M8 2v4" />
                                                    <path d="M16 2v4" />
                                                    <rect width="18" height="18" x="3" y="4" rx="2" />
                                                    <path d="M3 10h18" />
                                                </svg>
                                                @if(@$list->status == 'scheduled' || @$list->status == 'missed')
                                                    {{ dateFor(@$list->scheduled_date) }}
                                                @else
                                                    {{ dateFor(@$list->administered_date) }}
                                                @endif
                                            </div>
                                        </div>
                                        @php
                                            $status = strtolower(@$list->status);
                                            $badgeClass = match($status) {
                                                'scheduled' => 'warning',
                                                'missed' => 'danger',
                                                'completed' => 'success',
                                                default => 'secondary'
                                            };
                                        @endphp
                                     <div class="badge {{ $badgeClass }}">{{ @$list->status }}</div>
                                        <div style="display: flex; gap: 0.5rem;">
                                            <a href="{{ route('vc.view-vaccination', ed($list->id, true)) }}" class="btn-outline btn-sm">View</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <!-- Age Reports Tab -->
            <div class="tab-content" id="reports">
                <!-- Summary Cards -->
                <div class="stats-grid">
                    <div class="stat-card blue">
                        <div class="stat-header">
                            <div class="stat-title">Total Patients</div>
                            <svg class="icon" viewBox="0 0 24 24">
                                <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2" />
                                <circle cx="9" cy="7" r="4" />
                                <path d="m22 21-3-3" />
                                <path d="m15 18 3 3" />
                            </svg>
                        </div>
                        <div class="stat-value">{{$total['patients_one_month']}}</div>
                        <div class="stat-change">
                            @if($percentageChange !== null)
                                @if($percentageChange > 0)
                                    +{{ round($percentageChange, 2) }}% from last month
                                @elseif($percentageChange < 0)
                                    {{ round($percentageChange, 2) }}% from last month
                                @else
                                    No change from last month
                                @endif
                            @else
                                N/A
                            @endif
                        </div>
                    </div>

                    <div class="stat-card green">
                        <div class="stat-header">
                            <div class="stat-title">Total Pediatric Patients</div>
                            <svg class="icon" viewBox="0 0 24 24">
                                <path d="M6 9H4.5a2.5 2.5 0 0 1 0-5H6" />
                                <path d="M14 15h1.5a2.5 2.5 0 0 1 0 5H14" />
                                <path d="M6 2v6" />
                                <path d="M14 16v6" />
                                <path d="M6 16a6 6 0 0 1 12 0" />
                            </svg>
                        </div>
                        <div class="stat-value">{{$total['children_count_one_month']}}</div>
                        <div class="stat-change">
                            <!-- +5% from last month -->
                            @if($childrenPercentageChange !== null)
                                @if($childrenPercentageChange > 0)
                                    +{{ round($childrenPercentageChange, 2) }}% from last month
                                @elseif($childrenPercentageChange < 0)
                                    {{ round($childrenPercentageChange, 2) }}% from last month
                                @else
                                    No change from last month
                                @endif
                            @else
                                N/A
                            @endif
                        </div>
                    </div>

                    <div class="stat-card purple">
                        <div class="stat-header">
                            <div class="stat-title">Total Adult Patients</div>
                            <svg class="icon" viewBox="0 0 24 24">
                                <path d="M3 3v5h5" />
                                <path d="M3 12a9 9 0 0 1 9-9" />
                                <path d="m3 8 6 6 8-8" />
                            </svg>
                        </div>
                        <div class="stat-value">{{$total['adult_count_one_month']}}</div>
                        <div class="stat-change">
                            <!-- 94% completion rate -->
                             @if($adultPercentageChange !== null)
                                @if($adultPercentageChange > 0)
                                    +{{ round($childrenPercentageChange, 2) }}% from last month
                                @elseif($adultPercentageChange < 0)
                                    {{ round($adultPercentageChange, 2) }}% from last month
                                @else
                                    No change from last month
                                @endif
                            @else
                                N/A
                            @endif
                        </div>
                    </div>

                    <div class="stat-card orange">
                        <div class="stat-header">
                            <div class="stat-title">Total Geriatric Patients</div>
                            <svg class="icon" viewBox="0 0 24 24">
                                <path d="M8 2v4" />
                                <path d="M16 2v4" />
                                <rect width="18" height="18" x="3" y="4" rx="2" />
                                <path d="M3 10h18" />
                            </svg>
                        </div>
                        <div class="stat-value">{{$total['senior_citizens_count_one_month']}}</div>
                        <div class="stat-change">
                             @if($seniorCitizensPercentageChange !== null)
                                @if($seniorCitizensPercentageChange > 0)
                                    +{{ round($childrenPercentageChange, 2) }}% from last month
                                @elseif($seniorCitizensPercentageChange < 0)
                                    {{ round($seniorCitizensPercentageChange, 2) }}% from last month
                                @else
                                    No change from last month
                                @endif
                            @else
                                N/A
                            @endif
                        </div>
                    </div>
                </div>

                <div class="content-grid">
                <!-- Vaccine Type Distribution -->
                    <div class="card shadow-sm mt-4">
                        <div class="card-header" style="display: flex; flex-direction: column;">
                            <h5 class="mb-0">Vaccination Status by Age Group</h5>
                        </div>

                        <div class="chart-container">
                            <div class="card-content">
                                <div class="age-stats">
                                    <div class="age-stat-item">
                                        <div class="age-stat-header">
                                            <span>0-2 years</span>
                                            <div class="age-stat-meta">
                                                <div class="badge"
                                                    style="background: rgba(59, 130, 246, 0.1); color: #3b82f6; border: 1px solid #3b82f6;">
                                                @if($onePercentageChange > 0)
                                                    +{{ round($onePercentageChange, 2) }}% 
                                                @elseif($onePercentageChange < 0)
                                                    {{ round($onePercentageChange, 2) }}% 
                                                @else
                                                    0%
                                                @endif
                                            </div>
                                            </div>
                                        </div>
                                        <div class="progress-bar">
                                            <div class="progress-fill" style="width: {{ round($onePercentageChange, 2) }}%; background: #3b82f6;"></div>
                                        </div>
                                    </div>

                                    <div class="age-stat-item">
                                        <div class="age-stat-header">
                                            <span>3-6 years</span>
                                            <div class="age-stat-meta">
                                                <div class="badge"
                                                    style="background: rgba(16, 185, 129, 0.1); color: #10b981; border: 1px solid #10b981;">
                                                    @if($secondPercentageChange > 0)
                                                        +{{ round($secondPercentageChange, 2) }}% 
                                                    @elseif($secondPercentageChange < 0)
                                                        {{ round($secondPercentageChange, 2) }}% 
                                                    @else
                                                        0%
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="progress-bar">
                                            <div class="progress-fill" style="width: {{ round($secondPercentageChange, 2) }}%; background: #10b981;"></div>
                                        </div>
                                    </div>

                                    <div class="age-stat-item">
                                        <div class="age-stat-header">
                                            <span>7-12 years</span>
                                            <div class="age-stat-meta">
                                                <div class="badge"
                                                    style="background: rgba(245, 158, 11, 0.1); color: #f59e0b; border: 1px solid #f59e0b;">
                                                    @if($thirdPercentageChange > 0)
                                                        +{{ round($thirdPercentageChange, 2) }}% 
                                                    @elseif($thirdPercentageChange < 0)
                                                        {{ round($thirdPercentageChange, 2) }}% 
                                                    @else
                                                        0%
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="progress-bar">
                                            <div class="progress-fill" style="width: {{ round($thirdPercentageChange, 2) }}%; background: #f59e0b;"></div>
                                        </div>
                                    </div>

                                    <div class="age-stat-item">
                                        <div class="age-stat-header">
                                            <span>13-18 years</span>
                                            <div class="age-stat-meta">
                                                <div class="badge"
                                                    style="background: rgba(239, 68, 68, 0.1); color: #ef4444; border: 1px solid #ef4444;">
                                                    @if($fourthPercentageChange > 0)
                                                        +{{ round($fourthPercentageChange, 2) }}% 
                                                    @elseif($fourthPercentageChange < 0)
                                                        {{ round($fourthPercentageChange, 2) }}% 
                                                    @else
                                                        0%
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="progress-bar">
                                            <div class="progress-fill" style="width: {{ round($fourthPercentageChange, 2) }}%; background: #ef4444;"></div>
                                        </div>
                                    </div>

                                    <div class="age-stat-item">
                                        <div class="age-stat-header">
                                            <span>65+ years</span>
                                            <div class="age-stat-meta">
                                                <div class="badge"
                                                    style="background: rgba(132, 204, 22, 0.1); color: #84cc16; border: 1px solid #84cc16;">
                                                    @if($fifthPercentageChange > 0)
                                                        +{{ round($fifthPercentageChange, 2) }}% 
                                                    @elseif($fifthPercentageChange < 0)
                                                        {{ round($fifthPercentageChange, 2) }}% 
                                                    @else
                                                        0%
                                                    @endif</div>
                                            </div>
                                        </div>
                                        <div class="progress-bar">
                                            <div class="progress-fill" style="width: {{ round($fifthPercentageChange, 2) }}%; background: #84cc16;"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                     <div class="card shadow-sm mt-4">
                        <div class="card-header" style="display: flex; flex-direction: column;">
                            <h5 class="mb-0">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2">
                                    <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                                    <circle cx="12" cy="10" r="3"></circle>
                                </svg>
                                Top Locations
                            </h5>
                        </div>
                        <div class="chart-container">
                            <div class="card-content">
                                @foreach ($topDistricts as $row)
                                    <div class="stat-row">
                                        <span style="font-size: 16px; font-weight: 600;">{{ $row->district_name ?? 'Unknown District' }}</span>
                                        <span class="font-bold" style="font-size: 16px; font-weight: 600;">{{ $row->district_patient_count }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Reminders Tab -->
            <div class="tab-content" id="reminders">
               

                <!-- Active Reminders -->
                <div class="reminder-content active" id="reminder-reminders">
                    <div class="card">
                        <div class="card-header">
                            <div style="display: flex; justify-content: space-between; align-items: center;">
                                <div>
                                    <div class="card-title">Scheduled Vaccination</div>
                                </div>
                            </div>
                        </div>
                        <div class="card-content">
                            <div class="reminder-queue">
                                @forelse($total['scheduled'] as $list)
                                    <div class="reminder-item">
                                        <div class="reminder-main">
                                            <div class="patient-left">
                                                <div class="upcoming-icon">
                                                    <svg class="icon" viewBox="0 0 24 24">
                                                        <path d="M22 2 11 13" />
                                                        <path d="m11 13 5.5-5.5a7.07 7.07 0 0 0-5-5l-5.5 5.5" />
                                                        <path d="M13 11h7" />
                                                    </svg>
                                                </div>
                                                <div>
                                                    <div class="patient-details">
                                                        <h3>{{ @$list->patient_name }}</h3>
                                                        <div class="patient-meta">
                                                            <span>@if(!empty($list->age))Age: {{ $list->age }}@endif</span>
                                                            <span>{{ @$list->vaccine_nm }}</span>
                                                            <span style="display: flex; align-items: center; gap: 0.25rem;">
                                                                <svg class="icon" viewBox="0 0 24 24" style="width: 12px; height: 12px;">
                                                                    <path d="M8 2v4" />
                                                                    <path d="M16 2v4" />
                                                                    <rect width="18" height="18" x="3" y="4" rx="2" />
                                                                    <path d="M3 10h18" />
                                                                </svg>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="patient-right">
                                                <div class="badge" style="background: #fef3c7; color: #92400e;">Due: {{ dateFor(@$list->scheduled_date) }}</div>
                                                <div style="display: flex; gap: 0.5rem;">
                                                    <a href="{{ route('vc.edit-vaccination', ed(@$list->id, true)) }}">
                                                        <button class="btn-outline btn-sm">Edit</button>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="text-center text-gray-500 py-4">No data present</div>
                                @endforelse
                            </div>
                        </div>
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
<script>
// Tab functionality
const tabButtons = document.querySelectorAll('.tab-button');
const tabContents = document.querySelectorAll('.tab-content');

tabButtons.forEach(button => {
    button.addEventListener('click', () => {
        const tabId = button.getAttribute('data-tab');

        // Remove active class from all tabs and contents
        tabButtons.forEach(btn => btn.classList.remove('active'));
        tabContents.forEach(content => content.classList.remove('active'));

        // Add active class to clicked tab and corresponding content
        button.classList.add('active');
        document.getElementById(tabId).classList.add('active');
    });
});
</script>
<script>
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
<script>
    document.getElementById('patientSearch').addEventListener('keyup', function () {
        const query = this.value.toLowerCase();
        const patients = document.querySelectorAll('.searchable-patient');

        patients.forEach(patient => {
            const text = patient.textContent.toLowerCase();
            if (text.includes(query)) {
                patient.style.display = '';
            } else {
                patient.style.display = 'none';
            }
        });
    });
</script>
<script>
    function filterPatients() {
        const query = document.getElementById('patientSearch')?.value.toLowerCase() || '';
        const ageRange = document.getElementById('ageFilter').value;
        const patients = document.querySelectorAll('.searchable-patient');

        patients.forEach(patient => {
            const text = patient.textContent.toLowerCase();
            const age = parseInt(patient.dataset.age) || 0;

            let ageMatch = true;
            if (ageRange !== 'all') {
                const [min, max] = ageRange.includes('+') 
                    ? [parseInt(ageRange), Infinity] 
                    : ageRange.split('-').map(Number);
                ageMatch = age >= min && age <= max;
            }

            const textMatch = text.includes(query);

            patient.style.display = (textMatch && ageMatch) ? '' : 'none';
        });
    }

    document.getElementById('patientSearch')?.addEventListener('keyup', filterPatients);
    document.getElementById('ageFilter').addEventListener('change', filterPatients);
</script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const ctx = document.getElementById('vaccineChart');
        if (!ctx) return;

        // Pass Laravel data to JS
        const vaccineData = @json($vaccine_issuse);

        // Extract labels and counts
        const labels = vaccineData.map(item => item.vaccine_name);
        const dataCounts = vaccineData.map(item => item.total);

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'No. of Vaccinations',
                    data: dataCounts,
                    backgroundColor: '#4e73df',
                    borderRadius: 5
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: { precision: 0 }
                    }
                }
            }
        });
    });
</script>
@endpush