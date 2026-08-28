<div class="row">
    <div class="col-12 mb-3">
        <h5 class="border-bottom pb-2">Basic Information</h5>
    </div>

    <div class="col-md-6 mb-3">
        <label><strong>Ledger Name <span class="text-danger">*</span></strong></label>
        <input type="text" name="ledger_name" class="form-control"
               value="{{ old('ledger_name', $item->ledger_name ?? '') }}" placeholder="Enter ledger name">
    </div>

    <div class="col-md-6 mb-3">
        <label><strong>Ledger Group <span class="text-danger">*</span></strong></label>
        <select name="ledger_group" class="form-control">
            <option value="">Select Ledger Group</option>
            <option value="Direct Expenses" {{ old('ledger_group', $item->ledger_group ?? '') == 'Direct Expenses' ? 'selected' : '' }}>Direct Expenses</option>
            <option value="Indirect Expenses" {{ old('ledger_group', $item->ledger_group ?? '') == 'Indirect Expenses' ? 'selected' : '' }}>Indirect Expenses</option>
            <option value="Purchase Accounts" {{ old('ledger_group', $item->ledger_group ?? '') == 'Purchase Accounts' ? 'selected' : '' }}>Purchase Accounts</option>
            <option value="Manufacturing Expenses" {{ old('ledger_group', $item->ledger_group ?? '') == 'Manufacturing Expenses' ? 'selected' : '' }}>Manufacturing Expenses</option>
        </select>
    </div>

    <div class="col-12 mt-2 mb-3">
        <h5 class="border-bottom pb-2">TDS Configuration</h5>
    </div>

    <div class="col-md-3 mb-3">
        <label><strong>TDS Applicable <span class="text-danger">*</span></strong></label>
        <select name="tds_applicable" id="tds_applicable" class="form-control">
            <option value="1" {{ old('tds_applicable', $item->tds_applicable ?? 0) == 1 ? 'selected' : '' }}>Y</option>
            <option value="0" {{ old('tds_applicable', $item->tds_applicable ?? 0) == 0 ? 'selected' : '' }}>N</option>
        </select>
    </div>

    <div class="col-md-3 mb-3">
        <label><strong>TDS Nature of Payment <span class="text-danger tds-required">*</span></strong></label>
        <input type="text" name="tds_nature_payment" id="tds_nature_payment" class="form-control"
               value="{{ old('tds_nature_payment', $item->tds_nature_payment ?? '') }}" placeholder="Enter TDS nature">
    </div>

    <div class="col-md-3 mb-3">
        <label><strong>TDS Rate (%) <span class="text-danger tds-required">*</span></strong></label>
        <input type="number" step="0.01" name="tds_rate" id="tds_rate" class="form-control"
               value="{{ old('tds_rate', $item->tds_rate ?? '') }}" placeholder="0.00">
    </div>

    <div class="col-md-3 mb-3">
        <label><strong>TDS Threshold (Optional)</strong></label>
        <input type="number" step="0.01" name="tds_threshold" class="form-control"
               value="{{ old('tds_threshold', $item->tds_threshold ?? '') }}" placeholder="0.00">
    </div>

    <div class="col-12 mt-2 mb-3">
        <h5 class="border-bottom pb-2">GST Configuration</h5>
    </div>

    <div class="col-md-3 mb-3">
        <label><strong>GST Applicable <span class="text-danger">*</span></strong></label>
        <select name="gst_applicable" id="gst_applicable" class="form-control">
            <option value="1" {{ old('gst_applicable', $item->gst_applicable ?? 0) == 1 ? 'selected' : '' }}>Y</option>
            <option value="0" {{ old('gst_applicable', $item->gst_applicable ?? 0) == 0 ? 'selected' : '' }}>N</option>
        </select>
    </div>

    <div class="col-md-3 mb-3">
        <label><strong>GST Charge Type <span class="text-danger gst-required">*</span></strong></label>
        <select name="gst_charge_type" id="gst_charge_type" class="form-control">
            <option value="">Select</option>
            <option value="Forward" {{ old('gst_charge_type', $item->gst_charge_type ?? '') == 'Forward' ? 'selected' : '' }}>Forward</option>
            <option value="RCM" {{ old('gst_charge_type', $item->gst_charge_type ?? '') == 'RCM' ? 'selected' : '' }}>RCM</option>
            <option value="Both" {{ old('gst_charge_type', $item->gst_charge_type ?? '') == 'Both' ? 'selected' : '' }}>Both</option>
        </select>
    </div>

    <div class="col-md-3 mb-3">
        <label><strong>SAC / HSN Code <span class="text-danger gst-required">*</span></strong></label>
        <input type="text"
            name="sac_hsn_code"
            id="sac_hsn_code"
            class="form-control"
            value="{{ old('sac_hsn_code', $item->sac_hsn_code ?? '') }}"
            placeholder="Enter 4 to 8 digit code"
            minlength="4"
            maxlength="8"
            pattern="[0-9]{4,8}"
            inputmode="numeric">
    </div>

    <div class="col-md-3 mb-3">
        <label><strong>GST Rate (%) <span class="text-danger gst-required">*</span></strong></label>
        <select name="gst_rate" id="gst_rate" class="form-control">
            <option value="">Select</option>
            @foreach([0,5,12,18,28] as $rate)
                <option value="{{ $rate }}" {{ old('gst_rate', $item->gst_rate ?? '') == (string)$rate ? 'selected' : '' }}>
                    {{ $rate }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="col-md-3 mb-3 gst-ledger-group">
        <label><strong>IGST Ledger Name <span class="text-danger gst-ledger-required">*</span></strong></label>
        <input type="text" name="igst_ledger_name" id="igst_ledger_name" class="form-control"
               value="{{ old('igst_ledger_name', $item->igst_ledger_name ?? '') }}" placeholder="Enter IGST ledger">
    </div>

    <div class="col-md-3 mb-3 gst-ledger-group">
        <label><strong>CGST Ledger Name <span class="text-danger gst-ledger-required">*</span></strong></label>
        <input type="text" name="cgst_ledger_name" id="cgst_ledger_name" class="form-control"
               value="{{ old('cgst_ledger_name', $item->cgst_ledger_name ?? '') }}" placeholder="Enter CGST ledger">
    </div>

    <div class="col-md-3 mb-3 gst-ledger-group">
        <label><strong>SGST Ledger Name <span class="text-danger gst-ledger-required">*</span></strong></label>
        <input type="text" name="sgst_ledger_name" id="sgst_ledger_name" class="form-control"
               value="{{ old('sgst_ledger_name', $item->sgst_ledger_name ?? '') }}" placeholder="Enter SGST ledger">
    </div>

    <div class="col-md-3 mb-3 rcm-ledger-group">
        <label><strong>RCM Output GST Ledger <span class="text-danger rcm-required">*</span></strong></label>
        <input type="text" name="rcm_output_gst_ledger" id="rcm_output_gst_ledger" class="form-control"
               value="{{ old('rcm_output_gst_ledger', $item->rcm_output_gst_ledger ?? '') }}" placeholder="Enter RCM ledger">
    </div>

    <div class="col-12 mt-2 mb-3">
        <h5 class="border-bottom pb-2">Cost Centre & Misc</h5>
    </div>

    <div class="col-md-3 mb-3">
        <label><strong>Cost Centre Applicable (Optional)</strong></label>
        <select name="cost_centre_applicable" class="form-control">
            <option value="1" {{ old('cost_centre_applicable', $item->cost_centre_applicable ?? 0) == 1 ? 'selected' : '' }}>Y</option>
            <option value="0" {{ old('cost_centre_applicable', $item->cost_centre_applicable ?? 0) == 0 ? 'selected' : '' }}>N</option>
        </select>
    </div>

    <div class="col-md-3 mb-3">
        <label><strong>Default Cost Centre (Optional)</strong></label>
        <input type="text" name="default_cost_centre" class="form-control"
               value="{{ old('default_cost_centre', $item->default_cost_centre ?? '') }}" placeholder="Enter cost centre">
    </div>

    <div class="col-md-3 mb-3">
        <label><strong>Opening Balance (Optional)</strong></label>
        <input type="number" step="0.01" name="opening_balance" class="form-control"
               value="{{ old('opening_balance', $item->opening_balance ?? 0) }}" placeholder="0.00">
    </div>

    <div class="col-md-12 mb-3">
        <label><strong>Description / Notes (Optional)</strong></label>
        <textarea name="description" class="form-control" rows="4" placeholder="Enter description">{{ old('description', $item->description ?? '') }}</textarea>
    </div>

    <div class="col-12 mt-3">
        <button type="submit" class="btn btn-success">Save</button>
        <a href="{{ route('expense-ledger-master.index') }}" class="btn btn-secondary">Back</a>
    </div>
</div>

@push('js')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const tdsApplicable = document.getElementById('tds_applicable');
        const tdsNature = document.getElementById('tds_nature_payment');
        const tdsRate = document.getElementById('tds_rate');

        const gstApplicable = document.getElementById('gst_applicable');
        const gstChargeType = document.getElementById('gst_charge_type');
        const sacHsnCode = document.getElementById('sac_hsn_code');
        const gstRate = document.getElementById('gst_rate');

        const igstLedger = document.getElementById('igst_ledger_name');
        const cgstLedger = document.getElementById('cgst_ledger_name');
        const sgstLedger = document.getElementById('sgst_ledger_name');
        const rcmLedger = document.getElementById('rcm_output_gst_ledger');

        function handleTdsFields() {
            const isTds = tdsApplicable.value === '1';
            tdsNature.required = isTds;
            tdsRate.required = isTds;
        }

        function handleGstFields() {
            const isGst = gstApplicable.value === '1';
            const chargeType = gstChargeType.value;

            gstChargeType.required = isGst;
            sacHsnCode.required = isGst;
            gstRate.required = isGst;

            igstLedger.required = false;
            cgstLedger.required = false;
            sgstLedger.required = false;
            rcmLedger.required = false;

            if (isGst && (chargeType === 'Forward' || chargeType === 'Both')) {
                igstLedger.required = true;
                cgstLedger.required = true;
                sgstLedger.required = true;
            }

            if (isGst && (chargeType === 'RCM' || chargeType === 'Both')) {
                rcmLedger.required = true;
            }
        }

        tdsApplicable.addEventListener('change', handleTdsFields);
        gstApplicable.addEventListener('change', handleGstFields);
        gstChargeType.addEventListener('change', handleGstFields);

        handleTdsFields();
        handleGstFields();
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const sacHsnCode = document.getElementById('sac_hsn_code');

        if (sacHsnCode) {
            sacHsnCode.addEventListener('input', function () {
                this.value = this.value.replace(/[^0-9]/g, '').slice(0, 8);
            });
        }
    });
</script>
@endpush
