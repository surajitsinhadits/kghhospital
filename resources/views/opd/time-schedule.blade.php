@extends('layouts.structure')
@push('title')
    <title>Time Schedule List</title>
@endpush
@push('css')
@endpush
@section('main-content')
    <div class="row">
        <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12">
            <div class="card">
                <div class="card-header card_hearder_mimi">
                    <h4 class="card-title card_hearder_mimi_text">TIME SCHEDULE LIST</h4>
                </div>
                <div class="card-body">
                    <form action="{{Route('opd.view-time-schedule')}}" method="GET">
                        <div class="row justify-content-center">
                            <div class="form-group col-md-2">
                                <label for="doctor">Doctor <span class="text-danger">*</span></label>
                                <select id="doctor" class="form-control select2-show-search" name="doctor" required>
                                    <option value="">Select Doctor</option>
                                    @foreach ($doctor as $item)
                                        <option value="{{ $item->id }}" {{@$_GET['doctor'] == $item->id ? 'selected' : ''}}>Dr. {{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-2 appoinmentdays" style="margin-top: 2px;">
                                <label>Select Date Range <span class="text-danger">*</span></label>
                                <input type="text" class="form-control dateRangePickr" value="{{@$_GET['date']}}" name="date" placeholder="Select Date" required>
                            </div>
                            <div class="form-group col-md-2 appoinmentdays d-flex">
                                <button type="submit" class="btn btn-primary" style="margin-top: 28px;"><i class="fa fa-search"></i> Search Schedule</button>
                                <a href="{{Route('opd.view-time-schedule')}}" class="btn btn-warning mx-2" style="margin-top: 28px;">Reset</a>
                            </div>
                        </div>
                    </form>
                </div>
                @if ($unique_days)
                <div class="card-body border">
                    <form action="{{Route('opd.save-time-schedule')}}" method="POST">
                        @csrf
                        <input type="hidden" name="doctor_id" id="doctor_id" value="{{@$_GET['doctor']}}">
                        <input type="hidden" name="date" id="date" value="{{@$_GET['date']}}">
                        <div class="row mt-3">
                            <div class="form-group col-md-3">
                                <label for="doctor">Select Days <span class="text-danger">*</span></label>
                                <select id="doctor" class="multi-select select2-show-search" name="days[]" required multiple>
                                    <option value="Sunday" {{ in_array('Sunday', $unique_days) ? '' : 'disabled' }}>Sunday</option>
                                    <option value="Monday" {{ in_array('Monday', $unique_days) ? '' : 'disabled' }}>Monday</option>
                                    <option value="Tuesday" {{ in_array('Tuesday', $unique_days) ? '' : 'disabled' }}>Tuesday</option>
                                    <option value="Wednesday" {{ in_array('Wednesday', $unique_days) ? '' : 'disabled' }}>Wednesday</option>
                                    <option value="Thursday" {{ in_array('Thursday', $unique_days) ? '' : 'disabled' }}>Thursday</option>
                                    <option value="Friday" {{ in_array('Friday', $unique_days) ? '' : 'disabled' }}>Friday</option>
                                    <option value="Saturday" {{ in_array('Saturday', $unique_days) ? '' : 'disabled' }}>Saturday</option>
                                </select>
                                @error('days')
                                <small class="text-danger">{{$message}}</small>
                                @enderror
                            </div>

                            <div class="form-group col-md-2 appoinmentdays">
                                <label>From Time <span class="text-danger">*</span></label>
                                <input type="text" class="form-control timePickr" name="from_time" required>
                                @error('from_time')
                                <small class="text-danger">{{$message}}</small>
                                @enderror
                            </div>
                            <div class="form-group col-md-2 appoinmentdays">
                                <label>To Time <span class="text-danger">*</span></label>
                                <input type="text" class="form-control timePickr" name="to_time" required>
                                @error('to_time')
                                <small class="text-danger">{{$message}}</small>
                                @enderror
                            </div>
                            <div class="form-group col-md-2 appoinmentdays">
                                <label>Time Per Slot (In min) <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" name="time_per_slot" id="time_per_slot" required>
                                @error('time_per_slot')
                                <small class="text-danger">{{$message}}</small>
                                @enderror
                            </div>
                            <div class="form-group col-md-2 appoinmentdays">
                                <label>Patient Per Slot <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" name="patient_per_slot" required>
                                @error('patient_per_slot')
                                <small class="text-danger">{{$message}}</small>
                                @enderror
                            </div>
                            <div class="form-group col-md-1 appoinmentdays">
                                <button type="submit" class="btn btn-primary" style="margin-top: 27px"><i class="fa fa-plus"></i> SAVE</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="card-body border">
                    <div class="table-responsive">
                        <table class="table table-hover card-table table-vcenter text-nowrap border-left border-right border-bottom" id="subhendu">
                            <thead class="bg-primary text-white">
                                <tr class="border-left">
                                    <th class="text-white">
                                        is active?<br>
                                        <input style="width: 15%" type="checkbox" id="checkActive">
                                        <button class="badge badge-info" type="button" onclick="activeRow()">Deactive</button>
                                    </th>
                                    <th class="text-white">Doctor Name</th>
                                    <th class="text-white">Date (DD-MM-YYYY)</th>
                                    <th class="text-white">Timing</th>
                                    <th class="text-white">From (Slot)</th>
                                    <th class="text-white">To (Slot)</th>
                                    <th class="text-white">Patient Per Slot</th>
                                    <th class="text-white">
                                        Delete<br>
                                        <input style="width: 15%" type="checkbox" id="checkDelete">
                                        <button class="badge badge-danger" type="button" onclick="removeRow()">Delete</button>
                                    </th>
                                </tr>
                            </thead>
                            <tbody id="cvinrivnirn">
                                @foreach ($slot_details as $key => $value)
                                    <tr id="row{{ $key }}" style="background-color: rgb(203 203 203);">
                                        <td>
                                            <input type="hidden" value="{{ $value->id }}" name="slot_details_id[]" id="slot_details_id{{ $value->id }}" />
                                            @if ($value->booked == 0)
                                                <input type="checkbox" class="activeRow" id="activeRow{{ $value->id }}" value="{{ $value->id }}" name="ac_de_row[]" {{ @$value->is_active == '1' ? 'checked' : '' }} />
                                            @endif
                                        </td>
                                        <td>{{ $value->salutation }} {{ $value->name }}</td>
                                        <td>
                                            <input name="formattedDate[]" value="{{ @$value->date }}" type="hidden" />
                                            <input name="dayOfWeek[]" value="{{ @$value->day }}" type="hidden" />
                                            {{ dateFor(@$value->date) }} - <span style="color:blue">{{ @$value->day }}</span>
                                        </td>
                                        <td>{{ timeFor(@$value->from_time) }} - {{ timeFor(@$value->to_time) }} </td>
                                        <td>
                                            <input type="text" value="{{ timeFor(@$value->from_time) }}"
                                                required name="from_time_slot[]" id="from_time_slot{{ $value->id }}"
                                                onchange="get_update_data({{ $value->id }})"
                                                onkeyup="get_update_data({{ $value->id }})"
                                                class="form-control" />
                                        </td>
                                        <td>
                                            <input type="text" value="{{ timeFor(@$value->to_time) }}"
                                                required name="to_time_slot[]" id="to_time_slot{{ $value->id }}"
                                                onchange="get_update_data({{ $value->id }})"
                                                onkeyup="get_update_data({{ $value->id }})"
                                                class="form-control" />
                                        </td>
                                        <td>
                                            <input type="number" value="{{ @$value->patient_per_slot }}"
                                                required name="patient_per_slot[]" id="patient_per_slot{{ $value->id }}"
                                                onkeyup="get_update_data({{ $value->id }})"
                                                class="form-control" />
                                        </td>
                                        <td>
                                            @if ($value->booked == 0)
                                                <input type="checkbox" class="removeRow" id="deleterow{{ $value->id }}" value="{{ $value->id }}" name="delete_row[]" />
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
@endsection
@push('js')
<script>
    function activeRow() {
        var docton_id = $('#doctor_id').val();
        var date = $('#date').val();
        var activeRowValues = [];

        // Collect the values of checked checkboxes with the class "removeRow"
        $("input[name='ac_de_row[]']:checked").each(function() {
            activeRowValues.push($(this).val());
        });

        // Check if any checkbox is selected
        if (activeRowValues.length === 0) {
            toastr.error("Please select at least one row to active/deactive");
            return;
        }

        // Your existing AJAX code
        $.ajax({
            url: "{{Route('opd.active-slot')}}",
            type: "POST",
            data: {
                _token: '{{ csrf_token() }}',
                slotId: activeRowValues,
                doctonId: docton_id,
                date: date,
            },
            success: function(response) {
                toastr.success("Slots Status Changed successfully");
                setTimeout(function() {
                    location.reload();
                }, 2000);
            },
            error: function(error) {
                console.log(error);
            }
        });
    }

    function removeRow() {
        var docton_id = $('#doctor_id').val();
        var date = $('#date').val();
        var deleteRowValues = [];

        // Collect the values of checked checkboxes with the class "removeRow"
        $("input[name='delete_row[]']:checked").each(function() {
            deleteRowValues.push($(this).val());
        });

        // Check if any checkbox is selected
        if (deleteRowValues.length === 0) {
            toastr.error("Please select at least one row to delete");
            return;
        }

        // Your existing AJAX code
        $.ajax({
            url: "{{Route('opd.delete-slot')}}",
            type: "POST",
            data: {
                _token: '{{ csrf_token() }}',
                slotId: deleteRowValues,
                docton_id: docton_id,
                date: date,
            },
            success: function(response) {
                toastr.success("Slots deleted successfully");
                setTimeout(function() {
                    location.reload();
                }, 2000);
            },
            error: function(error) {
                console.log(error);
            }
        });
    }

    function get_update_data(slot_id) {
        var from_time_slot = $('#from_time_slot' + slot_id).val();
        var to_time_slot = $('#to_time_slot' + slot_id).val();
        var patient_per_slot = $('#patient_per_slot' + slot_id).val();
        $.ajax({
            url: "{{Route('opd.update-slot')}}",
            type: "POST",
            data: {
                _token: '{{ csrf_token() }}',
                slotId: slot_id,
                fromtimeslot: from_time_slot,
                totimeslot: to_time_slot,
                patientperslot: patient_per_slot,
            },

            success: function(response) {
                // toastr.success("Slots Updated successfully");
            },
            error: function(error) {
                console.log(error);
            }
        });
    }
</script>

<script>
    $(document).ready(function() {
        // Use jQuery to bind the function to the change event of "Check All" checkbox
        $("#checkDelete").change(function() {
            $(".removeRow").prop("checked", $(this).prop("checked"));
        });
        $("#checkActive").change(function() {
            $(".activeRow").prop("checked", $(this).prop("checked"));
        });
    });
</script>
@endpush
