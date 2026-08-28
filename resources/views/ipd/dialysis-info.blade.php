@extends('layouts.structure')
@push('title')
    <title>Dialysis Details</title>
@endpush
@push('css')
@endpush
@section('main-content')
    <div class="row">
        <div class="card ">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3 leftside_fixarea">
                        <x-billbar section="dialysis" id="{{$info->id}}" type="sec" />
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
                                                    <span class="font-weight-semibold w-50"> Dialysis ID </span>
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
                                                    {{$info->patient_info->responsible_person}}
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
                                                    {{$info->patient_info->responsible_person_ph_no}}
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
                                                    {{$info->package_name}}
                                                </td>
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
