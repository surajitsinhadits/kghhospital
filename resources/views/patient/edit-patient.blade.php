@extends('layouts.structure')
@push('title')
    <title>Edit Patient Details</title>
@endpush
@push('css')
@endpush
@section('main-content')
    <div class="row">
        <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12">
            <div class="card">
                <div class="card-header card_hearder_mimi justify-content-between">
                    <h4 class="card-title card_hearder_mimi_text">
                        Update Patient Details
                    </h4>
                </div>
                <form action="{{ route('hr.patient-update-details') }}" method="POST">
                    @csrf
                    <input type="hidden" name="uhid" value="{{ @$patient_details->id }}">
                    <div class="card-body hospital_allcardbodydesign">
                        <h5 class="font-weight-bold"><i class="fas fa-user"></i> Personal Information</h5>
                        <div class="">
                            <div class="row">
                                <div class="form-group col-md-2 newdesignadd">
                                    <label for="name"> Patient's name<span class="text-danger">*</span> </label>
                                    <input type="text" id="name" class="text-capitalize"
                                        value="{{ @$patient_details->name }}" required name="name">
                                    @error('name')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="form-gsroup col-md-2 newdesignadd ">
                                    <label for="patient_ph_no"> Patient's Phone No<span class="text-danger">*</span></label>
                                    <input type="text" id="patient_ph_no" name="phone"
                                        value="{{ @$patient_details->phone }}" required>
                                    @error('phone')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="form-group col-md-2 newuserlisttchange ">
                                    <label for="gender">Gender <span class="text-danger">*</span></label>
                                    <select name="gender" class="form-control" id="gender">
                                        <option value="">Select Gender</option>
                                        <option value="Male"
                                            {{ old('gender', @$patient_details->gender) == 'Male' ? 'selected' : '' }}>Male
                                        </option>
                                        <option value="Female"
                                            {{ old('gender', @$patient_details->gender) == 'Female' ? 'selected' : '' }}>
                                            Female</option>
                                        <option value="Others"
                                            {{ old('gender', @$patient_details->gender) == 'Others' ? 'selected' : '' }}>
                                            Others</option>
                                    </select>
                                    @error('gender')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="col-lg-2 newdesignadd">
                                    <label for="date_of_birth_year"> Year (age)<span class="text-danger">*</span></label>
                                    <input type="text" value="{{ @$patient_details->dob_year }}" id="dob_year"
                                        name="dob_year" onkeyup="conAge(this.value)">
                                    <small class="text-danger">{{ $errors->first('dob_year') }}</small>
                                </div>
                                <div class="col-lg-2 newdesignadd">
                                    <label for="date_of_birth_month"> Month </label>
                                    <input type="text" value="{{ @$patient_details->dob_month }}" id="dob_month"
                                        name="dob_month">
                                    <small class="text-danger">{{ $errors->first('dob_month') }}
                                    </small>
                                </div>
                                <div class="col-lg-2 newdesignadd">
                                    <label for="date_of_birth_day"> Day </label>
                                    <input type="text" value="{{ @$patient_details->dob_day }}" id="dob_day"
                                        name="dob_day">
                                    <small class="text-danger">{{ $errors->first('dob_day') }}
                                    </small>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="card-body border-top hospital_allcardbodydesign">
                        <div class="row">
                            <div class="col-lg-6 ">
                                <h5 class="font-weight-bold"><i class="fas fa-users-cog"></i> Guardian
                                    Details</h5>
                                <div class="main-profile-contact-list ">
                                    <div class="row">
                                        <div class="form-group col-md-6 newuserchangee">
                                            <label for="guardian_name"> Guardian`s Name</label>
                                            <input type="text" class="text-capitalize" id="guardian_name"
                                                value="{{ @$patient_details->guardian_name }}" name="guardian_name" />
                                            <small class="text-danger">{{ $errors->first('guardian_name') }}</small>
                                        </div>
                                        <div class="form-group col-md-6 newuserchangee">
                                            <label for="guardian_contact_no"> Guardian`s Phone No</label>
                                            <input type="text" id="guardian_contact_no"
                                                value="{{ @$patient_details->guardian_contact_no }}"
                                                name="guardian_contact_no">
                                            <small class="text-danger">{{ $errors->first('guardian_contact_no') }}</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body border-top hospital_allcardbodydesign">
                        <h5 class="font-weight-bold"><i class="fas fa-map-marker-alt"></i>Address</h5>
                        <div class="main-profile-contact-list">
                            <div class="row">
                                <div class="form-group col-md-3 newuserchangee">
                                    <label for="address">Address<span class="text-danger">*</span></label>
                                    <input type="text" id="address" value="{{ @$patient_details->address }}"
                                        name="address" required>
                                    <small class="text-danger">{{ $errors->first('address') }}</small>
                                </div>
                                <div class="form-group col-md-2 addpatientdesign ">
                                    <label for="state">State<span class="text-danger">*</span></label>
                                    <select name="state" class="form-control select2-show-search"
                                        onchange="getDistrict(this.value,{{ @$patient_details->district }})"
                                        id="state">
                                        <option value="">Select State</option>
                                        @foreach ($states as $s)
                                            <option value="{{ $s->id }}"
                                                {{ @$patient_details->state == $s->id ? 'selected' : '' }}>
                                                {{ $s->name }}</option>
                                        @endforeach
                                    </select>
                                    <small class="text-danger">{{ $errors->first('state') }}</small>
                                </div>
                                <div class="form-group col-md-2 addpatientdesign ">
                                    <label for="district">District <span class="text-danger">*</span></label>
                                    <select name="district" class="form-control select2-show-search" id="district">
                                        <option value="">Select District</option>
                                    </select>
                                    <small class="text-danger">{{ $errors->first('district') }}</small>
                                </div>
                                <div class="form-group col-md-1 addpatientdesignpin">
                                    <label for="pin_no">Pin No.</label>
                                    <input type="text" id="pin_code" name="pin_code"
                                        value="{{ @$patient_details->pin_code }}" />
                                    <small class="text-danger">{{ $errors->first('pin_code') }}</small>
                                </div>
                                <div class="form-group col-md-2 addpatientdesignin d-inline-block">
                                    <label for="identification_name"> Identification Name </label>
                                    <select name="identification_name" class="form-control select2-show-search"
                                        id="identification_name">
                                        <option value="Aadhar Card">Aadhar Card</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-2 addpatientdesign d-inline-block">
                                    <label for="identification_number">National Identification
                                        Number</label>
                                    <input type="text" value="{{ @$patient_details->identification_number }}"
                                        id="identification_number" name="identification_number" />
                                    <small class="text-danger">{{ $errors->first('identification_number') }}</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-center">
                        <button class="btn btn-indigo" type="submit">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script>
        function getDistrict(state_id, old_district_id = null) {
            if (state_id) {
                $('#district').html('<option value="">Select District</option>'); // Fixed "value" typo

                $.ajax({
                    url: "{{ Route('get-district') }}",
                    type: "POST",
                    data: {
                        _token: '{{ csrf_token() }}',
                        state_id: state_id,
                    },
                    success: function(response) {
                        if (response.success && response.districts.length > 0) {
                            $.each(response.districts, function(key, value) {
                                let selected = (old_district_id && old_district_id == value.id) ?
                                    'selected' : '';
                                $('#district').append(
                                    `<option value="${value.id}" ${selected}>${value.name}</option>`
                                );
                            });
                        }
                    },
                    error: function(error) {
                        console.log("Error fetching districts:", error);
                    }
                });
            }
        }

        function conAge(year) {
            const currentYear = new Date().getFullYear();
            year = year.toString().trim();

            if (!isNaN(year) && year.length === 4) {
                const new_year = currentYear - parseInt(year, 10);
                if (new_year < 0) {
                    $('#dob_year').val(0);
                } else {
                    $('#dob_year').val(new_year);
                }
            } else {
                $('#dob_year').val(year);
            }
        }



        // Auto-load districts when editing a patient
        $(document).ready(function() {
            let selectedState = $('#state').val();
            let selectedDistrict = "{{ old('district', @$patient_details->district) }}"; // Correct field reference

            if (selectedState) {
                getDistrict(selectedState, selectedDistrict);
            }
        });
    </script>
    <script>
        $(document).ready(function() {
            // Helper: is field required?
            function isRequired($input) {
                return $input.prop('required');
            }

            // Name: required, no special chars
            function validateName() {
                let $input = $('#name');
                let val = $input.val();
                let regex = /^[a-zA-Z0-9\s,.-]*$/;
                if (isRequired($input) && val.trim() === '') {
                    $input.addClass('is-invalid').css('border-color', '#dc3545');
                    return false;
                } else if (val.trim() && !regex.test(val)) {
                    $input.addClass('is-invalid').css('border-color', '#dc3545');
                    return false;
                } else {
                    $input.removeClass('is-invalid').css('border-color', '');
                    return true;
                }
            }

            // Guardian Name: required if required, no special chars
            function validateGuardianName() {
                let $input = $('#guardian_name');
                let val = $input.val();
                let regex = /^[a-zA-Z0-9\s,.-]*$/;
                if (isRequired($input) && val.trim() === '') {
                    $input.addClass('is-invalid').css('border-color', '#dc3545');
                    return false;
                } else if (val.trim() && !regex.test(val)) {
                    $input.addClass('is-invalid').css('border-color', '#dc3545');
                    return false;
                } else {
                    $input.removeClass('is-invalid').css('border-color', '');
                    return true;
                }
            }

            function validateNationalId() {
                let $input = $('#national_identification_number');
                let val = $input.val();
                // Restrict to 16 digits max
                if (val.length > 16) {
                    val = val.slice(0, 16);
                    $input.val(val);
                }
                // If not empty, must be exactly 16 digits
                if (val.trim() && !/^\d{16}$/.test(val)) {
                    $input.addClass('is-invalid').css('border-color', '#dc3545');
                    return false;
                } else {
                    $input.removeClass('is-invalid').css('border-color', '');
                    return true;
                }
            }

            // Phone: required, 10 digits
            function validatePhone() {
                let $input = $('#patient_ph_no');
                let val = $input.val();
                if (isRequired($input) && val.trim() === '') {
                    $input.addClass('is-invalid').css('border-color', '#dc3545');
                    return false;
                } else if (val.trim() && !/^\d{10}$/.test(val)) {
                    $input.addClass('is-invalid').css('border-color', '#dc3545');
                    return false;
                } else {
                    $input.removeClass('is-invalid').css('border-color', '');
                    return true;
                }
            }

            // Gender: required
            function validateGender() {
                let $input = $('#gender');
                let val = $input.val();
                if (isRequired($input) && val === '') {
                    $input.addClass('is-invalid').css('border-color', '#dc3545');
                    return false;
                } else {
                    $input.removeClass('is-invalid').css('border-color', '');
                    return true;
                }
            }

            // Year: required, numeric
            function validateYear() {
                let $input = $('#dob_year');
                let val = $input.val();
                if (isRequired($input) && val.trim() === '') {
                    $input.addClass('is-invalid').css('border-color', '#dc3545');
                    return false;
                } else if (val.trim() && !/^\d+$/.test(val)) {
                    $input.addClass('is-invalid').css('border-color', '#dc3545');
                    return false;
                } else {
                    $input.removeClass('is-invalid').css('border-color', '');
                    return true;
                }
            }

            // Month: numeric (not required)
            function validateMonth() {
                let $input = $('#dob_month');
                let val = $input.val();
                if (val.trim() && !/^\d+$/.test(val)) {
                    $input.addClass('is-invalid').css('border-color', '#dc3545');
                    return false;
                } else {
                    $input.removeClass('is-invalid').css('border-color', '');
                    return true;
                }
            }

            // Day: numeric (not required)
            function validateDay() {
                let $input = $('#dob_day');
                let val = $input.val();
                if (val.trim() && !/^\d+$/.test(val)) {
                    $input.addClass('is-invalid').css('border-color', '#dc3545');
                    return false;
                } else {
                    $input.removeClass('is-invalid').css('border-color', '');
                    return true;
                }
            }

            // Address: required, no special chars
            function validateAddress() {
                let $input = $('#address');
                let val = $input.val();
                let regex = /^[a-zA-Z0-9\s,.-]*$/;
                if (isRequired($input) && val.trim() === '') {
                    $input.addClass('is-invalid').css('border-color', '#dc3545');
                    return false;
                } else if (val.trim() && !regex.test(val)) {
                    $input.addClass('is-invalid').css('border-color', '#dc3545');
                    return false;
                } else {
                    $input.removeClass('is-invalid').css('border-color', '');
                    return true;
                }
            }

            // State: required
            function validateState() {
                let $input = $('#state');
                let val = $input.val();
                if (isRequired($input) && val === '') {
                    $input.addClass('is-invalid').css('border-color', '#dc3545');
                    return false;
                } else {
                    $input.removeClass('is-invalid').css('border-color', '');
                    return true;
                }
            }

            // District: required
            function validateDistrict() {
                let $input = $('#district');
                let val = $input.val();
                if (isRequired($input) && val === '') {
                    $input.addClass('is-invalid').css('border-color', '#dc3545');
                    return false;
                } else {
                    $input.removeClass('is-invalid').css('border-color', '');
                    return true;
                }
            }

            // Pin: numeric (not required)
            function validatePin() {
                let $input = $('#pin_code');
                let val = $input.val();
                if (val.trim() && !/^\d+$/.test(val)) {
                    $input.addClass('is-invalid').css('border-color', '#dc3545');
                    return false;
                } else {
                    $input.removeClass('is-invalid').css('border-color', '');
                    return true;
                }
            }

            // Guardian phone: numeric (not required, but if present must be exactly 10 digits)
            function validateGuardianPhone() {
                let $input = $('#guardian_contact_no');
                let val = $input.val();
                // Restrict to 10 digits max
                if (val.length > 10) {
                    val = val.slice(0, 10);
                    $input.val(val);
                }
                // If not empty, must be exactly 10 digits
                if (val.trim() && !/^\d{10}$/.test(val)) {
                    $input.addClass('is-invalid').css('border-color', '#dc3545');
                    return false;
                } else {
                    $input.removeClass('is-invalid').css('border-color', '');
                    return true;
                }
            }

            // Attach input events for live validation
            $('#name').on('input', validateName);
            $('#guardian_name').on('input', validateGuardianName);
            $('#patient_ph_no').on('input', function() {
                this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10);
                validatePhone();
            });
            $('#gender').on('change', validateGender);
            $('#dob_year').on('input', function() {
                this.value = this.value.replace(/[^0-9]/g, '');
                validateYear();
            });
            $('#dob_month').on('input', function() {
                this.value = this.value.replace(/[^0-9]/g, '');
                validateMonth();
            });
            $('#dob_day').on('input', function() {
                this.value = this.value.replace(/[^0-9]/g, '');
                validateDay();
            });
            $('#address').on('input', validateAddress);
            $('#state').on('change', validateState);
            $('#district').on('change', validateDistrict);
            $('#pin_code').on('input', function() {
                this.value = this.value.replace(/[^0-9]/g, '');
                validatePin();
            });
            $('#guardian_contact_no').on('input', function() {
                this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10);
                validateGuardianPhone();
            });

            // Highlight required fields on blur if empty (no message, just border)
            $('form[action*="patient-update-details"] [required]').each(function() {
                var $input = $(this);
                $input.on('blur', function() {
                    if ($input.val().trim() === '') {
                        $input.addClass('is-invalid').css('border-color', '#dc3545');
                    } else {
                        $input.removeClass('is-invalid').css('border-color', '');
                    }
                });
                $input.on('input', function() {
                    if ($input.val().trim() !== '') {
                        $input.removeClass('is-invalid').css('border-color', '');
                    }
                });
            });

            // On form submit, validate all
            $('form[action*="patient-update-details"]').on('submit', function(e) {
                let valid = true;
                if (!validateName()) valid = false;
                if (!validateGuardianName()) valid = false;
                if (!validatePhone()) valid = false;
                if (!validateGender()) valid = false;
                if (!validateYear()) valid = false;
                if (!validateMonth()) valid = false;
                if (!validateDay()) valid = false;
                if (!validateAddress()) valid = false;
                if (!validateState()) valid = false;
                if (!validateDistrict()) valid = false;
                if (!validatePin()) valid = false;
                if (!validateGuardianPhone()) valid = false;

                // Check all required fields again on submit
                $('form[action*="patient-update-details"] [required]').each(function() {
                    var $input = $(this);
                    if ($input.val().trim() === '') {
                        $input.addClass('is-invalid').css('border-color', '#dc3545');
                        valid = false;
                    }
                });

                if (!valid) {
                    e.preventDefault();
                    if (typeof toastr !== 'undefined') {
                        toastr.error('Please fix validation errors before submitting.');
                    } else {
                        alert('Please fix validation errors before submitting.');
                    }
                    return false;
                }
            });
        });
    </script>
@endpush
