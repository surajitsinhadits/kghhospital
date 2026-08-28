@extends('layouts.structure')

@push('title')
    <title>ADD NEW VENDOR</title>
@endpush

@push('css')
@endpush

@section('main-content')
@php
    $gstRegistrationTypes = [
        'Regular',
        'Composition',
        'Unregistered',
        'Consumer',
        'Deemed Export',
        'SEZ Developer',
        'SEZ Unit',
        'Unknown',
    ];

    $stateCodeOptions = [
        '01' => 'Jammu & Kashmir',
        '02' => 'Himachal Pradesh',
        '03' => 'Punjab',
        '04' => 'Chandigarh',
        '05' => 'Uttarakhand',
        '06' => 'Haryana',
        '07' => 'Delhi',
        '08' => 'Rajasthan',
        '09' => 'Uttar Pradesh',
        '10' => 'Bihar',
        '11' => 'Sikkim',
        '12' => 'Arunachal Pradesh',
        '13' => 'Nagaland',
        '14' => 'Manipur',
        '15' => 'Mizoram',
        '16' => 'Tripura',
        '17' => 'Meghalaya',
        '18' => 'Assam',
        '19' => 'West Bengal',
        '20' => 'Jharkhand',
        '21' => 'Odisha',
        '22' => 'Chhattisgarh',
        '23' => 'Madhya Pradesh',
        '24' => 'Gujarat',
        '25' => 'Daman & Diu',
        '26' => 'Dadra & Nagar Haveli',
        '27' => 'Maharashtra',
        '28' => 'Andhra Pradesh',
        '29' => 'Karnataka',
        '30' => 'Goa',
        '31' => 'Lakshadweep',
        '32' => 'Kerala',
        '33' => 'Tamil Nadu',
        '34' => 'Puducherry',
        '35' => 'Andaman & Nicobar',
        '36' => 'Telangana',
        '37' => 'Andhra Pradesh (New)',
        '38' => 'Ladakh',
        '97' => 'Other Territory',
    ];

    $placeOfSupplyOptions = [
        'Jammu & Kashmir',
        'Himachal Pradesh',
        'Punjab',
        'Chandigarh',
        'Uttarakhand',
        'Haryana',
        'Delhi',
        'Rajasthan',
        'Uttar Pradesh',
        'Bihar',
        'Sikkim',
        'Arunachal Pradesh',
        'Nagaland',
        'Manipur',
        'Mizoram',
        'Tripura',
        'Meghalaya',
        'Assam',
        'West Bengal',
        'Jharkhand',
        'Odisha',
        'Chhattisgarh',
        'Madhya Pradesh',
        'Gujarat',
        'Daman & Diu',
        'Dadra & Nagar Haveli',
        'Maharashtra',
        'Andhra Pradesh',
        'Karnataka',
        'Goa',
        'Lakshadweep',
        'Kerala',
        'Tamil Nadu',
        'Puducherry',
        'Andaman & Nicobar',
        'Telangana',
        'Andhra Pradesh (New)',
        'Ladakh',
        'Other Territory',
    ];

    $yesNoOptions = ['1' => 'Y', '0' => 'N'];

    $tdsDeducteeTypes = [
        'Company',
        'Non-Company (Resident)',
        'Non-Resident (Individual)',
        'Non-Resident (Company)',
        'Cooperative Society',
        'HUF',
        'Trust',
        'AOP/BOI',
    ];

    $tdsNatureOptions = [
        '192 - Salaries',
        '193 - Interest on Securities',
        '194 - Dividend',
        '194A - Interest other than Sec',
        '194B - Winnings Lottery',
        '194C - Contractors',
        '194D - Insurance Commission',
        '194G - Commission on Lottery',
        '194H - Commission/Brokerage',
        '194I - Rent',
        '194IA - Transfer of Immovable Property',
        '194J - Professional/Technical Fees',
        '194K - Income from MF Units',
        '194LA - Compensation (Land Acq)',
        '194M - Payment to Contractor/Professional (Indiv)',
        '194N - Cash Withdrawal',
        '194O - E-Commerce',
        '194Q - Purchase of Goods',
        '194R - Benefits/Perquisites',
        '194S - VDA (Crypto)',
        '195 - Non-Resident Payments',
        '206C - TCS on various items',
    ];

    $tdsApplicableValue = old('tds_applicable', isset($response) ? (string)($response->tds_applicable ?? '0') : '0');
    $maintainBillWiseValue = old('maintain_bill_wise', isset($response) ? (string)($response->maintain_bill_wise ?? '0') : '0');
    $isLowerDeductionValue = old('is_lower_deduction', isset($response) ? (string)($response->is_lower_deduction ?? '0') : '0');
@endphp

<div class="row">
    <div class="card">
        <div class="card-header d-block card_hearder_mimi">
            <div class="row">
                <div class="col-md-6 card-title card_hearder_mimi_text">
                    {{ isset($response) ? 'EDIT VENDOR' : 'ADD VENDOR' }}
                </div>
            </div>
        </div>

        <div class="card-body">
            <form action="{{ route('store.update-vendor', ['id' => @$response->id]) }}" method="POST" id="yourFormId">
                @csrf

                <div class="">
                    <div class="form-group">
                        <label for="vendor_name" class="medicinelabel">Vendor Name <span class="text-danger">*</span></label>
                        <input type="text" value="{{ old('vendor_name', @$response->vendor_name) }}" id="vendor_name" name="vendor_name">
                        @error('vendor_name')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="row row-sm">
                        <div class="col-lg addvendoredit">
                            <label for="short_name">Short Name</label>
                            <input type="text" class="mb-4" id="short_name" name="short_name" value="{{ old('short_name', @$response->short_name) }}">
                            @error('short_name')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="col-lg addvendoredit">
                            <label for="email">Vendor Email <span class="text-danger">*</span></label>
                            <input type="text" class="mb-4" id="email" name="email" value="{{ old('email', @$response->email) }}">
                            @error('email')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="col-lg addvendoredit">
                            <label for="phone">Vendor Phone no.</label>
                            <input type="text" class="mb-4" id="phone" name="phone" maxlength="10" oninput="this.value = this.value.replace(/[^0-9]/g, '');" value="{{ old('phone', @$response->phone) }}">
                            @error('phone')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="row row-sm">
                        <div class="col-lg addvendoredit">
                            <label for="state">State Code <span class="text-danger">*</span></label>
                            <select class="form-control select2-show-search" id="state" name="state">
                                <option value="">Select State Code</option>
                                @foreach ($stateCodeOptions as $stateCodeValue => $stateCodeName)
                                    <option
                                        value="{{ $stateCodeValue }}"
                                        {{ in_array(old('state', @$response->state), [$stateCodeValue, $stateCodeValue . '-' . $stateCodeName, @$response->state_code], true) ? 'selected' : '' }}>
                                        {{ $stateCodeName }}
                                    </option>
                                @endforeach
                            </select>
                            @error('state')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="col-lg addvendoredit">
                            <label for="place_of_supply">Place of Supply</label>
                            <select class="form-control select2-show-search" id="place_of_supply" name="place_of_supply">
                                <option value="">Select Place of Supply</option>
                                @foreach ($placeOfSupplyOptions as $placeOfSupply)
                                    <option value="{{ $placeOfSupply }}" {{ old('place_of_supply', @$response->place_of_supply) == $placeOfSupply ? 'selected' : '' }}>
                                        {{ $placeOfSupply }}
                                    </option>
                                @endforeach
                            </select>
                            @error('place_of_supply')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="row row-sm">
                        <div class="col-lg addvendoredit">
                            <label for="pin_code">Pincode</label>
                            <input type="text" class="mb-4" id="pin_code" name="pin_code" value="{{ old('pin_code', @$response->pin_code) }}">
                        </div>

                        <div class="col-lg addvendoredit">
                            <label for="gstin">GSTIN <span class="text-danger">*</span></label>
                            <input type="text" class="mb-4" id="gstin" name="gstin" value="{{ old('gstin', @$response->gstin) }}">
                            @error('gstin')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="col-lg addvendoredit">
                            <label for="pan_number">PAN Number <span class="text-danger">*</span></label>
                            <input type="text" class="mb-4" id="pan_number" name="pan_number" value="{{ old('pan_number', @$response->pan_number) }}">
                            @error('pan_number')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="row row-sm">
                        <div class="col-lg addvendoredit">
                            <label for="gst_registration_type">GST Registration Type <span class="text-danger">*</span></label>
                            <select class="form-control" id="gst_registration_type" name="gst_registration_type">
                                <option value="">Select GST Registration Type</option>
                                @foreach ($gstRegistrationTypes as $gstType)
                                    <option value="{{ $gstType }}" {{ old('gst_registration_type', @$response->gst_registration_type) == $gstType ? 'selected' : '' }}>
                                        {{ $gstType }}
                                    </option>
                                @endforeach
                            </select>
                            @error('gst_registration_type')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="col-lg addvendoredit">
                            <label for="contact_person_name">Contact Person name</label>
                            <input type="text" class="mb-4" id="contact_person_name" name="contact_person_name" value="{{ old('contact_person_name', @$response->contact_person_name) }}">
                        </div>

                        <div class="col-lg addvendoredit">
                            <label for="opening_balance">Opening Balance</label>
                            <input type="number" step="0.01" class="mb-4" id="opening_balance" name="opening_balance" value="{{ old('opening_balance', @$response->opening_balance ?? 0) }}">
                            @error('opening_balance')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="row row-sm">
                        <div class="col-lg addvendoredit">
                            <label for="address">Vendor Address</label>
                            <input type="text" class="mb-4" id="address" name="address" value="{{ old('address', @$response->address) }}">
                        </div>

                        <div class="col-lg addvendoredit">
                            <label for="address_line_2">Address Line 2</label>
                            <input type="text" class="mb-4" id="address_line_2" name="address_line_2" value="{{ old('address_line_2', @$response->address_line_2) }}">
                            @error('address_line_2')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="row row-sm">
                        <div class="col-lg addvendoredit">
                            <label for="credit_limit">Credit Limit</label>
                            <input type="number" step="0.01" min="0" class="mb-4" id="credit_limit" name="credit_limit" value="{{ old('credit_limit', @$response->credit_limit ?? 0) }}">
                            @error('credit_limit')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="col-lg addvendoredit">
                            <label for="credit_days">Credit Days</label>
                            <input type="number" min="0" class="mb-4" id="credit_days" name="credit_days" value="{{ old('credit_days', @$response->credit_days ?? 0) }}">
                            @error('credit_days')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="col-lg addvendoredit">
                            <label for="maintain_bill_wise">Maintain Bill-wise <span class="text-danger">*</span></label>
                            <select class="form-control" id="maintain_bill_wise" name="maintain_bill_wise">
                                @foreach ($yesNoOptions as $optionValue => $optionLabel)
                                    <option value="{{ $optionValue }}" {{ (string)$maintainBillWiseValue === (string)$optionValue ? 'selected' : '' }}>
                                        {{ $optionLabel }}
                                    </option>
                                @endforeach
                            </select>
                            @error('maintain_bill_wise')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="row row-sm">
                        <div class="col-lg addvendoredit">
                            <label for="tds_applicable">TDS Applicable</label>
                            <select class="form-control" id="tds_applicable" name="tds_applicable">
                                @foreach ($yesNoOptions as $optionValue => $optionLabel)
                                    <option value="{{ $optionValue }}" {{ (string)$tdsApplicableValue === (string)$optionValue ? 'selected' : '' }}>
                                        {{ $optionLabel }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-lg addvendoredit tds-dependent">
                            <label for="tds_deductee_type">TDS Deductee Type <span class="text-danger">*</span></label>
                            <select class="form-control" id="tds_deductee_type" name="tds_deductee_type">
                                <option value="">Select TDS Deductee Type</option>
                                @foreach ($tdsDeducteeTypes as $tdsDeducteeType)
                                    <option value="{{ $tdsDeducteeType }}" {{ old('tds_deductee_type', @$response->tds_deductee_type) == $tdsDeducteeType ? 'selected' : '' }}>
                                        {{ $tdsDeducteeType }}
                                    </option>
                                @endforeach
                            </select>
                            @error('tds_deductee_type')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="col-lg addvendoredit tds-dependent">
                            <label for="tds_nature_of_payment">TDS Nature of Payment <span class="text-danger">*</span></label>
                            <select class="form-control" id="tds_nature_of_payment" name="tds_nature_of_payment">
                                <option value="">Select TDS Nature of Payment</option>
                                @foreach ($tdsNatureOptions as $tdsNature)
                                    <option value="{{ $tdsNature }}" {{ old('tds_nature_of_payment', @$response->tds_nature_of_payment) == $tdsNature ? 'selected' : '' }}>
                                        {{ $tdsNature }}
                                    </option>
                                @endforeach
                            </select>
                            @error('tds_nature_of_payment')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="row row-sm">
                        <div class="col-lg addvendoredit">
                            <label for="is_lower_deduction">Is Lower Deduction</label>
                            <select class="form-control" id="is_lower_deduction" name="is_lower_deduction">
                                @foreach ($yesNoOptions as $optionValue => $optionLabel)
                                    <option value="{{ $optionValue }}" {{ (string)$isLowerDeductionValue === (string)$optionValue ? 'selected' : '' }}>
                                        {{ $optionLabel }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-lg addvendoredit lower-deduction-dependent">
                            <label for="lower_deduction_rate">Lower Deduction Rate</label>
                            <input type="number" step="0.01" min="0" max="100" class="mb-4" id="lower_deduction_rate" name="lower_deduction_rate" value="{{ old('lower_deduction_rate', @$response->lower_deduction_rate) }}">
                            @error('lower_deduction_rate')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="col-lg addvendoredit lower-deduction-dependent">
                            <label for="lower_deduction_cert_no">Lower Deduction Cert No</label>
                            <input type="text" class="mb-4" id="lower_deduction_cert_no" name="lower_deduction_cert_no" value="{{ old('lower_deduction_cert_no', @$response->lower_deduction_cert_no) }}">
                            @error('lower_deduction_cert_no')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary mt-4 mb-0 submitBtn">
                    {{ isset($response) ? 'Update Vendor' : 'Add Vendor' }}
                </button>
            </form>
        </div>
    </div>
</div>
@endsection

@push('js')
<script>
    $(document).ready(function () {
        const form = $('#yourFormId');
        const requiredFields = ["vendor_name", "email", "pan_number", "gstin", "gst_registration_type", "state", "maintain_bill_wise"];
        let isSubmitting = false;
        let lastClickedSubmit = null;

        function toggleTdsFields() {
            const tdsApplicable = $('#tds_applicable').val() === '1';
            $('.tds-dependent').toggle(tdsApplicable);

            if (!tdsApplicable) {
                $('#tds_deductee_type').val('');
                $('#tds_nature_of_payment').val('');
            }
        }

        function toggleLowerDeductionFields() {
            const isLowerDeduction = $('#is_lower_deduction').val() === '1';
            $('.lower-deduction-dependent').toggle(isLowerDeduction);

            if (!isLowerDeduction) {
                $('#lower_deduction_rate').val('');
                $('#lower_deduction_cert_no').val('');
            }
        }

        form.find('.submitBtn').on('click', function () {
            lastClickedSubmit = this;
        });

        $('#tds_applicable').on('change', toggleTdsFields);
        $('#is_lower_deduction').on('change', toggleLowerDeductionFields);

        toggleTdsFields();
        toggleLowerDeductionFields();

        form.on('submit', function (e) {
            if (isSubmitting) {
                e.preventDefault();
                return;
            }

            let isValid = true;

            requiredFields.forEach(field => {
                let inputField = form.find(`[name="${field}"]`);
                if (!inputField.length) return;

                let fieldValue = (inputField.val() || '').toString().trim();

                if (fieldValue) {
                    inputField.removeClass('border border-danger');
                } else {
                    inputField.addClass('border border-danger');
                    isValid = false;
                }
            });

            if ($('#tds_applicable').val() === '1') {
                ['tds_deductee_type', 'tds_nature_of_payment'].forEach(field => {
                    let inputField = form.find(`[name="${field}"]`);
                    let fieldValue = (inputField.val() || '').toString().trim();

                    if (fieldValue) {
                        inputField.removeClass('border border-danger');
                    } else {
                        inputField.addClass('border border-danger');
                        isValid = false;
                    }
                });
            }

            if (!isValid) {
                e.preventDefault();
                alert('Please fill all required fields.');
                return;
            }

            isSubmitting = true;
            form.find('.submitBtn').prop('disabled', true);

            if (lastClickedSubmit) {
                $(lastClickedSubmit).html('<i class="fa fa-spinner fa-spin me-1"></i> Processing...');
            }
        });
    });
</script>
@endpush
