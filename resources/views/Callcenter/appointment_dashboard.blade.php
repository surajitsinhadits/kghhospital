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
                            <p class="stat-title">Appointment</p>
                            <a class="stat-value" href="{{ route('callcenter.save-call-center', ['id' => 1]) }}">Sync</a>
                        </div>
                        <div class="stat-icon blue">
                            <i class="fas fa-users"></i>
                        </div>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-content">
                        <div class="stat-info">
                            <p class="stat-title">Vaccination</p>
                            <a class="stat-value" href="{{ route('callcenter.save-call-center', ['id' => 2]) }}">Sync</a>
                        </div>
                        <div class="stat-icon red">
                            <i class="fas fa-tint"></i>
                        </div>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-content">
                        <div class="stat-info">
                            <p class="stat-title">Blood</p>
                            <a class="stat-value" href="{{ route('callcenter.save-call-center', ['id' => 3]) }}">Sync</a>
                        </div>
                        <div class="stat-icon green">
                            <i class="fas fa-calendar"></i>
                        </div>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-content">
                        <div class="stat-info">
                            <p class="stat-title">OT</p>
                            <a class="stat-value" href="{{ route('callcenter.save-call-center', ['id' => 4]) }}">Sync</a>
                        </div>
                        <div class="stat-icon purple">
                            <i class="fas fa-chart-line"></i>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </main>
@endsection
@push('js')
@endpush
