@extends('layouts.structure')

@push('title')
    <title>Eye Surgery Case Entry</title>
@endpush

@push('css')
@endpush

@section('main-content')
<div class="row">
    <div class="card">
        <div class="card-header d-block card_hearder_mimi">
            <div class="row">
                <div class="col-md-6 card-title card_hearder_mimi_text">
                    {{ $title ?? 'New' }} Eye Surgery Case
                </div>
            </div>
        </div>

        <div class="card-body">
            <form method="POST" id="myForm" action="{{ route('optical.update-surgery-planning', @$edit->id) }}">
                @csrf
                <div class="card-body">
                    <div class="hospital_allcardbodydesign border mt-2">
                        <h5 class="text-blue"> <i class="fa fa-user text-orange"></i> PATIENT DETAILS : </h5>
                        <div class="row">
                            <div class="col-lg-12 ">
                                <div class="main-profile-contact-list ">
                                    <div class="row">
                                        <div class="form-group col-md-1 newdesignadd45">
                                            <label for="uhid" class="form-label"> UHID </label>
                                            <input type="text" id="uhid" onkeyup="getPatient(this.value,'id')" class="text-capitalize" name="uhid" value="{{ old('uhid') }}" readonly>
                                            @error('uhid')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="form-gsroup col-md-2 newdesignadd45">
                                            <label class="form-label" for="patient_ph_no"> Mobile <span class="text-danger">*</span></label>
                                            <input type="text" id="patient_ph_no" name="phone" onkeyup="getPatient(this.value, 'phone')" maxlength="10" oninput="this.value = this.value.replace(/[^0-9]/g, '');" value="{{ old('phone') }}">
                                            @error('phone')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-1 newdesignadd45">
                                            <label>Marital Status</label>
                                            <select name="marital_status" class="form-control" id="marital_status">
                                                <option value="">Select</option>
                                                <option value="Single" {{ old('marital_status') == 'Single' ? 'selected' : '' }}> Single</option>
                                                <option value="Married" {{ old('marital_status') == 'Married' ? 'selected' : '' }}> Married</option>
                                                <option value="Widowed" {{ old('marital_status') == 'Widowed' ? 'selected' : '' }}> Widowed</option>
                                                <option value="Separated" {{ old('marital_status') == 'Separated' ? 'selected' : '' }}> Separated</option>
                                                <option value="Not Specified" {{ old('marital_status') == 'Not Specified' ? 'selected' : '' }}> Not Specified</option>
                                            </select>
                                            @error('marital_status')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-2 newdesignadd45">
                                            <label for="name" class="form-label"> Patient's name <span class="text-danger">*</span></label>
                                            <input type="text" id="name" class="text-capitalize" name="name" onkeyup="getPatient(this.value, 'name')" value="{{ old('name') }}">
                                            @error('name')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-1 newaddappon45">
                                            <label for="gender">Gender <span class="text-danger">*</span></label>
                                            <select name="gender" class="form-control" id="gender">
                                                <option value="">Select</option>
                                                <option value="Male" {{ old('gender') == 'Male' ? 'selected' : '' }}> Male</option>
                                                <option value="Female" {{ old('gender') == 'Female' ? 'selected' : '' }}> Female</option>
                                                <option value="Others" {{ old('gender') == 'Others' ? 'selected' : '' }}> Others</option>
                                            </select>
                                            @error('gender')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-lg-2 newdesignadd45">
                                            <label for="guardian_name" class="form-label"> Guardian Name</label>
                                            <input type="text" id="guardian_name" name="guardian_name" class="text-capitalize" value="{{ old('guardian_name') }}">
                                            @error('guardian_name')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-1 newaddappon45">
                                            <label class="form-label">Relation</label>
                                            <select name="relation" class="form-control select2-show-search" id="relation">
                                                <option value="">Select</option>
                                                <option value="Father" {{ old('relation') == 'Father' ? 'selected' : '' }}> Father</option>
                                                <option value="Mother" {{ old('relation') == 'Mother' ? 'selected' : '' }}> Mother</option>
                                                <option value="Son" {{ old('relation') == 'Son' ? 'selected' : '' }}> Son</option>
                                                <option value="Daughter" {{ old('relation') == 'Daughter' ? 'selected' : '' }}> Daughter</option>
                                                <option value="Relative" {{ old('relation') == 'Relative' ? 'selected' : '' }}> Relative</option>
                                                <option value="Friend" {{ old('relation') == 'Friend' ? 'selected' : '' }}> Friend</option>
                                                <option value="Husband" {{ old('relation') == 'Husband' ? 'selected' : '' }}> Husband</option>
                                                <option value="Wife" {{ old('relation') == 'Wife' ? 'selected' : '' }}> Wife</option>
                                                <option value="Guardian" {{ old('relation') == 'Guardian' ? 'selected' : '' }}> Guardian</option>
                                                <option value="Daughter-in-law" {{ old('relation') == 'Daughter-in-law' ? 'selected' : '' }}> Daughter-in-law</option>
                                                <option value="Son-in-law" {{ old('relation') == 'Son-in-law' ? 'selected' : '' }}> Son-in-law</option>
                                                <option value="Neighbour" {{ old('relation') == 'Neighbour' ? 'selected' : '' }}> Neighbour</option>
                                                <option value="Nephew" {{ old('relation') == 'Nephew' ? 'selected' : '' }}> Nephew</option>
                                                <option value="Niece" {{ old('relation') == 'Niece' ? 'selected' : '' }}> Niece</option>
                                                <option value="Grand Mother" {{ old('relation') == 'Grand Mother' ? 'selected' : '' }}> Grand Mother</option>
                                                <option value="Grand Father" {{ old('relation') == 'Grand Father' ? 'selected' : '' }}> Grand Father</option>
                                                <option value="Teacher" {{ old('relation') == 'Teacher' ? 'selected' : '' }}> Teacher</option>
                                                <option value="Mother-in-law" {{ old('relation') == 'Mother-in-law' ? 'selected' : '' }}> Mother-in-law</option>
                                                <option value="Father-in-law" {{ old('relation') == 'Father-in-law' ? 'selected' : '' }}> Father-in-law</option>
                                                <option value="Brother" {{ old('relation') == 'Brother' ? 'selected' : '' }}> Brother</option>
                                                <option value="Sister" {{ old('relation') == 'Sister' ? 'selected' : '' }}> Sister</option>
                                                <option value="Cousin" {{ old('relation') == 'Cousin' ? 'selected' : '' }}> Cousin</option>
                                                <option value="Grand Daughter" {{ old('relation') == 'Grand Daughter' ? 'selected' : '' }}> Grand Daughter</option>
                                                <option value="Grand Son" {{ old('relation') == 'Grand Son' ? 'selected' : '' }}> Grand Son</option>
                                            </select>
                                            @error('relation')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="form-gsroup col-md-2 newdesignadd45 ">
                                            <label class="form-label"> Alternative Number </label>
                                            <input type="text" name="guardian_contact_no" id="guardian_contact_no" class="form-control" maxlength="10" oninput="this.value = this.value.replace(/[^0-9]/g, '');" value="{{ old('guardian_contact_no') }}">
                                            @error('guardian_contact_no')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="card-body hospital_allcardbodydesign border mt-2" style="display:none;" id="search_result">
                                        <div class="table-responsive">
                                            <table class="table table-hover card-table table-vcenter text-nowrap border-left border-right border-bottom">
                                                <thead class="bg-primary text-white">
                                                    <tr class="border-left">
                                                        <th class="text-white">UHID</th>
                                                        <th class="text-white">Patient Name</th>
                                                        <th class="text-white">Age</th>
                                                        <th class="text-white">Phone</th>
                                                        <th class="text-white">Address</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="search_result_row"></tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-1 newdesignadd45">
                                            <label class="form-label" for="date_of_birth_year"> DOB</label>
                                            <input type="text" class="form-control datePickr" id="date_of_birth" name="date_of_birth" onchange="getagefromdate(this.value)" value="{{ old('date_of_birth') }}">
                                            @error('date_of_birth')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-lg-1 newdesignadd45">
                                            <label class="form-label" for="date_of_birth_year"> Year</label>
                                            <input type="text" id="date_of_birth_year" name="date_of_birth_year" onkeyup="getage()" value="{{ old('date_of_birth_year') }}">
                                            @error('date_of_birth_year')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="col-lg-1 newdesignadd45">
                                            <label class="form-label" for="date_of_birth_month"> Month</label>
                                            <input type="text" id="date_of_birth_month" name="date_of_birth_month" onkeyup="getage()" value="{{ old('date_of_birth_month') }}">
                                            @error('date_of_birth_month')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-lg-1 newdesignadd45">
                                            <label class="form-label" for="date_of_birth_day"> Day</label>
                                            <input type="text" id="date_of_birth_day" name="date_of_birth_day" onkeyup="getage()" value="{{ old('date_of_birth_day') }}">
                                            @error('date_of_birth_day')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="form-group col-md-2 newdesignadd45">
                                            <label class="form-label" for="address">Address <span class="text-danger">*</span></label>
                                            <input type="text" id="address" name="address" value="{{ old('address') }}">
                                            @error('address')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="form-group col-md-2 newaddappon45">
                                            <label class="form-label" for="state">State <span class="text-danger">*</span></label>
                                            <select name="state" class="form-control select2-show-search" onchange="getDistrict(this.value)" id="state">
                                                <option value="">Select State</option>
                                                @foreach ($states as $s)
                                                    <option value="{{$s->id}}" {{ old('state', 35) == $s->id ? 'selected' : '' }}>{{$s->name}}</option>
                                                @endforeach
                                            </select>
                                            @error('state')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="form-group col-md-1 newaddappon45">
                                            <label class="form-label" for="district">District</label>
                                            <select name="district" class="form-control select2-show-search" id="district">
                                                <option value="">Select District</option>
                                            </select>
                                            @error('district')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="form-group col-md-1 newdesignadd45">
                                            <label class="form-label" for="pin_code">Pin Code</label>
                                            <input type="text" id="pin_code" name="pin_code" value="{{ old('pin_code') }}">
                                            @error('pin_code')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="form-group col-md-2 newdesignadd45">
                                            <label class="form-label" for="aadhar_card_no">Aadhar Number</label>
                                            <input type="text" id="aadhar_card_no" name="aadhar_card_no" value="{{ old('aadhar_card_no') }}">
                                            @error('aadhar_card_no')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="hospital_allcardbodydesign border mt-2">
                        <h5 class="text-blue"> <i class="fa fa-user text-orange"></i> SURGERY DETAILS : </h5>
                        <div class="row">
                            <div class="form-group col-md-2">
                                <label>Planning Date <span class="text-danger">*</span></label>
                                <input type="text" name="planning_date" class="form-control datePickr" value="{{ old('planning_dtae') }}" required>
                                @error('planning_date')<small class="text-danger">{{$message}}</small>@enderror
                            </div>
                            <div class="form-group col-md-2">
                                <label for="department">Department</label>
                                <select name="department" class="form-control select2-show-search" onchange="getDoctor(this.value)" id="department">
                                    <option value="">All</option>
                                    @foreach ($department as $dept)
                                    <option value="{{$dept->id}}" {{ old('department', $user ? $user->department_id : '') == $dept->id ? 'selected' : '' }}>
                                        {{$dept->department_name}}
                                    </option>
                                    @endforeach
                                </select>
                                @error('department')<small class="text-danger">{{$message}}</small>@enderror
                            </div>
                            <div class="form-group col-md-2">
                                <label>Doctor <span class="text-danger">*</span></label>
                                <select name="doctor" class="form-control select2-show-search" id="doctor" required>
                                    <option value="">Select</option>
                                    @foreach ($doctor as $doc)
                                        <option value="{{$doc->id}}" {{ old('doctor') == $doc->id ? 'selected' : '' }}>Dr. {{$doc->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-2">
                                <label>Eye <span class="text-danger">*</span></label>
                                <select name="eye" class="form-control" required>
                                    <option value="">Select</option>
                                    <option value="left" {{ old('eye') == 'left' ? 'selected' : '' }}>Left</option>
                                    <option value="right" {{ old('eye') == 'right' ? 'selected' : '' }}>Right</option>
                                    <option value="both" {{ old('eye') == 'both' ? 'selected' : '' }}>Both</option>
                                </select>
                            </div>

                            <div class="form-group col-md-2">
                                <label>Surgery Type <span class="text-danger">*</span></label>
                                <select name="surgery_type" class="form-control select2-show-search" required>
                                    <option value="">Select</option>
                                    <option value="Cataract" {{ old('surgery_type') == 'Cataract' ? 'selected' : '' }}>Cataract</option>
                                    <option value="LASIK" {{ old('surgery_type') == 'LASIK' ? 'selected' : '' }}>LASIK</option>
                                    <option value="Retinal" {{ old('surgery_type') == 'Retinal' ? 'selected' : '' }}>Retinal</option>
                                    <option value="Glaucoma" {{ old('surgery_type') == 'Glaucoma' ? 'selected' : '' }}>Glaucoma</option>
                                    <option value="Other" {{ old('surgery_type') == 'Other' ? 'selected' : '' }}>Other</option>
                                </select>
                            </div>

                            <div class="form-group col-md-2">
                                <label>Diagnosis <span class="text-danger">*</span></label>
                                <input type="text" name="diagnosis" class="form-control"
                                    value="{{ old('diagnosis') }}" required>
                            </div>

                            <div class="form-group col-md-2">
                                <label>Priority <span class="text-danger">*</span></label>
                                <select name="priority" class="form-control" required>
                                    <option value="">Select</option>
                                    <option value="elective" {{ old('priority') == 'elective' ? 'selected' : '' }}>Elective</option>
                                    <option value="urgent" {{ old('priority') == 'urgent' ? 'selected' : '' }}>Urgent</option>
                                </select>
                            </div>

                            <div class="form-group col-md-2">
                                <label>Status <span class="text-danger">*</span></label>
                                <select name="status" class="form-control" required>
                                    <option value="planned">Planned</option>
                                    <option value="scheduled" disabled>Scheduled</option>
                                    <option value="completed" disabled>Completed</option>
                                    <option value="cancelled" disabled>Cancelled</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="text-center mb-4">
                    <button class="btn btn-primary btn-sm submitBtn" type="submit"
                        name="submit" value="new"><i class="fa fa-file text-success"></i>
                        Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@push('js')
<script>
    getDistrict(35);
    function getPatient(val, col) {
        var div_data = '';
        $('#search_result').attr('style', 'display:none', true);
        $('#search_result_row').html('');
        if (val && col) {
            $.ajax({
                url: "{{ route('opd.get-patients') }}",
                type: "POST",
                data: {
                    _token: '{{ csrf_token() }}',
                    field: col,
                    value: val,
                },
                success: function(response) {
                    if (response.success && (response.patients.length > 0)) {
                        $('#search_result').removeAttr('style', true);
                        $.each(response.patients, function(key, value) {
                            let patientData = encodeURIComponent(JSON.stringify(value));
                            div_data += `<tr class="color_hover_charnge" onclick="selectPatient('${patientData}')" style="cursor: pointer !important;">
                            <td>${value.uhid || value.id}</td>
                            <td>${value.name}</td>
                            <td>${value.dob_year || 0}Y ${value.dob_month || 0}M ${value.dob_day || 0}D</td>
                            <td>${value.phone}</td>
                            <td>${value.address}</td>
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
    function selectPatient(data) {
        let patient = JSON.parse(decodeURIComponent(data));
        $('#uhid').val(patient.id);
        $('#name').val(patient.name);
        $('#patient_ph_no').val(patient.phone);
        $('#guardian_name').val(patient.guardian_name);
        $('#relation').val(patient.guardian_realation).trigger('change');
        $('#marital_status').val(patient.marital_status).trigger('change');
        $('#guardian_contact_no').val(patient.guardian_contact_no);
        $('#gender').val(patient.gender).trigger('change');
        if(patient.date_of_birth){
            let dateObj = new Date(patient.date_of_birth);
            let formattedDOB = dateObj.getDate().toString().padStart(2, '0') + '-' +
                            (dateObj.getMonth() + 1).toString().padStart(2, '0') + '-' +
                            dateObj.getFullYear();
            $('#date_of_birth').val(formattedDOB).trigger('change');
            getagefromdate(formattedDOB);
        }else{
            if(patient.dob_day || patient.dob_month || patient.dob_year){
                $('#date_of_birth_day').val(patient.dob_day);
                $('#date_of_birth_month').val(patient.dob_month);
                $('#date_of_birth_year').val(patient.dob_year);
                getage();
            }
        }
        $('#address').val(patient.address);
        getDistrict(patient.state,patient.district);
        $('#pin_code').val(patient.pin_code);
        $('#aadhar_card_no').val(patient.identification_number);
        $('#search_result_row').html('');
        $('#search_result').attr('style', 'display:none', true);
    }
    function getDistrict(state_id, district_id = 0) {
        if (state_id) {
            $('#district').html('<option vaule="">Select District</option>');
            $.ajax({
                url: "{{ Route('get-district') }}",
                type: "POST",
                data: {
                    _token: '{{ csrf_token() }}',
                    state_id: state_id,
                },
                success: function(response) {
                    if (response.success && (response.districts.length > 0)) {
                        $.each(response.districts, function(key, value) {
                            if(district_id == value.id){
                                $('#district').append(`<option value="${value.id}" selected>${value.name}</option>`);
                            }else{
                                $('#district').append(`<option value="${value.id}">${value.name}</option>`);
                            }
                        });
                    }
                },
                error: function(error) {
                    console.log(error);
                }
            });
        }
    }
    function getage() {
        var year = $('#date_of_birth_year').val();
        var month = $('#date_of_birth_month').val();
        var days = $('#date_of_birth_day').val();
        var currentDate = new Date();
        var date = new Date(currentDate.getFullYear() - year,
        currentDate.getMonth() - month,
        currentDate.getDate() - days);
        var yyyy = date.getFullYear().toString();
        var mm = (date.getMonth() + 1).toString().padStart(2, '0');
        var dd = date.getDate().toString().padStart(2, '0');
        var formattedDate = dd + '-' + mm + '-' + yyyy;
        $('#date_of_birth').val(formattedDate);
    }
    function getagefromdate(dob_date) {
        const nw = new Date();
        const dateArray = dob_date.split("-").map(Number);

        let nw_year = nw.getFullYear();
        let nw_month = nw.getMonth() + 1;
        let nw_day = nw.getDate();

        let dob_year = dateArray[2];
        let dob_month = dateArray[1];
        let dob_day = dateArray[0];

        let dob_in_date = ((parseInt(dob_year) * parseInt(365)) + (parseInt(dob_month) * parseInt(30)) + parseInt(dob_day));
        let now_in_date = ((parseInt(nw_year) * parseInt(365)) + (parseInt(nw_month) * parseInt(30)) + parseInt(nw_day));

        if (now_in_date >= dob_in_date) {
            let diffe_date = parseInt(parseInt(now_in_date) - parseInt(dob_in_date));

            let year = parseInt(diffe_date / 365);
            let remnder = diffe_date % 365;

            let month = parseInt(remnder / 30);
            let days = remnder % 30;

            $('#date_of_birth_year').val(year);
            $('#date_of_birth_month').val(month);
            $('#date_of_birth_day').val(days);
        } else {
            alert('Enter a Valid Date');
            $('#date_of_birth').reset();
        }
    }
    function getDoctor(department_id) {
        if (department_id) {
            $('#doctor').html('<option vaule="">Select Doctor</option>');
            $.ajax({
                url: "{{Route('opd.get-doctors')}}",
                type: "POST",
                data: {
                    _token: '{{ csrf_token() }}',
                    dept_id: department_id,
                },
                success: function(response) {
                    if (response.success && (response.doctors.length > 0)) {
                        $.each(response.doctors, function(key, value) {
                            $('#doctor').append(`<option value="${value.id}">${value.salutation} ${value.name}</option>`);
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
