@extends('layouts.structure')
@push('title')
    <title>OT Details</title>
@endpush
@push('css')
@endpush
@section('main-content')
    <div class="row">
        <div class="card ">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3 leftside_fixarea">
                        <x-billbar section="ot" id="{{ $info->ot_reg_id }}" type="sec" />
                    </div>
                    <form
                        action="{{ @$edit_preparation ? route('ot.update-ot-preparation') : route('ot.save-ot-preparation') }}"
                        method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="ot_reg_id" value="{{ $info->ot_reg_id }}">
                        <input type="hidden" name = "ot_surg_id" value="{{ $info->id }}">
                        <input type="hidden" name = "patient_id" value="{{ $info->patient_id }}">
                        <input type="hidden" name="preparation_id" value="{{ @$edit_preparation->id }}">

                        <div class="col-md-9 rightside_fixarea">
                            <h3><u>OT Preparation Process</u></h3>
                            {{-- style="border:none !important" --}}
                            <div class="row ">

                                <div class="form-group col-lg-2">
                                    <label>WHO Checklist Validation:</label><br>
                                    <input type="radio" name="who_validation" value="Yes"
                                        {{ old('who_validation', @$edit_preparation->who_validation ?? 'Yes') == 'Yes' ? 'checked' : '' }}> Yes
                                    <input type="radio" name="who_validation" value="No"
                                        {{ old('who_validation', @$edit_preparation->who_validation) == 'No' ? 'checked' : '' }}> No
                                </div>
                                <div class="form-group col-lg-3">
                                    <label>ASA Score:</label>
                                    <select name="asa_score" class="form-control select2-show-search" required>
                                        <option value="">Select</option>
                                        <option value="1" {{ @$edit_preparation->asa_score == '1' ? 'selected' : '' }}>
                                            I - Healthy</option>
                                        <option value="2"
                                            {{ @$edit_preparation->asa_score == '2' ? 'selected' : '' }}>
                                            II - Mild systemic disease</option>
                                        <option value="3"
                                            {{ @$edit_preparation->asa_score == '3' ? 'selected' : '' }}>
                                            III - Severe systemic disease</option>
                                        <option value="4"
                                            {{ @$edit_preparation->asa_score == '4' ? 'selected' : '' }}>
                                            IV - Life-threatening disease</option>
                                        <option value="5"
                                            {{ @$edit_preparation->asa_score == '5' ? 'selected' : '' }}>
                                            V - Moribund</option>
                                    </select>
                                </div>

                                <div class="form-group col-lg-3">
                                    <label for="comorbidity">Co-morbidity:</label>
                                    <select name="co_morbidity" id="comorbidity" class="form-control select2-show-search">
                                        <option value="">-- Select Co-morbidity --</option>
                                        <option value="Diabetes"
                                            {{ @$edit_preparation->co_morbidity == 'Diabetes' ? 'selected' : '' }}>
                                            Diabetes</option>
                                        <option value="Hypertension"
                                            {{ @$edit_preparation->co_morbidity == 'Hypertension' ? 'selected' : '' }}>
                                            Hypertension</option>
                                        <option value="Asthma"
                                            {{ @$edit_preparation->co_morbidity == 'Asthma' ? 'selected' : '' }}>
                                            Asthma</option>
                                        <option value="COPD"
                                            {{ @$edit_preparation->co_morbidity == 'COPD' ? 'selected' : '' }}>
                                            COPD</option>
                                        <option value="Coronary Artery Disease"
                                            {{ @$edit_preparation->co_morbidity == 'Coronary Artery Disease' ? 'selected' : '' }}>
                                            Coronary Artery Disease</option>
                                        <option value="Chronic Kidney Disease"
                                            {{ @$edit_preparation->co_morbidity == 'Chronic Kidney Disease' ? 'selected' : '' }}>
                                            Chronic Kidney Disease</option>
                                        <option value="Liver Disease"
                                            {{ @$edit_preparation->co_morbidity == 'Liver Disease' ? 'selected' : '' }}>
                                            Liver Disease</option>
                                        <option value="Obesity"
                                            {{ @$edit_preparation->co_morbidity == 'Obesity' ? 'selected' : '' }}>
                                            Obesity</option>
                                        <option value="Thyroid Disorder"
                                            {{ @$edit_preparation->co_morbidity == 'Thyroid Disorder' ? 'selected' : '' }}>
                                            Thyroid Disorder</option>
                                        <option value="Anemia"
                                            {{ @$edit_preparation->co_morbidity == 'Anemia' ? 'selected' : '' }}>
                                            Anemia</option>
                                        <option value="Cancer"
                                            {{ @$edit_preparation->co_morbidity == 'Cancer' ? 'selected' : '' }}>
                                            Cancer</option>
                                        <option value="Tuberculosis"
                                            {{ @$edit_preparation->co_morbidity == 'Tuberculosis' ? 'selected' : '' }}>
                                            Tuberculosis</option>
                                        <option value="HIV/AIDS"
                                            {{ @$edit_preparation->co_morbidity == 'HIV/AIDS' ? 'selected' : '' }}>
                                            HIV/AIDS</option>
                                        <option value="Stroke History"
                                            {{ @$edit_preparation->co_morbidity == 'Stroke History' ? 'selected' : '' }}>
                                            Stroke History</option>
                                        <option value="Epilepsy"
                                            {{ @$edit_preparation->co_morbidity == 'Epilepsy' ? 'selected' : '' }}>
                                            Epilepsy</option>
                                        <option value="Mental Health Disorder"
                                            {{ @$edit_preparation->co_morbidity == 'Mental Health Disorder' ? 'selected' : '' }}>
                                            Mental Health Disorder</option>
                                        <option value="Smoking"
                                            {{ @$edit_preparation->co_morbidity == 'Smoking' ? 'selected' : '' }}>
                                            Smoking</option>
                                        <option value="Alcohol Use Disorder"
                                            {{ @$edit_preparation->co_morbidity == 'Alcohol Use Disorder' ? 'selected' : '' }}>
                                            Alcohol Use Disorder</option>
                                        <option value="Sleep Apnea"
                                            {{ @$edit_preparation->co_morbidity == 'Sleep Apnea' ? 'selected' : '' }}>
                                            Sleep Apnea</option>
                                        <option value="Rheumatoid Arthritis"
                                            {{ @$edit_preparation->co_morbidity == 'Rheumatoid Arthritis' ? 'selected' : '' }}>
                                            Rheumatoid Arthritis</option>
                                    </select>
                                </div>

                                <div class="form-group col-lg-3">
                                    <label>Patient Consent (Upload Signature/Image):</label><br>
                                    <input class="form-control" type="file" name="consent_file">

                                    @if (isset($edit_preparation) && $edit_preparation->consent_file)
                                        <div class="mt-2">
                                            <label>Previously Uploaded:</label><br>
                                            <a href="{{ url('public/' . $edit_preparation->consent_file) }}"
                                                target="_blank">
                                                <img src="{{ url('public/' . $edit_preparation->consent_file) }}"
                                                    alt="Consent File"
                                                    style="max-height: 100px; border: 1px solid #ccc; padding: 3px;">
                                            </a>
                                        </div>
                                    @endif
                                </div>
                                <div class="form-group col-lg-12">
                                    <label>
                                        <input type="checkbox" id="enableReasonCheckbox" onchange="toggleTextarea()"
                                            class="me-2" style="width: 30px;" value="yes" name="reschedule_check"
                                            {{ @$edit_preparation->reschedule_check == 'yes' ? 'checked' : '' }}>
                                        Enable Suggested Reschedule Reason
                                    </label>
                                    <textarea class="form-control" name="reschedule_reason" id="rescheduleReason" rows="5" cols="120"
                                        {{ @$edit_preparation->reschedule_check == 'yes' ? '' : 'disabled' }}>{{ @$edit_preparation ? @$edit_preparation->reschedule_reason : '' }}</textarea>
                                </div>

                                @if( $testNames->count() > 0 && !@$edit_preparation )
                                <div class="form-group col-lg-12" {{ @$edit_preparation->id ? 'style="display:none;"' : '' }}>
                                    <div class="modal-body border p-3 rounded shadow-sm" style="background-color: #f9f9fb;">
                                        <button onclick="handleConfirmAllChange()" type="button" name="save" class="btn btn-success btn-sm">Confirm All Test?</button>
                                    </div>
                                </div>
                                @endif
                                    
                                <div class="form-group col-lg-12">
                                </div>

                                @if( @$ot_registration->status != 'Completed' )
                                <div class="modal-footer justify-content-center">
                                    <div class="mt-5">
                                        @if( @$edit_preparation->status != 'Confirmed' )
                                            @if( $testNames->count() > 0 && @$edit_preparation->id )
                                            <button type="submit" name="save" class="btn btn-primary btn-sm submitBtn" value="1"><i class="fa fa-file text-success"></i> Save as Draft </button>
                                            <button type="submit" name="save" class="btn btn-success btn-sm submitBtn" value="2"><i class="fa fa-file"></i> Confirm </button>
                                            @else
                                                @if( @$edit_preparation->id || $testNames->count() == 0 )
                                                    <button type="submit" name="save" class="btn btn-primary btn-sm submitBtn" value="1"><i class="fa fa-file text-success"></i> Save as Draft </button>
                                                    <button type="submit" name="save" class="btn btn-success btn-sm submitBtn" value="2"><i class="fa fa-file"></i> Confirm </button>
                                                @else
                                                    <button type="submit" disabled name="save" class="btn btn-primary btn-sm submitBtn" value="1"><i class="fa fa-file text-success"></i> Save as Draft </button>
                                                    <button type="submit" disabled name="save" class="btn btn-success btn-sm submitBtn" value="2"><i class="fa fa-file"></i> Confirm </button>
                                                @endif
                                            @endif
                                            
                                        @endif
                                    </div>
                                </div>
                                @endif
                            </div>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Confirm All Modal -->
    <!-- Confirm All Modal -->
    <div class="modal fade" id="confirmAllModal" tabindex="-1" aria-labelledby="confirmAllModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <form id="confirmAllForm" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="ot_preparation_id" value="{{ @$edit_preparation->id }}">
                <input type="hidden" name="test_confirmation" value="yes">

                <input type="hidden" name="ot_reg_id" value="{{ $info->ot_reg_id }}">
                <input type="hidden" name = "ot_surg_id" value="{{ $info->id }}">
                <input type="hidden" name = "patient_id" value="{{ $info->patient_id }}">

                <div class="modal-content border rounded">
                    <div class="modal-header">
                        <h5 class="modal-title" id="confirmAllModalLabel">Confirm All Tests</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <p>Please confirm that all tests listed below are done. If not, upload the test result.</p>

                        <div class="list-group">
                            @foreach ($testNames as $index => $test)
                                <div
                                    class="list-group-item d-flex justify-content-between align-items-start flex-wrap mb-2 border rounded">
                                    <div class="me-auto mt-3" style="min-width: 200px;">
                                        <strong>
                                            {{ $loop->iteration }}.

                                            @if( in_array($test->id, $existingInvestigationCharges) )
                                                <a href="{{ route('investigation.print-from-report-update', ['id' => ed($existingInvestigationCharges[$test->id], true)]) }}"
                                                    class="text-success text-decoration-underline">
                                                    {{ $test->charge_name }}
                                                </a>
                                            @else
                                                {{ $test->charge_name }}
                                            @endif
                                        </strong>
                                    </div>

                                    <div class="form-group col-lg-3">
                                        <select name="test[{{ $test->id }}][confirmed]" class="form-control select2-show-search" required>
                                            <option value="">Select</option>
                                            @foreach ($testNames as $index => $test_name)
                                                @if( $test_name->id == $test->id )
                                                    <option value="{{ $test_name->id }}" selected>{{ $test_name->charge_name }}</option>
                                                @else
                                                    <option value="{{ $test_name->id }}">{{ $test_name->charge_name }}</option>
                                                @endif
                                            @endforeach

                                            @foreach ($existingTestNames as $index => $exist_test_name)
                                                @if( $exist_test_name->id == $test->id )
                                                    <option value="{{ $exist_test_name->id }}" selected>{{ $exist_test_name->charge_name }}</option>
                                                @else
                                                    <option value="{{ $exist_test_name->id }}">{{ $exist_test_name->charge_name }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="mt-3">
                                        <strong>OR</strong>
                                    </div>

                                    <!-- File input -->
                                    <div style="min-width: 220px;">
                                        <input type="file" class="form-control form-control-sm"
                                            name="test[{{ $test->id }}][file]" accept=".pdf,.jpg,.jpeg,.png,.docx">
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-primary" onclick="submitTestPreparation()">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection
@push('js')
    <!-- Required for modal behavior -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        function toggleTextarea() {
            const checkbox = document.getElementById('enableReasonCheckbox');
            const textarea = document.getElementById('rescheduleReason');
            textarea.disabled = !checkbox.checked;
        }


        function handleConfirmAllChange(checkbox) {
            // if (checkbox.checked) {
                // Only show modal when checkbox is checked
                var confirmModal = new bootstrap.Modal(document.getElementById('confirmAllModal'));
                confirmModal.show();
            // }
        }

        function submitTestPreparation() {

            let isValid = true;

            $totalTests = {{ count($testNames) }};
            var confirmedTests = []; var fileInputs = [];
            $("select[name^='test'][name$='[confirmed]']").each(function(i) {

                if ($(this).val() !== "") {
                    confirmedTests[i] = $(this).val();
                } else {
                    confirmedTests[i] = null;
                }
                
            });

            $("input[name^='test'][name$='[file]']").each(function(k) {

                if ($(this).val().trim() !== "") {
                    fileInputs[k] = $(this).val();
                } else {
                    fileInputs[k] = null;
                } 
            });

            for (let j = 0; j < $totalTests; j++) {

                if( !confirmedTests[j] && !fileInputs[j] ) {
                    isValid = false;
                }

            }

            if (!isValid) {
                alert("Please fill all file fields");
                return false;
            }

            let form = $('#confirmAllForm')[0];
            let formData = new FormData(form);
            $.ajax({
                url: "{{ route('ot.update-ot-prepation-test') }}",
                method: "POST",
                data: formData,
                contentType: false,
                processData: false,
                headers: {
                    'X-CSRF-TOKEN': $('input[name="_token"]').val()
                },
                beforeSend: function() {
                    // Optionally show loading spinner
                },
                success: function(response) {
                    if (response.status) {
                        alert(response.message);
                        $('#confirmAllModal').modal('hide');
                        location.reload();
                    } else {
                        alert('Something went wrong!');
                    }
                },
                error: function(xhr) {
                    console.error(xhr.responseText);
                    alert('Error submitting form. Check console.');
                }
            });
        }
    </script>
@endpush
