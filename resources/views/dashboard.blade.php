@extends('layouts.structure')
@push('title')
    <title>Dashboard</title>
@endpush
@push('css')
@endpush
@section('main-content')
    <div class="row">
        <div class="container-fluid cardmain_areaboxsection4234">
            <div class="row">
                <div class="col-lg-9 foursection_outarea">
                    <div class="row">
                        <div class="col-lg-3">
                            <a href="{{ route('opd.opd') }}">
                                <div class="cardmain_dashboardarea">
                                    <div class="cardmain_innerdashboardarea">
                                        <div class="departmnt_imgsection">
                                            <img src="public/assets/images/doctor-consultation1.png"
                                                class="dprmnt_imgdesignhs">
                                        </div>
                                        <h2 class="cardinnerhdng_textdesign">
                                            OPD
                                        </h2>
                                        <ul class="features">
                                            <li>
                                                <span class="icon">
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                        width="24" height="24">
                                                        <path fill="none" d="M0 0h24v24H0z"></path>
                                                        <path
                                                            d="M10 15.172l9.192-9.193 1.415 1.414L10 18l-6.364-6.364 1.414-1.414z"
                                                            fill="currentColor">
                                                        </path>
                                                    </svg>
                                                </span>
                                                <span><strong>Today Patient : </strong>
                                                    <num id="opd-t">0</num>
                                                </span>
                                            </li>
                                            <li>
                                                <span class="icon">
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                        width="24" height="24">
                                                        <path fill="none" d="M0 0h24v24H0z"></path>
                                                        <path
                                                            d="M10 15.172l9.192-9.193 1.415 1.414L10 18l-6.364-6.364 1.414-1.414z"
                                                            fill="currentColor">
                                                        </path>
                                                    </svg>
                                                </span>
                                                <span><strong>Today Collection : </strong> ₹<num id="opd-i">0</num>
                                                    /-</span>
                                            </li>
                                            <li>
                                                <span class="icon">
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                        width="24" height="24">
                                                        <path fill="none" d="M0 0h24v24H0z"></path>
                                                        <path
                                                            d="M10 15.172l9.192-9.193 1.415 1.414L10 18l-6.364-6.364 1.414-1.414z"
                                                            fill="currentColor">
                                                        </path>
                                                    </svg>
                                                </span>
                                                <span><strong>New Patient : </strong>
                                                    <num id="opd-n">0</num>
                                                </span>
                                            </li>
                                            <li>
                                                <span class="icon">
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                        width="24" height="24">
                                                        <path fill="none" d="M0 0h24v24H0z"></path>
                                                        <path
                                                            d="M10 15.172l9.192-9.193 1.415 1.414L10 18l-6.364-6.364 1.414-1.414z"
                                                            fill="currentColor">
                                                        </path>
                                                    </svg>
                                                </span>
                                                <span><strong>Old Patient : </strong>
                                                    <num id="opd-o">0</num>
                                                </span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-lg-3">
                            <a href="{{ route('emg.patient-list') }}">
                                <div class="cardmain_dashboardarea">
                                    <div class="cardmain_innerdashboardarea">
                                        <div class="departmnt_imgsection">
                                            <img src="public/assets/images/ambulance.png" class="dprmnt_imgdesignhs">
                                        </div>
                                        <h2 class="cardinnerhdng_textdesign">
                                            EMERGENCY
                                        </h2>
                                        <ul class="features">
                                            <li>
                                                <span class="icon">
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                        width="24" height="24">
                                                        <path fill="none" d="M0 0h24v24H0z"></path>
                                                        <path
                                                            d="M10 15.172l9.192-9.193 1.415 1.414L10 18l-6.364-6.364 1.414-1.414z"
                                                            fill="currentColor">
                                                        </path>
                                                    </svg>
                                                </span>
                                                <span><strong>Today Patient : </strong>
                                                    <num id="emergency-t">0</num>
                                                </span>
                                            </li>
                                            <li>
                                                <span class="icon">
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                        width="24" height="24">
                                                        <path fill="none" d="M0 0h24v24H0z"></path>
                                                        <path
                                                            d="M10 15.172l9.192-9.193 1.415 1.414L10 18l-6.364-6.364 1.414-1.414z"
                                                            fill="currentColor">
                                                        </path>
                                                    </svg>
                                                </span>
                                                <span><strong>Today Collection : </strong> ₹<num id="emergency-i">0
                                                    </num>/-</span>
                                            </li>
                                            <li>
                                                <span class="icon">
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                        width="24" height="24">
                                                        <path fill="none" d="M0 0h24v24H0z"></path>
                                                        <path
                                                            d="M10 15.172l9.192-9.193 1.415 1.414L10 18l-6.364-6.364 1.414-1.414z"
                                                            fill="currentColor">
                                                        </path>
                                                    </svg>
                                                </span>
                                                <span><strong>New Patient : </strong>
                                                    <num id="emergency-n">0</num>
                                                </span>
                                            </li>
                                            <li>
                                                <span class="icon">
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                        width="24" height="24">
                                                        <path fill="none" d="M0 0h24v24H0z"></path>
                                                        <path
                                                            d="M10 15.172l9.192-9.193 1.415 1.414L10 18l-6.364-6.364 1.414-1.414z"
                                                            fill="currentColor">
                                                        </path>
                                                    </svg>
                                                </span>
                                                <span><strong>Old Patient : </strong>
                                                    <num id="emergency-o">0</num>
                                                </span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-lg-3">
                            <a href="{{ route('ipd.dialysis') }}">
                                <div class="cardmain_dashboardarea">
                                    <div class="cardmain_innerdashboardarea">
                                        <div class="departmnt_imgsection">
                                            <img src="public/assets/images/medical-doctor-in-patient-heart-check.png"
                                                class="dprmnt_imgdesignhs">
                                        </div>
                                        <h2 class="cardinnerhdng_textdesign">
                                            DIALYSIS
                                        </h2>
                                        <ul class="features">
                                            <li>
                                                <span class="icon">
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                        width="24" height="24">
                                                        <path fill="none" d="M0 0h24v24H0z"></path>
                                                        <path
                                                            d="M10 15.172l9.192-9.193 1.415 1.414L10 18l-6.364-6.364 1.414-1.414z"
                                                            fill="currentColor">
                                                        </path>
                                                    </svg>
                                                </span>
                                                <span><strong>Today Patient : </strong>
                                                    <num id="dialysis-t">0</num>
                                                </span>
                                            </li>
                                            <li>
                                                <span class="icon">
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                        width="24" height="24">
                                                        <path fill="none" d="M0 0h24v24H0z"></path>
                                                        <path
                                                            d="M10 15.172l9.192-9.193 1.415 1.414L10 18l-6.364-6.364 1.414-1.414z"
                                                            fill="currentColor">
                                                        </path>
                                                    </svg>
                                                </span>
                                                <span><strong>Today Collection : </strong> ₹<num id="dialysis-i">0</num>
                                                    /-</span>
                                            </li>
                                            <li>
                                                <span class="icon">
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                        width="24" height="24">
                                                        <path fill="none" d="M0 0h24v24H0z"></path>
                                                        <path
                                                            d="M10 15.172l9.192-9.193 1.415 1.414L10 18l-6.364-6.364 1.414-1.414z"
                                                            fill="currentColor">
                                                        </path>
                                                    </svg>
                                                </span>
                                                <span><strong>New Patient : </strong>
                                                    <num id="dialysis-n">0</num>
                                                </span>
                                            </li>
                                            <li>
                                                <span class="icon">
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                        width="24" height="24">
                                                        <path fill="none" d="M0 0h24v24H0z"></path>
                                                        <path
                                                            d="M10 15.172l9.192-9.193 1.415 1.414L10 18l-6.364-6.364 1.414-1.414z"
                                                            fill="currentColor">
                                                        </path>
                                                    </svg>
                                                </span>
                                                <span><strong>Old Patient : </strong>
                                                    <num id="dialysis-o">0</num>
                                                </span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-lg-3">
                            <a href="{{ route('investigation.investigation') }}">
                                <div class="cardmain_dashboardarea">
                                    <div class="cardmain_innerdashboardarea">
                                        <div class="departmnt_imgsection">
                                            <img src="public/assets/images/patient.png" class="dprmnt_imgdesignhs">
                                        </div>
                                        <h2 class="cardinnerhdng_textdesign">
                                            INVESTIGATION
                                        </h2>
                                        <ul class="features">
                                            <li>
                                                <span class="icon">
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                        width="24" height="24">
                                                        <path fill="none" d="M0 0h24v24H0z"></path>
                                                        <path
                                                            d="M10 15.172l9.192-9.193 1.415 1.414L10 18l-6.364-6.364 1.414-1.414z"
                                                            fill="currentColor">
                                                        </path>
                                                    </svg>
                                                </span>
                                                <span><strong>Today Patient : </strong>
                                                    <num id="investigation-t">0</num>
                                                </span>
                                            </li>
                                            <li>
                                                <span class="icon">
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                        width="24" height="24">
                                                        <path fill="none" d="M0 0h24v24H0z"></path>
                                                        <path
                                                            d="M10 15.172l9.192-9.193 1.415 1.414L10 18l-6.364-6.364 1.414-1.414z"
                                                            fill="currentColor">
                                                        </path>
                                                    </svg>
                                                </span>
                                                <span><strong>Today Collection : </strong> ₹<num id="investigation-i">0</num>
                                                    /-</span>
                                            </li>
                                            <li>
                                                <span class="icon">
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                        width="24" height="24">
                                                        <path fill="none" d="M0 0h24v24H0z"></path>
                                                        <path
                                                            d="M10 15.172l9.192-9.193 1.415 1.414L10 18l-6.364-6.364 1.414-1.414z"
                                                            fill="currentColor">
                                                        </path>
                                                    </svg>
                                                </span>
                                                <span><strong>New Patient : </strong>
                                                    <num id="investigation-n">0</num>
                                                </span>
                                            </li>
                                            <li>
                                                <span class="icon">
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                        width="24" height="24">
                                                        <path fill="none" d="M0 0h24v24H0z"></path>
                                                        <path
                                                            d="M10 15.172l9.192-9.193 1.415 1.414L10 18l-6.364-6.364 1.414-1.414z"
                                                            fill="currentColor">
                                                        </path>
                                                    </svg>
                                                </span>
                                                <span><strong>Old Patient : </strong>
                                                    <num id="investigation-o">0</num>
                                                </span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-lg-6">
                            <div class="cardmain_dashboardarea">
                                <div class="cardmain_innerdashboardarea in">
                                    <div class="departmnt_imgsection">
                                        <img src="public/assets/images/medical-doctor-in-patient-heart-check.png"
                                            class="dprmnt_imgdesignhs">
                                    </div>
                                    <h2 class="cardinnerhdng_textdesign">
                                        OPD REGISTRATION DETAILS
                                    </h2>
                                    <div class="tanew">
                                        <table class="table bordercoloradd">
                                            <thead>
                                                <tr>
                                                    <th style="color:#270f8a">DOCTOR NAME</th>
                                                    <th style="color:#270f8a">No. of Patient</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if($opd_details)
                                                @foreach ($opd_details as $key=>$item)
                                                <tr>
                                                    <td>{{$key+1}}. <a href="{{ route('opd.opd') }}?doctor_id={{@$item->doctor_id}}">{{@$item->salutation}} {{@$item->doctor_name}}[{{@$item->empid }}]</a></td>
                                                    <td>T : {{@$item->visit_count}} || N : {{@$item->new_count}} || O : {{@$item->old_count}}</td>
                                                </tr>
                                                @endforeach
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="cardmain_dashboardarea">
                                <div class="cardmain_innerdashboardarea in">
                                    <div class="departmnt_imgsection">
                                        <img src="public/assets/images/medical-doctor-in-patient-heart-check.png"
                                            class="dprmnt_imgdesignhs">
                                    </div>
                                    <h2 class="cardinnerhdng_textdesign">
                                        EMG REGISTRATION DETAILS
                                    </h2>
                                    <div class="tanew">
                                        <table class="table bordercoloradd">
                                            <thead>
                                                <tr>
                                                    <th style="color:#270f8a">DOCTOR NAME</th>
                                                    <th style="color:#270f8a">No. of Patient</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if($emg_details)
                                                @foreach ($emg_details as $key=>$item)
                                                <tr>
                                                    <td>{{$key+1}}. <a href="{{ route('emg.patient-list') }}?doctor_id={{@$item->doctor_id}}">{{@$item->salutation}}
                                                        {{@$item->doctor_name}}[{{@$item->empid }}]</a></td>
                                                    <td>T : {{@$item->visit_count}} || N : {{@$item->new_count}} || O : {{@$item->old_count}}</td>
                                                </tr>
                                                @endforeach
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 mt-4">
                            <div class="cardmain_dashboardarea">
                                <div class="cardmain_innerdashboardarea in">
                                    <div class="departmnt_imgsection">
                                        <img src="public/assets/images/medical-doctor-in-patient-heart-check.png"
                                            class="dprmnt_imgdesignhs">
                                    </div>
                                    <h2 class="cardinnerhdng_textdesign">
                                        IPD REGISTRATION DETAILS
                                    </h2>
                                    <div class="tanew">
                                        <table class="table bordercoloradd">
                                            <thead>
                                                <tr>
                                                    <th style="color:#270f8a">DOCTOR NAME</th>
                                                    <th style="color:#270f8a">No. of Patient</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if($ipd_details)
                                                @foreach ($ipd_details as $key=>$item)
                                                <tr>
                                                    <td>{{$key+1}}. <a href="{{ route('ipd.ipd') }}?doctor_id={{@$item->doctor_id}}?type=IPD">{{@$item->salutation}}
                                                        {{@$item->doctor_name}}[{{@$item->empid }}]</a></td>
                                                    <td>T : {{@$item->visit_count}} || N : {{@$item->new_count}} || O : {{@$item->old_count}}</td>
                                                </tr>
                                                @endforeach
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 mt-4">
                            <div class="cardmain_dashboardarea">
                                <div class="cardmain_innerdashboardarea in">
                                    <div class="departmnt_imgsection">
                                        <img src="public/assets/images/medical-doctor-in-patient-heart-check.png"
                                            class="dprmnt_imgdesignhs">
                                    </div>
                                    <h2 class="cardinnerhdng_textdesign">
                                        DAYCARE REGISTRATION DETAILS
                                    </h2>
                                    <div class="tanew">
                                        <table class="table bordercoloradd">
                                            <thead>
                                                <tr>
                                                    <th style="color:#270f8a">DOCTOR NAME</th>
                                                    <th style="color:#270f8a">No. of Patient</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if($daycare_details)
                                                @foreach ($daycare_details as $key=>$item)
                                                <tr>
                                                    <td>{{$key+1}}. <a href="{{ route('ipd.ipd') }}?doctor_id={{@$item->doctor_id}}?type=DAYCARE">{{@$item->salutation}}
                                                        {{@$item->doctor_name}}[{{@$item->empid }}]</a></td>
                                                    <td>T : {{@$item->visit_count}} || N : {{@$item->new_count}} || O : {{@$item->old_count}}</td>
                                                </tr>
                                                @endforeach
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 foursection_outarea">
                    <a href="{{ route('ipd.ipd') }}">
                        <div class="cardmain_dashboardarea">
                            <div class="cardmain_innerdashboardarea">
                                <div class="departmnt_imgsection">
                                    <img src="public/assets/images/doctor-consultation1.png"
                                        class="dprmnt_imgdesignhs">
                                </div>
                                <h2 class="cardinnerhdng_textdesign">
                                    IPD / DAYCARE
                                </h2>
                                <ul class="features">
                                    <li>
                                        <span class="icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                width="24" height="24">
                                                <path fill="none" d="M0 0h24v24H0z"></path>
                                                <path
                                                    d="M10 15.172l9.192-9.193 1.415 1.414L10 18l-6.364-6.364 1.414-1.414z"
                                                    fill="currentColor">
                                                </path>
                                            </svg>
                                        </span>
                                        <span><strong>Today Patient : </strong>
                                            <num id="ipd-t">0</num> / <num id="daycare-t">0</num>
                                        </span>
                                    </li>
                                    <li>
                                        <span class="icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                width="24" height="24">
                                                <path fill="none" d="M0 0h24v24H0z"></path>
                                                <path
                                                    d="M10 15.172l9.192-9.193 1.415 1.414L10 18l-6.364-6.364 1.414-1.414z"
                                                    fill="currentColor">
                                                </path>
                                            </svg>
                                        </span>
                                        <span><strong>Today IPD Collection : </strong> ₹<num id="ipd-i">0</num> /-</span>
                                    </li>
                                    <li>
                                        <span class="icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                width="24" height="24">
                                                <path fill="none" d="M0 0h24v24H0z"></path>
                                                <path
                                                    d="M10 15.172l9.192-9.193 1.415 1.414L10 18l-6.364-6.364 1.414-1.414z"
                                                    fill="currentColor">
                                                </path>
                                            </svg>
                                        </span>
                                        <span><strong>Today DAYCARE Collection : </strong> ₹<num id="daycare-i">0</num> /-</span>
                                    </li>
                                    <li>
                                        <span class="icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                width="24" height="24">
                                                <path fill="none" d="M0 0h24v24H0z"></path>
                                                <path
                                                    d="M10 15.172l9.192-9.193 1.415 1.414L10 18l-6.364-6.364 1.414-1.414z"
                                                    fill="currentColor">
                                                </path>
                                            </svg>
                                        </span>
                                        <span><strong>New Patient : </strong>
                                            <num id="ipd-n">0</num>  / <num id="daycare-n">0</num>
                                        </span>
                                    </li>
                                    <li>
                                        <span class="icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                width="24" height="24">
                                                <path fill="none" d="M0 0h24v24H0z"></path>
                                                <path
                                                    d="M10 15.172l9.192-9.193 1.415 1.414L10 18l-6.364-6.364 1.414-1.414z"
                                                    fill="currentColor">
                                                </path>
                                            </svg>
                                        </span>
                                        <span><strong>Old Patient : </strong>
                                            <num id="ipd-o">0</num>  / <num id="daycare-o">0</num>
                                        </span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </a>
                    <div class="cardmain_dashboardarea mt-4">
                        <div class="cardmain_innerdashboardarea">
                            <div class="departmnt_imgsection">
                                <a href="{{ route('opd.add-enquiry') }}" data-placement="left"
                                    data-toggle="tooltip" title="Click here to new Enquiry">
                                    <img src="public/assets/images/faq.png" class="dprmnt_imgdesignhs">
                                </a>
                            </div>
                            <a href="{{ route('opd.appointments') }}">
                                <h2 class="cardinnerhdng_textdesign">TODAY ENQUIRY : <span style="color:#cd0008"
                                        id="enquiry">0</span></h2>
                            </a>
                        </div>
                    </div>
                    <div class="cardmain_dashboardarea mt-4">
                        <div class="cardmain_innerdashboardarea">
                            <div class="departmnt_imgsection">
                                <a href="{{ route('hr.child-register') }}" data-placement="left"
                                    data-toggle="tooltip" title="Click here to new baby registration">
                                    <img src="public/assets/images/baby-boy.png" class="dprmnt_imgdesignhs">
                                </a>
                            </div>
                            <a href="{{ route('hr.child-list') }}">
                                <h2 class="cardinnerhdng_textdesign">NURSERY : <span style="color:#cd0008"
                                        id="nursery">0</span></h2>
                            </a>
                        </div>
                    </div>
                    <div class="cardmain_dashboardarea mt-2" style="height: 568px;overflow: scroll;">
                        @if(!empty($active_doctor))
                            @foreach ($active_doctor as $value)
                            <div class="doctnewschedulearea" style="margin-top: 3%;">
                                <div style="border-radius: 9px;background-color: #fff;height: 160px;">
                                    <div class="card-body" style="padding: 7px;">
                                        <div style="height: auto;">
                                            <div class="cardmain_dashboardarea1" @if(@$value['in_out_status'] == 'In') style="background-color:#d5ffd5" @elseif(@$value['in_out_status'] == 'Out') style="background-color:#fdb9ba" @else style="background-color:#f7f79c" @endif>
                                                <div class="cardmain_innerdashboardarea1">
                                                    <div class="row">
                                                        <div class="col-lg-3">
                                                            <div class="doctorscheimg">
                                                                <img src="public/assets/images/doc.png">
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-7">
                                                            <div class="doctorschetext">
                                                                <h3>{{ @$value['name'] }}</h3>
                                                                <h4 style="color: #a63030;">{{ @$value['avilable_time'] }}</h4>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-2">
                                                            @if(@$value['in_out_status'] == 'In')
                                                            <a href="#" class="btn btn-default btn-sm" data-placement="left" data-toggle="tooltip" title="Doctor Out"><i class="fa fa-arrow-alt-circle-left text-info"></i></a>
                                                            @else
                                                            <a href="#" data-placement="left" data-toggle="tooltip" title="Doctor Unavailable"><i class="fa fa-ban text-danger"></i></a>
                                                            @endif
                                                        </div>
                                                        <div class="col-lg-12">
                                                            <h4 style="color: #064009;font-size: 10px;text-transform: uppercase; margin-top: 9px;">{{ @$value['details'] }}</h4>
                                                        </div>
                                                        <div class="col-lg-12">
                                                            <h3 style="font-size:12px">
                                                                @if(@$value['in_out_details']->in_time !=  null)
                                                                IN {{ @$value['in_out_details']->in_time != null ? date('h:i A',strtotime($value['in_out_details']->in_time)) : '' }} -- OUT {{ @$value['in_out_details']->out_time != null ? date('h:i A',strtotime($value['in_out_details']->out_time)) : '' }}
                                                                @endif
                                                                &nbsp;&nbsp;&nbsp;
                                                                @if(@$value['in_out_status'] ==  'In')
                                                                    <span class="badge badge-gradient-success mt-2">IN</span>
                                                                @elseif(@$value['in_out_status'] ==  'Out')
                                                                    <span class="badge badge-gradient-primary mt-2">OUT</span>
                                                                @elseif(@$value['in_out_status'] ==  'Unavailable')
                                                                    <span class="badge badge-gradient-secondary mt-2">Unavailable</span>
                                                                @endif
                                                            </h3>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
<script>
    function update_data() {
        $.ajax({
            url: "{{route('get-count-data')}}",
            method: 'GET',
            success: function(response) {
                $('#opd-t').text(response.opd.total_patient);
                $('#opd-i').text(response.opd.income);
                $('#opd-n').text(response.opd.new_patient);
                $('#opd-o').text(response.opd.old_patient);

                $('#emergency-t').text(response.emergency.total_patient);
                $('#emergency-i').text(response.emergency.income);
                $('#emergency-n').text(response.emergency.new_patient);
                $('#emergency-o').text(response.emergency.old_patient);

                $('#ipd-t').text(response.ipd.total_patient);
                $('#ipd-i').text(response.ipd.income);
                $('#ipd-n').text(response.ipd.new_patient);
                $('#ipd-o').text(response.ipd.old_patient);

                $('#daycare-t').text(response.daycare.total_patient);
                $('#daycare-i').text(response.daycare.income);
                $('#daycare-n').text(response.daycare.new_patient);
                $('#daycare-o').text(response.daycare.old_patient);

                $('#investigation-t').text(response.investigation.total_patient);
                $('#investigation-i').text(response.investigation.income);
                $('#investigation-n').text(response.investigation.new_patient);
                $('#investigation-o').text(response.investigation.old_patient);

                $('#dialysis-t').text(response.dialysis.total_patient);
                $('#dialysis-i').text(response.dialysis.income);
                $('#dialysis-n').text(response.dialysis.new_patient);
                $('#dialysis-o').text(response.dialysis.old_patient);

                $('#nursery').text(response.nursery);
                $('#enquiry').text(response.enquiry);
            },
            error: function(xhr, status, error) {
                console.log('Error fetching data:', error);
            }
        });
    }
    $(document).ready(function() {
        update_data();
        setInterval(update_data, 30000);
    });
</script>
@endpush
