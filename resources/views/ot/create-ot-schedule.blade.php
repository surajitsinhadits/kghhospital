@extends('layouts.structure')
@push('title')
    <title>OT Schedule</title>
@endpush
@push('css')
@endpush
@section('main-content')
    <div class="row">
        <div class="card ">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3 leftside_fixarea">
                        <x-billbar section="ot" id="{{ $ot_surgical_request->ot_reg_id }}" type="sec" />
                    </div>
                    <form action="{{ @$edit_schedule ? route('ot.update-ot-schedule') : route('ot.save-ot-schedule') }}"
                        method="POST">
                        @csrf
                        <input type="hidden" name="ot_reg_id" value="{{ $ot_surgical_request->ot_reg_id }}">
                        <input type="hidden" name = "ot_surg_req_id" value="{{ $ot_surgical_request->id }}">
                        <input type="hidden" name = "patient_id" value="{{ $ot_surgical_request->patient_id }}">
                        <input type="hidden" name = "ot_preparation_id" value="{{ $ot_preparation->id }}">
                        <input type="hidden" name = "ot_name" value="{{ $ot_registration->operation_name }}">
                        <input type="hidden" name = "schedule_id" value="{{ @$edit_schedule->id }}">


                        <div class="col-md-9 rightside_fixarea">
                            <h3><u>OT Scheduling Confirmation</u></h3>
                            {{-- style="border:none !important" --}}
                            <div class="row ">

                                <div class="form-group col-md-2">
                                    <label for="doctor">OT Room<span class="text-danger">*</span></label>
                                    <select name="ot_room" class="form-control select2-show-search" id="ot_room">
                                        <option value="">Select</option>
                                        @foreach ($ot_rooms as $data)
                                            <option
                                                value="{{ $data->id }}" {{ old('ot_room', (@$edit_schedule->ot_room) ? @$edit_schedule->ot_room : $ot_surgical_request->ot_room) == $data->id ? 'selected' : '' }}>
                                                {{ $data->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('ot_room')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="form-group col-md-2 ">
                                    <label class="date-format">Proposed OT Date <span class="text-danger">*</span></label>
                                    <input type="text" name="ot_date" id="proposed_date" class="form-control datePickr"
                                        value="{{ old('ot_date', @$edit_schedule ? dateFor(@$edit_schedule->ot_date) : dateFor(@$ot_surgical_request->proposed_ot_date)) }}">
                                    @error('ot_date')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="form-group col-md-2">
                                    <label class="date-format">From Time <span class="text-danger">*</span></label>
                                    <input type="text" name="from_time" id="from_time" class="form-control timePickr"
                                        value="{{ old('from_time', @$edit_schedule ? @$edit_schedule->from_time : @$ot_surgical_request->from_time) }}">
                                    @error('from_time')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="form-group col-md-2">
                                    <label class="date-format">To Time <span class="text-danger">*</span></label>
                                    <input type="text" name="to_time" id="to_time" class="form-control timePickr"
                                        value="{{ old('to_time', @$edit_schedule ? @$edit_schedule->to_time : @$ot_surgical_request->to_time) }}">
                                    @error('to_time')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Flags</label><br>
                                    <div class="form-check form-check-inline">
                                        <input class="mr-1" type="checkbox" name="flags[]" value="Emergency"
                                            {{ in_array('Emergency', explode(',', @$edit_schedule->flags ?? '')) ? 'checked' : '' }}>
                                        <label class="form-check-label">Emergency</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="mr-1" type="checkbox" name="flags[]" value="Pediatric"
                                            {{ in_array('Pediatric', explode(',', @$edit_schedule->flags ?? '')) ? 'checked' : '' }}>
                                        <label class="form-check-label">Pediatric</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="mr-1" type="checkbox" name="flags[]" value="High-Risk"
                                            {{ in_array('High-Risk', explode(',', @$edit_schedule->flags ?? '')) ? 'checked' : '' }}>
                                        <label class="form-check-label">High-Risk</label>
                                    </div>
                                </div>

                                <div class="form-group col-md-3">
                                    <label for="department">Department <span class="text-danger">*</span></label>
                                    <select name="department_id" class="form-control select2-show-search" id="department_id"
                                        onchange="getDoctor(this.value)">
                                        <option value="">All</option>
                                        @foreach ($department as $data)
                                            <option value="{{ $data->id }}"
                                                {{ $data->id == old('department_id', (@$edit_schedule->deft_id) ? @$edit_schedule->deft_id : @$ot_surgical_request->department) ? 'selected' : '' }}>
                                                {{ $data->department_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('department_id')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="form-group col-md-3">
                                    <label for="doctor">Surgent Name</label>
                                    <select name="surgeon_name[]" class="form-control select2-show-search" id="surgeon_name"
                                        multiple>
                                        <option value="">Select</option>
                                    </select>
                                    @error('surgeon_name')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="form-group col-md-3">
                                    <label for="doctor">Anaesthetist Name</label>
                                    <select name="anaesthetist_name[]" class="form-control select2-show-search"
                                        id="anaesthetist_name" multiple>
                                        <option value="">Select</option>
                                    </select>
                                    @error('anaesthetist_name')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>



                                <div class="form-group col-md-3">
                                    <label for="doctor">Nurse</label>
                                    <select name="nurse_name[]" class="form-control select2-show-search" id="nurse_name"
                                        multiple>
                                        @foreach ($nurse as $data)
                                            <option value="{{ $data->id }}"
                                                {{ in_array($data->id, @$edit_schedule ? explode(',', @$edit_schedule->nurse_id ?? '') : explode(',', $ot_surgical_request->nurse ?? '')) ? 'selected' : '' }}>
                                                {{ $data->salutation }} {{ $data->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('nurse_name')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>


                                <div class="form-group col-md-3">
                                    <label for="doctor">OT Technician</label>
                                    <select name="ot_technician[]" class="form-control select2-show-search"
                                        id="ot_technician" multiple>
                                        @foreach ($ot_technician as $data)
                                            <option value="{{ $data->id }}"
                                                {{ in_array($data->id, @$edit_schedule ? explode(',', @$edit_schedule->technician_id ?? '') : explode(',', @$ot_surgical_request->ot_technician ?? '')) ? 'selected' : '' }}>
                                                {{ $data->salutation }} {{ $data->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('ot_technician')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                @if( @$ot_registration->status != 'Completed' )
                                    @if( !@$billing->id )
                                    <div class="modal-footer" style="margin-top: 71px;">
                                        <div class="mt-5">
                                            <button type="submit" name="save" class="btn btn-success btn-sm submitBtn" value = "2"><i class="fa fa-file"></i> {{ @$edit_schedule ? 'Update & Draft' : 'Save & Draft' }} </button>
                                            <button type="submit" name="save" class="btn btn-success btn-sm submitBtn" value ="proceed"><i class="fas fa-pump-medical"></i> Proceed OT</button>
                                        </div>
                                    </div>
                                    @endif
                                @endif

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
        $(document).ready(function() {
            var dept_id = $('#department_id').val();

            const selectedSurgeons =
                "{{ @$edit_schedule ? @$edit_schedule->sergeon_id : @$ot_surgical_request->surgeon ?? '' }}".split(
                    ',');
            const selectedAnaesthetists =
                "{{ @$edit_schedule ? @$edit_schedule->anaesthesia_id : @$ot_surgical_request->anaesthetist ?? '' }}"
                .split(',');


            if (dept_id) {
                getDoctor(dept_id, selectedSurgeons, selectedAnaesthetists);
            }
        });

        function getDoctor(dept_id, selectedSurgeons = [], selectedAnaesthetists = []) {
            if (dept_id) {
                $('#surgeon_name').html('<option value="">Select Doctor</option>');
                $('#anaesthetist_name').html('<option value="">Select Doctor</option>');

                $.ajax({
                    url: "{{ Route('opd.get-doctors') }}",
                    type: "POST",
                    data: {
                        _token: '{{ csrf_token() }}',
                        dept_id: dept_id,
                    },
                    success: function(response) {
                        if (response.success && response.doctors.length > 0) {
                            $.each(response.doctors, function(index, doctor) {
                                const isSurgeonSelected = selectedSurgeons.includes(doctor.id
                                    .toString()) ? 'selected' : '';
                                const isAnaesthetistSelected = selectedAnaesthetists.includes(doctor.id
                                    .toString()) ? 'selected' : '';

                                const surgeonOption =
                                    `<option value="${doctor.id}" ${isSurgeonSelected}>${doctor.salutation} ${doctor.name}</option>`;
                                const anaesthetistOption =
                                    `<option value="${doctor.id}" ${isAnaesthetistSelected}>${doctor.salutation} ${doctor.name}</option>`;

                                $('#surgeon_name').append(surgeonOption);
                                $('#anaesthetist_name').append(anaesthetistOption);
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
