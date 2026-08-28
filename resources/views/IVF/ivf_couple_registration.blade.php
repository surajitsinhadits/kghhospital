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
                    <form method="POST" action="{{ route('ivf.couple-registration-save') }}" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="id" value="{{ @$edit->id ?? '' }}">
                        <div class="card-body hospital_allcardbodydesign px-5">
                            <h5 class="font-weight-bold"><i class="fas fa-user"></i> Male Couple</h5>
                            <input type="hidden" name="male_patient_id" id="male_patient_id"
                                value="{{ old('male_patient_id', @$edit->male_patient_id ?? '') }}">
                            <div class="row">
                                <div class="col-md-2 newuserchange">
                                    <label>Patient Name <span class="text-danger">*</span></label>
                                    <input type="text" name="male_name" id="male_name" class="form-control"
                                        value="{{ old('male_name', @$edit->male_name ?? '') }}" autocomplete="off"
                                        onkeyup="getMaleDoner(this.value)">
                                    @error('male_name')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-2 newuserchange">
                                    <label>Gender <span class="text-danger">*</span></label>
                                    <select name="male_gender" class="form-control" id="male_gender">
                                        <option value="">Select</option>
                                        @foreach (['Male', 'Female', 'Other'] as $gender)
                                            <option value="{{ $gender }}"
                                                {{ old('male_gender', @$edit->male_gender ?? '') == $gender ? 'selected' : '' }}>
                                                {{ $gender }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('male_gender')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-2 newuserchange">
                                    <label>Contact No <span class="text-danger">*</span></label>
                                    <input type="text" name="male_contact_number"
                                        value="{{ old('male_contact_number', $edit->male_contact_number ?? '') }}"
                                        class="form-control" id="male_contact_number" maxlength="10">
                                    @error('male_contact_number')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-2 newuserchange">
                                    <label>Date Of Birth</label>
                                    <input type="text" name="male_dob" class="form-control datePickr" id="male_dob"
                                        value="{{ old('male_dob', dateFor(@$edit->male_dob) ?? '') }}">
                                </div>

                                <div class="col-md-2 newuserchange">
                                    <label>Email</label>
                                    <input type="email" name="male_email" class="form-control" id="male_email"
                                        value="{{ old('male_email', $edit->male_email ?? '') }}">
                                </div>

                                <div class="col-md-12">
                                    <div class="card-body hospital_allcardbodydesign" style="display:none"
                                        id="male_search_result">
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
                                                <tbody id="male_search_result_row"></tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-2 newuserchange">
                                    <label>Address <span class="text-danger">*</span></label>
                                    <textarea name="male_address" rows="1" class="form-control" id="male_address">{{ old('male_address', $edit->male_address ?? '') }}</textarea>
                                    @error('male_address')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-2 newuserchange">
                                    <label for="male_state">State <span class="text-danger">*</span></label>
                                    <select name="male_state" class="form-control" onchange="getMaleDistrict(this.value)"
                                        id="male_state" tabindex="9">
                                        <option value="">Select State</option>
                                        @foreach ($states as $s)
                                            <option value="{{ $s->id }}"
                                                {{ old('male_state', $edit->male_state ?? '') == $s->id ? 'selected' : '' }}>
                                                {{ $s->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('male_state')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-2 newuserchange">
                                    <label for="male_district">District <span class="text-danger">*</span></label>
                                    <select name="male_district" class="form-control" id="male_district">
                                        <option value="">Select District</option>
                                    </select>
                                    @error('male_district')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-2 newuserchange">
                                    <label for="male_pin_code">Pin No.</label>
                                    <input type="text" id="male_pin_code" name="male_pin_code"
                                        value="{{ old('male_pin_code', $edit->male_pin_code ?? '') }}"
                                        class="form-control" tabindex="11">
                                </div>
                            </div>
                        </div>

                        <div class="card-body hospital_allcardbodydesign px-5">
                            <h5 class="font-weight-bold"><i class="fas fa-user"></i> Female Couple</h5>
                            <input type="hidden" name="female_patient_id" id="female_patient_id"
                                value="{{ old('female_patient_id', @$edit->female_patient_id ?? '') }}">
                            <div class="row">
                                <div class="col-md-2 newuserchange">
                                    <label>Patient Name <span class="text-danger">*</span></label>
                                    <input type="text" name="female_name" id="female_name" class="form-control"
                                        value="{{ old('female_name', @$edit->female_name ?? '') }}" autocomplete="off"
                                        onkeyup="getFemaleDoner(this.value)">
                                    @error('female_name')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-2 newuserchange">
                                    <label>Gender <span class="text-danger">*</span></label>
                                    <select name="female_gender" class="form-control" id="female_gender">
                                        <option value="">Select</option>
                                        @foreach (['Male', 'Female', 'Other'] as $gender)
                                            <option value="{{ $gender }}"
                                                {{ old('female_gender', @$edit->female_gender ?? '') == $gender ? 'selected' : '' }}>
                                                {{ $gender }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('female_gender')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-2 newuserchange">
                                    <label>Contact No <span class="text-danger">*</span></label>
                                    <input type="text" name="female_contact_number"
                                        value="{{ old('female_contact_number', $edit->female_contact_number ?? '') }}"
                                        class="form-control" id="female_contact_number" maxlength="10">
                                    @error('female_contact_number')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-2 newuserchange">
                                    <label>Date Of Birth</label>
                                    <input type="text" name="female_dob" class="form-control datePickr"
                                        id="female_dob"
                                        value="{{ old('female_dob', dateFor(@$edit->female_dob) ?? '') }}">
                                </div>

                                <div class="col-md-2 newuserchange">
                                    <label>Email</label>
                                    <input type="email" name="female_email" class="form-control" id="female_email"
                                        value="{{ old('female_email', $edit->female_email ?? '') }}">
                                </div>

                                <div class="col-md-12">
                                    <div class="card-body hospital_allcardbodydesign" style="display:none"
                                        id="female_search_result">
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
                                                <tbody id="female_search_result_row"></tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-2 newuserchange">
                                    <label>Address <span class="text-danger">*</span></label>
                                    <textarea name="female_address" rows="1" class="form-control" id="female_address">{{ old('female_address', $edit->female_address ?? '') }}</textarea>
                                    @error('female_address')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-2 newuserchange">
                                    <label for="female_state">State <span class="text-danger">*</span></label>
                                    <select name="female_state" class="form-control"
                                        onchange="getFemaleDistrict(this.value)" id="female_state" tabindex="9">
                                        <option value="">Select State</option>
                                        @foreach ($states as $s)
                                            <option value="{{ $s->id }}"
                                                {{ old('female_state', $edit->female_state ?? '') == $s->id ? 'selected' : '' }}>
                                                {{ $s->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('female_state')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-2 newuserchange">
                                    <label for="female_district">District <span class="text-danger">*</span></label>
                                    <select name="female_district" class="form-control" id="female_district">
                                        <option value="">Select District</option>
                                    </select>
                                    @error('female_district')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-2 newuserchange">
                                    <label for="female_pin_code">Pin No.</label>
                                    <input type="text" id="female_pin_code" name="female_pin_code"
                                        value="{{ old('female_pin_code', $edit->female_pin_code ?? '') }}"
                                        class="form-control" tabindex="11">
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
        function getMaleDoner(val) {
            var div_data = '';
            $('#male_search_result').attr('style', 'display:none', true);
            $('#male_search_result_row').html('');
            if (val) {
                $.ajax({
                    url: "{{ route('ivf.male-doner') }}",
                    type: "POST",
                    data: {
                        _token: '{{ csrf_token() }}',
                        field: 'name',
                        value: val,
                    },
                    success: function(response) {
                        if (response.success && (response.data.length > 0)) {
                            $('#male_search_result').removeAttr('style', true);
                            $.each(response.data, function(key, value) {
                                let donerData = JSON.stringify(value).replace(/"/g, '&quot;');
                                div_data += `<tr class="color_hover_charnge" onclick="selectMaleDoner('${donerData}')" style="cursor: pointer !important;">
                                    <td>${value.name}</td>
                                    <td>${value.phone}</td>
                                    <td>${value.gender}</td>
                                    <td>${value.date_of_birth ? formatDateTime(value.date_of_birth,'date') : ''}</td>
                                    <td>${value.blood_group ?? ''}</td>
                                    <td>${value.gov_id ?? ''}</td>
                                    <td>${value.last_donation_date ?? ''}</td>
                                    <td>${value.address ?? ''}</td>
                                </tr>`;
                            });
                            $('#male_search_result_row').html(div_data);
                        }
                    },
                    error: function(error) {
                        console.log(error);
                    }
                });
            }
        }

        function selectMaleDoner(data) {
            let doner = JSON.parse(data);
            $('#male_name').val(doner.name);
            $('#male_gender').val(doner.gender).trigger('change');
            $('#male_contact_number').val(doner.phone);
            $('#male_dob').val(doner.date_of_birth ? formatDateTime(doner.date_of_birth, 'date') : '');
            $('#male_email').val(doner.email);
            $('#male_address').val(doner.address);
            $('#male_state').val(doner.state).trigger('change');
            getMaleDistrict(doner.state, doner.district);
            $('#male_pin_code').val(doner.pin_code);
            $('#male_patient_id').val(doner.id);

            $('#male_search_result_row').html('');
            $('#male_search_result').attr('style', 'display:none', true);
        }

        function getMaleDistrict(state_id, dist_id = 0) {
            if (state_id) {
                $('#male_district').html('<option value="">Select District</option>');
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
                                $('#male_district').append(
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

        function getFemaleDoner(val) {
            var div_data = '';
            $('#female_search_result').attr('style', 'display:none', true);
            $('#female_search_result_row').html('');
            if (val) {
                $.ajax({
                    url: "{{ route('ivf.female-doner') }}",
                    type: "POST",
                    data: {
                        _token: '{{ csrf_token() }}',
                        field: 'name',
                        value: val,
                    },
                    success: function(response) {
                        if (response.success && (response.data.length > 0)) {
                            $('#female_search_result').removeAttr('style', true);
                            $.each(response.data, function(key, value) {
                                let donerData = JSON.stringify(value).replace(/"/g, '&quot;');
                                div_data += `<tr class="color_hover_charnge" onclick="selectFemaleDoner('${donerData}')" style="cursor: pointer !important;">
                                    <td>${value.name}</td>
                                    <td>${value.phone}</td>
                                    <td>${value.gender}</td>
                                    <td>${value.date_of_birth ? formatDateTime(value.date_of_birth,'date') : ''}</td>
                                    <td>${value.blood_group ?? ''}</td>
                                    <td>${value.gov_id ?? ''}</td>
                                    <td>${value.last_donation_date ?? ''}</td>
                                    <td>${value.address ?? ''}</td>
                                </tr>`;
                            });
                            $('#female_search_result_row').html(div_data);
                        }
                    },
                    error: function(error) {
                        console.log(error);
                    }
                });
            }
        }

        function selectFemaleDoner(data) {
            let doner = JSON.parse(data);
            $('#female_name').val(doner.name);
            $('#female_gender').val(doner.gender).trigger('change');
            $('#female_contact_number').val(doner.phone);
            $('#female_dob').val(doner.date_of_birth ? formatDateTime(doner.date_of_birth, 'date') : '');
            $('#female_email').val(doner.email);
            $('#female_address').val(doner.address);
            $('#female_state').val(doner.state).trigger('change');
            getFemaleDistrict(doner.state, doner.district);
            $('#female_pin_code').val(doner.pin_code);
            $('#female_patient_id').val(doner.id);

            $('#female_search_result_row').html('');
            $('#female_search_result').attr('style', 'display:none', true);
        }

        function getFemaleDistrict(state_id, dist_id = 0) {
            if (state_id) {
                $('#female_district').html('<option value="">Select District</option>');
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
                                $('#female_district').append(
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
            let selectedMaleState = $('#male_state').val();
            let selectedMaleDistrict = "{{ old('male_district', @$edit->male_district) }}";
            if (selectedMaleState) {
                getMaleDistrict(selectedMaleState, selectedMaleDistrict);
            }

            let selectedFemaleState = $('#female_state').val();
            let selectedFemaleDistrict = "{{ old('female_district', @$edit->female_district) }}";
            if (selectedFemaleState) {
                getFemaleDistrict(selectedFemaleState, selectedFemaleDistrict);
            }
        });
    </script>
@endpush
