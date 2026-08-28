@extends('layouts.structure')
@push('title')
    <title>
        Patient Details</title>
@endpush
@push('css')
@endpush
@section('main-content')
    <?php
    if ($totalDue > 0) {
        $balance_amount =
            '<span style="font-weight: 900; font-size: 22px; color:red;">
                                                        DUE AMOUNT : ₹' .
            number_format($totalDue, 2) .
            '</span>';
        $color = '#ffcfcf';
    } else {
        $balance_amount = '<span style="font-weight: 900; font-size: 27px; color:rgb(4, 121, 9);">
                                                        Full Paid</span>';
        $color = '#b0ffb0';
    }
    ?>
    <div class="row">
        <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12">
            <div class="card">
                <div class="card-header card_hearder_mimi justify-content-between">
                    <h4 class="card-title card_hearder_mimi_text">
                        {{ @$patient_details->name }}
                        (UHID: {{ @$patient_details->uhid ?? @$patient_details->id }}) <i class="fa fa-check-circle text-warning"></i>
                    </h4>
                    <div>
                        <a href="{{ route('hr.patient-edit-details', ed($patient_details->id, true)) }}"
                            style="color:white;font-weight: 600;" class="btn btn-default btn-sm"><i class="fa fa-edit"></i>
                            EDIT</a>
                    </div>
                </div>
                <div class="card-body p-0" style="margin-bottom: 32px;">
                    <div class="card-body">
                        <div class="col-md-12">
                            <div class="row"
                                style="background-color: #dddddd;border: 2px solid #4689b1; border-radius: 15px; margin: 0px 0px 0px 0px;">
                                <div class="col-md-6 ">
                                    <div class="nw">
                                        <table class="table bordernone">
                                            <tbody>
                                                <tr>
                                                    <td class="py-2 px-0"><i class="fas fa-yin-yang text-danger"></i></td>
                                                    <td class="py-2 px-5">
                                                        <span class="font-weight-semibold w-50 text-blue">Gender </span>
                                                    </td>
                                                    <td class="py-2 px-5">{!! @$patient_details->gender !!}</td>
                                                </tr>
                                                <tr>
                                                    <td class="py-2 px-0"><i class="fas fa-yin-yang text-danger"></i></td>
                                                    <td class="py-2 px-5">
                                                        <span class="font-weight-semibold w-50 text-blue">Age </span>
                                                    </td>
                                                    <td class="py-2 px-5">
                                                        @if (@$patient_details->dob_year != null)
                                                            {{ @$patient_details->dob_year }}Y
                                                        @endif
                                                        @if (@$patient_details->dob_month != null)
                                                            {{ @$patient_details->dob_month }}M
                                                        @endif
                                                        @if (@$patient_details->dob_day != null)
                                                            {{ @$patient_details->dob_day }}D
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="py-2 px-0"><i class="fas fa-yin-yang text-danger"></i></td>
                                                    <td class="py-2 px-5">
                                                        <span class="font-weight-semibold w-50 text-blue">Phone no </span>
                                                    </td>
                                                    <td class="py-2 px-5">{{ @$patient_details->phone }}
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="col-md-6 ">
                                    <div class="nw">
                                        <table class="table bordernone">
                                            <tbody>
                                                <tr>
                                                    <td class="py-2 px-0"><i class="fas fa-yin-yang text-danger"></i></td>
                                                    <td class="py-2 px-5">
                                                        <span class="font-weight-semibold w-50 text-blue">Address </span>
                                                    </td>
                                                    <td class="py-2 px-5">
                                                        {!! @$patient_details->address !!} @if (@$patient_details->_state->name)
                                                            ,{!! @$patient_details->_district->name !!},{!! @$patient_details->_state->name !!},{!! @$patient_details->pin_no !!}
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    @if (@$patient_details->identification_number != null)
                                                        <td class="py-2 px-0"><i class="fas fa-yin-yang text-danger"></i>
                                                        </td>
                                                        <td class="py-2 px-5">
                                                            <span class="font-weight-semibold w-50 text-blue">Aadhar Card No
                                                                : </span>
                                                        </td>
                                                        <td class="py-2 px-5">{{ @$patient_details->identification_number }}
                                                        </td>
                                                    @endif
                                                </tr>
                                                <tr>
                                                    <td class="py-2 px-5 text-center" colspan="3">
                                                        {!! @$balance_amount !!}</br>
                                                        @if (@$credit_amount)
                                                            <span style="color: green;">{!! 'Credit Amount: ' . @$credit_amount !!}</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tbtable mt-2">
                        <div class="tab-teaser">
                            <div class="tab-menu">
                                <ul>
                                    <?php $actv = 'active'; ?>
                                    @if (@$opd_enquiry[0]->id != null)
                                        <li><a href="#" class="{{ @$actv }}" data-rel="tab-1">APPOINTMENT</a>
                                        </li>
                                        <?php $actv = ''; ?>
                                    @endif

                                    @if (@$opd_details[0]->id != null)
                                        <li><a href="#" data-rel="tab-2" class="{{ @$actv }}">OPD</a></li>
                                        <?php $actv = ''; ?>
                                    @endif

                                    @if (@$emg_details[0]->id != null)
                                        <li><a href="#" data-rel="tab-3" class="{{ @$actv }}">EMG</a></li>
                                        <?php $actv = ''; ?>
                                    @endif

                                    @if (@$ipd_details[0]->id != null)
                                        <li><a href="#" data-rel="tab-4" class="{{ @$actv }}">IPD</a></li>
                                        <?php $actv = ''; ?>
                                    @endif

                                    @if (@$daycare_details[0]->id != null)
                                        <li><a href="#" data-rel="tab-5" class="{{ @$actv }}">DAY-CARE</a>
                                        </li>
                                        <?php $actv = ''; ?>
                                    @endif

                                    {{-- @if (@$bill_details[0]->id != null)
                                <li><a href="#" data-rel="tab-7" class="{{ @$actv }}">BILL</a></li>
                                <?php $actv = ''; ?>
                                @endif --}}

                                    @if (@$receipt_details[0]->id != null)
                                        <li><a href="#" data-rel="tab-8" class="{{ @$actv }}">RECEIPT</a></li>
                                        <?php $actv = ''; ?>
                                    @endif

                                    @if (@$refund_details[0]->id != null)
                                        <li><a href="#" data-rel="tab-9" class="{{ @$actv }}">REFUND</a></li>
                                        <?php $actv = ''; ?>
                                    @endif

                                    @if (@$emr_details[0]->id != null)
                                    <li><a href="#" data-rel="tab-12" class="{{ @$actv }}">Medical
                                            Record</a></li>
                                    <?php $actv = ''; ?>
                                    @endif

                                    {{-- <li><a href="#" data-rel="tab-11" class="{{ @$actv }}">NOTE</a></li> --}}
                                </ul>
                            </div>
                            <div class="tab-main-box">
                                <?php $show = true; ?>
                                @if (@$opd_enquiry[0]->id != null)
                                    <div class="tab-box" id="tab-1"
                                        @if (@$show) style="display:block;" @endisset >
                                    <div class="text-right mb-2" >
                                    </div>
                                    <div class="table-responsive ">
                                    <table
                                        class="table table-bordered text-nowrap key-buttons border-left border-right border-bottom">
                                        <thead class="bg-primary text-white">
                                            <tr class="border-left">
                                                <th class="text-white">Sl. No</th>
                                                <th class="text-white">Enq No.</th>
                                                <th class="text-white">App. Date & time</th>
                                                <th class="text-white">Doctor</th>
                                                <th class="text-white">#</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($opd_enquiry as $value)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>
                                                        {{ @$value->id }}
                                                    </td>
                                                    <td>
                                                         {{ @$item->appointment_date ? dateFor($item->appointment_date) : '' }} -
                                                        {{ @$item->appointment_time ? timeFor($item->appointment_time) : '' }}
                                                    </td>
                                                    <td>
                                                        {{ @$value->salutation }}
                                                        {{ @$value->name }}
                                                    </td>
                                                    <td>
                                                        @if ($value->is_register == '1')
                                                            <span class="badge badge-gradient-success mt-2">OPD Registered</span>
                                                        @else
                                                            <span class="badge badge-gradient-secondary mt-2">OPD Not Registered</span> @endif
                                        </td>
                                        </tr>
                                @endforeach
                                </tbody>
                                </table>
                            </div>
                        </div>
                        <?php $show = false; ?>
                        @endif

                        @if (@$opd_details[0]->id != null)
                            <div class="tab-box" id="tab-2"
                                @if (@$show) style="display:block;" @endisset >
                                <div class="text-right mb-2" >
                                </div>
                                <div class="table-responsive ">
                                    <table class="table table-bordered text-nowrap key-buttons border-left border-right border-bottom">
                                        <thead class="bg-primary text-white">
                                            <tr class="border-left">
                                                <th class="text-white">Sl No.</th>
                                                <th class="text-white">OPD Id</th>
                                                <th class="text-white">Bill Id</th>
                                                <th class="text-white">Appointment Date</th>
                                                <th class="text-white">Department</th>
                                                <th class="text-white">Doctor</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($opd_details as $value)
                                            <?php
                                            if (@$value->due_amount > 0) {
                                                $balance_amount = '<span style="font-weight: 900;font-size: 22px;color:red">DUE AMOUNT : ₹' . abs(round(@$value->due_amount, 2)) . '</span>';
                                                $color = '#ffcfcf';
                                            } else {
                                                $balance_amount = '<span  style="font-weight: 900;font-size: 27px;color:rgb(4, 121, 9)">Full Paid</span>';
                                                $color = '#b0ffb0';
                                            }

                                            if (@$value->cradit_amount > 0) {
                                                $amount_details = '<span class="badge badge-gradient-primary mt-2">Credit Amount : ₹' . abs(round(@$value->cradit_amount, 2)) . ' </span>';
                                            } elseif (@$value->due_amount > 0) {
                                                $amount_details = '<span class="badge badge-gradient-secondary mt-2">Due Amount : ₹' . abs(round(@$value->due_amount, 2)) . ' </span>';
                                            } else {
                                                $amount_details = '<span class="badge badge-gradient-success mt-2">No Due </span>';
                                            }
                                            ?>

                                                <tr style="background-color:{{ @$color }}">
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td> <a target="_blank" data-placement="left" data-toggle="tooltip" title="Click here"
                                                        style="cursor: pointer !important"  href="#" >{{ @$value->id }}</a>
                                                    </td>
                                                    <td>
                                                        <a  href="{{ route('bill.billing-details', ['emg', ed(@$value->billing_id, true)]) }}" data-placement="top" data-toggle="tooltip"
                                                        title="Click here to show bill details">
                                                        {{ @$value->uid }}</a> <br>
                                                        @if ($value->bill_status == 3)
                                                        <span class="badge badge-gradient-secondary mt-2">Cancel Bill</span> @endif
                                {!! $amount_details !!} </td>
                                <td> {{ dateFor($value->appointment_date, true) }}</td>
                                <td>
                                    {{ @$value->department_name }}
                                </td>
                                <td>
                                    {{ @$value->doctor_name }}
                                </td>
                                </tr>
                        @endforeach
                        </tbody>
                        </table>
                    </div>
                </div>
                <?php $show = false; ?>
                @endif

                @if (@$emg_details[0]->id != null)
                    <div class="tab-box" id="tab-3"
                        @if (@$show) style="display:block;" @endisset>
                                <div class="table-responsive ">
                                    <table
                                        class="table table-bordered text-nowrap key-buttons border-left border-right border-bottom">
                                        <thead class="bg-primary text-white">
                                            <tr class="border-left">
                                                <th class="text-white">Sl No.</th>
                                                <th class="text-white">EMG Id</th>
                                                <th class="text-white">Bill Id</th>
                                                <th class="text-white">Appointment Date</th>
                                                <th class="text-white">Department</th>
                                                <th class="text-white">Doctor</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($emg_details as $value)
                                                <?php
                                                if (@$value->due_amount > 0) {
                                                    $balance_amount = '<span style="font-weight: 900;font-size: 22px;color:red">DUE AMOUNT : ₹' . abs(round(@$value->due_amount, 2)) . '</span>';
                                                    $color = '#ffcfcf';
                                                } else {
                                                    $balance_amount = '<span  style="font-weight: 900;font-size: 27px;color:rgb(4, 121, 9)">Full Paid</span>';
                                                    $color = '#b0ffb0';
                                                }

                                                if (@$value->cradit_amount > 0) {
                                                    $amount_details = '<span class="badge badge-gradient-primary mt-2">Credit Amount : ₹' . abs(round(@$value->cradit_amount, 2)) . ' </span>';
                                                } elseif (@$value->due_amount > 0) {
                                                    $amount_details = '<span class="badge badge-gradient-secondary mt-2">Due Amount : ₹' . abs(round(@$value->due_amount, 2)) . ' </span>';
                                                } else {
                                                    $amount_details = '<span class="badge badge-gradient-success mt-2">No Due </span>';
                                                }
                                                ?>
                                                <tr style="background-color:{{ @$color }}">
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>
                                                        <a data-placement="left" data-toggle="tooltip" title="Click here" style="cursor: pointer !important"  href="#">{{ @$value->id }}</a>
                                                    </td>
                                                    <td>
                                                        <a  href="{{ route('bill.billing-details', ['emg', ed(@$value->billing_id, true)]) }}" data-placement="top" data-toggle="tooltip" title="Click here to show bill details">
                                                            {{ @$value->uid }}</a> <br>
                                                        @if ($value->bill_status == 3)
                                                        <span class="badge badge-gradient-secondary mt-2">Cancel Bill</span> @endif
                        {!! $amount_details !!} </td>
                        <td>
                            {{ dateFor($value->appointment_date, true) }}
                        </td>
                        <td>
                            {{ @$value->department_name }}
                        </td>
                        <td>
                            {{ @$value->doctor_name }}
                        </td>
                        </tr>
                @endforeach
                </tbody>
                </table>
            </div>
        </div>
        <?php $show = false; ?>
        @endif

        @if (@$ipd_details[0]->id != null)
            <div class="tab-box" id="tab-4"
                @if (@$show) style="display:block;" @endisset>
                                <div class="text-right mb-2" >
                                </div>
                                <div class="table-responsive ">
                                    <table
                                        class="table table-bordered text-nowrap key-buttons border-left border-right border-bottom">
                                        <thead class="bg-primary text-white">
                                            <tr class="border-left">
                                                <th class="text-white">Sl No.</th>
                                                <th class="text-white">IPD Id</th>
                                                <th class="text-white">Admission Date</th>
                                                <th class="text-white">Department</th>
                                                <th class="text-white">Doctor</th>
                                                <th class="text-white">Bed</th>
                                                <th class="text-white">Discharged Date</th>
                                                <th class="text-white">Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($ipd_details as $value)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td><a data-placement="left" data-toggle="tooltip" title="Click here"
                                                        href="{{ route('ipd.ipd-info', ed(@$value->id, true)) }}">{{ @$value->id }}</a></td>
                                                    <td>{{ dateFor($value->admission_date, true) }}</td>
                                                    <td>
                                                        {{ @$value->department_name }}
                                                    </td>
                                                    <td>
                                                        {{ @$value->doctor_name }}
                                                    </td>
                                                    <td>
                                                        @if (isset($value->ward_id))
                                                            {{ @$value->bed_name }}( {{ @$value->ward_name }} ) @endif
                </td>
                <td>
                    {{ @$value->discharge_at ? dateFor(@$value->discharge_at, true) : '' }}
                </td>
                <td>
                    {!! @$value->discharge_at
                        ? '<span class="badge badge-danger">Discharged</span>'
                        : ' <span class="badge badge-success">Admitted</span>' !!}
                </td>
                </tr>
        @endforeach
        </tbody>
        </table>
    </div>
    </div>
    <?php $show = false; ?>
    @endif

    @if (@$daycare_details[0]->id != null)
        <div class="tab-box" id="tab-5"
            @if (@$show) style="display:block;" @endisset>
                                <div class="text-right mb-2"  >
                                </div>
                                <div class="table-responsive ">
                                    <table
                                        class="table table-bordered text-nowrap key-buttons border-left border-right border-bottom">
                                        <thead class="bg-primary text-white">
                                            <tr class="border-left">
                                                <th class="text-white">Sl No.</th>
                                                <th class="text-white">DayCare Id</th>
                                                <th class="text-white">Admission Date</th>
                                                <th class="text-white">Department</th>
                                                <th class="text-white">Doctor</th>
                                                <th class="text-white">Bed</th>
                                                <th class="text-white">Discharged Date</th>
                                                <th class="text-white">Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($daycare_details as $value)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td><a data-placement="left" data-toggle="tooltip" title="Click here"
                                                            href="{{ route('ipd.ipd-info', ed(@$value->id, true)) }}" >{{ @$value->id }}</a></td>
                                                    <td>{{ dateFor($value->admission_date, true) }}</td>
                                                    <td>
                                                        {{ @$value->department_name }}
                                                    </td>
                                                    <td>
                                                        {{ @$value->doctor_name }}</td>
                                                    <td>
                                                        @if (isset($value->ward_id))
                                                        {{ @$value->bed_name }}( {{ @$value->ward_name }} ) @endif
            </td>
            <td>
                {{ @$value->discharge_at ? dateFor($value->discharge_at, true) : '' }}
            </td>
            <td>
                {!! @$value->discharge_at
                    ? '<span class="badge badge-danger">Discharged</span>'
                    : ' <span class="badge badge-success">Admitted</span>' !!}
            </td>
            </tr>
    @endforeach
    </tbody>
    </table>
    </div>
    </div>
    <?php $show = false; ?>
    @endif

    @if (@$bill_details[0]->id != null)
        <div class="tab-box" id="tab-7"
            @if (@$show) style="display:block;" @endisset>
                                <div class="text-right mb-2" >
                                </div>
                                <div class="table-responsive ">
                                    <table class="table table-bordered text-nowrap key-buttons border-left border-right border-bottom">
                                        <thead class="bg-primary text-white">
                                            <tr class="border-left">
                                                <th class="text-white">Sl No.</th>
                                                <th class="text-white">Bill Id</th>
                                                <th class="text-white">Bill Date</th>
                                                <th class="text-white">Section</th>
                                                <th class="text-white">Bill Amount(₹)</th>
                                                <th class="text-white">Due(₹)</th>
                                                <th class="text-white">Credit(₹)</th>
                                                {{-- <th class="text-white">Refund/Adjustment</th> --}}
                                                <th class="text-white">Paid Amount(₹)</th>
                                                <th class="text-white">Status</th>
                                                <th class="text-white">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $total = 0; ?>
                                            @foreach ($bill_details as $value)
                                            <?php $total += $value->grand_total; ?>
                                                <?php
                                                $color = '#caffc4';
                                                if ($value->cradit_amount > 0) {
                                                    $color = '#cedfff';
                                                }
                                                if ($value->due_amount > 0) {
                                                    $color = '#ffcece';
                                                }
                                                ?>
                                                <tr style="background-color: {{ @$color }}">
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>
                                                        @if ($value->section == 'OPD')
                                                            <a href="{{ route('bill.billing-details', ['opd', ed($value->id, true)]) }}">{{ $value->uid }}</a>
                                                        @elseif($value->section == 'EMG')
                                                            <a href="{{ route('bill.billing-details', ['emg', ed($value->id, true)]) }}" >{{ $value->uid }}</a>
                                                        @elseif($value->section == 'IPD')
                                                            <a href="{{ route('bill.billing-details', ['ipd', ed($value->id, true)]) }}" >{{ $value->uid }}</a>
                                                        @elseif($value->section == 'DAYCARE')
                                                            <a href="{{ route('bill.billing-details', ['ipd', ed($value->id, true)]) }}" >{{ $value->uid }}</a>
                                                        @else
                                                            <a href="{{ route('bill.billing-details', ['investigation', ed($value->id, true)]) }}" >{{ $value->uid }}</a> @endif
            </td>
            <td>
                {{ dateFor($value->bill_date, true) }}
            </td>
            <td>
                <span class="badge badge-gradient-success mt-2"> {{ @$value->section }} </span>
            </td>
            <td>
                {{ $value->grand_total }}
            </td>
            <td>
                {{ @$value->due_amount }}
            </td>
            <td>
                {{ @$value->cradit_amount }}
            </td>
            {{-- <td>
                                                        {{ @$value->credit_amount_used_in_another_bill > 0 ? 'Adjust in bill : '.$value->credit_amount_used_in_another_bill : '' }}<br>
                                                        {{ @$value->credit_amount_refund > 0 ? 'Refund : '.$value->credit_amount_refund : '' }}
                                                    </td> --}}
            <td>{{ @$value->total_payment }}</td>

            <td>
                @if ($value->status == 'Done')
                    <span class="badge badge-gradient-primary mt-2">{{ @$value->status }}</span>
                @else
                    <span class="badge badge-gradient-secondary mt-2">{{ @$value->status }}</span>
                @endif
            </td>
            <td>
                @if ($value->section == 'IPD')
                    <a class="btn btn-primary btn-sm" target="_blank"
                        href="{{ route('bill.billing-details', ['ipd', ed($value->id, true)]) }}"><i class="fa fa-eye"></i>
                    </a>
                @elseif($value->section == 'DAYCARE')
                    <a class="btn btn-primary btn-sm" target="_blank"
                        href="{{ route('bill.billing-details', ['ipd', ed($value->id, true)]) }}"><i
                            class="fa fa-eye"></i>
                    </a>
                @else
                    <a class="btn btn-primary btn-sm" target="_blank"
                        href="{{ route('bill.billing-details', [strtolower($value->section), ed($value->id, true)]) }}"><i
                            class="fa fa-eye"></i> </a>
                @endif
            </td>
            </tr>
    @endforeach
    <div class="text-left">
        <span style="color:rgb(24, 146, 0);font-weight:700;font-size:22px">Total : ₹{{ @$total }}</span>
    </div>
    </tbody>
    </table>
    </div>
    </div>
    <?php $show = false; ?>
    @endif

    @if (@$receipt_details[0]->id != null)
        <div class="tab-box" id="tab-8"
            @if (@$show) style="display:block;" @endisset>
                                <div class="text-right mb-2" >
                                </div>
                                <div class="table-responsive ">
                                    <table
                                        class="table table-bordered text-nowrap key-buttons border-left border-right border-bottom">
                                        <thead class="bg-primary text-white">
                                            <tr class="border-left">
                                                <th class="text-white">Sl. No</th>
                                                <th class="text-white">Payment Id</th>
                                                <th class="text-white">Section</th>
                                                <th class="text-white">Date</th>
                                                <th class="text-white">Amount(₹)</th>
                                                <th class="text-white">Received By</th>
                                                <th class="text-white">Payment Mode</th>
                                                <th class="text-white">#</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $total = 0; ?>
                                            @foreach ($receipt_details as $item)
                                            <?php $total += $item->payment_amount; ?>
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>
                                                        R{{ $item->id }}
                                                    </td>
                                                    <td>
                                                        <span class="badge badge-gradient-primary mt-2">{{ $item->section }}</span>
                                                    </td>
                                                    <td>
                                                        {{ dateFor($item->payment_date, true) }}
                                                    </td>
                                                    <td>
                                                        {{ $item->payment_amount }}
                                                    </td>
                                                    <td>
                                                        {{ @$item->payment_recived_by_name }}
                                                    </td>
                                                    <td>
                                                        {{ @$item->payment_mode }}{{ @$item->payment_mode == 'Cash' ? '' : ' - ' . $item->payment_bank }}
                                                    </td>
                                                    <td>
                                                        <a class="" target="_blank" data-placement="left" data-toggle="tooltip" title="Print Receipt" href="{{ route('bill.print-payment-receipt', [ucwords(strtolower($item->section)), ed($item->id, true)]) }}"><i class="fa fa-print"></i></a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                            <div class="text-left">
                                                <span style="color:rgb(24, 146, 0);font-weight:700;font-size:22px">Total : ₹{{ @$total }}</span>
                                            </div>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <?php $show = false; ?> @endif
            @if (@$refund_details[0]->id != null) <div class="tab-box" id="tab-9" @if (@$show) style="display:block;" @endisset>
                                <div class="text-right mb-2"  >
                                </div>
                                <div class="table-responsive ">
                                    <table
                                        class="table table-bordered text-nowrap key-buttons border-left border-right border-bottom">
                                        <thead class="bg-primary text-white">
                                            <tr class="border-left">
                                                <th class="text-white">Refund Id</th>
                                                <th class="text-white">From Bill</th>
                                                <th class="text-white">Date</th>
                                                <th class="text-white">Amount(₹)</th>
                                                <th class="text-white">Refund By</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $total = 0; ?>
                                            @foreach ($refund_details as $item)
                                            <?php $total += $item->refund_amount; ?>
                                                <tr>
                                                    <td class="sorting_1">
                                                        RF{{ $item->refund_id }}
                                                        <span class="badge badge-gradient-primary">{{ $item->section }}</span>
                                                        {!! $item->is_cancel == 1 ? '<span class="badge badge-danger">Cancelled</span>' : '' !!}
                                                    </td>
                                                    <td>{{ $item->uid }}</td>
                                                    <td>{{ dateFor($item->refund_at, true) }}</td>
                                                    <td>{{ $item->refund_amount }}</td>
                                                    <td>{{ $item->refund_name }}</td>
                                                </tr>
                                            @endforeach
                                            <div class="text-left">
                                                <span style="color:rgb(24, 146, 0);font-weight:700;font-size:22px">Total : ₹{{ @$total }}</span>
                                            </div>
                                        </tbody>
                                    </table>
                                </div>
                            </div> @endif
            {{-- <div class="tab-box" id="tab-11"
            @if (@$show) style="display:block;" @endisset>
                                <div class="col-xl-12 col-lg-12 col-md-12">
                                    <a data-target="#modaldemo1" data-toggle="modal" href="#" class="btn btn-primary btn-sm text-right"><i class="fa fa-file"></i> <b>New Note</b></a>
                                    <div class="ex3 mt-3">
                                        <div class="latest-timeline scrollbar3 mt-3" id="scrollbar3">
                                            <ul class="timeline mb-0">
                                                @if (@$note_details[0]->id != null)
                                                @foreach ($note_details as $item)
                                                <li class="mt-0">
                                                    <div class="d-flex"><span class="time-data">{{ $item->title }}</span><span class="ml-auto text-muted fs-11">
                                                           {{ dateFor($item->created_at) }}
                                                            <a href="{{ route('hr.patient-note-delete', ed($item->id, true)) }}"> <i class="fa fa-trash ml-2"></i> Delete</a>
                                                        </span></div>
                                                    <p class="text-muted fs-12"> {!! $item->note !!}</p>
                                                    @if (!empty($item->p_document))
                                                    <a href="{{ asset('public/assets/images/patientdocument/' . $item->p_document) }}"
                                                    class="btn btn-sm btn-outline-success mt-1"
                                                    target="_blank" download>
                                                        <i class="fa fa-download"></i> Download
                                                    </a> @endif
            </li>
    @endforeach
    @endif
    </ul>
    </div>
    </div>
    </div>
    </div> --}}


<div class="tab-box" id="tab-12" @if (@$show) style="display:block;" @endif>
    @foreach(@$emr_details as $data)

@php

    $vitals = json_decode($data->vitals);
    // dd($vitals);
    $complaints =  json_decode($data->complaints);
    $diagnosis =  json_decode($data->diagnosis);
    $medicines =  json_decode($data->medicines);
    $tests = json_decode($data->test_name);
   // dd($tests)

@endphp
    <div class="col-xl-12 col-lg-12 col-md-12">

        <div class="ex3 mt-3">
            {{-- <div class="card shadow-sm rounded-3 p-4 mb-4"> --}}
                <h4 class="mb-3 text-primary">{{ $data->section == 'opd' ? 'OPD' : 'EMG' }} - {{ \Carbon\Carbon::parse($data->date)->format('d M Y, h:i A') }}</h4>

                <!-- Vitals -->
                <div class="mb-4">
                    <h5 class="text-success">Vitals</h5>
                    <table class="table table-bordered table-sm">
                        <thead class="table-light">
                            <tr>
                                <th>Height</th>
                                <th>Weight</th>
                                <th>Pulse</th>
                                <th>BP</th>
                                <th>Temperature</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($vitals ?? [] as $vital)
                                <tr>
                                    <td>{{ $vital->height ?? '-' }}</td>
                                    <td>{{ $vital->weight ?? '-' }}</td>
                                    <td>{{ $vital->pulse ?? '-' }}</td>
                                    <td>{{ $vital->bp_systolic ?? '-' }}/{{ $vital->bp_diastolic ?? '-' }}</td>
                                    <td>{{ $vital->temperature ?? '-' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Complaints -->
                <div class="mb-4">
                    <h5 class="text-success">Complaints</h5>
                     <table class="table table-bordered table-sm">
                        <thead class="table-light">
                            <tr>
                                <th>Complaint</th>
                                <th>Frequency</th>
                                <th>Severity</th>
                                <th>Duration</th>
                                <th>Date</th>

                            </tr>
                        </thead>
                        <tbody>
                           @foreach ($complaints ?? [] as $item)
                                <tr>
                                    <td>{{ $item->complaints ?? '-' }}</td>
                                    <td>{{ $item->frequency ?? '-' }}</td>
                                    <td>{{ $item->severity ?? '-' }}</td>
                                    <td>{{ $item->duration ?? '-' }}</td>
                                    <td>{{ $item->complaints_date ?? '-' }}</td>

                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Diagnosis -->
                <div class="mb-4">
                    <h5 class="text-success">Diagnosis</h5>
                     <table class="table table-bordered table-sm">
                        <thead class="table-light">
                            <tr>
                                <th>Diagnosis</th>
                                <th>Duration</th>
                                <th>Date</th>


                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($diagnosis ?? [] as $item)
                                <tr>
                                    <td>{{ $item->diagnosis ?? '-' }}</td>
                                    <td>{{ $item->diagnosis_duration ?? '-' }}</td>
                                    <td>{{ $item->diagnosis_date ?? '-' }}</td>


                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>

                <!-- Medicines -->
                <div class="mb-4">
                    <h5 class="text-success">Medicines</h5>
                    <table class="table table-bordered table-sm">
                        <thead class="table-light">
                            <tr>
                                <th>Composition</th>
                                <th>Medicine</th>
                                <th>Dose</th>
                                <th>When</th>
                                <th>Frequency</th>
                                <th>Duration</th>
                                <th>Notes</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($medicines ?? [] as $med)
                                <tr>
                                    <td>{{ $med->composition ?? '-' }}</td>
                                    <td>{{ $med->medicine ?? '-' }}</td>
                                    <td>{{ $med->dose ?? '-' }}</td>
                                    <td>{{ $med->when ?? '-' }}</td>
                                    <td>{{ $med->frequency ?? '-' }}</td>
                                    <td>{{ $med->medicine_duration ?? '-' }}</td>
                                    <td>{{ $med->notes_instructions ?? '-' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Test Needed -->
                <div class="mb-4">
                    <h5 class="text-success">Test Needed</h5>
                    <ul class="list-group">
                        {{-- @foreach ($tests ?? [] as $test) --}}
                            {{-- <li class="list-group-item">{{ $test ?? '-' }}</li> --}}
                           {{ collect($tests ?? [])->implode(',   ') ?: '-' }}
                        {{-- @endforeach --}}
                        {{-- {{ collect($tests ?? [])->pluck('tests')->filter()->implode(', ') ?: '-' }} --}}
                    </ul>
                </div>

                <!-- Advice -->
                <div class="mb-4">
                    <h5 class="text-success">Advice</h5>
                    <div class="border rounded p-3 bg-light">
                        {!! $data->advice ?? 'No advice given.' !!}
                    </div>
                </div>
            {{-- </div> --}}
        </div>

    </div>
    @endforeach
</div>



        </div>
        </div>
        </div>
        </div>
        </div>
        </div>
        </div>
        <div class="modal" id="modaldemo1">
            <div class="modal-dialog" style="width: 700px" role="document">
                <div class="modal-content modal-content-demo">
                    <div class="modal-header">
                        <h6 class="modal-title">Note / Attachment</h6><button aria-label="Close" class="close"
                            data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <form action="{{ route('hr.patient-note-add') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="patient_id" value="{{ @$patient_details->id }}" />
                        <div class="modal-body">
                            <div class="row mt-3">
                                <div class="col-md-6">
                                    <label class="text-blue">Title</label>
                                    <input name="title" type="text" required />
                                </div>
                                <div class="col-md-6">
                                    <label class="text-blue">Document</label>
                                    <input name="p_document" type="file" accept=".pdf,.doc,.docx" />
                                </div>
                                <div class="col-md-12 mt-5">
                                    <label class="text-blue">Note</label>
                                    <textarea class="ckeditor" name="note" required></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-indigo" type="submit">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endsection
    @push('js')
        <script>
            $('.tab-menu li a').on('click', function() {
                var target = $(this).attr('data-rel');
                $('.tab-menu li a').removeClass('active');
                $(this).addClass('active');
                $("#" + target).fadeIn('slow').siblings(".tab-box").hide();
                return false;
            });
        </script>
        <script src="//cdn.ckeditor.com/4.14.0/standard/ckeditor.js"></script>

        <script type="text/javascript">
            $(document).ready(function() {

                $('.ckeditor').ckeditor();

            });
        </script>
    @endpush
