@extends('layouts.structure')
@push('title')
    <title>Edit IPD Admission</title>
@endpush
@push('css')
@endpush
@section('main-content')
<div class="row">
    <div class="card ">
        <div class="card-body">
            <div class="row">
                <div class="col-md-3 leftside_fixarea">
                    <x-billbar section="ipd" id="{{$info->id}}" type="sec" />
                </div>
                <div class="col-md-9 rightside_fixarea" style="border:2px solid black">
                    <form action="{{route('ipd.update-admission',$info->id)}}" id="yourFormId" method="POST">
                        @csrf
                        <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="hospital_allcardbodydesign border">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="main-profile-contact-list ">
                                                    <div class="row mt-2">
                                                        <div class="col-md-2">
                                                            <label class="form-label">
                                                                Admission Type <span class="text-danger">*</span>
                                                            </label>

                                                            <select
                                                                name="admission_type"
                                                                id="admission_type"
                                                                class="form-control"
                                                                {{ !empty($isBillExists) && $isBillExists ? 'disabled' : '' }}
                                                            >
                                                                <option value="">Select</option>
                                                                <option value="IPD" {{ ($info->admission_type ?? '') == 'IPD' ? 'selected' : '' }}>
                                                                    IPD Admission
                                                                </option>
                                                                <option value="DAYCARE" {{ ($info->admission_type ?? '') == 'DAYCARE' ? 'selected' : '' }}>
                                                                    Day-Care Admission
                                                                </option>
                                                            </select>

                                                            {{-- ✅ disabled select will not submit, so keep the value with a hidden input --}}
                                                            @if(!empty($isBillExists) && $isBillExists)
                                                                <input type="hidden" name="admission_type" value="{{ $info->admission_type }}">
                                                            @endif

                                                            @error('admission_type')
                                                                <span class="text-danger">{{ $message }}</span>
                                                            @enderror
                                                        </div>

                                                        <div class="col-md-2">
                                                            <label class="form-label">Admission Date & time <span class="text-danger">*</span></label>
                                                            <input type="text" class="form-control dateTimePickr" id="admission_date" name="admission_date" value="{{ dateFor($info->admission_date, true) }}">
                                                            @error('admission_date')
                                                            <span class="text-danger">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                        <div class="col-md-2">
                                                            <label class="form-label" for="package_type">Package Type <span class="text-danger">*</span></label>
                                                            <select id="patient_package_type" class="form-control" name="patient_package_type">
                                                                <option value="">Select</option>
                                                                <option value="Package with medicine" {{ $info->package_type == 'Package with medicine' ? 'selected' : '' }}>Package with medicine</option>
                                                                <option value="Package without medicine" {{ $info->package_type == 'Package without medicine' ? 'selected' : '' }}>Package without medicine</option>
                                                                <option value="Conservative Medicine" {{ $info->package_type == 'Conservative Medicine' ? 'selected' : '' }}>Conservative Medicine</option>
                                                                <option value="Dialysis" {{ $info->package_type == 'Dialysis' ? 'selected' : '' }}>Dialysis</option>
                                                            </select>
                                                            @error('patient_package_type')
                                                            <span class="text-danger">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                        <div class="col-md-3">
                                                            <label class="form-label">Insurance Type <span class="text-danger">*</span></label>
                                                            <select id="insurance_type" name="insurance_type" class="form-group select2-show-search">
                                                                <option value="">Select</option>
                                                                @foreach ($tpa as $type)
                                                                <option value="{{$type->id}}" {{ $info->insurance_id == $type->id ? 'selected' : '' }}>{{$type->tpa_name}}</option>
                                                                @endforeach
                                                            </select>
                                                            @error('insurance_type')
                                                            <span class="text-danger">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                        <div class="col-md-3">
                                                            <label class="form-label">Insurance No.</label>
                                                            <input type="text" class="form-control" id="insurance_no" name="insurance_no" value="{{ $info->insurance_no }}">
                                                            @error('insurance_no')
                                                            <span class="text-danger">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="hospital_allcardbodydesign border mt-2">
                                        <h5 class="text-blue"> <i class="fa fa-user text-orange"></i> PATIENT DETAILS : </h5>
                                        <div class="row">
                                            <div class="col-lg-12 ">
                                                <div class="main-profile-contact-list ">
                                                    <div class="row">
                                                        <div class="form-group col-md-1 newdesignadd45">
                                                            <label for="uhid" class="form-label"> UHID </label>
                                                            <input type="text" id="uhid" onkeyup="getPatient(this.value,'id')" class="text-capitalize" name="uhid" value="{{ $info->patient_id }}">
                                                            @error('uhid')
                                                                <span class="text-danger">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                        <div class="form-gsroup col-md-2 newdesignadd45">
                                                            <label class="form-label" for="patient_ph_no"> Mobile <span class="text-danger">*</span></label>
                                                            <input type="text" id="patient_ph_no" name="phone" onkeyup="getPatient(this.value, 'phone')" maxlength="10" oninput="this.value = this.value.replace(/[^0-9]/g, '');" value="{{ $info->patient_info->phone }}">
                                                            @error('phone')
                                                                <span class="text-danger">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                        <div class="form-group col-md-1 newdesignadd45">
                                                            <label>Marital Status</label>
                                                            <select name="marital_status" class="form-control" id="marital_status">
                                                                <option value="">Select</option>
                                                                <option value="Single" {{ $info->patient_info->marital_status == 'Single' ? 'selected' : '' }}> Single</option>
                                                                <option value="Married" {{ $info->patient_info->marital_status == 'Married' ? 'selected' : '' }}> Married</option>
                                                                <option value="Widowed" {{ $info->patient_info->marital_status == 'Widowed' ? 'selected' : '' }}> Widowed</option>
                                                                <option value="Separated" {{ $info->patient_info->marital_status == 'Separated' ? 'selected' : '' }}> Separated</option>
                                                                <option value="Not Specified" {{ $info->patient_info->marital_status == 'Not Specified' ? 'selected' : '' }}> Not Specified</option>
                                                            </select>
                                                            @error('marital_status')
                                                                <span class="text-danger">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                        <div class="form-group col-md-2 newdesignadd45">
                                                            <label for="name" class="form-label"> Patient's name <span class="text-danger">*</span></label>
                                                            <input type="text" id="name" class="text-capitalize" name="name" onkeyup="getPatient(this.value, 'name')" value="{{ $info->patient_info->name }}">
                                                            @error('name')
                                                                <span class="text-danger">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                        <div class="form-group col-md-1 newaddappon45">
                                                            <label for="gender">Gender <span class="text-danger">*</span></label>
                                                            <select name="gender" class="form-control" id="gender">
                                                                <option value="">Select</option>
                                                                <option value="Male" {{ $info->patient_info->gender == 'Male' ? 'selected' : '' }}> Male</option>
                                                                <option value="Female" {{ $info->patient_info->gender == 'Female' ? 'selected' : '' }}> Female</option>
                                                                <option value="Others" {{ $info->patient_info->gender == 'Others' ? 'selected' : '' }}> Others</option>
                                                            </select>
                                                            @error('gender')
                                                                <span class="text-danger">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                        <div class="col-lg-2 newdesignadd45">
                                                            <label for="guardian_name" class="form-label"> Guardian Name <span class="text-danger">*</span></label>
                                                            <input type="text" id="guardian_name" name="guardian_name" class="text-capitalize" value="{{ $info->patient_info->guardian_name }}">
                                                            @error('guardian_name')
                                                                <span class="text-danger">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                        <div class="form-group col-md-1 newaddappon45">
                                                            <label class="form-label">Relation <span class="text-danger">*</span></label>
                                                            <select name="relation" class="form-control select2-show-search" id="relation">
                                                                <option value="">Select</option>
                                                                <option value="Father" {{ $info->patient_info->guardian_realation == 'Father' ? 'selected' : '' }}> Father</option>
                                                                <option value="Mother" {{ $info->patient_info->guardian_realation == 'Mother' ? 'selected' : '' }}> Mother</option>
                                                                <option value="Son" {{ $info->patient_info->guardian_realation == 'Son' ? 'selected' : '' }}> Son</option>
                                                                <option value="Daughter" {{ $info->patient_info->guardian_realation == 'Daughter' ? 'selected' : '' }}> Daughter</option>
                                                                <option value="Relative" {{ $info->patient_info->guardian_realation == 'Relative' ? 'selected' : '' }}> Relative</option>
                                                                <option value="Friend" {{ $info->patient_info->guardian_realation == 'Friend' ? 'selected' : '' }}> Friend</option>
                                                                <option value="Husband" {{ $info->patient_info->guardian_realation == 'Husband' ? 'selected' : '' }}> Husband</option>
                                                                <option value="Wife" {{ $info->patient_info->guardian_realation == 'Wife' ? 'selected' : '' }}> Wife</option>
                                                                <option value="Guardian" {{ $info->patient_info->guardian_realation == 'Guardian' ? 'selected' : '' }}> Guardian</option>
                                                                <option value="Daughter-in-law" {{ $info->patient_info->guardian_realation == 'Daughter-in-law' ? 'selected' : '' }}> Daughter-in-law</option>
                                                                <option value="Son-in-law" {{ $info->patient_info->guardian_realation == 'Son-in-law' ? 'selected' : '' }}> Son-in-law</option>
                                                                <option value="Neighbour" {{ $info->patient_info->guardian_realation == 'Neighbour' ? 'selected' : '' }}> Neighbour</option>
                                                                <option value="Nephew" {{ $info->patient_info->guardian_realation == 'Nephew' ? 'selected' : '' }}> Nephew</option>
                                                                <option value="Niece" {{ $info->patient_info->guardian_realation == 'Niece' ? 'selected' : '' }}> Niece</option>
                                                                <option value="Grand Mother" {{ $info->patient_info->guardian_realation == 'Grand Mother' ? 'selected' : '' }}> Grand Mother</option>
                                                                <option value="Grand Father" {{ $info->patient_info->guardian_realation == 'Grand Father' ? 'selected' : '' }}> Grand Father</option>
                                                                <option value="Teacher" {{ $info->patient_info->guardian_realation == 'Teacher' ? 'selected' : '' }}> Teacher</option>
                                                                <option value="Mother-in-law" {{ $info->patient_info->guardian_realation == 'Mother-in-law' ? 'selected' : '' }}> Mother-in-law</option>
                                                                <option value="Father-in-law" {{ $info->patient_info->guardian_realation == 'Father-in-law' ? 'selected' : '' }}> Father-in-law</option>
                                                                <option value="Brother" {{ $info->patient_info->guardian_realation == 'Brother' ? 'selected' : '' }}> Brother</option>
                                                                <option value="Sister" {{ $info->patient_info->guardian_realation == 'Sister' ? 'selected' : '' }}> Sister</option>
                                                                <option value="Cousin" {{ $info->patient_info->guardian_realation == 'Cousin' ? 'selected' : '' }}> Cousin</option>
                                                                <option value="Grand Daughter" {{ $info->patient_info->guardian_realation == 'Grand Daughter' ? 'selected' : '' }}> Grand Daughter</option>
                                                                <option value="Grand Son" {{ $info->patient_info->guardian_realation == 'Grand Son' ? 'selected' : '' }}> Grand Son</option>
                                                            </select>
                                                            @error('relation')
                                                                <span class="text-danger">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                        <div class="form-gsroup col-md-2 newdesignadd45 ">
                                                            <label class="form-label"> Guardian Contact No </label>
                                                            <input type="text" name="guardian_contact_no" id="guardian_contact_no" class="form-control" maxlength="10" oninput="this.value = this.value.replace(/[^0-9]/g, '');" value="{{ $info->patient_info->guardian_contact_no }}">
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
                                                            <input type="text" class="form-control datePickr" id="date_of_birth" name="date_of_birth" onchange="getagefromdate(this.value)" value="{{ $info->patient_info->date_of_birth }}">
                                                            @error('date_of_birth')
                                                                <span class="text-danger">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                        <div class="col-lg-1 newdesignadd45">
                                                            <label class="form-label" for="date_of_birth_year"> Year</label>
                                                            <input type="text" id="date_of_birth_year" name="date_of_birth_year" onkeyup="getage()" value="{{ $info->patient_info->dob_year }}">
                                                            @error('date_of_birth_year')
                                                                <span class="text-danger">{{ $message }}</span>
                                                            @enderror
                                                        </div>

                                                        <div class="col-lg-1 newdesignadd45">
                                                            <label class="form-label" for="date_of_birth_month"> Month</label>
                                                            <input type="text" id="date_of_birth_month" name="date_of_birth_month" onkeyup="getage()" value="{{ $info->patient_info->dob_month }}">
                                                            @error('date_of_birth_month')
                                                                <span class="text-danger">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                        <div class="col-lg-1 newdesignadd45">
                                                            <label class="form-label" for="date_of_birth_day"> Day</label>
                                                            <input type="text" id="date_of_birth_day" name="date_of_birth_day" onkeyup="getage()" value="{{ $info->patient_info->dob_day }}">
                                                            @error('date_of_birth_day')
                                                                <span class="text-danger">{{ $message }}</span>
                                                            @enderror
                                                        </div>

                                                        <div class="form-group col-md-2 newdesignadd45">
                                                            <label class="form-label" for="address">Address <span class="text-danger">*</span></label>
                                                            <input type="text" id="address" name="address" value="{{ $info->patient_info->address }}">
                                                            @error('address')
                                                                <span class="text-danger">{{ $message }}</span>
                                                            @enderror
                                                        </div>

                                                        <div class="form-group col-md-2 newaddappon45">
                                                            <label class="form-label" for="state">State <span class="text-danger">*</span></label>
                                                            <select name="state" class="form-control select2-show-search" onchange="getDistrict(this.value, {{$info->patient_info->district}})" id="state">
                                                                <option value="">Select State</option>
                                                                @foreach ($states as $s)
                                                                    <option value="{{$s->id}}" {{ $info->patient_info->state == $s->id ? 'selected' : '' }}>{{$s->name}}</option>
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
                                                            <input type="text" id="pin_code" name="pin_code" value="{{ $info->patient_info->pin_code }}">
                                                            @error('pin_code')
                                                                <span class="text-danger">{{ $message }}</span>
                                                            @enderror
                                                        </div>

                                                        <div class="form-group col-md-2 newdesignadd45">
                                                            <label class="form-label" for="aadhar_card_no">Aadhar Number</label>
                                                            <input type="text" id="aadhar_card_no" name="aadhar_card_no" value="{{ $info->patient_info->identification_number }}">
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
                                        <h5 class="text-blue"> <i class="fa fa-bed text-orange"></i> PATIENT ADMISSION INFORMATION :</h5>
                                        <div class="row">
                                            <div class="col-lg-12 ">
                                                <div class="main-profile-contact-list ">
                                                    <div class="row">
                                                        <div class="col-md-2 ipd-registrationproaddd">
                                                            <label for="symptoms"> Symptoms </label>
                                                            <input type="text" id="symptoms" name="symptoms" value="{{ $info->symptoms }}">
                                                            @error('symptoms')<span class="text-danger">{{ $message }}</span>@enderror
                                                        </div>
                                                        <div class="col-md-2 ipd-registrationproaddd">
                                                            <label class="form-label"> Diagnosis at the time of Admission </label>
                                                            <select id="icd_code_at_the_time_of_admission" name="icd_code_at_the_time_of_admission" class="form-control select2-show-search">
                                                                <option value="">Select</option>
                                                                @foreach ($diagonases as $dia)
                                                                    <option value="{{$dia->id}}" {{ $info->diagnosis_id == $dia->id ? 'selected' : '' }}>{{$dia->diagonasis_name}}</option>
                                                                @endforeach
                                                            </select>
                                                            @error('icd_code_at_the_time_of_admission')<span class="text-danger">{{ $message }}</span>@enderror
                                                        </div>
                                                        <div class="col-md-2 ipd-registrationproaddd">
                                                            <label class="form-label">Under Doctor <span class="text-danger">*</span></label>
                                                            <select id="under_doctor" name="under_doctor" class="form-control select2-show-search">
                                                                <option value="">Select</option>
                                                                @foreach ($doctor as $doc)
                                                                    <option value="{{$doc->id}}" {{ $info->doctor_id == $doc->id ? 'selected' : '' }}>{{$doc->salutation}} {{$doc->name}}</option>
                                                                @endforeach
                                                            </select>
                                                            @error('under_doctor')<span class="text-danger">{{ $message }}</span>@enderror
                                                        </div>
                                                        <div class="col-md-2 ipd-registrationproaddd">
                                                            <label class="form-label">Other Under Doctor</label>
                                                            <select id="other_under_doctor" name="other_under_doctor" class="form-control select2-show-search">
                                                                <option value="">Select</option>
                                                                @foreach ($doctor as $doc)
                                                                    <option value="{{$doc->id}}" {{ $info->other_doctor_id == $doc->id ? 'selected' : '' }}>{{$doc->salutation}} {{$doc->name}}</option>
                                                                @endforeach
                                                            </select>
                                                            @error('other_under_doctor')<span class="text-danger">{{ $message }}</span>@enderror
                                                        </div>
                                                        <div class="col-md-2 ipd-registrationproaddd">
                                                            <label class="form-label">Bed Category <span class="text-danger">*</span></label>
                                                            <select id="bed_category" name="bed_category" class="form-control select2-show-search" onchange="getWard(this.value)">
                                                                <option value="">Select</option>
                                                                @foreach ($wards as $ward)
                                                                    <option value="{{$ward->id}}" {{ $info->ward_id == $ward->id ? 'selected' : '' }}>{{$ward->ward_name}}</option>
                                                                @endforeach
                                                            </select>
                                                            @error('bed_category')<span class="text-danger">{{ $message }}</span>@enderror
                                                        </div>
                                                        <div class="col-md-2 ipd-registrationproaddd">
                                                            <label class="form-label">Bed <span class="text-danger">*</span></label>
                                                            <select name="bed" class="form-control select2-show-search" id="bed">
                                                                <option value="{{ $info->bed_id }}">{{ $info->bed_name }}</option>
                                                            </select>
                                                            @error('bed')<span class="text-danger">{{ $message }}</span>@enderror
                                                        </div>
                                                        <div class="col-md-4 ipd-registrationproaddd">
                                                            <label class="form-label"> History of alcoholism, tobacco or substance abuse, if any</label>
                                                            <textarea class="form-control" id="history_alcoholism" name="history_alcoholism">{{ $info->history_alcoholism }}</textarea>
                                                            @error('history_alcoholism')<span class="text-danger">{{ $message }}</span>@enderror
                                                        </div>
                                                        <div class="col-md-4 ipd-registrationproaddd">
                                                            <label class="form-label"> Significant Past Medical and Surgical History, if any</label>
                                                            <textarea class="form-control" id="medical_surgical_history" name="medical_surgical_history">{{ $info->medical_surgical_history }}</textarea>
                                                            @error('medical_surgical_history')<span class="text-danger">{{ $message }}</span>@enderror
                                                        </div>
                                                        <div class="col-md-4 ipd-registrationproaddd">
                                                            <label class="form-label"> Family History if significant/ relevant to diagnosis or treatment</label>
                                                            <textarea class="form-control" id="family_history_diagnosis" name="family_history_diagnosis">{{ $info->family_history_diagnosis }}</textarea>
                                                            @error('family_history_diagnosis')<span class="text-danger">{{ $message }}</span>@enderror
                                                        </div>
                                                        <div class="form-group col-md-4 newaddappon45">
                                                            <label>Referred By <span class="text-danger">*</span></label>
                                                            <select id="referred_by" name="referred_by" class="form-control select2-show-search">
                                                                <option value="">Select</option>
                                                                @foreach ($referral as $ref)
                                                                    <option value="{{$ref->id}}" {{ $info->referred_by == $ref->id ? 'selected' : '' }}>{{$ref->referral_name}}</option>
                                                                @endforeach
                                                            </select>
                                                            @error('referred_by')<span class="text-danger">{{ $message }}</span>@enderror
                                                        </div>
                                                        <div class="form-group col-md-4 newaddappon45">
                                                            <label>Provider</label>
                                                            <select id="provider" name="provider" class="form-control select2-show-search">
                                                                <option value="">Select</option>
                                                                @foreach ($provider as $pro)
                                                                    <option value="{{$pro->id}}" {{ $info->provider == $pro->id ? 'selected' : '' }}>{{$pro->referral_name}}</option>
                                                                @endforeach
                                                            </select>
                                                            @error('provider')<span class="text-danger">{{ $message }}</span>@enderror
                                                        </div>
                                                        <div class="form-group col-md-4 newaddappon45">
                                                            <label>Market By</label>
                                                            <select id="market_by" name="market_by" class="form-control select2-show-search">
                                                                <option value="">Select</option>
                                                                @foreach ($market_by as $mar)
                                                                    <option value="{{$mar->id}}" {{ $info->market_by == $mar->id ? 'selected' : '' }}>{{$mar->referral_name}}</option>
                                                                @endforeach
                                                            </select>
                                                            @error('market_by')<span class="text-danger">{{ $message }}</span>@enderror
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="hospital_allcardbodydesign border mt-2">
                                        <h5 class="text-blue"> <i class="fa fa-bed text-orange"></i> RESPONSIBLE PERSON DETAILS :</h5>
                                        <div class="row">
                                            <div class="col-lg-12 ">
                                                <div class="row">
                                                    <div class="col-md-3 ipd-registrationproaddd">
                                                        <label for="responsible_person" class="form-label">Name</label>
                                                        <input type="text" id="responsible_person" class="text-capitalize" name="responsible_person" value="{{ $info->responsible_person }}">
                                                        @error('responsible_person')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                    <div class="col-md-2 ipd-registrationproaddd">
                                                        <label class="form-label">Relation With Patient</label>
                                                        <select name="responsible_person_relation" class="form-control select2-show-search" id="responsible_person_relation">
                                                            <option value="">Select</option>
                                                            <option value="Father" {{ $info->responsible_person_relation == 'Father' ? 'selected' : '' }}>Father</option>
                                                            <option value="Mother" {{ $info->responsible_person_relation == 'Mother' ? 'selected' : '' }}>Mother</option>
                                                            <option value="Son" {{ $info->responsible_person_relation == 'Son' ? 'selected' : '' }}>Son</option>
                                                            <option value="Daughter" {{ $info->responsible_person_relation == 'Daughter' ? 'selected' : '' }}>Daughter</option>
                                                            <option value="Relative" {{ $info->responsible_person_relation == 'Relative' ? 'selected' : '' }}>Relative</option>
                                                            <option value="Friend" {{ $info->responsible_person_relation == 'Friend' ? 'selected' : '' }}>Friend</option>
                                                            <option value="Husband" {{ $info->responsible_person_relation == 'Husband' ? 'selected' : '' }}>Husband</option>
                                                            <option value="Wife" {{ $info->responsible_person_relation == 'Wife' ? 'selected' : '' }}>Wife</option>
                                                            <option value="Guardian" {{ $info->responsible_person_relation == 'Guardian' ? 'selected' : '' }}>Guardian</option>
                                                            <option value="Daughter-in-law" {{ $info->responsible_person_relation == 'Daughter-in-law' ? 'selected' : '' }}>Daughter-in-law</option>
                                                            <option value="Son-in-law" {{ $info->responsible_person_relation == 'Son-in-law' ? 'selected' : '' }}>Son-in-law</option>
                                                            <option value="Neighbour" {{ $info->responsible_person_relation == 'Neighbour' ? 'selected' : '' }}>Neighbour</option>
                                                            <option value="Nephew" {{ $info->responsible_person_relation == 'Nephew' ? 'selected' : '' }}>Nephew</option>
                                                            <option value="Niece" {{ $info->responsible_person_relation == 'Niece' ? 'selected' : '' }}>Niece</option>
                                                            <option value="Grand Mother" {{ $info->responsible_person_relation == 'Grand Mother' ? 'selected' : '' }}>Grand Mother</option>
                                                            <option value="Grand Father" {{ $info->responsible_person_relation == 'Grand Father' ? 'selected' : '' }}>Grand Father</option>
                                                            <option value="Teacher" {{ $info->responsible_person_relation == 'Teacher' ? 'selected' : '' }}>Teacher</option>
                                                            <option value="Mother-in-law" {{ $info->responsible_person_relation == 'Mother-in-law' ? 'selected' : '' }}>Mother-in-law</option>
                                                            <option value="Father-in-law" {{ $info->responsible_person_relation == 'Father-in-law' ? 'selected' : '' }}>Father-in-law</option>
                                                            <option value="Brother" {{ $info->responsible_person_relation == 'Brother' ? 'selected' : '' }}>Brother</option>
                                                            <option value="Sister" {{ $info->responsible_person_relation == 'Sister' ? 'selected' : '' }}>Sister</option>
                                                            <option value="Cousin" {{ $info->responsible_person_relation == 'Cousin' ? 'selected' : '' }}>Cousin</option>
                                                            <option value="Grand Daughter" {{ $info->responsible_person_relation == 'Grand Daughter' ? 'selected' : '' }}>Grand Daughter</option>
                                                            <option value="Grand Son" {{ $info->responsible_person_relation == 'Grand Son' ? 'selected' : '' }}>Grand Son</option>
                                                        </select>
                                                        @error('responsible_person_relation')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                    <div class="col-md-3 ipd-registrationproaddd">
                                                        <label for="responsible_person_ph_no" class="form-label"> Phone No</label>
                                                        <input type="text" id="responsible_person_ph_no" class="text-capitalize" name="responsible_person_ph_no" value="{{ $info->responsible_person_ph_no }}" maxlength="10" oninput="this.value = this.value.replace(/[^0-9]/g, '');">
                                                        @error('responsible_person_ph_no')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                    <div class="col-md-1 ipd-registrationproaddd">
                                                        <label for="responsible_person_age" class="form-label"> Age</label>
                                                        <input type="text" id="responsible_person_age" class="text-capitalize" name="responsible_person_age" value="{{ $info->responsible_person_age }}">
                                                        @error('responsible_person_age')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                    <div class="col-md-3 ipd-registrationproaddd">
                                                        <label for="responsible_person_address" class="form-label"> Address</label>
                                                        <input type="text" id="responsible_person_address" class="text-capitalize" name="responsible_person_address" value="{{ $info->responsible_person_address }}">
                                                        @error('responsible_person_address')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="modal-footer justify-content-center">
                                        <button class="btn btn-primary" type="submit" name="save" value="save"><i class="fa fa-file text-success"></i> Update</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('js')
    <script>
        document.addEventListener("click", function(event) {
            const inputField = document.getElementById("uhid");

            const table = document.getElementById("search_result");

            if (event.target !== inputField && !table.contains(event.target)) {
                table.style.display = "none";
            }
        });
        $(document).ready(function() {
            $('#yourFormId').submit(function(e) {
                e.preventDefault();

                let admission_type = $('#admission_type').val();
                let admission_date = $('#admission_date').val();
                let patient_package_type = $('#patient_package_type').val();
                let insurance_type = $('#insurance_type').val();
                let name = $('#name').val();
                let gender = $('#gender').val();
                let guardian_name = $('#guardian_name').val();
                let relation = $('#relation').val();
                let address = $('#address').val();
                let under_doctor = $('#under_doctor').val();
                let bed_category = $('#bed_category').val();
                let bed = $('#bed').val();
                let referred_by = $('#referred_by').val();
                let patient_ph_no = $('#patient_ph_no').val();
                if(admission_type && admission_date && patient_package_type && insurance_type && name && gender && guardian_name && relation && address && under_doctor && bed_category && bed && referred_by && patient_ph_no){
                    if(!isValidPhoneNumber(patient_ph_no)){
                        alert('Please enter a valid 10-digit Phone Number.');
                        return;
                    }
                    if($('#payment_amount').val()){
                        var PaymentMode = document.getElementById("payment_mode").value;
                        var bankNameValue = document.getElementById("bank_name").value;
                        if (PaymentMode !== "Cash" && bankNameValue === "") {
                            alert("Please select a bank when payment mode is not cash.");
                            return;
                        }
                    }
                    $(this).unbind('submit').submit();
                }else{
                    alert('Please select all required fields.');
                    const fields = [
                        "admission_type", "admission_date", "patient_package_type", "insurance_type",
                        "name", "gender", "guardian_name", "relation", "address", "under_doctor",
                        "bed_category", "bed", "referred_by", "patient_ph_no"
                    ];

                    fields.forEach(field => {
                        if ($(`#${field}`).val()) {
                            $(`#${field}`).removeClass('border border-danger');
                            $(`#${field}`).next('.select2-container').find('.select2-selection').removeClass('border border-danger');
                        } else {
                            $(`#${field}`).addClass('border border-danger');
                            $(`#${field}`).next('.select2-container').find('.select2-selection').addClass('border border-danger');

                        }
                    });
                }
            });
        });
        function isValidPhoneNumber(phoneNumber) {
            var cleanedPhoneNumber = phoneNumber.replace(/\D/g, '');  // Remove non-digit characters
            return cleanedPhoneNumber.length === 10;  // Check if the cleaned phone number is exactly 10 digits
        }

        getDistrict({{$info->patient_info->state}},{{$info->patient_info->district}});
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
        function getWard(ward_id) {
            if (ward_id) {
                $('#bed').html('<option vaule="">Select Bed</option>');
                $.ajax({
                    url: "{{ Route('get-beds') }}",
                    type: "POST",
                    data: {
                        _token: '{{ csrf_token() }}',
                        ward_id: ward_id,
                    },
                    success: function(response) {
                        if (response.success && (response.beds.length > 0)) {
                            $.each(response.beds, function(key, value) {
                                $('#bed').append(`<option value="${value.id}">${value.bed_name}</option>`);
                            });
                        }
                    },
                    error: function(error) {
                        console.log(error);
                    }
                });
            }
        }
        getage();
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
    </script>
@endpush
