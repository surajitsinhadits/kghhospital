@extends('layouts.structure')

@push('title')
    <title>{{ $title }}</title>
@endpush

@section('main-content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header card_hearder_mimi">
                    <h4 class="card-title card_hearder_mimi_text">{{ $title }}</h4>
                </div>
                <div class="card-body row justify-content-center">
                    <form method="POST" class="w-75" id="doner-register-form" action="{{ route('bl.doner-save', @$edit->id) }}"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="card-body hospital_allcardbodydesign">
                            <h5 class="font-weight-bold"><i class="fas fa-user"></i> Donor Information</h5>
                            <div class="row">
                                <div class="col-md-1 newuserchange">
                                    <label>Donor ID</label>
                                    <input type="text" name="doner_id" class="form-control"
                                        value="{{ old('id', $edit->id ?? '') }}" id="doner_id" readonly>
                                </div>
                                <div class="col-md-2 newuserchange">
                                    <label>Camp </label>
                                    <select name="camp_id" class="form-control" id="camp_id">
                                        <option value="">Select Camp</option>
                                        @foreach ($camps as $item)
                                            <option value="{{ $item->id }}"
                                                {{ old('gender', @$edit->camp_id ?? '') == $item->id ? 'selected' : '' }}>
                                                {{ $item->camp_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3 newuserchange">
                                    <label>Donor Name <span class="text-danger">*</span></label>
                                    <input type="text" name="name" id="name" class="form-control"
                                        value="{{ old('name', @$edit->name ?? '') }}" autocomplete="off"
                                        onkeyup="getDoner(this.value,'name')" required>
                                    @error('name')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-3 newuserchange">
                                    <label>Gender <span class="text-danger">*</span></label>
                                    <select name="gender" class="form-control" id="gender" required>
                                        <option value="">Select</option>
                                        @foreach (['Male', 'Female', 'Other'] as $gender)
                                            <option value="{{ $gender }}"
                                                {{ old('gender', @$edit->gender ?? '') == $gender ? 'selected' : '' }}>
                                                {{ $gender }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('gender')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-3 newuserchange">
                                    <label>Contact Number <span class="text-danger">*</span></label>
                                    <input type="text" name="contact_number"
                                        value="{{ old('contact_number', $edit->contact_number ?? '') }}"
                                        class="form-control" id="contact_number"
                                        onkeyup="getDoner(this.value,'contact_number')" maxlength="10" required>
                                    @error('contact_number')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-12">
                                    <div class="card-body hospital_allcardbodydesign" style="display:none"
                                        id="search_result">
                                        <div class="table-responsive">
                                            <table class="table table-hover card-table table-vcenter text-nowrap border"
                                                style="background-color:#d9d9d9;border:1px solid black !important">
                                                <thead class="text-white" style="background-color:#5e6545">
                                                    <tr class="border-left">
                                                        <th class="text-white">Donor Name</th>
                                                        <th class="text-white">Phone</th>
                                                        <th class="text-white">Gender</th>
                                                        <th class="text-white">DOB</th>
                                                        <th class="text-white">Blood Group</th>
                                                        <th class="text-white">Gov. ID</th>
                                                        <th class="text-white">Last Donation Date</th>
                                                        <th class="text-white">Address</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="search_result_row"></tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-2 newuserchange">
                                    <label>Date Of Birth</label>
                                    <input type="text" name="dob" class="form-control datePickr" id="dob"
                                        value="{{ old('dob', dateFor(@$edit->dob) ?? '') }}">
                                </div>

                                <div class="col-md-2 newuserchange">
                                    <label>Blood Group</label>
                                    <select name="blood_group" class="form-control" id="blood_group">
                                        <option value="">Select</option>
                                        @foreach (['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'] as $bg)
                                            <option value="{{ $bg }}"
                                                {{ old('blood_group', $edit->blood_group ?? '') == $bg ? 'selected' : '' }}>
                                                {{ $bg }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-2 newuserchange">
                                    <label>Email</label>
                                    <input type="email" name="email" class="form-control" id="email"
                                        value="{{ old('email', $edit->email ?? '') }}">
                                </div>

                                <div class="col-md-3 newuserchange">
                                    <label>Aadhar Number/Gov. ID</label>
                                    <input type="text" name="gov_id" class="form-control" id="gov_id"
                                        value="{{ old('gov_id', $edit->gov_id ?? '') }}">
                                </div>

                                <div class="col-md-3 newuserchange">
                                    <label>Health Questionnaire Responses</label>
                                    <select name="health_questionnaire_responses" class="form-control"
                                        id="health_questionnaire_responses">
                                        <option value="">Select</option>
                                        @foreach (['Yes', 'No', 'NLP'] as $bg)
                                            <option value="{{ $bg }}"
                                                {{ old('health_questionnaire_responses', $edit->health_questionnaire_responses ?? '') == $bg ? 'selected' : '' }}>
                                                {{ $bg }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-3 newuserchange">
                                    <label>Deferral Reason</label>
                                    <input type="text" name="deferral_reason" class="form-control"
                                        id="deferral_reason"
                                        value="{{ old('deferral_reason', $edit->deferral_reason ?? '') }}">
                                </div>
                                <div class="col-md-3 newuserchange">
                                    <label>Last Donation date</label>
                                    <input type="text" name="last_donation_date" class="form-control datePickr"
                                        id="last_donation_date"
                                        value="{{ old('last_donation_date', dateFor(@$edit->last_donation_date) ?? '') }}">

                                </div>
                                <div class="col-md-6 newuserchange">
                                    <label>Address <span class="text-danger">*</span></label>
                                    <textarea name="address" rows="1" class="form-control" id="address" required>{{ old('address', $edit->address ?? '') }}</textarea>
                                    @error('address')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="col-md-4 newuserchange">
                                    <label for="state">State <span class="text-danger">*</span></label>
                                    <select name="state" class="form-control" onchange="getDistrict(this.value)"
                                        id="state" tabindex="9" required>
                                        <option value="">Select State</option>
                                        @foreach ($states as $s)
                                            <option value="{{ $s->id }}"
                                                {{ old('state', $edit->state ?? '') == $s->id ? 'selected' : '' }}>
                                                {{ $s->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('state')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-4 newuserchange">
                                    <label for="district">District <span class="text-danger">*</span></label>
                                    <select name="district" class="form-control" id="district" required>
                                        <option value="">Select District</option>
                                    </select>
                                    @error('district')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-4 newuserchange">
                                    <label for="pin_no">Pin No.</label>
                                    <input type="text" id="pin_code" name="pin_code"
                                        value="{{ old('pin_code', $edit->pin_code ?? '') }}" class="form-control"
                                        tabindex="11">
                                </div>

                            </div>
                        </div>
                        <div class="card-body hospital_allcardbodydesign">
                            <div class="row justify-content-center">
                                <button type="submit" class="btn btn-primary" name="submit_action" value="{{ strtolower(str_replace(' ', '_', $btn)) }}">
                                    <i class="fa fa-paper-plane mr-2"></i> {{ $btn }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        function getDoner(val, col) {
            var div_data = '';
            $('#search_result').attr('style', 'display:none', true);
            $('#search_result_row').html('');
            if (val && col) {
                $.ajax({
                    url: "{{ route('bl.doner-info') }}",
                    type: "POST",
                    data: {
                        _token: '{{ csrf_token() }}',
                        field: col,
                        value: val,
                    },
                    success: function(response) {
                        if (response.success && (response.doner.length > 0)) {
                            $('#search_result').removeAttr('style', true);
                            $.each(response.doner, function(key, value) {
                                let donerData = encodeURIComponent(JSON.stringify(value));
                                div_data += `<tr class="color_hover_charnge" onclick="selectDoner('${donerData}')" style="cursor: pointer !important;">
                                    <td>${value.name}</td>
                                    <td>${value.contact_number}</td>
                                    <td>${value.gender}</td>
                                    <td>${value.dob ? formatDateTime(value.dob,'date') : ''}</td>
                                    <td>${value.blood_group ?? ''}</td>
                                    <td>${value.gov_id ?? ''}</td>
                                    <td>${value.last_donation_date ? formatDateTime(value.last_donation_date,'date') : ''}</td>
                                    <td>${value.address ?? ''}</td>
                                </tr>`;
                            });
                            $('#search_result_row').html(div_data);
                        }
                    },
                    error: function(error) {
                        console.log(error);
                    }
                });
            }
        }

        function selectDoner(data) {
            let doner = JSON.parse(decodeURIComponent(data));
            $('#doner_id').val(doner.id);
            $('#name').val(doner.name);
            $('#camp_id').val(doner.camp_id);
            $('#gender').val(doner.gender).trigger('change');
            $('#contact_number').val(doner.contact_number);
            $('#dob').val(doner.dob ? formatDateTime(doner.dob, 'date') : '');
            $('#blood_group').val(doner.blood_group).trigger('change');
            $('#email').val(doner.email);
            $('#gov_id').val(doner.gov_id);
            $('#health_questionnaire_responses').val(doner.health_questionnaire_responses).trigger('change');
            $('#deferral_reason').val(doner.deferral_reason);
            $('#last_donation_date').val(doner.last_donation_date ? formatDateTime(doner.last_donation_date, 'date') : '');
            $('#address').val(doner.address);
            $('#state').val(doner.state).trigger('change');
            getDistrict(doner.state, doner.district);
            $('#pin_code').val(doner.pin_code);

            $('#search_result_row').html('');
            $('#search_result').attr('style', 'display:none', true);
        }

        function getDistrict(state_id, dist_id = 0) {
            if (state_id) {
                $('#district').html('<option value="">Select District</option>');
                $.ajax({
                    url: "{{ route('get-district') }}",
                    type: "POST",
                    data: {
                        _token: '{{ csrf_token() }}',
                        state_id: state_id,
                    },
                    success: function(response) {
                        if (response.success && response.districts.length > 0) {
                            $.each(response.districts, function(key, value) {
                                $('#district').append(
                                    `<option value="${value.id}" ${dist_id == value.id ? 'selected' : ''}>${value.name}</option>`
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

        $(document).ready(function() {
            let selectedState = $('#state').val();
            let selectedDistrict = "{{ old('district', @$edit->district) }}";

            if (selectedState) {
                getDistrict(selectedState, selectedDistrict);
            }
        });
    </script>

    <script>
        $(document).ready(function() {
            const $form = $('#doner-register-form');
            let activeSubmitButton = null;

            // Validation rules for each field
            function validateField($field) {
                let name = $field.attr('name');
                let val = $field.val() ? $field.val().trim() : '';
                let valid = true;

                switch (name) {
                    case 'name':
                        valid = !!val && /^[A-Za-z\s]+$/.test(val);
                        break;
                    case 'gender':
                        valid = !!val;
                        break;
                    case 'contact_number':
                        valid = !!val && /^\d{10}$/.test(val);
                        break;
                    case 'email':
                        // Allow empty, but if filled must be valid
                        valid = !val || /^[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,}$/.test(val);
                        break;
                    case 'address':
                        // Only allow spaces, commas, slashes, alphabets, and numbers
                        valid = !!val && /^[A-Za-z0-9\s,\/]+$/.test(val);
                        break;
                    case 'state':
                        valid = !!val;
                        break;
                    case 'district':
                        valid = !!val;
                        break;
                    case 'gov_id':
                        // Only alphabets and numbers allowed, no special characters or spaces
                        valid = !!val && /^[A-Za-z0-9]+$/.test(val);
                        break;
                    case 'pin_code':
                        // Only numbers allowed, no alphabets
                        valid = !val || /^[0-9]+$/.test(val);
                        break;
                    default:
                        // For other fields, no validation
                        break;
                }

                if (!valid) {
                    $field.addClass('border-danger').removeClass('border-primary').css('border-color', '#dc3545');
                } else {
                    $field.removeClass('border-danger').addClass('border-primary').css('border-color', '#007bff');
                }
                return valid;
            }

            // Validate all required fields
            function validateForm() {
                let valid = true;
                let $fields = $(
                    'input[name="name"], ' +
                    'select[name="gender"], ' +
                    'input[name="contact_number"], ' +
                    'input[name="email"], ' +
                    'textarea[name="address"], ' +
                    'select[name="state"], ' +
                    'select[name="district"], ' +
                    'input[name="gov_id"], ' +
                    'input[name="pin_code"]'
                );
                $fields.each(function() {
                    if (!validateField($(this))) valid = false;
                });
                return valid;
            }

            // Live validation on keyup/change for all relevant fields
            $(
                'input[name="name"], ' +
                'select[name="gender"], ' +
                'input[name="contact_number"], ' +
                'input[name="email"], ' +
                'textarea[name="address"], ' +
                'select[name="state"], ' +
                'select[name="district"], ' +
                'input[name="gov_id"], ' +
                'input[name="pin_code"]'
            ).on('input change keyup', function() {
                validateField($(this));
            });

            // Restrict Donor Name to alphabets and spaces only
            $('input[name="name"]').on('input', function() {
                this.value = this.value.replace(/[^A-Za-z\s]/g, '');
            });

            // Restrict Contact Number to digits only, max 10 digits
            $('input[name="contact_number"]').on('input', function() {
                this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10);
            });

            // Restrict Address to spaces, commas, slashes, alphabets, and numbers only
            $('textarea[name="address"]').on('input', function() {
                this.value = this.value.replace(/[^A-Za-z0-9\s,\/]/g, '');
            });

            // Restrict gov_id to alphabets and numbers only, no special characters or spaces
            $('input[name="gov_id"]').on('input', function() {
                this.value = this.value.replace(/[^A-Za-z0-9]/g, '');
            });

            // Restrict pin_code to numbers only, no alphabets
            $('input[name="pin_code"]').on('input', function() {
                this.value = this.value.replace(/[^0-9]/g, '');
            });

            $form.find('button[type="submit"], input[type="submit"]').on('click', function() {
                activeSubmitButton = this;
            });

            // On submit, prevent submit if invalid
            $form.on('submit', function(e) {
                const form = this;

                if ($form.data('submitting') === true) {
                    e.preventDefault();
                    return false;
                }

                if (!validateForm()) {
                    e.preventDefault();
                    let $firstInvalid = $(this).find('.border-danger:visible').first();
                    if ($firstInvalid.length) $firstInvalid.focus();
                    return false;
                }

                if (!form.checkValidity()) {
                    return true;
                }

                const submitter = e.originalEvent && e.originalEvent.submitter
                    ? e.originalEvent.submitter
                    : activeSubmitButton;

                if (submitter && submitter.name) {
                    $('<input>', {
                        type: 'hidden',
                        name: submitter.name,
                        value: submitter.value
                    }).appendTo(form);
                }

                $form.data('submitting', true);

                $form.find('button[type="submit"], input[type="submit"]').each(function() {
                    if (this.tagName === 'BUTTON') {
                        this.dataset.originalText = this.innerHTML;
                        this.innerHTML = 'Processing...';
                    } else {
                        this.dataset.originalText = this.value;
                        this.value = 'Processing...';
                    }

                    this.disabled = true;
                });
            });

            // Remove error highlight on input/change if valid
            $('input, select, textarea').on('input change', function() {
                if ($(this).hasClass('border-danger')) {
                    validateField($(this));
                }
            });
        });
    </script>
@endpush
