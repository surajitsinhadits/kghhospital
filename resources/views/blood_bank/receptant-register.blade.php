@extends('layouts.structure')
@push('title')
    <title>{{ $title }}</title>
@endpush

@section('main-content')
    <div class="row">
        <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12">
            <div class="card">
                <div class="card-header card_hearder_mimi">
                    <h4 class="card-title card_hearder_mimi_text">{{ $title }}</h4>
                </div>
                <div class="card-body">
                    <form class="form-horizontal" enctype="multipart/form-data" method="POST"
                        action="{{ route('bl.receptant-save', @$edit->id) }}">
                        @csrf
                        <input type="hidden" name="id" value="{{ old('id', $edit->id ?? '') }}">

                        <div class="row">
                            <div class="col-md-4">
                                <label>Patient <span class="text-danger">*</span></label>
                                <select name="patient_id" class="select2 form-control" required>
                                    <option value="">-- Select Patient --</option>
                                    @foreach ($patient as $patient)
                                        <option value="{{ $patient->id }}"
                                            {{ old('patient_id', $edit->patient_id ?? '') == $patient->id ? 'selected' : '' }}>
                                            {{ $patient->name }} (ID: {{ $patient->id }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('patient_id')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <label>Blood Group <span class="text-danger">*</span></label>
                                <select name="blood_group" class="form-control" required>
                                    <option value="">-- Select Blood Group --</option>
                                    @foreach ($bloodGroups as $group)
                                        <option value="{{ $group->id }}"
                                            {{ old('blood_group', $edit->blood_group ?? '') == $group->id ? 'selected' : '' }}>
                                            {{ $group->blood_group }} ({{ $group->quantity }} ml)
                                        </option>
                                    @endforeach
                                </select>
                                @error('blood_group')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <label>Donated Date</label>
                                <input type="date" name="donated_date" class="form-control"
                                    value="{{ old('donated_date', isset($edit['donated_date']) ? \Carbon\Carbon::parse($edit['donated_date'])->format('Y-m-d') : '') }}">
                                @error('donated_date')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        <div class="mt-3">
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-paper-plane mr-2"></i> {{ $btn }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
@endpush
