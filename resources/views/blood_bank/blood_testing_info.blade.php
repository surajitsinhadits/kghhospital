@extends('layouts.structure')

@push('title')
    <title>Blood Testing Info</title>
@endpush
@push('css')
<style>
    /* Classic Report Styling */
    .classic-report-card {
        border: 1px solid #d1d1d1;
        box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }

    .classic-report-header {
        background: linear-gradient(135deg, #8e0e00, #1f1c18);
        border-bottom: 2px solid #8e0e00;
    }

    .classic-report-footer {
        background-color: #f8f9fa;
        border-top: 1px solid #d1d1d1;
        font-size: 12px;
    }

    .report-section {
        margin-bottom: 30px;
    }

    .section-header {
        margin-bottom: 20px;
        position: relative;
    }

    .section-title {
        color: #8e0e00;
        font-weight: 600;
        display: inline-block;
        background: #f8f9fa;
        padding: 5px 15px;
        border-radius: 4px;
        border-left: 4px solid #8e0e00;
    }

    .header-line {
        position: absolute;
        bottom: 10px;
        left: 0;
        width: 100%;
        height: 1px;
        background: linear-gradient(to right, #8e0e00, transparent);
        z-index: -1;
    }

    .classic-table {
        border: 1px solid #dee2e6;
    }

    .classic-table th {
        background-color: #f8f9fa;
        font-weight: 600;
    }

    .hospital-stamp {
        font-style: italic;
        color: #6c757d;
    }

    .report-date {
        color: #6c757d;
        font-size: 12px;
    }

    .badge-success {
        background-color: #28a745;
    }

    .badge-danger {
        background-color: #dc3545;
    }
</style>
@endpush
@section('main-content')
<div class="row">
    <div class="col-12">
        <div class="card classic-report-card">
            <div class="card-header card_hearder_mimi">
                <h4 class="card-title text-white"><i class="fas fa-flask mr-2"></i> BLOOD TEST REPORT</h4>
            </div>
            <div class="card-body">
                <!-- Donor Information Section -->
                <div class="report-section mb-4">
                    <div class="section-header">
                        <h5 class="section-title"><i class="fas fa-user-tie mr-2"></i> Donor Information</h5>
                        <div class="header-line"></div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-bordered classic-table">
                                <tbody>
                                    <tr>
                                        <th width="40%">Donor Name</th>
                                        <td>{{ @$data->donor_name ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Gender</th>
                                        <td>{{ @$data->gen ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Date of Birth</th>
                                        <td>{{ @$data->dob ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Blood Group</th>
                                        <td>{{ @$data->blood_group ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Last Donation Date</th>
                                        <td>{{ dateFor(@$data->last_donation_date ?? '') }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="col-md-6">
                            <table class="table table-bordered classic-table">
                                <tbody>
                                    <tr>
                                        <th width="40%">Contact Number</th>
                                        <td>{{ @$data->contact_no ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Email</th>
                                        <td>{{ @$data->email ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Address</th>
                                        <td>{{ @$data->address ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <th>State/District</th>
                                        <td>{{ @$data->state_name ?? 'N/A' }} / {{ @$data->district_name ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Pin Code</th>
                                        <td>{{ @$data->pin_code ?? 'N/A' }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                @if ($test_data)
                <!-- Test Results Section -->
                <div class="report-section">
                    <div class="section-header">
                        <h5 class="section-title"><i class="fas fa-microscope mr-2"></i> Test Results</h5>
                        <div class="header-line"></div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-bordered classic-table">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Test Parameter</th>
                                        <th>Result</th>
                                        <th>Test Parameter</th>
                                        <th>Result</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <th>QC Checks Log</th>
                                        <td>{{ @$test_data->qc_checks_log ?? 'N/A' }}</td>
                                        <th>Quarantine Flag</th>
                                        <td>
                                            <span class="badge badge-{{ @$test_data->quarantine_flag == '0' ? 'success' : 'danger' }}">
                                                {{ @$test_data->quarantine_flag == 1 ? 'Yes' : 'No' }}
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>NAT Result</th>
                                        <td>
                                            <span class="badge badge-{{ @$test_data->nat_result == 'Negative' ? 'success' : 'danger' }}">
                                                {{ @$test_data->nat_result ?? 'N/A' }}
                                            </span>
                                        </td>
                                        <th>ELISA Result</th>
                                        <td>
                                            <span class="badge badge-{{ @$test_data->elisa_result == 'Negative' ? 'success' : 'danger' }}">
                                                {{ @$test_data->elisa_result ?? 'N/A' }}
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>HIV Result</th>
                                        <td>
                                            <span class="badge badge-{{ @$test_data->hiv_result == 'Negative' ? 'success' : 'danger' }}">
                                                {{ @$test_data->hiv_result ?? 'N/A' }}
                                            </span>
                                        </td>
                                        <th>HBSAG Result</th>
                                        <td>
                                            <span class="badge badge-{{ @$test_data->hbsag_result == 'Negative' ? 'success' : 'danger' }}">
                                                {{ @$test_data->hbsag_result ?? 'N/A' }}
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>HCV Result</th>
                                        <td>
                                            <span class="badge badge-{{ @$test_data->hcv_result == 'Negative' ? 'success' : 'danger' }}">
                                                {{ @$test_data->hcv_result ?? 'N/A' }}
                                            </span>
                                        </td>
                                        <th>Syphilis Result</th>
                                        <td>
                                            <span class="badge badge-{{ @$test_data->syphilis_result == 'Negative' ? 'success' : 'danger' }}">
                                                {{ @$test_data->syphilis_result ?? 'N/A' }}
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Malaria Result</th>
                                        <td>
                                            <span class="badge badge-{{ @$test_data->malaria_result == 'Negative' ? 'success' : 'danger' }}">
                                                {{ @$test_data->malaria_result ?? 'N/A' }}
                                            </span>
                                        </td>
                                        <th>Crossmatch Result</th>
                                        <td>
                                            <span class="badge badge-{{ @$test_data->crossmatch_result == 'Compatible' ? 'success' : 'danger' }}">
                                                {{ @$test_data->crossmatch_result ?? 'N/A' }}
                                            </span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                @endif
            </div>

            {{-- <div class="card-footer classic-report-footer">
                <div class="row">
                    <div class="col-md-6">
                        <p class="report-date">Report Generated: {{ date('d M Y h:i A') }}</p>
                    </div>
                    <div class="col-md-6 text-right">
                        <p class="hospital-stamp">Blood Bank Management System</p>
                    </div>
                </div>
            </div> --}}
        </div>
    </div>
</div>
@endsection
@push('js')
@endpush
