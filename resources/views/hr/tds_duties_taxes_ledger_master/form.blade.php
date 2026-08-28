<div class="row">
    <div class="col-12 mb-3">
        <h5 class="border-bottom pb-2">Identification</h5>
    </div>

    <div class="col-md-6 mb-3">
        <label><strong>TDS Ledger Name <span class="text-danger">*</span></strong></label>
        <input type="text" name="tds_ledger_name" class="form-control"
               value="{{ old('tds_ledger_name', $item->tds_ledger_name ?? '') }}"
               placeholder="Enter TDS ledger name">
    </div>

    <div class="col-md-6 mb-3">
        <label><strong>Under Group <span class="text-danger">*</span></strong></label>
        <input type="text" name="under_group" class="form-control"
               value="{{ old('under_group', $item->under_group ?? 'Duties & Taxes') }}"
               readonly>
    </div>

    <div class="col-12 mt-2 mb-3">
        <h5 class="border-bottom pb-2">TDS Classification</h5>
    </div>

    <div class="col-md-6 mb-3">
        <label><strong>TDS Section Code <span class="text-danger">*</span></strong></label>
        <select name="tds_section_code" class="form-control">
            <option value="">Select TDS Section Code</option>
            @php
                $tdsSectionCodes = [
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
            @endphp
            @foreach($tdsSectionCodes as $code)
                <option value="{{ $code }}" {{ old('tds_section_code', $item->tds_section_code ?? '') == $code ? 'selected' : '' }}>
                    {{ $code }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="col-md-6 mb-3">
        <label><strong>TDS Section Description <span class="text-danger">*</span></strong></label>
        <input type="text" name="tds_section_desc" class="form-control"
               value="{{ old('tds_section_desc', $item->tds_section_desc ?? '') }}"
               placeholder="Enter TDS section description">
    </div>

    <div class="col-md-6 mb-3">
        <label><strong>Deductee Type <span class="text-danger">*</span></strong></label>
        <select name="deductee_type" class="form-control">
            <option value="">Select Deductee Type</option>
            @php
                $deducteeTypes = [
                    'Company',
                    'Non-Company (Resident)',
                    'Non-Resident (Individual)',
                    'Non-Resident (Company)',
                    'Cooperative Society',
                    'HUF',
                    'Trust',
                    'AOP/BOI',
                ];
            @endphp
            @foreach($deducteeTypes as $deductee)
                <option value="{{ $deductee }}" {{ old('deductee_type', $item->deductee_type ?? '') == $deductee ? 'selected' : '' }}>
                    {{ $deductee }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="col-md-6 mb-3">
        <label><strong>TDS Rate (%) <span class="text-danger">*</span></strong></label>
        <input type="number" step="0.01" name="tds_rate" class="form-control"
               value="{{ old('tds_rate', $item->tds_rate ?? '') }}"
               placeholder="0.00">
    </div>

    <div class="col-md-3 mb-3">
        <label><strong>Surcharge Applicable <span class="text-danger">*</span></strong></label>
        <select name="surcharge_applicable" id="surcharge_applicable" class="form-control">
            <option value="1" {{ old('surcharge_applicable', $item->surcharge_applicable ?? 0) == 1 ? 'selected' : '' }}>Y</option>
            <option value="0" {{ old('surcharge_applicable', $item->surcharge_applicable ?? 0) == 0 ? 'selected' : '' }}>N</option>
        </select>
    </div>

    <div class="col-md-3 mb-3">
        <label><strong>Surcharge Rate (%)</strong></label>
        <input type="number" step="0.01" name="surcharge_rate" id="surcharge_rate" class="form-control"
               value="{{ old('surcharge_rate', $item->surcharge_rate ?? '') }}"
               placeholder="0.00">
    </div>

    <div class="col-md-3 mb-3">
        <label><strong>Cess Applicable <span class="text-danger">*</span></strong></label>
        <select name="cess_applicable" id="cess_applicable" class="form-control">
            <option value="1" {{ old('cess_applicable', $item->cess_applicable ?? 0) == 1 ? 'selected' : '' }}>Y</option>
            <option value="0" {{ old('cess_applicable', $item->cess_applicable ?? 0) == 0 ? 'selected' : '' }}>N</option>
        </select>
    </div>

    <div class="col-md-3 mb-3">
        <label><strong>Cess Rate (%)</strong></label>
        <input type="number" step="0.01" name="cess_rate" id="cess_rate" class="form-control"
               value="{{ old('cess_rate', $item->cess_rate ?? '') }}"
               placeholder="0.00">
    </div>

    <div class="col-12 mt-2 mb-3">
        <h5 class="border-bottom pb-2">Payment & Challan</h5>
    </div>

    <div class="col-md-6 mb-3">
        <label><strong>TDS Payment Code <span class="text-danger">*</span></strong></label>
        <input type="text" name="tds_payment_code" class="form-control"
               value="{{ old('tds_payment_code', $item->tds_payment_code ?? '') }}"
               placeholder="Enter TDS payment code">
    </div>

    <div class="col-md-6 mb-3">
        <label><strong>TDS Type <span class="text-danger">*</span></strong></label>
        <select name="tds_type" class="form-control">
            <option value="">Select TDS Type</option>
            <option value="TDS" {{ old('tds_type', $item->tds_type ?? '') == 'TDS' ? 'selected' : '' }}>TDS</option>
            <option value="TCS" {{ old('tds_type', $item->tds_type ?? '') == 'TCS' ? 'selected' : '' }}>TCS</option>
        </select>
    </div>

    <div class="col-12 mt-2 mb-3">
        <h5 class="border-bottom pb-2">Threshold</h5>
    </div>

    <div class="col-md-6 mb-3">
        <label><strong>Annual Threshold (INR)</strong></label>
        <input type="number" step="0.01" name="annual_threshold" class="form-control"
               value="{{ old('annual_threshold', $item->annual_threshold ?? '') }}"
               placeholder="0.00">
    </div>

    <div class="col-md-6 mb-3">
        <label><strong>Single Txn Threshold</strong></label>
        <input type="number" step="0.01" name="single_txn_threshold" class="form-control"
               value="{{ old('single_txn_threshold', $item->single_txn_threshold ?? '') }}"
               placeholder="0.00">
    </div>

    <div class="col-12 mt-2 mb-3">
        <h5 class="border-bottom pb-2">Misc</h5>
    </div>

    <div class="col-md-6 mb-3">
        <label><strong>Nature of Payment <span class="text-danger">*</span></strong></label>
        <input type="text" name="nature_of_payment" class="form-control"
               value="{{ old('nature_of_payment', $item->nature_of_payment ?? '') }}"
               placeholder="Enter nature of payment">
    </div>

    <div class="col-md-6 mb-3">
        <label><strong>Opening Balance</strong></label>
        <input type="number" step="0.01" name="opening_balance" class="form-control"
               value="{{ old('opening_balance', $item->opening_balance ?? 0) }}"
               placeholder="0.00">
    </div>

    <div class="col-12 mt-3">
        <button type="submit" class="btn btn-success">Save</button>
        <a href="{{ route('tds-duties-taxes-ledger-master.index') }}" class="btn btn-secondary">Back</a>
    </div>
</div>

@push('js')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const surchargeApplicable = document.getElementById('surcharge_applicable');
        const surchargeRate = document.getElementById('surcharge_rate');
        const cessApplicable = document.getElementById('cess_applicable');
        const cessRate = document.getElementById('cess_rate');

        function handleSurcharge() {
            surchargeRate.required = surchargeApplicable.value === '1';
        }

        function handleCess() {
            cessRate.required = cessApplicable.value === '1';
        }

        surchargeApplicable.addEventListener('change', handleSurcharge);
        cessApplicable.addEventListener('change', handleCess);

        handleSurcharge();
        handleCess();
    });
</script>
@endpush
