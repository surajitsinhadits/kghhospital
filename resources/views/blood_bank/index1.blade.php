@extends('layouts.structure')
@push('title')
    <title>Dashboard</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endpush
@push('css')
    <link href="{{ url('public/assets') }}/css/dashboard.css" rel="stylesheet" />
    <style>
        .card {
            margin: 0px !important;
        }
    </style>
     <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: linear-gradient(135deg, #fef2f2 0%, #ffffff 50%, #fdf2f8 100%);
            min-height: 100vh;
            color: #374151;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 24px;
        }

        .header {
            text-align: center;
            margin-bottom: 32px;
            padding: 32px 0;
        }

        .header-title {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            margin-bottom: 16px;
        }

        .header-icon {
            width: 48px;
            height: 48px;
            background: #dc2626;
            border-radius: 50%;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
        }

        .header h1 {
            font-size: 2.5rem;
            font-weight: bold;
            background: linear-gradient(to right, #dc2626, #e91e63);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .header p {
            font-size: 1.25rem;
            color: #6b7280;
            max-width: 600px;
            margin: 0 auto;
        }

        .alert {
            background: #fef2f2;
            border-left: 4px solid #dc2626;
            padding: 16px;
            margin-bottom: 24px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            gap: 12px;
            animation: pulse 2s infinite;
        }

        .alert-icon {
            color: #dc2626;
            font-size: 20px;
        }

        .alert-content h3 {
            font-weight: 600;
            margin-bottom: 4px;
        }

        .alert-actions {
            margin-left: auto;
            display: flex;
            gap: 8px;
        }

        .btn {
            padding: 8px 16px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 500;
            transition: all 0.2s;
        }

        .btn-primary {
            background: #dc2626;
            color: white;
        }

        .btn-primary:hover {
            background: #b91c1c;
        }

        .btn-ghost {
            background: transparent;
            color: #6b7280;
        }

        .btn-ghost:hover {
            background: #f3f4f6;
        }

        .metrics-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 24px;
            margin-bottom: 32px;
        }

        .metric-card {
            background: white;
            padding: 24px;
            border-radius: 12px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            border-left: 4px solid;
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .metric-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .metric-card:nth-child(1) { border-left-color: #dc2626; }
        .metric-card:nth-child(2) { border-left-color: #2563eb; }
        .metric-card:nth-child(3) { border-left-color: #16a34a; }
        .metric-card:nth-child(4) { border-left-color: #ea580c; }

        .metric-header {
            display: flex;
            justify-content: between;
            align-items: center;
            margin-bottom: 12px;
        }

        .metric-title {
            font-size: 0.875rem;
            font-weight: 500;
            color: #6b7280;
        }

        .metric-icon {
            font-size: 16px;
        }

        .metric-value {
            font-size: 2rem;
            font-weight: bold;
            margin-bottom: 4px;
        }

        .metric-change {
            font-size: 0.75rem;
            color: #6b7280;
        }

        .blood-groups-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
            gap: 16px;
            margin-bottom: 32px;
            background: white;
            padding: 24px;
            border-radius: 12px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .blood-group-container {
            display: grid;
            grid-template-columns: repeat(4, 1fr); /* 4 per row */
            gap: 20px; /* space between items */
            margin-top: 15px;
        }

        .blood-group {
            text-align: center;
            padding: 10px;
        }

        .blood-group-type {
            font-size: 1.5rem;
            font-weight: bold;
            color: #dc2626;
            margin-bottom: 8px;
        }

        .blood-group-units {
            font-size: 1.125rem;
            font-weight: 600;
            margin-bottom: 8px;
        }

        .blood-group-status {
            padding: 4px 8px;
            border-radius: 12px;
            font-size: 0.75rem;
            font-weight: 600;
            margin-bottom: 4px;
        }

        .status-normal {
            background: #dcfce7;
            color: #166534;
        }

        .status-low {
            background: #fef3c7;
            color: #92400e;
        }

        .status-critical {
            background: #fee2e2;
            color: #991b1b;
        }

        .blood-group-percentage {
            font-size: 0.75rem;
            color: #6b7280;
        }

        .tabs {
            margin-bottom: 32px;
            margin-top: 26px;
        }

        .tab-list {
            display: flex;
            background: white;
            border-radius: 8px;
            padding: 4px;
            margin-bottom: 13px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .tab-button {
            flex: 1;
            padding: 12px 16px;
            border: none;
            background: transparent;
            cursor: pointer;
            border-radius: 6px;
            font-weight: 500;
            transition: all 0.2s;
        }

        .tab-button.active {
            background: #dc2626;
            color: white;
        }

        .tab-content {
            display: none;
        }

        .tab-content.active {
            display: block;
        }

        .card {
            background: white;
            padding: 24px;
            border-radius: 12px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            margin-bottom: 24px;
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .card-header {
            margin-bottom: 20px;
        }

        .card-title {
            font-size: 1.25rem;
            font-weight: 600;
            margin-bottom: 4px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .card-description {
            color: #6b7280;
            font-size: 0.875rem;
        }

        .chart-container {
            position: relative;
            height: 300px;
            margin: 20px 0;
        }

        .transactions-list {
            space-y: 16px;
        }

        .transaction-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 16px;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            transition: background-color 0.2s;
        }

        .transaction-item:hover {
            background: #f9fafb;
        }

        .transaction-left {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .transaction-icon {
            width: 16px;
            height: 16px;
        }

        .transaction-icon.issue {
            color: #dc2626;
        }

        .transaction-icon.receive {
            color: #16a34a;
        }

        .transaction-details h4 {
            font-weight: 500;
            margin-bottom: 4px;
        }

        .transaction-details p {
            font-size: 0.875rem;
            color: #6b7280;
            margin-bottom: 2px;
        }

        .transaction-right {
            text-align: right;
        }

        .transaction-time {
            font-weight: 500;
            margin-bottom: 4px;
        }

        .transaction-status {
            padding: 2px 8px;
            border-radius: 12px;
            font-size: 0.75rem;
            margin-bottom: 4px;
        }

        .status-completed {
            background: #dcfce7;
            color: #166534;
        }

        .status-pending {
            background: #fef3c7;
            color: #92400e;
        }

        .transaction-id {
            font-size: 0.75rem;
            color: #6b7280;
        }

        .eligibility-section {
            margin-bottom: 32px;
        }

        .compatibility-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 24px;
        }

        .compatibility-table th,
        .compatibility-table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #e5e7eb;
        }

        .compatibility-table th {
            background: #f9fafb;
            font-weight: 600;
        }

        .compatibility-table tr:hover {
            background: #f9fafb;
        }

        .donor-type-badge {
            padding: 4px 8px;
            border-radius: 12px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .donor-universal {
            background: #fee2e2;
            color: #991b1b;
        }

        .donor-common {
            background: #e5e7eb;
            color: #374151;
        }

        .donor-recipient {
            background: #dbeafe;
            color: #1e40af;
        }

        .blood-type-circle {
            width: 32px;
            height: 32px;
            background: #fee2e2;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            color: #dc2626;
            margin-right: 8px;
        }

        .recipient-badges {
            display: flex;
            flex-wrap: wrap;
            gap: 4px;
        }

        .recipient-badge {
            padding: 2px 6px;
            border: 1px solid #e5e7eb;
            border-radius: 4px;
            font-size: 0.75rem;
        }

        .criteria-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 24px;
        }

        .criteria-category {
            background: white;
            padding: 24px;
            border-radius: 12px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .criteria-item {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            padding: 12px;
            background: #f9fafb;
            border-radius: 8px;
            margin-bottom: 12px;
            transition: background-color 0.2s;
        }

        .criteria-item:hover {
            background: #f3f4f6;
        }

        .criteria-icon {
            margin-top: 2px;
        }

        .criteria-icon.eligible {
            color: #16a34a;
        }

        .criteria-icon.ineligible {
            color: #dc2626;
        }

        .criteria-icon.conditional {
            color: #ea580c;
        }

        .criteria-content {
            flex: 1;
        }

        .criteria-requirement {
            font-weight: 500;
            margin-bottom: 4px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .criteria-badge {
            padding: 2px 8px;
            border-radius: 12px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .badge-eligible {
            background: #dcfce7;
            color: #166534;
        }

        .badge-ineligible {
            background: #fee2e2;
            color: #991b1b;
        }

        .badge-conditional {
            background: #fef3c7;
            color: #92400e;
        }

        .criteria-description {
            font-size: 0.875rem;
            color: #6b7280;
        }

        .reference-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 16px;
            margin-top: 24px;
        }

        .reference-item {
            text-align: center;
            padding: 24px;
            border-radius: 12px;
        }

        .reference-eligible {
            background: #dcfce7;
        }

        .reference-conditional {
            background: #fef3c7;
        }

        .reference-ineligible {
            background: #fee2e2;
        }

        .reference-icon {
            width: 48px;
            height: 48px;
            margin: 0 auto 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
        }

        .reference-title {
            font-weight: 600;
            margin-bottom: 8px;
        }

        .reference-description {
            font-size: 0.875rem;
        }

        @keyframes pulse {
            0%, 100% {
                opacity: 1;
            }
            50% {
                opacity: 0.8;
            }
        }

        @media (max-width: 768px) {
            .container {
                padding: 16px;
            }

            .header h1 {
                font-size: 2rem;
            }

            .metrics-grid {
                grid-template-columns: 1fr;
            }

            .blood-groups-grid {
                grid-template-columns: repeat(auto-fit, minmax(100px, 1fr));
            }

            .tab-list {
                flex-direction: column;
            }

            .criteria-grid {
                grid-template-columns: 1fr;
            }

            .compatibility-table {
                font-size: 0.875rem;
            }

            .compatibility-table th,
            .compatibility-table td {
                padding: 8px;
            }
        }
    </style>
@endpush
@section('main-content')
<main class="main-content">
<div class="container">
    <!-- Key Metrics -->
    <div class="metrics-grid">
        <div class="metric-card">
            <div class="metric-header">
                <span class="metric-title">Total Blood Units</span>
                <span class="metric-icon" style="color: #dc2626;">🩸</span>
            </div>
            <div class="metric-value" style="color: #dc2626;">{{@$total['available_blood_one_month']}}</div>
            <div class="metric-change">
                @if($availableBloodPercentageChange !== null)
                    @if($availableBloodPercentageChange > 0)
                        +{{ round($availableBloodPercentageChange, 2) }}% from last month
                    @elseif($availableBloodPercentageChange < 0)
                        {{ round($availableBloodPercentageChange, 2) }}% from last month
                    @else
                        No change from last month
                    @endif
                @else
                    N/A
                @endif
            </div>
        </div>

        <div class="metric-card">
            <div class="metric-header">
                <span class="metric-title">Active Donors</span>
                <span class="metric-icon" style="color: #2563eb;">👥</span>
            </div>
            <div class="metric-value" style="color: #2563eb;">{{@$active_doners}}</div>
        </div>

        <div class="metric-card">
            <div class="metric-header">
                <span class="metric-title">Units Issued This Month</span>
                <span class="metric-icon" style="color: #16a34a;">📈</span>
            </div>
            <div class="metric-value" style="color: #16a34a;">{{@$total['issued_blood_one_month']}}</div>
            <div class="metric-change">
                @if($issuedBloodPercentageChange !== null)
                    @if($issuedBloodPercentageChange > 0)
                        +{{ round($issuedBloodPercentageChange, 2) }}% from last month
                    @elseif($issuedBloodPercentageChange < 0)
                        {{ round($issuedBloodPercentageChange, 2) }}% from last month
                    @else
                        No change from last month
                    @endif
                @else
                    N/A
                @endif
            </div>
        </div>

        <div class="metric-card">
            <div class="metric-header">
                <span class="metric-title">Critical Stock</span>
                <span class="metric-icon" style="color: #ea580c;">⚠️</span>
            </div>
            <div class="metric-value" style="color: #ea580c;">{{@$criticalCount}}</div>
            <div class="metric-change">Blood groups below minimum</div>
        </div>
    </div>

    <!-- Blood Group Inventory Status -->
    <div class="card">
        <div class="card-header">
            <h2 class="card-title">
                <span style="color: #dc2626;">📊</span>
                Blood Group Inventory Status
            </h2>
        </div>
        <div class="blood-group-container">
        @foreach(@$bloodGroupSummary as $list)
            <div class="blood-group">
                <div class="blood-group-type">{{ @$list['bloodGroup'] ?? '' }}</div>
                <div class="blood-group-units">{{ @$list['current'] ?? 0 }} units</div>
                <div class="blood-group-status status-critical">
                    {{ @$list['status'] ?? 'NORMAL' }}
                </div>
                <div class="blood-group-percentage">{{ @$list['availablePercentage'] ?? 0 }}% of population</div>
            </div>
        @endforeach
        </div>
    </div>

    <!-- Dashboard Tabs -->
    <div class="tabs">
        <div class="tab-list">
            <button class="tab-button active" onclick="switchTab(event, 'inventory')">Inventory</button>
            <button class="tab-button" onclick="switchTab(event, 'analytics')">Analytics</button>
            <button class="tab-button" onclick="switchTab(event, 'eligibility')">Eligibility</button>
            <button class="tab-button" onclick="switchTab(event, 'donors')">Donors</button>
        </div>

        <!-- Inventory Tab -->
        <div id="inventory" class="tab-content active">
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px;">
                <!-- Blood Inventory Chart -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Blood Inventory Levels</h3>
                    </div>
                    <div class="chart-container">
                        <canvas id="inventoryChart"></canvas>
                    </div>
                    <div style="display: flex; justify-content: center; gap: 24px; margin-top: 16px; font-size: 0.875rem;">
                        <div style="display: flex; align-items: center; gap: 8px;">
                            <div style="width: 12px; height: 12px; background: #16a34a; border-radius: 2px;"></div>
                            <span>Normal Stock</span>
                        </div>
                        <div style="display: flex; align-items: center; gap: 8px;">
                            <div style="width: 12px; height: 12px; background: #eab308; border-radius: 2px;"></div>
                            <span>Low Stock</span>
                        </div>
                        <div style="display: flex; align-items: center; gap: 8px;">
                            <div style="width: 12px; height: 12px; background: #dc2626; border-radius: 2px;"></div>
                            <span>Critical Stock</span>
                        </div>
                    </div>
                </div>

                <!-- Recent Transactions -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <span style="color: #2563eb;">🕒</span>
                            Recent Transactions
                        </h3>
                    </div>
                    <div class="transactions-list">
                        @foreach(@$blood_transaction as $list)
                        <div class="transaction-item">
                            <div class="transaction-left">
                                <div class="transaction-details">
                                    <h4>{{@$list->blood_group}} • 1 unit</h4>
                                    <p>{{@$list->patient_name}}</p>
                                    <p>{{@$list->section}}</p>
                                </div>
                            </div>
                            <div class="transaction-right">
                                <div class="transaction-time">{{dateFor(@$list->created_at)}}</div>
                                <div class="transaction-id">Billing ID: {{@$list->billing_id}}</div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- Analytics Tab -->
        <div id="analytics" class="tab-content">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Monthly Blood Issue Trends by Blood Group</h3>
                </div>
                <div class="chart-container">
                    <canvas id="analyticsChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Eligibility Tab -->
        <div id="eligibility" class="tab-content">
            <div class="eligibility-section">
                <!-- Blood Compatibility Matrix -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <span style="color: #dc2626;">❤️</span>
                            Blood Group Compatibility Matrix
                        </h3>
                    </div>
                    <table class="compatibility-table">
                        <thead>
                            <tr>
                                <th>Donor Blood Group</th>
                                <th>Can Donate To</th>
                                <th>Donor Type</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <div style="display: flex; align-items: center;">
                                        <div class="blood-type-circle">O-</div>
                                        <span style="font-weight: 500;">O-</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="recipient-badges">
                                        <span class="recipient-badge">O-</span>
                                        <span class="recipient-badge">O+</span>
                                        <span class="recipient-badge">A-</span>
                                        <span class="recipient-badge">A+</span>
                                        <span class="recipient-badge">B-</span>
                                        <span class="recipient-badge">B+</span>
                                        <span class="recipient-badge">AB-</span>
                                        <span class="recipient-badge">AB+</span>
                                    </div>
                                </td>
                                <td><span class="donor-type-badge donor-universal">Universal Donor</span></td>
                            </tr>
                            <tr>
                                <td>
                                    <div style="display: flex; align-items: center;">
                                        <div class="blood-type-circle">O+</div>
                                        <span style="font-weight: 500;">O+</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="recipient-badges">
                                        <span class="recipient-badge">O+</span>
                                        <span class="recipient-badge">A+</span>
                                        <span class="recipient-badge">B+</span>
                                        <span class="recipient-badge">AB+</span>
                                    </div>
                                </td>
                                <td><span class="donor-type-badge donor-common">Common Donor</span></td>
                            </tr>
                            <tr>
                                <td>
                                    <div style="display: flex; align-items: center;">
                                        <div class="blood-type-circle">A-</div>
                                        <span style="font-weight: 500;">A-</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="recipient-badges">
                                        <span class="recipient-badge">A-</span>
                                        <span class="recipient-badge">A+</span>
                                        <span class="recipient-badge">AB-</span>
                                        <span class="recipient-badge">AB+</span>
                                    </div>
                                </td>
                                <td><span class="donor-type-badge donor-common">Type A Donor</span></td>
                            </tr>
                            <tr>
                                <td>
                                    <div style="display: flex; align-items: center;">
                                        <div class="blood-type-circle">A+</div>
                                        <span style="font-weight: 500;">A+</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="recipient-badges">
                                        <span class="recipient-badge">A+</span>
                                        <span class="recipient-badge">AB+</span>
                                    </div>
                                </td>
                                <td><span class="donor-type-badge donor-common">Type A Donor</span></td>
                            </tr>
                            <tr>
                                <td>
                                    <div style="display: flex; align-items: center;">
                                        <div class="blood-type-circle">B-</div>
                                        <span style="font-weight: 500;">B-</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="recipient-badges">
                                        <span class="recipient-badge">B-</span>
                                        <span class="recipient-badge">B+</span>
                                        <span class="recipient-badge">AB-</span>
                                        <span class="recipient-badge">AB+</span>
                                    </div>
                                </td>
                                <td><span class="donor-type-badge donor-common">Type B Donor</span></td>
                            </tr>
                            <tr>
                                <td>
                                    <div style="display: flex; align-items: center;">
                                        <div class="blood-type-circle">B+</div>
                                        <span style="font-weight: 500;">B+</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="recipient-badges">
                                        <span class="recipient-badge">B+</span>
                                        <span class="recipient-badge">AB+</span>
                                    </div>
                                </td>
                                <td><span class="donor-type-badge donor-common">Type B Donor</span></td>
                            </tr>
                            <tr>
                                <td>
                                    <div style="display: flex; align-items: center;">
                                        <div class="blood-type-circle">AB-</div>
                                        <span style="font-weight: 500;">AB-</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="recipient-badges">
                                        <span class="recipient-badge">AB-</span>
                                        <span class="recipient-badge">AB+</span>
                                    </div>
                                </td>
                                <td><span class="donor-type-badge donor-common">Type AB Donor</span></td>
                            </tr>
                            <tr>
                                <td>
                                    <div style="display: flex; align-items: center;">
                                        <div class="blood-type-circle">AB+</div>
                                        <span style="font-weight: 500;">AB+</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="recipient-badges">
                                        <span class="recipient-badge">AB+</span>
                                    </div>
                                </td>
                                <td><span class="donor-type-badge donor-recipient">Universal Recipient Only</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Eligibility Criteria -->
                <div class="criteria-grid">
                    <div class="criteria-category">
                        <div class="card-header">
                            <h3 class="card-title">
                                <span style="color: #2563eb;">📅</span>
                                Age Requirements
                            </h3>
                        </div>
                        <div class="criteria-item">
                            <div class="criteria-icon eligible">✅</div>
                            <div class="criteria-content">
                                <div class="criteria-requirement">
                                    18-65 years (General)
                                    <span class="criteria-badge badge-eligible">Eligible</span>
                                </div>
                                <div class="criteria-description">Standard age range for blood donation</div>
                            </div>
                        </div>
                        <div class="criteria-item">
                            <div class="criteria-icon conditional">⚠️</div>
                            <div class="criteria-content">
                                <div class="criteria-requirement">
                                    17 years (With parental consent)
                                    <span class="criteria-badge badge-conditional">Conditional</span>
                                </div>
                                <div class="criteria-description">Requires written parental consent</div>
                            </div>
                        </div>
                        <div class="criteria-item">
                            <div class="criteria-icon conditional">⚠️</div>
                            <div class="criteria-content">
                                <div class="criteria-requirement">
                                    66+ years (With medical clearance)
                                    <span class="criteria-badge badge-conditional">Conditional</span>
                                </div>
                                <div class="criteria-description">Requires doctor's approval</div>
                            </div>
                        </div>
                        <div class="criteria-item">
                            <div class="criteria-icon ineligible">❌</div>
                            <div class="criteria-content">
                                <div class="criteria-requirement">
                                    Under 17 years
                                    <span class="criteria-badge badge-ineligible">Not Eligible</span>
                                </div>
                                <div class="criteria-description">Too young for blood donation</div>
                            </div>
                        </div>
                    </div>

                    <div class="criteria-category">
                        <div class="card-header">
                            <h3 class="card-title">
                                <span style="color: #2563eb;">⚖️</span>
                                Weight Requirements
                            </h3>
                        </div>
                        <div class="criteria-item">
                            <div class="criteria-icon eligible">✅</div>
                            <div class="criteria-content">
                                <div class="criteria-requirement">
                                    50+ kg (110+ lbs)
                                    <span class="criteria-badge badge-eligible">Eligible</span>
                                </div>
                                <div class="criteria-description">Minimum weight for safe donation</div>
                            </div>
                        </div>
                        <div class="criteria-item">
                            <div class="criteria-icon conditional">⚠️</div>
                            <div class="criteria-content">
                                <div class="criteria-requirement">
                                    45-49 kg (99-109 lbs)
                                    <span class="criteria-badge badge-conditional">Conditional</span>
                                </div>
                                <div class="criteria-description">Requires medical evaluation</div>
                            </div>
                        </div>
                        <div class="criteria-item">
                            <div class="criteria-icon ineligible">❌</div>
                            <div class="criteria-content">
                                <div class="criteria-requirement">
                                    Under 45 kg (Under 99 lbs)
                                    <span class="criteria-badge badge-ineligible">Not Eligible</span>
                                </div>
                                <div class="criteria-description">Insufficient body weight</div>
                            </div>
                        </div>
                    </div>

                    <div class="criteria-category">
                        <div class="card-header">
                            <h3 class="card-title">
                                <span style="color: #2563eb;">❤️</span>
                                Health Status
                            </h3>
                        </div>
                        <div class="criteria-item">
                            <div class="criteria-icon eligible">✅</div>
                            <div class="criteria-content">
                                <div class="criteria-requirement">
                                    Good general health
                                    <span class="criteria-badge badge-eligible">Eligible</span>
                                </div>
                                <div class="criteria-description">No current illness or infection</div>
                            </div>
                        </div>
                        <div class="criteria-item">
                            <div class="criteria-icon eligible">✅</div>
                            <div class="criteria-content">
                                <div class="criteria-requirement">
                                    Hemoglobin ≥12.5 g/dL
                                    <span class="criteria-badge badge-eligible">Eligible</span>
                                </div>
                                <div class="criteria-description">Adequate iron levels</div>
                            </div>
                        </div>
                        <div class="criteria-item">
                            <div class="criteria-icon eligible">✅</div>
                            <div class="criteria-content">
                                <div class="criteria-requirement">
                                    Blood pressure 90-180/50-100
                                    <span class="criteria-badge badge-eligible">Eligible</span>
                                </div>
                                <div class="criteria-description">Normal blood pressure range</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Donors Tab -->
        <div id="donors" class="tab-content">
            <div class="metrics-grid">
                <div class="metric-card">
                    <div class="metric-header">
                        <span class="metric-title">Total Active Donors</span>
                        <span class="metric-icon" style="color: #16a34a;">🏆</span>
                    </div>
                    <div class="metric-value" style="color: #2563eb;">{{$active_doners}}</div>
                </div>

                <div class="metric-card">
                    <div class="metric-header">
                        <span class="metric-title">Total Inactive Donors</span>
                        <span class="metric-icon" style="color: #2563eb;">👥</span>
                    </div>
                    <div class="metric-value" style="color: #16a34a;">{{$inactive_donors}}</div>
                </div>

                <div class="metric-card">
                    <div class="metric-header">
                        <span class="metric-title">This Month</span>
                        <span class="metric-icon" style="color: #7c3aed;">📅</span>
                    </div>
                    <div class="metric-value" style="color: #7c3aed;">{{$total['donations_one_month']}}</div>
                    <div class="metric-change">Donations completed</div>
                </div>

                <div class="metric-card">
                    <div class="metric-header">
                        <span class="metric-title">Growth Rate</span>
                        <span class="metric-icon" style="color: #ea580c;">📈</span>
                    </div>
                    <div class="metric-value" style="color: #ea580c;">
                            @if($donationsPercentageChange !== null)
                            @if($donationsPercentageChange > 0)
                                +{{ round($donationsPercentageChange, 2) }}% 
                            @elseif($donationsPercentageChange < 0)
                                {{ round($donationsPercentageChange, 2) }}% 
                            @else
                                0%
                            @endif
                        @else
                            N/A
                        @endif
                    </div>
                    <div class="metric-change">Compared to last month</div>
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px;">
                <!-- Top Donors -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <span style="color: #eab308;">🏆</span>
                            Top Donors
                        </h3>
                    </div>
                    @php
                        use Carbon\Carbon;
                        $sixMonthsAgo = Carbon::now()->subMonths(6);
                    @endphp
                    <div class="transactions-list">
                        @foreach($topDonations as $list)
                            @php
                            $isActive = isset($list->last_donation_date) && Carbon::parse($list->last_donation_date)->gte($sixMonthsAgo);
                            $statusColor = $isActive ? '#16a34a' : '#dc2626'; // green / red
                            $statusBg = $isActive ? '#d1fae5' : '#fee2e2';     // light green / light red
                        @endphp
                        <div class="transaction-item">
                            <div class="transaction-left">
                                <div style="width: 40px; height: 40px; background: #f3f4f6; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: bold;">JS</div>
                                <div class="transaction-details">
                                    <h4>{{$list->name}}</h4>
                                    <p>Blood Group: {{$list->blood_group}}</p>
                                </div>
                            </div>
                            <div class="transaction-right">
                                <div class="transaction-time" style="color: #6b7280;">{{ $list->total_donations }} donations</div>
                                <div class="transaction-status" style="background: {{ $statusBg }}; color: {{ $statusColor }}; padding: 4px 8px; border-radius: 5px; font-weight: bold;">
                                    {{ $isActive ? 'Active' : 'Inactive' }}
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- Recent Donations -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Recent Donations</h3>
                    </div>
                    <div class="transactions-list">
                        @foreach ($recentDonations as $item)
                        <div class="transaction-item">
                            <div class="transaction-left">
                                <div style="width: 32px; height: 32px; background: #f3f4f6; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 0.75rem;">
                                    {{ collect(explode(' ', $item['name'] ?? '')) 
                                    ->filter() 
                                    ->map(function ($word) {
                                        return strtoupper(mb_substr($word, 0, 1));
                                    }) 
                                    ->take(2) 
                                    ->implode('') }}
                                </div>
                                <div class="transaction-details">
                                    <h4>{{ $item['name'] }}</h4>
                                    <p>Blood Group: {{ @$item['blood_group'] }}</p>
                                </div>
                            </div>
                            <div class="transaction-right">
                                <div class="transaction-time">{{ dateFor(@$item['donation_date']) }}</div>
                                <p style="font-size: 0.875rem; color: #6b7280;">1 unit(s)</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</main>
@endsection
@push('js')
<script>
    const bloodData = @json($bloodGroupSummary);
</script>
 <script>
    // Tab switching functionality
    function switchTab(evt, tabName) {
        // Hide all tab content
        document.querySelectorAll(".tab-content").forEach(tab => tab.classList.remove("active"));

        // Remove active class from all tab buttons
        document.querySelectorAll(".tab-button").forEach(btn => btn.classList.remove("active"));

        // Show the selected tab and mark button active
        document.getElementById(tabName).classList.add("active");
        evt.currentTarget.classList.add("active");

        // Initialize charts when their tab is opened
        if (tabName === 'inventory' && !window.inventoryChartLoaded) {
            setTimeout(initInventoryChart, 100);
            window.inventoryChartLoaded = true;
        } 
        else if (tabName === 'analytics' && !window.analyticsChartLoaded) {
            setTimeout(initAnalyticsChart, 100);
            window.analyticsChartLoaded = true;
        }
    }

    // Inventory Chart
    function initInventoryChart() {
        const ctx = document.getElementById('inventoryChart');
        if (!ctx) return;

        const getBarColor = (current, minimum) => {
            if (current <= minimum) return '#dc2626'; // Critical
            if (current <= minimum * 1.5) return '#eab308'; // Low
            return '#16a34a'; // Normal
        };

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: bloodData.map(d => d.bloodGroup),
                datasets: [{
                    data: bloodData.map(d => d.current),
                    backgroundColor: bloodData.map(d => getBarColor(d.current, d.minimum)),
                    borderRadius: 4,
                }]
            },
            options: {
                responsive: true,
                plugins: { legend: { display: false } },
                scales: {
                    y: { beginAtZero: true, min: 0, max: 45, ticks: { stepSize: 5 } }
                }
            }
        });
    }

    // Analytics Chart
    const monthlyData = @json($monthlyBloodIssueData);

    function initAnalyticsChart() {
        const ctx = document.getElementById('analyticsChart');
        if (!ctx) return;

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: monthlyData.map(d => d.month),
                datasets: [
                    { label: 'O+', data: monthlyData.map(d => d['O+']), borderColor: '#dc2626', backgroundColor: 'rgba(220,38,38,0.1)', borderWidth: 3, tension: 0.1 },
                    { label: 'A+', data: monthlyData.map(d => d['A+']), borderColor: '#ea580c', backgroundColor: 'rgba(234,88,12,0.1)', borderWidth: 2, tension: 0.1 },
                    { label: 'B+', data: monthlyData.map(d => d['B+']), borderColor: '#16a34a', backgroundColor: 'rgba(22,163,74,0.1)', borderWidth: 2, tension: 0.1 },
                    { label: 'AB+', data: monthlyData.map(d => d['AB+']), borderColor: '#7c3aed', backgroundColor: 'rgba(124,58,237,0.1)', borderWidth: 2, tension: 0.1 },
                    { label: 'O-', data: monthlyData.map(d => d['O-']), borderColor: '#0891b2', backgroundColor: 'rgba(8,145,178,0.1)', borderWidth: 2, borderDash: [5,5], tension: 0.1 },
                    { label: 'A-', data: monthlyData.map(d => d['A-']), borderColor: '#c2410c', backgroundColor: 'rgba(194,65,12,0.1)', borderWidth: 2, borderDash: [5,5], tension: 0.1 },
                    { label: 'B-', data: monthlyData.map(d => d['B-']), borderColor: '#65a30d', backgroundColor: 'rgba(101,163,13,0.1)', borderWidth: 2, borderDash: [5,5], tension: 0.1 },
                    { label: 'AB-', data: monthlyData.map(d => d['AB-']), borderColor: '#be185d', backgroundColor: 'rgba(190,24,93,0.1)', borderWidth: 2, borderDash: [5,5], tension: 0.1 }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { position: 'top' } },
                scales: {
                    y: { beginAtZero: true, grid: { color: 'rgba(0,0,0,0.1)' } },
                    x: { grid: { color: 'rgba(0,0,0,0.1)' } }
                }
            }
        });
    }

    // Load inventory chart on page load (default tab)
    document.addEventListener('DOMContentLoaded', () => {
        setTimeout(initInventoryChart, 100);
        window.inventoryChartLoaded = true;
    });
</script>

@endpush
