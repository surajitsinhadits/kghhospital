@extends('layouts.structure')
@push('title')
    <title>Call Details</title>
@endpush
@push('css')
@endpush
@section('main-content')

    <div class="row">
        <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12">
            <div class="card">
                <div class="card-header card_hearder_mimi justify-content-between">
                    <h4 class="card-title card_hearder_mimi_text">
                        CALL DETAILS
                    </h4>
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
                                                        <span class="font-weight-semibold w-50 text-blue">Department Name
                                                        </span>
                                                    </td>
                                                    <td class="py-2 px-5">{{ @$patient_details->department }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="py-2 px-0"><i class="fas fa-yin-yang text-danger"></i></td>
                                                    <td class="py-2 px-5">
                                                        <span class="font-weight-semibold w-50 text-blue">Appoinment Date
                                                        </span>
                                                    </td>
                                                    <td class="py-2 px-5">
                                                        {{ dateFor(@$patient_details->appointment_date, true) }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="py-2 px-0"><i class="fas fa-yin-yang text-danger"></i></td>
                                                    <td class="py-2 px-5">
                                                        <span class="font-weight-semibold w-50 text-blue">Phone no</span>
                                                    </td>
                                                    <td class="py-2 px-5">
                                                        <a href="tel:{{ @$patient_details->phone }}"
                                                            class="text-dark">{{ @$patient_details->phone }}</a>
                                                    </td>
                                                </tr>
                                                 <tr>
                                                    <td class="py-2 px-0"><i class="fas fa-yin-yang text-danger"></i></td>
                                                    <td class="py-2 px-5">
                                                        <span class="font-weight-semibold w-50 text-blue">Note</span>
                                                    </td>
                                                    <td class="py-2 px-5">
                                                        {{ @$patient_details->note }}
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
                                                        <span class="font-weight-semibold w-50 text-blue">Patient Name
                                                        </span>
                                                    </td>
                                                    <td class="py-2 px-5">
                                                        {{ @$patient_details->patient_name }}(UHID: {{ @$patient_details->patient_uhid ?? @$patient_details->patient_id }})
                                                    </td>
                                                </tr>
                                                <tr>
                                                    @php
                                                        $actionCode = $call_status->action ?? null;
                                                        $statusText = match ($actionCode) {
                                                            1 => 'Completed',
                                                            2 => 'Rescheduled',
                                                            3 => 'Cancelled',
                                                            default => 'Pending',
                                                        };

                                                        $statusColor = match ($statusText) {
                                                            'Completed' => 'color: green;',
                                                            'Rescheduled' => 'color: #0dcaf0;', 
                                                            'Cancelled' => 'color: red;',
                                                            'Pending' => 'color: orange;',
                                                        };

                                                        $statusLabel =
                                                            '<span style="font-weight: 700; font-size: 29px; ' .
                                                            $statusColor .
                                                            '">
                                                            Status: ' .
                                                            $statusText .
                                                            '</span>';
                                                    @endphp

                                                    <td class="py-2 px-5 text-center" colspan="3">
                                                        {!! $statusLabel !!}
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="card-body">
                        <form action="{{ route('callcenter.save-details',@$call_status->id) }}" method="POST">
                            @csrf
                            <div class="row">
                             <input type="hidden" name="cc_id" value="{{@$patient_details->id}}">
                                <div class="form-group col-md-6" id="remarks-field">
                                    <label>Remarks <span class="text-danger">*</span></label>
                                    <textarea class="form-control" name="remarks" rows="3">{{ old('remarks', $call_status->remarks ?? '') }}</textarea>
                                </div>
                                <div class="form-group col-md-2">
                                    <label>Last Call At <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control dateTimePickr" name="call_at"
                                        value="{{ old('call_at', @$call_status->call_at ? dateFor($call_status->call_at,true) : '') }}"
                                        required>
                                </div>
                                <div class="form-group col-md-2">
                                    <label>Action <span class="text-danger">*</span></label>
                                    <select class="form-control" name="action" required>
                                        <option value="">Select</option>
                                        <option value="1"
                                            {{ old('action', $call_status->action ?? '') == 1 ? 'selected' : '' }}>Completed
                                        </option>
                                        <option value="2"
                                            {{ old('action', $call_status->action ?? '') == 2 ? 'selected' : '' }}>
                                            Rescheduled</option>
                                        <option value="3"
                                            {{ old('action', $call_status->action ?? '') == 3 ? 'selected' : '' }}>
                                            Cancelled</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-2" id="reschedule-date-field" style="display: none;">
                                    <label>Reschedule Date <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control dateTimeStratPickr" name="reschedule_date"
                                        value="">
                                </div>
                            </div>
                             <div class="form-group col-md-2">
                                <button type="submit" class="btn btn-primary">Save</button>
                                <a href="{{ url()->previous() }}" class="btn btn-secondary">Cancel</a>
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
        document.addEventListener('DOMContentLoaded', function() {
            const actionSelect = document.querySelector('select[name="action"]');
            const rescheduleDateField = document.getElementById('reschedule-date-field');

            function toggleRescheduleDateField() {
                if (actionSelect.value === '2') {
                    rescheduleDateField.style.display = 'block';
                } else {
                    rescheduleDateField.style.display = 'none';
                }
            }

            // Initial load check
            toggleRescheduleDateField();

            // On change event
            actionSelect.addEventListener('change', toggleRescheduleDateField);
        });
    </script>
@endpush
