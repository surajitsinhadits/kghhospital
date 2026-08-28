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
                <div class="card-body">
                    <form method="POST" action="{{ route('bl.blood-collection-save') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body hospital_allcardbodydesign px-5">
                            <h5 class="font-weight-bold"><i class="fas fa-user"></i> Donor Information</h5>

                            <div class="row">
                                <div class="col-md-2 newuserchange">
                                    <label>Donation Date <span class="text-danger">*</span></label>
                                    <input type="text" name="donation_date" class="form-control datePickr"
                                        value="{{ @$edit->donation_date ? dateFor($edit->donation_date) : date('d-m-Y') }}">
                                    @error('donation_date')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-1 newuserchange">
                                    <label>Donor ID</label>
                                    <input type="text" name="doner_id" class="form-control"
                                        value="{{ old('id', $edit->donor_id ?? '') }}" id="doner_id" readonly>
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

                                <div class="col-md-2 newuserchange">
                                    <label>Donor Name <span class="text-danger">*</span></label>
                                    <input type="text" name="name" id="name" class="form-control"
                                        value="{{ old('name', @$edit->name ?? '') }}" autocomplete="off"
                                        onkeyup="getDoner(this.value,'name')">
                                    @error('name')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-1 newuserchange">
                                    <label>Gender <span class="text-danger">*</span></label>
                                    <select name="gender" class="form-control" id="gender">
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

                                <div class="col-md-1 newuserchange">
                                    <label>Contact No <span class="text-danger">*</span></label>
                                    <input type="text" name="contact_number"
                                        value="{{ old('contact_number', $edit->contact_number ?? '') }}"
                                        class="form-control" id="contact_number"
                                        onkeyup="getDoner(this.value,'contact_number')" maxlength="10">
                                    @error('contact_number')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-1 newuserchange">
                                    <label>Date Of Birth</label>
                                    <input type="text" name="dob" class="form-control datePickr" id="dob"
                                        value="{{ old('dob', dateFor(@$edit->dob) ?? '') }}">
                                </div>

                                <div class="col-md-1 newuserchange">
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

                                <div class="col-md-1 newuserchange">
                                    <label>Email</label>
                                    <input type="email" name="email" class="form-control" id="email"
                                        value="{{ old('email', $edit->email ?? '') }}">
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
                                    <label>Last Donation date</label>
                                    <input type="text" name="last_donation_date" class="form-control datePickr"
                                        id="last_donation_date"
                                        value="{{ old('last_donation_date', dateFor(@$edit->last_donation_date) ?? '') }}">
                                </div>

                                <div class="col-md-1 newuserchange">
                                    <label>Gov. ID</label>
                                    <input type="text" name="gov_id" class="form-control" id="gov_id"
                                        value="{{ old('gov_id', $edit->gov_id ?? '') }}">
                                </div>

                                <div class="col-md-2 newuserchange">
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

                                <div class="col-md-2 newuserchange">
                                    <label>Deferral Reason</label>
                                    <input type="text" name="deferral_reason" class="form-control"
                                        id="deferral_reason"
                                        value="{{ old('deferral_reason', $edit->deferral_reason ?? '') }}">
                                </div>

                                <div class="col-md-2 newuserchange">
                                    <label>Address <span class="text-danger">*</span></label>
                                    <textarea name="address" rows="1" class="form-control" id="address">{{ old('address', $edit->address ?? '') }}</textarea>
                                    @error('address')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-1 newuserchange">
                                    <label for="state">State <span class="text-danger">*</span></label>
                                    <select name="state" class="form-control" onchange="getDistrict(this.value)"
                                        id="state" tabindex="9">
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

                                <div class="col-md-1 newuserchange">
                                    <label for="district">District <span class="text-danger">*</span></label>
                                    <select name="district" class="form-control" id="district">
                                        <option value="">Select District</option>
                                    </select>
                                    @error('district')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-1 newuserchange">
                                    <label for="pin_no">Pin No.</label>
                                    <input type="text" id="pin_code" name="pin_code"
                                        value="{{ old('pin_code', $edit->pin_code ?? '') }}" class="form-control"
                                        tabindex="11">
                                </div>
                            </div>
                        </div>

                        <div class="card-body hospital_allcardbodydesign px-5">
                            <h5 class="font-weight-bold"><i class="fas fa-tint"></i> Donation Information</h5>
                            <input type="hidden" name="donations_id"
                                value="{{ old('donations_id', @$edit->id ?? '') }}">
                            <div class="row">
                                @if (@$edit->bag_barcode)
                                    <div class="col-md-3 newuserchange">
                                        <label>Bag Barcode <span class="text-danger">*</span></label>
                                        <input type="text" name="bag_barcode"
                                            value="{{ old('bag_barcode', @$edit->bag_barcode ?? '') }}"
                                            class="form-control" id="bag_barcode" readonly>
                                        @error('bag_barcode')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                @else
                                    <div class="col-md-3 newuserchange">
                                        <label>Bag Barcode <span class="text-danger">*</span></label>
                                        <input type="text" name="bag_barcode" value="{{ old('bag_barcode') }}"
                                            class="form-control" id="bag_barcode">
                                        @error('bag_barcode')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                @endif
                                <div class="col-md-3 newuserchange">
                                    <label>Collection Site</label>
                                    <select name="collection_site" class="form-control">
                                        <option value="">-- Select --</option>
                                        @foreach (['Fixed', 'Mobile'] as $value)
                                            <option value="{{ $value }}"
                                                {{ old('collection_site', @$edit->collection_site ?? '') == $value ? 'selected' : '' }}>
                                                {{ $value }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-3 newuserchange">
                                    <label>Component Separation Status</label>
                                    <input type="text" name="component_seperation_status"
                                        value="{{ old('component_seperation_status', @$edit->component_seperation_status ?? '') }}"
                                        class="form-control" id="component_seperation_status">
                                </div>

                                <div class="col-md-3 newuserchange">
                                    <label>Component Type</label>
                                    <input type="text" name="component_type"
                                        value="{{ old('component_type', @$edit->component_type ?? '') }}"
                                        class="form-control" id="component_type">
                                </div>
                            </div>
                        </div>
                        <div class="card-body hospital_allcardbodydesign px-5">
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-paper-plane mr-2"></i> {{ $btn }}
                            </button>
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
                                let donerData = JSON.stringify(value).replace(/"/g, '&quot;');

                                let formattedDate = value.last_donation_date ? formatDateTime(value
                                    .last_donation_date, 'date') : '';

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
            let doner = JSON.parse(data);
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

        document.addEventListener('DOMContentLoaded', function() {
            const donationInput = document.querySelector('input[name="donation_date"]');
            const lastDonationInput = document.querySelector('input[name="last_donation_date"]');

            // Trigger on input change
            donationInput.addEventListener('change', checkDateDifference);
            lastDonationInput.addEventListener('change', checkDateDifference);

            function checkDateDifference() {
                const donationDateStr = donationInput.value;
                const lastDonationDateStr = lastDonationInput.value;

                if (!donationDateStr || !lastDonationDateStr) return;

                const donationDate = new Date(donationDateStr);
                const lastDonationDate = new Date(lastDonationDateStr);

                if (isNaN(donationDate.getTime()) || isNaN(lastDonationDate.getTime())) return;

                const diffTime = donationDate - lastDonationDate;
                const diffDays = diffTime / (1000 * 60 * 60 * 24);

                if (diffDays >= 0 && diffDays <= 180) {
                    alert(
                        '⚠️ Alert: Donor has donated within the last 6 months (less than 180 days). Please review eligibility before proceeding.'
                    );
                }
            }
        });
    </script>

    <script>
        $(document).ready(function() {
            // Validation rules for each field
            function validateField($field) {
                let name = $field.attr('name');
                let val = $field.val() ? $field.val().trim() : '';
                let valid = true;

                switch (name) {
                    case 'donation_date':
                        if (!val) valid = false;
                        break;
                    case 'name':
                        if (!val || !/^[A-Za-z\s]+$/.test(val)) valid = false;
                        break;
                    case 'gender':
                        if (!val) valid = false;
                        break;
                    case 'contact_number':
                        if (!val || !/^\d{10}$/.test(val)) valid = false;
                        break;
                    case 'email':
                        // Basic email regex
                        if (!val || !/^[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,}$/.test(val)) valid = false;
                        break;
                    case 'address':
                        // Only allow spaces, commas, slashes, alphabets, and numbers
                        if (!val || !/^[A-Za-z0-9\s,\/]+$/.test(val)) valid = false;
                        break;
                    case 'state':
                        if (!val) valid = false;
                        break;
                    case 'district':
                        if (!val) valid = false;
                        break;
                    case 'bag_barcode':
                        if ($field.is(':visible') && !$field.prop('readonly') && !val) valid = false;
                        break;
                        // Add more cases as needed for additional fields
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
                    'input[name="donation_date"], ' +
                    'input[name="name"], ' +
                    'select[name="gender"], ' +
                    'input[name="contact_number"], ' +
                    'textarea[name="address"], ' +
                    'select[name="state"], ' +
                    'select[name="district"], ' +
                    'input[name="bag_barcode"]'
                );
                $fields.each(function() {
                    if (!validateField($(this))) valid = false;
                });
                return valid;
            }

            // Live validation on keyup/change for all relevant fields
            $(
                'input[name="donation_date"], ' +
                'input[name="name"], ' +
                'select[name="gender"], ' +
                'input[name="contact_number"], ' +
                'input[name="email"], ' +
                'textarea[name="address"], ' +
                'select[name="state"], ' +
                'select[name="district"], ' +
                'input[name="bag_barcode"]'
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

            // On submit, prevent submit if invalid
            $('form').on('submit', function(e) {
                if (!validateForm()) {
                    e.preventDefault();
                    // Focus first invalid field
                    let $firstInvalid = $(this).find('.border-danger:visible').first();
                    if ($firstInvalid.length) $firstInvalid.focus();
                }
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
