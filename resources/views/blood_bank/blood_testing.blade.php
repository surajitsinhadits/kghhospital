@extends('layouts.structure')

@push('title')
    <title>{{ $title }}</title>
@endpush

@section('main-content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header card_hearder_mimi">
                    <h4 class="card-title card_hearder_mimi_text">{{ $title }}</h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('bl.blood-testing-save') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="card-body hospital_allcardbodydesign">
                                <h5 class="font-weight-bold"><i class="fas fa-tint"></i> Blood Information</h5>
                                <div class="row">
                                    <input type="hidden" name="donation_id" value="{{ @$donor->id }}">
                                    <input type="hidden" name="update_id" value="{{ @$edit->id }}">
                                    <div class="col-md-2 newuserchange">
                                        <label>Bag Barcode <span class="text-danger">*</span></label>
                                        <input type="text" name="bag_barcode"
                                            value="{{ old('bag_barcode', @$donor->bag_barcode ?? '') }}"
                                            class="form-control" id="bag_barcode" readonly>
                                        @error('bag_barcode')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="col-md-2 newuserchange">
                                        <label>Blood Group <span class="text-danger">*</span></label>
                                        <select name="blood_group" class="form-control" id="">
                                            <option value="">Select</option>
                                            @foreach (['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'] as $bg)
                                                <option value="{{ $bg }}"
                                                    {{ old('blood_group', $donor->blood_group ?? '') == $bg ? 'selected' : '' }}>
                                                    {{ $bg }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('blood_group')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="col-md-2 newuserchange">
                                        <label>Expiry Date <span class="text-danger">*</span></label>
                                        <input type="text" name="expiry_date"
                                            value="{{ dateFor(old('expiry_date', @$donor->expiry_date ?? '')) }}"
                                            class="form-control datePickr" id="expiry_date">
                                        @error('expiry_date')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="col-md-2 newuserchange">
                                        <label>Collection Site</label>
                                        <select name="collection_site" class="form-control">
                                            <option value="">-- Select --</option>
                                            @foreach (['Fixed', 'Mobile'] as $value)
                                                <option value="{{ $value }}"
                                                    {{ old('collection_site', @$donor->collection_site ?? '') == $value ? 'selected' : '' }}>
                                                    {{ $value }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-2 newuserchange">
                                        <label>Component Separation Status</label>
                                        <input type="text" name="component_seperation_status"
                                            value="{{ old('component_seperation_status', @$donor->component_seperation_status ?? '') }}"
                                            class="form-control" id="component_seperation_status">
                                    </div>
                                    <div class="col-md-2 newuserchange">
                                        <label>Component Type</label>
                                        <input type="text" name="component_type"
                                            value="{{ old('component_type', @$donor->component_type ?? '') }}"
                                            class="form-control" id="component_type">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-2 newuserchange">
                                        <label>QC Checks Log</label>
                                        <input type="text" name="qc_checks_log"
                                            value="{{ old('qc_checks_log', @$edit->qc_checks_log ?? '') }}"
                                            class="form-control" id="qc_checks_log">
                                    </div>
                                    <div class="col-md-2 newuserchange">
                                        <label>Quarantine Flag</label>
                                        <select name="quarantine_flag" class="form-control">
                                            <option value="">-- Select --</option>
                                            @foreach ([1 => 'Yes', 0 => 'No'] as $value => $label)
                                                <option value="{{ $value }}"
                                                    {{ old('quarantine_flag', $edit->quarantine_flag ?? '') == $value ? 'selected' : '' }}>
                                                    {{ $label }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-2 newuserchange">
                                        <label>Nat Result</label>
                                        <select name="nat_result" class="form-control">
                                            <option value="">-- Select --</option>
                                            @foreach (['Positive', 'Negative', 'Inconclusive'] as $value)
                                                <option value="{{ $value }}"
                                                    {{ old('nat_result', @$edit->nat_result ?? '') == $value ? 'selected' : '' }}>
                                                    {{ $value }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-2 newuserchange">
                                        <label>Elisa Result</label>
                                        <select name="elisa_result" class="form-control">
                                            <option value="">-- Select --</option>
                                            @foreach (['Positive', 'Negative', 'Inconclusive'] as $value)
                                                <option value="{{ $value }}"
                                                    {{ old('elisa_result', @$edit->elisa_result ?? '') == $value ? 'selected' : '' }}>
                                                    {{ $value }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-2 newuserchange">
                                        <label>HIV Result</label>
                                        <select name="hiv_result" class="form-control">
                                            <option value="">-- Select --</option>
                                            @foreach (['Positive', 'Negative', 'Inconclusive'] as $value)
                                                <option value="{{ $value }}"
                                                    {{ old('hiv_result', @$edit->hiv_result ?? '') == $value ? 'selected' : '' }}>
                                                    {{ $value }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-2 newuserchange">
                                        <label>HBSAG Result</label>
                                        <select name="hbsag_result" class="form-control">
                                            <option value="">-- Select --</option>
                                            @foreach (['Positive', 'Negative', 'Inconclusive'] as $value)
                                                <option value="{{ $value }}"
                                                    {{ old('hbsag_result', @$edit->hbsag_result ?? '') == $value ? 'selected' : '' }}>
                                                    {{ $value }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-2 newuserchange">
                                        <label>HCV Result</label>
                                        <select name="hcv_result" class="form-control">
                                            <option value="">-- Select --</option>
                                            @foreach (['Positive', 'Negative', 'Inconclusive'] as $value)
                                                <option value="{{ $value }}"
                                                    {{ old('hcv_result', @$edit->hcv_result ?? '') == $value ? 'selected' : '' }}>
                                                    {{ $value }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-2 newuserchange">
                                        <label>Syphilis Result</label>
                                        <select name="syphilis_result" class="form-control">
                                            <option value="">-- Select --</option>
                                            @foreach (['Positive', 'Negative', 'Inconclusive'] as $value)
                                                <option value="{{ $value }}"
                                                    {{ old('syphilis_result', @$edit->syphilis_result ?? '') == $value ? 'selected' : '' }}>
                                                    {{ $value }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-2 newuserchange">
                                        <label>Malaria Result</label>
                                        <select name="malaria_result" class="form-control">
                                            <option value="">-- Select --</option>
                                            @foreach (['Positive', 'Negative', 'Inconclusive'] as $value)
                                                <option value="{{ $value }}"
                                                    {{ old('malaria_result', @$edit->malaria_result ?? '') == $value ? 'selected' : '' }}>
                                                    {{ $value }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-2 newuserchange">
                                        <label>Crossmatch Result</label>
                                        <select name="crossmatch_result" class="form-control">
                                            <option value="">-- Select --</option>
                                            @foreach (['Compatible', 'Incompatible', 'Not done'] as $value)
                                                <option value="{{ $value }}"
                                                    {{ old('crossmatch_result', @$edit->crossmatch_result ?? '') == $value ? 'selected' : '' }}>
                                                    {{ $value }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body hospital_allcardbodydesign">
                            @if ($approval)
                            <button type="submit" name="submit" value="approve" class="btn btn-success mr-2">
                                <i class="fa fa-check-circle mr-2"></i> Approve
                            </button>
                            <button type="submit" name="submit" value="retest" class="btn btn-warning mr-2">
                                <i class="fa fa-check-circle mr-2"></i> Re-Test
                            </button>
                            <button type="submit" name="submit" value="reject" class="btn btn-danger mr-2">
                                <i class="fa fa-check-circle mr-2"></i> Reject
                            </button>
                            @else
                            <button type="submit" name="submit" value="update" class="btn btn-primary mr-2">
                                <i class="fa fa-paper-plane mr-2"></i> {{ $btn }}
                            </button>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
@endpush
