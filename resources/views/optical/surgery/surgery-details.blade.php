@extends('layouts.structure')

@push('title')
    <title>Surgery Case Information</title>
@endpush

@push('css')
@endpush

@section('main-content')
    <div class="row">
        <div class="card">
            <div class="card-header d-block card_hearder_mimi">
                <div class="row">
                    <div class="col-md-6 card-title card_hearder_mimi_text">
                        Surgery Case Information
                    </div>
                </div>
            </div>

            <div class="card-body">
                <form method="POST" id="myForm" action="{{ route('optical.update-surgery', @$surgery->id) }}">
                    @csrf
                    <div class="card-body p-0">
                        <div class="row no-gutters">
                            <div class="col-md-4">
                                <div class="options px-5 pt-2 pb-1">
                                    <table class="table table_border_none">
                                        <tbody>
                                            <tr>
                                                <td class="py-2 px-0"><i class="fas fa-yin-yang text-danger"></i></td>
                                                <td class="py-2 px-0">
                                                    <span class="font-weight-semibold w-50">Patient Name :- </span>
                                                </td>
                                                <td class="py-2 px-0">
                                                    {{ @$patient->name }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="py-2 px-0"><i class="fas fa-yin-yang text-danger"></i></td>
                                                <td class="py-2 px-0">
                                                    <span class="font-weight-semibold w-50">Patient UHID :- </span>
                                                </td>
                                                <td class="py-2 px-0">
                                                    {{ @$patient->uhid ?? @$patient->id }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="py-2 px-0"><i class="fas fa-yin-yang text-danger"></i></td>
                                                <td class="py-2 px-0">
                                                    <span class="font-weight-semibold w-50">Mobile :- </span>
                                                </td>
                                                <td class="py-2 px-0">
                                                    {{ @$patient->phone }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="py-2 px-0"><i class="fas fa-yin-yang text-danger"></i></td>
                                                <td class="py-2 px-0">
                                                    <span class="font-weight-semibold w-50">Gender :- </span>
                                                </td>
                                                <td class="py-2 px-0">
                                                    {{ @$patient->gender }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="py-2 px-0"><i class="fas fa-yin-yang text-danger"></i></td>
                                                <td class="py-2 px-0">
                                                    <span class="font-weight-semibold w-50">Marital Status :- </span>
                                                </td>
                                                <td class="py-2 px-0">
                                                    {{ @$patient->marital_status }}
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                {{-- ================== patient information ====================== --}}
                            </div>
                            <div class="col-md-4">
                                <div class="options px-5 pt-2 pb-1">
                                    <table class="table table_border_none">
                                        <tbody>
                                            <tr>
                                                <td class="py-2 px-0"><i class="fas fa-yin-yang text-danger"></i>
                                                </td>
                                                <td class="py-2 px-0">
                                                    <span class="font-weight-semibold w-50">DOB :- </span>
                                                </td>
                                                <td class="py-2 px-0">
                                                    {{ dateFor(@$patient->date_of_birth) }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="py-2 px-0"><i class="fas fa-yin-yang text-danger"></i>
                                                </td>
                                                <td class="py-2 px-0">
                                                    <span class="font-weight-semibold w-50">Age :- </span>
                                                </td>
                                                <td class="py-2 px-0">
                                                    {{ @$patient->dob_year ? $patient->dob_year . 'Y' : '' }}
                                                    {{ @$patient->dob_month ? $patient->dob_month . 'M' : '' }}
                                                    {{ @$patient->dob_day ? $patient->dob_day . 'D' : '' }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="py-2 px-0">
                                                    <i class="fas fa-yin-yang text-danger"></i>
                                                </td>
                                                <td class="py-2 px-0">
                                                    <span class="font-weight-semibold w-50">Guardian Name :- </span>
                                                </td>
                                                <td class="py-2 px-0">
                                                    {{ @$patient->guardian_name }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="py-2 px-0">
                                                    <i class="fas fa-yin-yang text-danger"></i>
                                                </td>
                                                <td class="py-2 px-0">
                                                    <span class="font-weight-semibold w-50">Relation :- </span>
                                                </td>
                                                <td class="py-2 px-0">
                                                    {{ @$patient->guardian_realation }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="py-2 px-0">
                                                    <i class="fas fa-yin-yang text-danger"></i>
                                                </td>
                                                <td class="py-2 px-0">
                                                    <span class="font-weight-semibold w-50">Alternative Number :- </span>
                                                </td>
                                                <td class="py-2 px-0">
                                                    {{ @$patient->guardian_contact_no }}
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="options px-5 pt-2 pb-1">
                                    <table class="table table_border_none">
                                        <tbody>
                                            <tr>
                                                <td class="py-2 px-0"><i class="fas fa-yin-yang text-danger"></i></td>
                                                <td class="py-2 px-0">
                                                    <span class="font-weight-semibold w-50">Address :- </span>
                                                </td>
                                                <td class="py-2 px-0">
                                                    {{ @$patient->address }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="py-2 px-0"><i class="fas fa-yin-yang text-danger"></i></td>
                                                <td class="py-2 px-0">
                                                    <span class="font-weight-semibold w-50">State :- </span>
                                                </td>
                                                <td class="py-2 px-0">
                                                    {{ @$patient->state_name }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="py-2 px-0"><i class="fas fa-yin-yang text-danger"></i></td>
                                                <td class="py-2 px-0">
                                                    <span class="font-weight-semibold w-50">District :- </span>
                                                </td>
                                                <td class="py-2 px-0">
                                                    {{ @$patient->district_name }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="py-2 px-0"><i class="fas fa-yin-yang text-danger"></i></td>
                                                <td class="py-2 px-0">
                                                    <span class="font-weight-semibold w-50">Pin Code :- </span>
                                                </td>
                                                <td class="py-2 px-0">
                                                    {{ @$patient->pin_code }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="py-2 px-0"><i class="fas fa-yin-yang text-danger"></i></td>
                                                <td class="py-2 px-0">
                                                    <span class="font-weight-semibold w-50">Aadhar Number :- </span>
                                                </td>
                                                <td class="py-2 px-0">
                                                    {{ @$patient->identification_number }}
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                {{-- ================== patient information ====================== --}}
                            </div>
                            <div class="col-lg-12 border-right">
                                <div class="hospital_allcardbodydesign border mt-2">
                                    <h5 class="text-blue"> <i class="fa fa-user text-orange"></i> SURGERY DETAILS : </h5>
                                    <div class="row">
                                        <div class="form-group col-md-2">
                                            <label>Planning Date <span class="text-danger">*</span></label>
                                            <input type="text" name="planning_date" class="form-control datePickr"
                                                value="{{ old('planning_date', dateFor($surgery->planning_date)) }}" required>
                                                @error('planning_date')<small class="text-danger">{{$message}}</small>@enderror
                                        </div>
                                        <div class="form-group col-md-2">
                                            <label for="department">Department</label>
                                            <select name="department" class="form-control select2-show-search"
                                                onchange="getDoctor(this.value)" id="department">
                                                <option value="">All</option>
                                                @foreach ($department as $dept)
                                                    <option value="{{ $dept->id }}"
                                                        {{ $surgery->dept_id == $dept->id ? 'selected' : '' }}>
                                                        {{ $dept->department_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('department')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-2">
                                            <label>Doctor <span class="text-danger">*</span></label>
                                            <select name="doctor" class="form-control select2-show-search"
                                                id="doctor" required>
                                                <option value="">Select</option>
                                                @foreach ($doctors as $doc)
                                                    <option value="{{ $doc->id }}"
                                                        {{ $surgery->doctor_id == $doc->id ? 'selected' : '' }}>Dr.
                                                        {{ $doc->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group col-md-2">
                                            <label>Eye <span class="text-danger">*</span></label>
                                            <select name="eye" class="form-control" required>
                                                <option value="">Select</option>
                                                <option value="left" {{ $surgery->eye == 'left' ? 'selected' : '' }}>
                                                    Left</option>
                                                <option value="right" {{ $surgery->eye == 'right' ? 'selected' : '' }}>
                                                    Right</option>
                                                <option value="both" {{ $surgery->eye == 'both' ? 'selected' : '' }}>
                                                    Both</option>
                                            </select>
                                        </div>

                                        <div class="form-group col-md-2">
                                            <label>Surgery Type <span class="text-danger">*</span></label>
                                            <select name="surgery_type" class="form-control select2-show-search" required>
                                                <option value="">Select</option>
                                                <option value="Cataract"
                                                    {{ $surgery->surgery_type == 'Cataract' ? 'selected' : '' }}>Cataract
                                                </option>
                                                <option value="LASIK"
                                                    {{ $surgery->surgery_type == 'LASIK' ? 'selected' : '' }}>LASIK
                                                </option>
                                                <option value="Retinal"
                                                    {{ $surgery->surgery_type == 'Retinal' ? 'selected' : '' }}>Retinal
                                                </option>
                                                <option value="Glaucoma"
                                                    {{ $surgery->surgery_type == 'Glaucoma' ? 'selected' : '' }}>Glaucoma
                                                </option>
                                                <option value="Other"
                                                    {{ $surgery->surgery_type == 'Other' ? 'selected' : '' }}>Other
                                                </option>
                                            </select>
                                        </div>

                                        <div class="form-group col-md-2">
                                            <label>Diagnosis <span class="text-danger">*</span></label>
                                            <input type="text" name="diagnosis" class="form-control"
                                                value="{{ $surgery->diagnosis }}" required>
                                        </div>

                                        <div class="form-group col-md-2">
                                            <label>Priority <span class="text-danger">*</span></label>
                                            <select name="priority" class="form-control" required>
                                                <option value="">Select</option>
                                                <option value="elective"
                                                    {{ $surgery->priority == 'elective' ? 'selected' : '' }}>Elective
                                                </option>
                                                <option value="urgent"
                                                    {{ $surgery->priority == 'urgent' ? 'selected' : '' }}>Urgent</option>
                                            </select>
                                        </div>

                                        <div class="form-group col-md-2">
                                            <label>Status <span class="text-danger">*</span></label>
                                            <select onchange="statusChange()" name="status" class="form-control"
                                                required>
                                                <option {{ $surgery->status == 'scheduled' ? 'disabled' : '' }} value="planned" {{ old('status', $surgery->status) == 'planned' ? 'selected' : '' }}>Planned</option>
                                                <option value="scheduled" {{ old('status', $surgery->status) == 'scheduled' ? 'selected' : '' }}>Scheduled</option>
                                                {{-- <option value="completed" {{ old('status', $surgery->status) == 'completed' ? 'selected' : '' }}>Completed</option> --}}
                                                <option value="cancelled" {{ old('status', $surgery->status) == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                            </select>
                                        </div>
                                        <!-- <div id="scheduled_section" class="{{ old('status', $surgery->status) != 'scheduled' ? 'd-none' : 'd-flex' }}"> -->
                                            <div class="form-group scheduled_section col-md-2 {{ old('status', $surgery->status) != 'scheduled' ? 'd-none' : '' }}">
                                                <label>Upload Consent Form</label>
                                                <input type="file" name="consent_file" style="margin: 0px;"
                                                    class="form-control">
                                            </div>

                                            <div class="form-group scheduled_section col-md-2 {{ old('status', $surgery->status) != 'scheduled' ? 'd-none' : '' }}">
                                                <label>Schedule Date <span class="text-danger">*</span></label>
                                                <input type="text" name="schedule_date" class="form-control datePickr"
                                                    value="{{ old('schedule_date', dateFor(@$surgery->schedule_date)) }}">
                                                @error('schedule_date')
                                                    <small class="text-danger">Schedule date is required.</small>
                                                @enderror
                                            </div>

                                            <div class="form-group scheduled_section col-md-1 {{ old('status', $surgery->status) != 'scheduled' ? 'd-none' : '' }}">
                                                <label>Form Time <span class="text-danger">*</span></label>
                                                <input type="text" name="schedule_form_time"
                                                    class="form-control timePickr"
                                                    value="{{ old('schedule_form_time', dateFor(@$surgery->schedule_form_time)) }}">
                                                @error('schedule_form_time')
                                                    <small class="text-danger">Form time is required.</small>
                                                @enderror
                                            </div>

                                            <div class="form-group scheduled_section col-md-1 {{ old('status', $surgery->status) != 'scheduled' ? 'd-none' : '' }}">
                                                <label>To Time <span class="text-danger">*</span></label>
                                                <input type="text" name="schedule_to_time"
                                                    class="form-control timePickr"
                                                    value="{{ old('schedule_to_time', dateFor(@$surgery->schedule_to_time)) }}">
                                                @error('schedule_to_time')
                                                    <small class="text-danger">To time is required.</small>
                                                @enderror
                                            </div>

                                            <div class="form-group scheduled_section col-md-2 {{ old('status', $surgery->status) != 'scheduled' ? 'd-none' : '' }}">
                                                <label for="package_id">Operation Package <span
                                                        class="text-danger">*</span></label>
                                                <select name="package_id" class="form-control select2-show-search"
                                                    id="package_id">
                                                    <option value="">Select</option>
                                                    @foreach ($otpackages as $doc)
                                                        <option value="{{ $doc->id }}" {{ $surgery->package_id == $doc->id ? 'selected' : '' }}>{{ $doc->package_name }}(₹{{ $doc->package_amount }})
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('package_id')
                                                    <small class="text-danger">Package is required.</small>
                                                @enderror
                                            </div>
                                        <!-- </div> -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="text-center mb-4 mt-2">
                        <button class="btn btn-primary btn-sm submitBtn" type="submit" name="submit" value="new">
                            <i class="fa fa-file text-success"></i> Update
                        </button>
                        <button id="update_ot_process" class="btn btn-primary btn-sm submitBtn" type="submit" name="submit" value="ot">
                            <i class="fa fa-file text-success"></i> Update & OT Process
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script>
        $(document).ready(function() {
            // Ensure correct display on page load
            statusChange();
        });

        function statusChange() {
            var status = $('select[name="status"]').val();
            if (status === 'scheduled') {
                $('#update_ot_process').removeClass('d-none');
                $('.scheduled_section').removeClass('d-none');
            } else {
                $('#update_ot_process').addClass('d-none');
                $('.scheduled_section').addClass('d-none');
            }
        }

        function getDoctor(department_id) {
            if (department_id) {
                $('#doctor').html('<option vaule="">Select Doctor</option>');
                $.ajax({
                    url: "{{ Route('opd.get-doctors') }}",
                    type: "POST",
                    data: {
                        _token: '{{ csrf_token() }}',
                        dept_id: department_id,
                    },
                    success: function(response) {
                        if (response.success && (response.doctors.length > 0)) {
                            $.each(response.doctors, function(key, value) {
                                $('#doctor').append(
                                    `<option value="${value.id}">${value.salutation} ${value.name}</option>`
                                    );
                            });
                        }
                    },
                    error: function(error) {
                        console.log(error);
                    }
                });
            }
        }
    </script>
@endpush
