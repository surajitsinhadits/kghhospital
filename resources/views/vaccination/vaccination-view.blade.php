@extends('layouts.structure')
@push('title')
    <title>Patient Vaccination Details</title>
@endpush
@push('css')
    <style>
        .patient-info,
        .vaccine-section,
        .schedule-section {
            margin-bottom: 30px;
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 15px;
            background-color: #f9f9f9;
        }

        .section-title {
            font-size: 18px;
            font-weight: bold;
            color: #2c5e92;
            margin-bottom: 15px;
            padding-bottom: 5px;
            border-bottom: 1px solid #ddd;
        }

        .info-row {
            display: flex;
            margin-bottom: 10px;
        }

        .info-label {
            font-weight: bold;
            width: 200px;
        }

        .info-value {
            flex: 1;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        td {
            padding: 5px;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .status-pending {
            color: #e67e22;
            font-weight: bold;
        }

        .status-completed {
            color: #27ae60;
            font-weight: bold;
        }

        .status-missed {
            color: #e74c3c;
            font-weight: bold;
        }
    </style>
@endpush
@section('main-content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header card_hearder_mimi">
                    <h4 class="card_hearder_mimi_text">VACCINATION INFO</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="patient-info">
                                <div class="section-title">PATIENT INFORMATION</div>
                                <div class="info-row">
                                    <div class="info-label">Patient Name:</div>
                                    <div class="info-value">{{ $patient->name }}</div>
                                </div>
                                <div class="info-row">
                                    <div class="info-label">Patient ID:</div>
                                    <div class="info-value">{{ $patient->uhid ?? $patient->id }}</div>
                                </div>
                                <div class="info-row">
                                    <div class="info-label">Age:</div>
                                    <div class="info-value">{{ $patient->dob_year ? $patient->dob_year . ' Year' : '' }}
                                    </div>
                                </div>
                                <div class="info-row">
                                    <div class="info-label">Date of Birth:</div>
                                    <div class="info-value">
                                        {{ $patient->date_of_birth ? dateFor($patient->date_of_birth) : '' }}</div>
                                </div>
                                <div class="info-row">
                                    <div class="info-label">Gender:</div>
                                    <div class="info-value">{{ $patient->gender }}</div>
                                </div>
                                <div class="info-row">
                                    <div class="info-label">Contact Number:</div>
                                    <div class="info-value">{{ $patient->phone }}</div>
                                </div>
                                <div class="info-row">
                                    <div class="info-label">Address:</div>
                                    <div class="info-value">{{ $patient->address }}, {{ $patient->district_name }},
                                        {{ $patient->state_name }}, {{ $patient->pin_code }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="patient-info">
                                <div class="section-title">VACCINE INFORMATION</div>
                                <div class="info-row">
                                    <div class="info-label">Vaccine Name:</div>
                                    <div class="info-value">{{ $vaccine_info->vaccine_name }}</div>
                                </div>
                                <div class="info-row">
                                    <div class="info-label">Brand:</div>
                                    <div class="info-value">{{ $vaccine_info->brand_name }}</div>
                                </div>
                                <div class="info-row">
                                    <div class="info-label">Manufacturer:</div>
                                    <div class="info-value">{{ $vaccine_info->manufacturer }}</div>
                                </div>
                                <div class="info-row">
                                    <div class="info-label">Injection Site:</div>
                                    <div class="info-value">{{ $vaccine_info->injection_site }}</div>
                                </div>
                                <div class="info-row">
                                    <div class="info-label">Route:</div>
                                    <div class="info-value">{{ $vaccine_info->route }}</div>
                                </div>
                                <div class="info-row">
                                    <div class="info-label">Disease Prevented:</div>
                                    <div class="info-value">{{ $vaccine_info->disease_prevented }}</div>
                                </div>
                                <div class="info-row">
                                    <div class="info-label">Drawbacks:</div>
                                    <div class="info-value">{{ $vaccine_info->drawbacks }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="vaccine-section">
                        <div class="section-title d-flex justify-content-between align-items-center">
                            VACCINATION INFORMATION
                            <!-- Button to trigger modal -->
                            @if(@$vaccination->status == 'completed')
                            <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#aefiModal"
                                data-id="{{ $vaccination->id }}"
                                data-patient="{{ $vaccination->patient_name }}"
                                data-vaccine="{{ $vaccination->name }}">
                                AEFI Report
                            </button>
                            @endif
                        </div>
                        <table>
                            <tbody>
                                <tr>
                                    <th>Scheduled Date</th>
                                    <td>{{ $vaccination->scheduled_date ? dateFor($vaccination->scheduled_date) : '' }}</td>
                                    <th>Administered Date</th>
                                    <td>{{ $vaccination->administered_date ? dateFor($vaccination->administered_date, true) : '' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>Status</th>
                                    <td>{{ ucwords($vaccination->status) }}</td>
                                    <th>Administered By</th>
                                    <td>{{ $vaccination->administered_by }}</td>
                                </tr>
                                <tr>
                                    <th>Batch Number</th>
                                    <td>{{ $vaccination->batch_no }}</td>
                                    <th>Amount</th>
                                    <td>₹{{ $vaccination->amount }} /-</td>
                                </tr>
                                <tr>
                                    <th>Consent Person</th>
                                    <td>{{ @$consents->signed_by }}</td>
                                    <th>Consent Number</th>
                                    <td>{{ @$consents->signed_phone }}</td>
                                </tr>
                                <tr>
                                    <th>Consent Form</th>
                                    <td>
                                        @if (@$consents->consent_form_path)
                                            <a style="font-size: 20px;"
                                                href="{{ asset('public/' . $consents->consent_form_path) }}"
                                                target="_blank" rel="noopener noreferrer" download><i
                                                    class="fas fa-download"></i></a>
                                        @endif
                                    </td>
                                    <th>Signature</th>
                                    <td>
                                        @if (@$consents->signature_image_path)
                                            <img width="200px" height="70px"
                                                src="{{ asset('public/' . $consents->signature_image_path) }}"
                                                alt="Signature">
                                        @endif
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- AEFI Report Modal -->
    <div class="modal fade" id="aefiModal" tabindex="-1" role="dialog" aria-labelledby="aefiModalLabel"
        aria-hidden="true" style="    width: 600px;  left:28%;">
        <div class="modal-dialog modal-md" role="document">
            <form action="{{ route('vc.update-aefi-reports', ['id' => @$edit->id]) }}" method="POST">
                @csrf
                <input type="hidden" name="patient_vaccination_id" id="modal_vaccination_id">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="aefiModalLabel">Add AEFI Report</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="">Patient Name</label>
                                    <input type="text" name="" id="modal_vaccination_patient_name" readonly>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="">Vaccine Name</label>
                                    <input type="text" name="" id="modal_vaccination_vaccine_name" readonly>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="symptoms">Symptoms</label>
                                    <input type="text" class="form-control" name="symptoms">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="classification">Classification</label>
                                    <select class="form-control" name="classification">
                                        <option value="">Select</option>
                                        <option value="minor">Minor</option>
                                        <option value="serious">Serious</option>
                                        <option value="severe">Severe</option>
                                        <option value="unrelated">Unrelated</option>
                                        <option value="unknown">Unknown</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="onset_interval">Onset Interval</label>
                                    <input type="text" class="form-control" name="onset_interval">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="outcome">Outcome</label>
                                    <select class="form-control" name="outcome">
                                        <option value="">Select</option>
                                        <option value="recovered">Recovered</option>
                                        <option value="ongoing">Ongoing</option>
                                        <option value="referred">Referred</option>
                                        <option value="hospitalized">Hospitalized</option>
                                        <option value="deceased">Deceased</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="action_taken">Action Taken</label>
                                    <input type="text" class="form-control" name="action_taken">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="investigation_notes">Investigation Notes</label>
                                    <input type="text" class="form-control" name="investigation_notes">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Submit Report</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
@push('js')
    <script>
    $('#aefiModal').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget); // Button that triggered the modal

        var vaccinationId = button.data('id'); // data-id
        var patientName = button.data('patient'); // data-patient
        var vaccineName = button.data('vaccine'); // data-vaccine

        console.log('Setting vaccination ID to modal:', vaccinationId);

        var modal = $(this);
        modal.find('#modal_vaccination_id').val(vaccinationId);
        modal.find('#modal_vaccination_patient_name').val(patientName);
        modal.find('#modal_vaccination_vaccine_name').val(vaccineName);
    });
</script>
@endpush
