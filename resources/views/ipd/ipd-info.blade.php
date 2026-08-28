@extends('layouts.structure')
@push('title')
    <title>IPD Details</title>
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
                        <div class="row no-gutters">
                            <div class="col-lg-6 col-xl-6 border-right">
                                <div class="options px-5 pt-2   pb-1">
                                    <table class="table table_border_none ipdtable_design">
                                        <tbody>
                                            <tr>
                                                <td class="py-2 px-0">
                                                    <i class="fas fa-yin-yang text-danger"></i>
                                                </td>
                                                <td class="py-2 px-0">
                                                    <span class="font-weight-semibold w-50">Gender</span>
                                                </td>
                                                <td class="py-2 px-0">
                                                    {{$info->patient_info->gender}}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="py-2 px-0">
                                                    <i class="fas fa-yin-yang text-danger"></i>
                                                </td>
                                                <td class="py-2 px-0">
                                                    <span class="font-weight-semibold w-50">Guardian Name</span>
                                                </td>
                                                <td class="py-2 px-0">
                                                    {{$info->patient_info->guardian_name}}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="py-2 px-0">
                                                    <i class="fas fa-yin-yang text-danger"></i>
                                                </td>
                                                <td class="py-2 px-0">
                                                    <span class="font-weight-semibold w-50">Relation with Guardian</span>
                                                </td>
                                                <td class="py-2 px-0">
                                                    {{$info->patient_info->guardian_realation}}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="py-2 px-0">
                                                    <i class="fas fa-yin-yang text-danger"></i>
                                                </td>
                                                <td class="py-2 px-0">
                                                    <span class="font-weight-semibold w-50">Guardian Mobile No </span>
                                                </td>
                                                <td class="py-2 px-0">
                                                    {{$info->patient_info->guardian_contact_no}}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="py-2 px-0">
                                                    <i class="fas fa-yin-yang text-danger"></i>
                                                </td>
                                                <td class="py-2 px-0">
                                                    <span class="font-weight-semibold w-50">Age </span>
                                                </td>
                                                <td class="py-2 px-0">
                                                    {{ @$info->patient_info->dob_year ? $info->patient_info->dob_year.'Y' : '' }}
                                                    {{ @$info->patient_info->dob_month ? $info->patient_info->dob_month.'M' : '' }}
                                                    {{ @$info->patient_info->dob_day ? $info->patient_info->dob_day.'D' : '' }}
                                                </td>
                                            </tr>
                                            <tr colspan="2">
                                                <td class="py-2 px-0">
                                                    <i class="fas fa-yin-yang text-danger"></i>
                                                </td>
                                                <td class="py-2 px-0">
                                                    <span class="font-weight-semibold w-50">Address </span>
                                                </td>
                                                <td class="py-2 px-0">
                                                    {{ @$info->patient_info->address }},
                                                    {{ @$info->patient_info->district_name }},
                                                    {{ @$info->patient_info->state_name }},
                                                    {{ @$info->patient_info->country }},
                                                    {{ @$info->patient_info->pin_code }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="py-2 px-0">
                                                    <i class="fas fa-yin-yang text-danger"></i>
                                                </td>
                                                <td class="py-2 px-0">
                                                    <span class="font-weight-semibold w-50">Aadhar Card No </span>
                                                </td>
                                                <td class="py-2 px-0">
                                                    {{$info->patient_info->identification_number}}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="py-2 px-0">
                                                    <i class="fas fa-yin-yang text-danger"></i>
                                                </td>
                                                <td class="py-2 px-0">
                                                    <span class="font-weight-semibold w-50"> Provider </span>
                                                </td>
                                                <td class="py-2 px-0">
                                                    {{@$info->provider_name->name}}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="py-2 px-0">
                                                    <i class="fas fa-yin-yang text-danger"></i>
                                                </td>
                                                <td class="py-2 px-0">
                                                    <span class="font-weight-semibold w-50"> Referral </span>
                                                </td>
                                                <td class="py-2 px-0">
                                                    {{@$info->referral_name->name}}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="py-2 px-0">
                                                    <i class="fas fa-yin-yang text-danger"></i>
                                                </td>
                                                <td class="py-2 px-0">
                                                    <span class="font-weight-semibold w-50"> Market By</span>
                                                </td>
                                                <td class="py-2 px-0">
                                                    {{@$info->market_by_name->name}}
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="col-lg-6 col-xl-6 border-right">
                                <div class="options px-5 pt-2 pb-1">
                                    <table class="table table_border_none ipdtable_design">
                                        <tbody>
                                            <tr>
                                                <td class="py-2 px-0">
                                                    <i class="fas fa-yin-yang text-danger"></i>
                                                </td>
                                                <td class="py-2 px-0">
                                                    <span class="font-weight-semibold w-50"> IPD ID </span>
                                                </td>
                                                <td class="py-2 px-0">
                                                    {{$info->id}}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="py-2 px-0">
                                                    <i class="fas fa-yin-yang text-danger"></i>
                                                </td>
                                                <td class="py-2 px-0">
                                                    <span class="font-weight-semibold w-50"> Admission Date </span>
                                                </td>
                                                <td class="py-2 px-0">
                                                    {{dateFor($info->admission_date, true)}}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="py-2 px-0">
                                                    <i class="fas fa-yin-yang text-danger"></i>
                                                </td>
                                                <td class="py-2 px-0">
                                                    <span class="font-weight-semibold w-50"> Department </span>
                                                </td>
                                                <td class="py-2 px-0">
                                                    {{$info->department_name}}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="py-2 px-0">
                                                    <i class="fas fa-yin-yang text-danger"></i>
                                                </td>
                                                <td class="py-2 px-0">
                                                    <span class="font-weight-semibold w-50"> Under Doctor </span>
                                                </td>
                                                <td class="py-2 px-0">
                                                    {{$info->doctor_name}}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="py-2 px-0">
                                                    <i class="fas fa-yin-yang text-danger"></i>
                                                </td>
                                                <td class="py-2 px-0">
                                                    <span class="font-weight-semibold w-50"> Other Under Doctor </span>
                                                </td>
                                                <td class="py-2 px-0">
                                                    {{$info->other_doctor_name}}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="py-2 px-0">
                                                    <i class="fas fa-yin-yang text-danger"></i>
                                                </td>
                                                <td class="py-2 px-0">
                                                    <span class="font-weight-semibold w-50"> Bed </span>
                                                </td>
                                                <td class="py-2 px-0">
                                                    {{$info->bed_name}}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="py-2 px-0">
                                                    <i class="fas fa-yin-yang text-danger"></i>
                                                </td>
                                                <td class="py-2 px-0">
                                                    <span class="font-weight-semibold w-50"> Ward </span>
                                                </td>
                                                <td class="py-2 px-0">
                                                    {{$info->ward_name}}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="py-2 px-0">
                                                    <i class="fas fa-yin-yang text-danger"></i>
                                                </td>
                                                <td class="py-2 px-0">
                                                    <span class="font-weight-semibold w-50"> Responsible By </span>
                                                </td>
                                                <td class="py-2 px-0">
                                                    {{$info->responsible_person}}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="py-2 px-0">
                                                    <i class="fas fa-yin-yang text-danger"></i>
                                                </td>
                                                <td class="py-2 px-0">
                                                    <span class="font-weight-semibold w-50"> Responsible By ph No. </span>
                                                </td>
                                                <td class="py-2 px-0">
                                                    {{$info->responsible_person_ph_no}}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="py-2 px-0">
                                                    <i class="fas fa-yin-yang text-danger"></i>
                                                </td>
                                                <td class="py-2 px-0">
                                                    <span class="font-weight-semibold w-50">Admission time Diagnosis</span>
                                                </td>
                                                <td class="py-2 px-0">
                                                    {{$info->diagonasis_name}}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="py-2 px-0">
                                                    <i class="fas fa-yin-yang text-danger"></i>
                                                </td>
                                                <td class="py-2 px-0">
                                                    <span class="font-weight-semibold w-50">Package Type</span>
                                                </td>
                                                <td class="py-2 px-0">
                                                    {{$info->package_type}}
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="row no-gutters border-top border-bottom mb-1">
                            <div class="col-lg-6 col-xl-6 border-right">
                                <div class="options px-5 pt-2 pb-1">
                                    <b><i class="fas fa-yin-yang text-success"></i> History of alcoholism, tobacco or substance abuse, if any :</b>
                                    {{$info->history_alcoholism}}
                                </div>
                            </div>
                            <div class="col-lg-6 col-xl-6 border-right">
                                <div class="options px-5 pt-2 pb-1">
                                    <b><i class="fas fa-yin-yang text-success"></i> Significant Past Medical and Surgical History, if any :</b>
                                    {{$info->medical_surgical_history}}
                                </div>
                            </div>
                            <div class="col-lg-6 col-xl-6 border-right">
                                <div class="options px-5 pt-2 pb-1">
                                    <b><i class="fas fa-yin-yang text-success"></i> Family History if significant/ relevant to diagnosis or treatment :</b>
                                    {{$info->family_history_diagnosis}}
                                </div>
                            </div>
                        </div>
                        <div class="row no-gutters">
                            <div class="col-lg-6 col-xl-6 border-right">
                                <div class="options px-5 pt-2   pb-1">
                                    <h5 class="text-blue">UNDER DOCTOR</h5>

                                    <div class="row">

                                        <div class="col-md-8 ipd-registrationproaddd">
                                            <form action="{{route('ipd.update-ipd-doctor')}}" method="POST">
                                                @csrf
                                                <input type="hidden" name="ipd_id" value="{{$info->id}}">
                                                <div class="row" style="margin-top: -20px;">
                                                    <div class="col-lg-8">
                                                        <select name="under_doctor" class="form-control select2-show-search" required>
                                                            <option value="">Select</option>
                                                            @foreach ($doctor as $doc)
                                                            <option value="{{$doc->id}}">{{$doc->salutation}} {{$doc->name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <button class="btn btn-primary btn-sm" type="submit" value="save" style="margin-top: 7px;">
                                                            <i class="fa fa-file text-success"></i>
                                                            Save
                                                        </button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>

                                        <div class="col-md-4 text-right">
                                            @if(isset($info->admission_type) && $info->admission_type != 'IPD' && isset($bill))
                                                <form action="{{ route('bill.shift-bill', ['section' => 'ipd']) }}" method="POST" class="d-inline ms-2">
                                                    @csrf
                                                    <input type="hidden" name="bill_id" value="{{ $bill->id }}">
                                                    <button id="shift-to-section" class="btn btn-lg btn-warning" type="submit">
                                                        Shift to {{ $info->admission_type == 'DAYCARE' ? 'IPD' : 'Daycare' }}
                                                    </button>
                                                </form>
                                            @endif
                                        </div>

                                    </div>

                                    <table class="table border" style="margin-top: 15px;">
                                        <thead class="bg-primary">
                                            <tr>
                                                <th scope="col" class="text-white text-center">Doctor Name</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>{{$info->salutation}} {{$info->doctor_name}} ({{$info->qualification}}, {{$info->experience}}, {{$info->specialization}})</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="col-lg-6 col-xl-6 border-right">
                                <div class="options px-5 pt-2 pb-1">
                                    <h5 class="text-blue">PATIENT TYPE </h5>
                                    <form action="{{route('ipd.update-ipd-insurance')}}" method="POST">
                                        @csrf
                                        <input type="hidden" name="ipd_id" value="{{$info->id}}">
                                        <div class="row">
                                            <div class="col-lg-4">
                                                <select name="patient_type" class="form-control select2-show-search" required>
                                                    <option value="">Select</option>
                                                    @foreach ($tpa as $ins)
                                                    <option value="{{$ins->id}}">{{$ins->tpa_name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            {{-- <div class="col-lg-3">
                                                <input type="text" class="dateTimePickr" value="" placeholder="Choose Date" name="date_time">
                                            </div> --}}
                                            <div class="col-lg-4">
                                                <input type="text" name="insurance_no" placeholder="Insurance No">
                                            </div>
                                            <div class="col-lg-2">
                                                <button class="btn btn-primary btn-sm" type="submit" name="save" value="save" style="margin-top: 7px;">
                                                    <i class="fa fa-file text-success"></i> Save
                                                </button>
                                            </div>
                                        </div>
                                    </form>

                                    <table class="table border" style="margin-top: 15px;">
                                        <thead class="bg-primary">
                                            <tr>
                                                <th scope="col" class="text-white">Patient Type</th>
                                                <th scope="col" class="text-white">Insurance No</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>{{$info->tpa_name}}</td>
                                                <td>{{$info->insurance_no}}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
@endpush
