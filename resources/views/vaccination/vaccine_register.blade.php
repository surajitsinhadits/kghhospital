@extends('layouts.structure')
@push('title')
    <title>Vaccine Registration</title>
@endpush
@push('css')
@endpush
@section('main-content')
    <div class="row">
        <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12">
            <form action="{{ route('vc.update-vaccine-register', @$edit->id) }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12">
                        <div class="border-0">
                            <div class="tab-content">
                                <div class="tab-pane active" id="tab-7">
                                    <div class="card">
                                        <div class="card-header card_hearder_mimi">
                                            <h4 class="card_hearder_mimi_text">VACCINE REGISTRATION</h4>
                                        </div>
                                        <div class="card-body hospital_allcardbodydesign ">
                                            <div class="opdneedit">
                                                <div class="row">
                                                    <div class="col-lg-12 ">
                                                        <div class="main-profile-contact-list ">
                                                            <div class="row">
                                                                <div class="form-group col-md-3 newaddappon">
                                                                    <label>Vaccine Name <span
                                                                            class="text-danger">*</span></label>
                                                                    <input type="text" name="vaccine_name"
                                                                        class="form-control"
                                                                        value="{{ old('vaccine_name', @$edit->vaccine_name ?? '') }}">
                                                                    @error('vaccine_name')
                                                                        <small class="text-danger">{{ $message }}</small>
                                                                    @enderror
                                                                </div>
                                                                <div class="form-group col-md-3 newaddappon">
                                                                    <label>Age/Group <span
                                                                            class="text-danger">*</span></label>
                                                                    <input type="text" name="age_group"
                                                                        class="form-control"
                                                                        value="{{ old('age_group', @$edit->age_group ?? '') }}">
                                                                    @error('age_group')
                                                                        <small class="text-danger">{{ $message }}</small>
                                                                    @enderror
                                                                </div>
                                                                <div class="form-group col-md-3 newaddappon">
                                                                    <label>Brand </label>
                                                                    <input type="text" name="brand_name"
                                                                        class="form-control"
                                                                        value="{{ old('brand_name', @$edit->brand_name ?? '') }}">
                                                                    @error('brand_name')
                                                                        <small class="text-danger">{{ $message }}</small>
                                                                    @enderror
                                                                </div>
                                                                <div class="form-group col-md-3 newaddappon">
                                                                    <label>Manufacturer </label>
                                                                    <input type="text" name="manufacturer"
                                                                        class="form-control"
                                                                        value="{{ old('manufacturer', @$edit->manufacturer ?? '') }}">
                                                                    @error('manufacturer')
                                                                        <small class="text-danger">{{ $message }}</small>
                                                                    @enderror
                                                                </div>
                                                                <div class="form-group col-md-2 newaddappon">
                                                                    <label>Injection Site <span
                                                                            class="text-danger">*</span></label>
                                                                    <select class="form-control" name="injection_site"
                                                                        id="injection_site">
                                                                        <option value="">-- Select Site --</option>
                                                                        <option value="Left Arm (Deltoid)"
                                                                            @selected(old('injection_site', @$edit->injection_site) == 'Left Arm (Deltoid)')>Left Arm (Deltoid)
                                                                        </option>
                                                                        <option value="Right Arm (Deltoid)"
                                                                            @selected(old('injection_site', @$edit->injection_site) == 'Right Arm (Deltoid)')>Right Arm (Deltoid)
                                                                        </option>
                                                                        <option value="Left Thigh"
                                                                            @selected(old('injection_site', @$edit->injection_site) == 'Left Thigh')>Left Thigh</option>
                                                                        <option value="Right Thigh"
                                                                            @selected(old('injection_site', @$edit->injection_site) == 'Right Thigh')>Right Thigh
                                                                        </option>
                                                                        <option value="Gluteal (Buttocks)"
                                                                            @selected(old('injection_site', @$edit->injection_site) == 'Gluteal (Buttocks)')>Gluteal (Buttocks)
                                                                        </option>
                                                                        <option value="Oral" @selected(old('injection_site', @$edit->injection_site) == 'Oral')>
                                                                            Oral</option>
                                                                        <option value="Nasal" @selected(old('injection_site', @$edit->injection_site) == 'Nasal')>
                                                                            Nasal</option>
                                                                        <option value="Subcutaneous"
                                                                            @selected(old('injection_site', @$edit->injection_site) == 'Subcutaneous')>Subcutaneous (SC)
                                                                        </option>
                                                                        <option value="Intradermal"
                                                                            @selected(old('injection_site', @$edit->injection_site) == 'Intradermal')>Intradermal (ID)
                                                                        </option>
                                                                    </select>
                                                                    @error('injection_site')
                                                                        <small class="text-danger">{{ $message }}</small>
                                                                    @enderror
                                                                </div>
                                                                <div class="form-group col-md-2 newaddappon">
                                                                    <label>Route <span class="text-danger">*</span></label>
                                                                    <input type="text" name="route"
                                                                        class="form-control"
                                                                        value="{{ old('route', @$edit->route ?? '') }}">
                                                                    @error('route')
                                                                        <small class="text-danger">{{ $message }}</small>
                                                                    @enderror
                                                                </div>

                                                                <div class="form-group col-md-2 newaddappon">
                                                                    <label>Storage Temperature</label>
                                                                    <input type="text" name="storage_temp"
                                                                        class="form-control"
                                                                        value="{{ old('storage_temp', @$edit->storage_temp ?? '') }}">
                                                                </div>
                                                                <div class="form-group col-md-2 newaddappon">
                                                                    <label>Unit <span class="text-danger">*</span></label>
                                                                    <select name="unit" id="unit"
                                                                        class="form-control">
                                                                        <option value="">-- Select Unit --</option>
                                                                        <option value="Box" @selected(old('unit', @$edit->unit) == 'Box')>Box</option>
                                                                        <option value="Carton" @selected(old('unit', @$edit->unit) == 'Carton')>Carton</option>
                                                                        <option value="Tray" @selected(old('unit', @$edit->unit) == 'Tray')>Tray</option>
                                                                        <option value="Blister Pack" @selected(old('unit', @$edit->unit) == 'Blister Pack')>Blister Pack</option>
                                                                        <option value="Tube Pack" @selected(old('unit', @$edit->unit) == 'Tube Pack')>Tube Pack</option>
                                                                    </select>
                                                                    @error('unit')
                                                                        <small class="text-danger">{{ $message }}</small>
                                                                    @enderror
                                                                </div>
                                                                <div class="form-group col-md-2 newaddappon">
                                                                    <label for="unit_subunit_relation">Relation <span
                                                                            class="text-danger">*</span></label>
                                                                    <div class="input-group mb-2" style="top: 0">
                                                                        <div class="input-group-prepend"
                                                                            style="width: 60px;">
                                                                            <div class="input-group-text w-100 px-1">1 Unit
                                                                                =</div>
                                                                        </div>
                                                                        <input type="number" class="form-control"
                                                                            id="unit_subunit_relation"
                                                                            name="unit_subunit_relation"
                                                                            value="{{ old('unit_subunit_relation', @$edit->unit_subunit_relation) }}"
                                                                            placeholder="How many?">
                                                                        <div class="input-group-prepend"
                                                                            style="width: 70px;">
                                                                            <div class="input-group-text w-100 px-1">Sub
                                                                                Unit</div>
                                                                        </div>
                                                                    </div>
                                                                    @error('unit_subunit_relation')
                                                                        <small class="text-danger">{{ $message }}</small>
                                                                    @enderror
                                                                </div>
                                                                <div class="form-group col-md-2 newaddappon">
                                                                    <label>Sub-Unit <span
                                                                            class="text-danger">*</span></label>
                                                                    <select name="sub_unit" id="sub_unit"
                                                                        class="form-control">
                                                                        <option value="">-- Select Subunit --
                                                                        </option>
                                                                        <option value="Vial" @selected(old('sub_unit', @$edit->sub_unit) == 'Vial')>Vial</option>
                                                                        <option value="Ampoule" @selected(old('sub_unit', @$edit->sub_unit) == 'Ampoule')>Ampoule</option>
                                                                        <option value="Pre-filled Syringe" @selected(old('sub_unit', @$edit->sub_unit) == 'Pre-filled Syringe')>Pre-filled
                                                                            Syringe</option>
                                                                        <option value="Oral Sachet" @selected(old('sub_unit', @$edit->sub_unit) == 'Oral Sachet')>Oral Sachet</option>
                                                                    </select>
                                                                    @error('sub_unit')
                                                                        <small class="text-danger">{{ $message }}</small>
                                                                    @enderror
                                                                </div>
                                                                <div class="form-group col-md-1 newaddappon">
                                                                    <label>No of Doses <span
                                                                            class="text-danger">*</span></label>
                                                                    <input type="number" name="no_of_doses"
                                                                        class="form-control"
                                                                        value="{{ old('no_of_doses', @$edit->no_of_doses ?? '') }}">
                                                                    @error('no_of_doses')
                                                                        <small class="text-danger">{{ $message }}</small>
                                                                    @enderror
                                                                </div>
                                                                <div class="form-group col-md-1 newaddappon">
                                                                    <label>Interval Days </label>
                                                                    <input type="text" name="interval_days"
                                                                        class="form-control"
                                                                        value="{{ old('interval_days', @$edit->interval_days ?? '') }}">
                                                                    @error('interval_days')
                                                                        <small class="text-danger">{{ $message }}</small>
                                                                    @enderror
                                                                </div>
                                                                <div class="form-group col-md-3 newaddappon">
                                                                    <label>Disease Prevented</label>
                                                                    <input type="text" name="disease_prevented"
                                                                        class="form-control"
                                                                        value="{{ old('disease_prevented', @$edit->disease_prevented ?? '') }}">
                                                                </div>
                                                                <div class="form-group col-md-3 newaddappon">
                                                                    <label>Drawbacks</label>
                                                                    <input type="text" name="drawbacks"
                                                                        class="form-control"
                                                                        value="{{ old('drawbacks', @$edit->drawbacks ?? '') }}">
                                                                </div>
                                                                <div class="form-group col-md-4 newaddappon">
                                                                    <label>Remarks</label>
                                                                    <input type="text" name="remarks"
                                                                        class="form-control"
                                                                        value="{{ old('remarks', @$edit->remarks ?? '') }}">
                                                                </div>
                                                                <div class="col-md-12 text-right newaddappon">
                                                                    <button class="btn btn-primary submitBtn"
                                                                        type="submit" name="submit" value="submit"><i
                                                                            class="fa fa-file text-success"></i>
                                                                        {{ $btn }}</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        {{-- <div class="table-responsive">
                                            <table class="table table-bordered border-left border-bottom border-right" id="data-table" style="width: 98%;margin-left:1%;">
                                                <thead class="bg-primary">
                                                    <tr>
                                                        <th scope="col" style="width: 44%" class="text-white">Gender</th>
                                                        <th scope="col" style="width: 10%" class="text-white">From Age</th>
                                                        <th scope="col" style="width: 10%" class="text-white">To Age</th>
                                                        <th scope="col" style="width: 10%" class="text-white">Dose(ml)</th>
                                                        <th scope="col" style="width: 2%" class="text-white">#</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="chargeTable">
                                                    <tr id="row">
                                                        <td>
                                                        <select class="form-control select2-show-search" id="gender">
                                                            <option value="all">All</option>
                                                            @foreach (['Male', 'Female'] as $gender)
                                                                <option value="{{ $gender }}" {{ old('gender', @$edit->gender ?? '') == $gender ? 'selected' : '' }}>{{ $gender }}</option>
                                                            @endforeach
                                                        </select>
                                                        </td>
                                                        <td>
                                                            <div class="input-group mb-2">
                                                                <input type="number" class="form-control" id="min_age" tabindex="4">
                                                                <div class="input-group-prepend" style="width: 70px;">
                                                                    <div class="w-100">
                                                                        <select id="min_age_type" class="form-control" style="margin-top: 3px;">
                                                                            <option value="days">D</option>
                                                                            <option value="months">M</option>
                                                                            <option value="years">Y</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="input-group mb-2">
                                                                <input type="number" class="form-control" id="max_age" tabindex="4">
                                                                <div class="input-group-prepend" style="width: 70px;">
                                                                    <div class="w-100">
                                                                        <select id="max_age_type" class="form-control" style="margin-top: 3px;">
                                                                            <option value="days">D</option>
                                                                            <option value="months">M</option>
                                                                            <option value="years">Y</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                           <input type="number" id="dose" class="form-control" value="{{ old('dose', @$edit->dose ?? '') }}">
                                                        </td>
                                                        <td>
                                                            <button class="btn btn-success btn-sm" id="buttonId" onclick="validation()" type="button"><i class="fa fa-plus"></i></button>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                            @error('gender')
                                            <span class="text-danger ml-4">{{ $message }}</span>
                                            @enderror
                                        </div> --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
@push('js')

@endpush
