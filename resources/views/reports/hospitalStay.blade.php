@extends('layouts.structure')

@push('title')
    <title>Hospital Stay Report</title>
@endpush

@section('main-content')
    <style>
        .report-wrapper {
            padding: 16px;
        }

        .summary-card-link {
            text-decoration: none !important;
            display: block;
            height: 100%;
            color: inherit;
        }

        .section-card {
            border: none;
            border-radius: 16px;
            background: #ffffff;
            box-shadow: 0 3px 14px rgba(0, 0, 0, 0.08);
            transition: all 0.25s ease;
            overflow: hidden;
            height: 100%;
            min-height: 140px;
            position: relative;
        }

        .section-card::before {
            content: "";
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
            height: 5px;
            background: #cbd5e1;
        }

        .section-card.opd::before { background: #06b6d4; }
        .section-card.emg::before { background: #2563eb; }
        .section-card.ipd::before { background: #16a34a; }
        .section-card.daycare::before { background: #f59e0b; }
        .section-card.dialysis::before { background: #ef4444; }
        .section-card.investigation::before { background: #64748b; }

        .section-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 10px 22px rgba(0, 0, 0, 0.13);
        }

        .section-card.active-card {
            border: 2px solid #2563eb;
            box-shadow: 0 10px 24px rgba(37, 99, 235, 0.18);
            background: #f4f9ff;
        }

        .section-card .card-body {
            padding: 24px 15px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
        }

        .section-label {
            font-size: 13px;
            font-weight: 800;
            color: #5f6f82;
            text-transform: uppercase;
            margin-bottom: 12px;
            letter-spacing: 0.4px;
        }

        .section-count {
            font-size: 42px;
            font-weight: 800;
            color: #111827;
            line-height: 1;
            margin-bottom: 8px;
        }

        .section-hint {
            font-size: 12px;
            font-weight: 600;
            color: #94a3b8;
        }

        .table-card {
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 3px 14px rgba(0, 0, 0, 0.08);
            overflow: hidden;
            margin-top: 10px;
        }

        .table-title {
            background: #f7f7f7;
            padding: 14px 18px;
            border-bottom: 1px solid #e5e7eb;
        }

        .section-heading {
            font-size: 17px;
            font-weight: 800;
            color: #1f2937;
            margin: 0;
        }

        .table thead th {
            background: #355b5b;
            color: #fff;
            border: 1px solid #d9d9d9;
            font-size: 13px;
            font-weight: 700;
            padding: 12px 10px;
            vertical-align: middle;
            white-space: nowrap;
        }

        .table tbody td {
            padding: 12px 10px;
            font-size: 14px;
            color: #374151;
            border-top: 1px solid #ececec;
            vertical-align: middle;
        }

        .table tbody tr:hover {
            background: #f9fbfd;
        }

        .patient-link {
            color: #2563eb;
            font-weight: 700;
            text-decoration: none;
        }

        .patient-link:hover {
            text-decoration: underline;
        }

        .empty-state {
            padding: 28px 20px;
            text-align: center;
            color: #6b7280;
            font-weight: 600;
        }

        @media (max-width: 767px) {

            .report-wrapper {
                padding: 10px;
            }

            .section-count {
                font-size: 34px;
            }
        }
    </style>

    <div class="row">
        <div class="card">
            <div class="card-header card_hearder_mimi">
                <div class="card-title card_hearder_mimi_text">Hospital Stay REPORT</div>
            </div>

            <div class="card-body p-0">
                <div class="col-md-12 border-right">
                    <form method="GET">
                        <div class="whitebackground">
                            <div class="row ">
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <input type="text" class="form-control datePickr"
                                            value="{{ request('from_date') }}" id="fromDate"
                                            name="from_date" placeholder="Choose From Date">
                                        @error('from_date')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <input type="text" class="form-control datePickr"
                                            value="{{ request('to_date') }}" id="toDate" name="to_date"
                                            placeholder="Choose To Date">
                                        @error('to_date')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="form-group d-flex">
                                        <button type="submit" class="btn btn-primary px-3 mr-2"><i
                                                class="fas fa-search"></i> Search</button>
                                        <a href="{{ route('reports.hospital.stay') }}" class="btn btn-warning px-3 mr-2"><i
                                                class="fas fa-history"></i> Reset</a>
                                        <button type="button" onclick="window.print()" class="btn btn-info px-3"><i
                                                class="fas fa-print"></i> Print</button>
                                        {{-- @if(!empty($activeSection)) --}}
                                            <a href="{{ route('reports.hospital.stay.export', [
                                                'format' => 'excel',
                                                'from_date' => request('from_date'),
                                                'to_date' => request('to_date'),
                                                'section' => request('section'),
                                            ]) }}"
                                                class="btn btn-success px-3 ml-2">
                                                <i class="fas fa-file-excel"></i> Excel
                                            </a>
                                        {{-- @endif --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="report-wrapper">

                @php
                    $sectionCards = [
                        'opd' => ['label' => 'OPD', 'color' => 'info'],
                        'emg' => ['label' => 'EMG', 'color' => 'primary'],
                        'ipd' => ['label' => 'IPD', 'color' => 'success'],
                        'daycare' => ['label' => 'Daycare', 'color' => 'warning'],
                        'dialysis' => ['label' => 'Dialysis', 'color' => 'danger'],
                        'investigation' => ['label' => 'Investigation', 'color' => 'secondary'],
                    ];
                @endphp

                @if(count($sectionCounts))
                    <div class="row">
                        @foreach($sectionCards as $key => $info)
                            @php
                                $isActive = !empty(request('section')) && request('section') == $key;
                                $link = route('reports.hospital.stay', array_filter([
                                    'from_date' => request('from_date'),
                                    'to_date' => request('to_date'),
                                    'section' => $key
                                ]));
                            @endphp

                            <div class="col-6 col-md-4 col-lg-2 mb-4">
                                <a href="{{ $link }}" class="summary-card-link">
                                    <div class="section-card {{ $key }} {{ $isActive ? 'active-card' : '' }}">
                                        <div class="card-body">
                                            <div class="section-label">{{ $info['label'] }}</div>
                                            <div class="section-count">{{ $sectionCounts[$key] ?? 0 }}</div>
                                            <div class="section-hint">Click to view list</div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                @elseif(request()->filled('from_date') || request()->filled('to_date'))
                    <div class="alert alert-light border text-muted">
                        No data found for the selected date range.
                    </div>
                @endif

                @if(!empty($activeSection))
                    <div class="table-card">
                        <div class="table-title">
                            <h5 class="section-heading">{{ strtoupper($activeSection) }} Patient List</h5>
                        </div>

                        @if(!$patientList || $patientList->isEmpty())
                            <div class="empty-state">
                                No patients found for this section.
                            </div>
                        @else
                            <div class="table-responsive">
                                <table class="table table-hover mb-0">
                                    <thead>
                                        <tr>
                                            <th width="60">#</th>
                                            <th>UHID</th>
                                            <th>Patient</th>
                                            <th>Doctor</th>
                                            <th>Department</th>
                                            <th>Admission Date</th>
                                            <th>Discharge</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($patientList as $index => $patient)
                                            <tr>
                                                <td>{{ $patientList->firstItem() + $index }}</td>
                                                <td>
                                                    <a href="{{ route('hr.patient-profile-details', ed($patient->patient_id, true)) }}"
                                                        class="patient-link">
                                                        {{ $patient->patient_uhid ?? $patient->patient_id }}
                                                    </a>
                                                </td>
                                                <td>{{ $patient->patient_name }}</td>
                                                <td>{{ $patient->doctor_name }}</td>
                                                <td>{{ $patient->department_name }}</td>
                                                <td>{{ dateFor($patient->record_date, true) }}</td>
                                                <td>{{ $patient->discharge_at ? dateFor($patient->discharge_at, true) : '-' }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            @if($patientList->hasPages())
                                <div class="d-flex justify-content-end px-3 py-3">
                                    {{ $patientList->links() }}
                                </div>
                            @endif
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
