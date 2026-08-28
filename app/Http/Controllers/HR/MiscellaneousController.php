<?php

namespace App\Http\Controllers\HR;

use App\Http\Controllers\Controller;
use App\Models\ExpenseLedgerMaster;
use App\Models\Miscellaneous;
use App\Models\StVendor;
use App\Models\TdsDutiesTaxesLedgerMaster;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Barryvdh\DomPDF\Facade\Pdf;

class MiscellaneousController extends Controller
{
    public function index()
    {
        $data = $this->prepareViewData('Miscellaneous Bills');
        $data['redirectRoute'] = 'hr.miscellaneous';

        return view('hr.miscellaneous', $data);
    }

    public function accountIndex()
    {
        $data = $this->prepareViewData('Account Miscellaneous Bills', true);
        $data['redirectRoute'] = 'hr.account-miscellaneous';
        return view('hr.account-miscellaneous', $data);
    }

    public function details(Request $request, Miscellaneous $miscellaneous)
    {
        $returnRoute = $request->query('ref') === 'account'
            ? 'hr.account-miscellaneous'
            : 'hr.miscellaneous';

        $data = $this->prepareDetailViewData($miscellaneous);
        $data['returnRoute'] = $returnRoute;

        return view('hr.miscellaneous-details', $data);
    }

    public function detailsPdf(Miscellaneous $miscellaneous)
    {
        $data = $this->prepareDetailViewData($miscellaneous);

        $pdf = Pdf::loadView('hr.miscellaneous-details-pdf', $data)
            ->setPaper('a4', 'portrait');

        return $pdf->download(sprintf('miscellaneous-%s.pdf', $miscellaneous->id));
    }

    public function store(Request $request)
    {
        $isAccountForm = $request->input('form_context') === 'account';
        $defaultRedirect = $isAccountForm
            ? 'hr.account-miscellaneous'
            : 'hr.miscellaneous';
        $redirectRoute = $request->input('redirect_route', $defaultRedirect);

        $request->validate([
            'invoice_upload' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',
            'bill_purpose' => 'required|string|max:255',
            'expense_ledger_masters_id' => $isAccountForm
                ? 'required|integer|exists:expense_ledger_masters,id'
                : 'nullable|integer|exists:expense_ledger_masters,id',
            'tds_duties_taxes_ledger_masters_id' => $isAccountForm
                ? 'required|integer|exists:tds_duties_taxes_ledger_masters,id'
                : 'nullable|integer|exists:tds_duties_taxes_ledger_masters,id',
            'service_provider' => $isAccountForm
                ? 'nullable|integer|exists:st_vendors,id'
                : 'required|integer|exists:st_vendors,id',
            'bill_amount' => 'required|numeric|min:0',
            'note' => 'nullable|string|max:1000',
            'narration' => 'nullable|string',
            'due_date' => 'nullable|date',
            'gst' => 'nullable|numeric|min:0|max:100',
            'discount' => 'nullable|numeric|min:0',
            'gst_amount' => 'nullable|numeric|min:0',
            'tds_bill_amount' => 'nullable|numeric|min:0',
            'tds_percentage' => 'nullable|numeric|min:0|max:100',
            'tds_deduction_amount' => 'nullable|numeric|min:0',
        ]);

        $data = $request->only([
            'bill_purpose',
            'expense_ledger_masters_id',
            'tds_duties_taxes_ledger_masters_id',
            'service_provider',
            'bill_amount',
            'note',
            'narration',
            'due_date',
            'gst',
            'discount',
            'gst_amount',
        ]);

        $billAmountValue = $this->parseAmountInput($request->input('bill_amount'));
        if ($billAmountValue !== null) {
            $data['bill_amount'] = $billAmountValue;
        }

        $data['discount'] = $this->parseAmountInput($data['discount'] ?? null) ?? 0;
        if ($isAccountForm) {
            $this->applyAccountTdsData($request, $data, $billAmountValue);
        } else {
            $data['gst'] = $this->normalizeGst($data['gst'] ?? null);
            $gstAmountInput = $this->parseAmountInput($request->input('gst_amount'));
            if ($gstAmountInput === null) {
                $baseAmount = $this->parseAmountInput($request->input('bill_amount'));
                $gstPercent = $this->normalizeGst($request->input('gst'));
                $gstAmountInput = $this->calculateTotalWithGst($baseAmount, $gstPercent);
            }
            if ($gstAmountInput !== null) {
                $data['gst_amount'] = $gstAmountInput;
            }
            $totalBase = $gstAmountInput ?? $billAmountValue ?? $data['bill_amount'];
            $totalAfterDiscount = max(($totalBase ?? 0) - ($data['discount'] ?? 0), 0);
            $data['gst_amount'] = $totalAfterDiscount;
            $data['total_amount'] = $totalAfterDiscount;
        }

        if (Schema::hasColumn('miscellanies', 'created_by')) {
            $data['created_by'] = Auth::id();
        }
        if ($isAccountForm && Schema::hasColumn('miscellanies', 'verified_by')) {
            $data['verified_by'] = Auth::id();
            $data['verified_at'] = now();
        }

        if ($request->hasFile('invoice_upload')) {
            $file = $request->file('invoice_upload');
            $targetDir = public_path('miscellaneous/invoices');
            if (!File::isDirectory($targetDir)) {
                File::makeDirectory($targetDir, 0755, true);
            }
            $filename = time() . '_' . Str::random(6) . '.' . $file->getClientOriginalExtension();
            $file->move($targetDir, $filename);
            $data['invoice_upload'] = 'public/miscellaneous/invoices/' . $filename;
        }

        $miscellaneous = DB::transaction(function () use ($data) {
            if (Schema::hasColumn('miscellanies', 'bill_no')) {
                $data['bill_no'] = $this->generateMiscellaneousBillNumber();
            }

            $miscellaneous = Miscellaneous::create($this->sanitizeOptionalColumns($data));
            $miscellaneous->updatePaymentStatus();

            return $miscellaneous;
        });

        return redirect()->route($redirectRoute)->with('success', 'Miscellaneous bill added.');
    }

    public function update(Request $request, Miscellaneous $miscellaneous)
    {
        $isAccountForm = $request->input('form_context') === 'account';
        $defaultRedirect = $isAccountForm
            ? 'hr.account-miscellaneous'
            : 'hr.miscellaneous';
        $redirectRoute = $request->input('redirect_route', $defaultRedirect);
        $request->validate([
            'invoice_upload' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',
            'bill_purpose' => 'required|string|max:255',
            'expense_ledger_masters_id' => $isAccountForm
                ? 'required|integer|exists:expense_ledger_masters,id'
                : 'nullable|integer|exists:expense_ledger_masters,id',
            'tds_duties_taxes_ledger_masters_id' => $isAccountForm
                ? 'required|integer|exists:tds_duties_taxes_ledger_masters,id'
                : 'nullable|integer|exists:tds_duties_taxes_ledger_masters,id',
            'service_provider' => $isAccountForm
                ? 'nullable|integer|exists:st_vendors,id'
                : 'required|integer|exists:st_vendors,id',
            'bill_amount' => 'required|numeric|min:0',
            'note' => 'nullable|string|max:1000',
            'narration' => 'nullable|string',
            'due_date' => 'nullable|date',
            'gst' => 'nullable|numeric|min:0|max:100',
            'discount' => 'nullable|numeric|min:0',
            'gst_amount' => 'nullable|numeric|min:0',
            'tds_bill_amount' => 'nullable|numeric|min:0',
            'tds_percentage' => 'nullable|numeric|min:0|max:100',
            'tds_deduction_amount' => 'nullable|numeric|min:0',
        ]);

        $data = $request->only([
            'bill_purpose',
            'expense_ledger_masters_id',
            'tds_duties_taxes_ledger_masters_id',
            'service_provider',
            'bill_amount',
            'note',
            'narration',
            'due_date',
            'gst',
            'discount',
            'gst_amount',
        ]);

        $billAmountValue = $this->parseAmountInput($request->input('bill_amount'));
        if ($billAmountValue !== null) {
            $data['bill_amount'] = $billAmountValue;
        }

        $discountInput = $this->parseAmountInput($request->input('discount'));
        if ($discountInput !== null) {
            $data['discount'] = $discountInput;
        } else {
            $data['discount'] = 0;
        }

        if ($isAccountForm) {
            $this->applyAccountTdsData($request, $data, $billAmountValue);
        } else {
            $gstValue = $this->normalizeGst($data['gst'] ?? null);
            $data['gst'] = $gstValue;
            $gstAmountInput = $this->parseAmountInput($request->input('gst_amount'));
            if ($gstAmountInput === null) {
                $baseAmount = $this->parseAmountInput($request->input('bill_amount'));
                $gstPercent = $this->normalizeGst($request->input('gst'));
                $gstAmountInput = $this->calculateTotalWithGst($baseAmount, $gstPercent);
            }
            $totalBase = $gstAmountInput ?? $billAmountValue ?? $data['bill_amount'];
            $data['gst_amount'] = $totalBase;
            $data['total_amount'] = $totalBase;
        }

        $shouldVerify = $request->boolean('mark_verified');
        if ($shouldVerify && Schema::hasColumn('miscellanies', 'verified_by')) {
            $data['verified_by'] = Auth::id();
            $data['verified_at'] = now();
        }

        $shouldApprove = $request->boolean('mark_approved');
        if ($shouldApprove && Schema::hasColumn('miscellanies', 'approved_by')) {
            if (!$miscellaneous->verified_by) {
                return redirect()->route($redirectRoute)->with('error', 'Bill must be verified before it can be approved.');
            }
        }

        if ($request->hasFile('invoice_upload')) {
            $file = $request->file('invoice_upload');
            $targetDir = public_path('miscellaneous/invoices');
            if (!File::isDirectory($targetDir)) {
                File::makeDirectory($targetDir, 0755, true);
            }
            $filename = time() . '_' . Str::random(6) . '.' . $file->getClientOriginalExtension();
            $file->move($targetDir, $filename);
            $data['invoice_upload'] = 'public/miscellaneous/invoices/' . $filename;
        }

        DB::transaction(function () use ($miscellaneous, &$data, $shouldApprove) {
            if ($shouldApprove) {
                $this->applyApprovalVoucherData($miscellaneous, $data);
            }

            $miscellaneous->update($this->sanitizeOptionalColumns($data));
            $miscellaneous->updatePaymentStatus();
        });

        return redirect()->route($redirectRoute)->with('success', 'Miscellaneous bill updated.');
    }

    protected function sanitizeOptionalColumns(array $data): array
    {
        $optionalColumns = [
            'bill_no',
            'note',
            'narration',
            'gst',
            'tds_section_code',
            'tds_percentage',
            'tds_bill_amount',
            'tds_deduction_amount',
            'created_by',
            'verified_by',
            'verified_at',
            'approved_by',
            'approved_at',
            'voucher_date',
            'voucher_number',
            'reference_number',
            'gst_amount',
            'total_amount',
            'expense_ledger_masters_id',
            'tds_duties_taxes_ledger_masters_id',
            'due_date',
        ];

        foreach ($optionalColumns as $column) {
            if (!Schema::hasColumn('miscellanies', $column)) {
                unset($data[$column]);
            }
        }

        return $data;
    }

    protected function normalizeGst(mixed $value): ?float
    {
        if ($value === null || $value === '') {
            return null;
        }

        return round((float) $value, 2);
    }

    protected function parseAmountInput(mixed $value): ?float
    {
        if ($value === null) {
            return null;
        }

        $value = trim((string) $value);
        if ($value === '') {
            return null;
        }

        return round((float) $value, 2);
    }

    protected function calculateTotalWithGst(?float $baseAmount, ?float $gstPercent): ?float
    {
        if ($baseAmount === null) {
            return null;
        }

        $gstPercent = $gstPercent ?? 0;
        return round($baseAmount + ($baseAmount * $gstPercent) / 100, 2);
    }

    protected function applyAccountTdsData(Request $request, array &$data, ?float $defaultBillAmount = null): void
    {
        $tdsLedgerId = $request->input('tds_duties_taxes_ledger_masters_id');
        $tdsLedger = $tdsLedgerId
            ? TdsDutiesTaxesLedgerMaster::query()->find($tdsLedgerId)
            : null;
        $sectionCode = $tdsLedger?->tds_section_code;
        $tdsBillAmount = $this->parseAmountInput($request->input('tds_bill_amount'));
        $tdsPercentage = $tdsLedger?->tds_rate !== null
            ? round((float) $tdsLedger->tds_rate, 2)
            : null;
        $tdsDeductionAmount = $tdsBillAmount !== null && $tdsPercentage !== null
            ? round(($tdsBillAmount * $tdsPercentage) / 100, 2)
            : 0.0;
        $netAmount = $tdsBillAmount !== null
            ? max($tdsBillAmount - $tdsDeductionAmount, 0)
            : ($defaultBillAmount ?? 0);

        $data['gst'] = null;
        $data['tds_section_code'] = $sectionCode !== '' ? $sectionCode : null;
        $data['tds_percentage'] = $tdsPercentage;
        $data['tds_bill_amount'] = $tdsBillAmount;
        $data['tds_deduction_amount'] = $tdsDeductionAmount;
        $data['gst_amount'] = $netAmount;
        $data['total_amount'] = $netAmount;
    }

    protected function applyApprovalVoucherData(Miscellaneous $miscellaneous, array &$data): void
    {
        $approvalDate = now();
        $data['approved_by'] = Auth::id();
        $data['approved_at'] = $approvalDate;

        if (Schema::hasColumn('miscellanies', 'voucher_date')) {
            $data['voucher_date'] = $approvalDate->toDateString();
        }

        if (Schema::hasColumn('miscellanies', 'voucher_number') && empty($miscellaneous->voucher_number)) {
            $data['voucher_number'] = $this->generateVoucherNumber($approvalDate);
        }

        if (Schema::hasColumn('miscellanies', 'reference_number') && empty($miscellaneous->reference_number)) {
            $data['reference_number'] = $this->generateReferenceNumber($approvalDate);
        }
    }

    protected function generateMiscellaneousBillNumber(?Carbon $date = null): string
    {
        $date ??= now();
        [$startDate, $endDate, $prefix] = $this->getFinancialYearMeta($date);

        $lastBillNo = Miscellaneous::query()
            ->whereBetween('created_at', [$startDate, $endDate])
            ->whereNotNull('bill_no')
            ->where('bill_no', 'like', $prefix . '#%')
            ->lockForUpdate()
            ->orderByDesc('id')
            ->value('bill_no');

        $lastSequence = 0;
        if ($lastBillNo && preg_match('/#(\d+)$/', $lastBillNo, $matches)) {
            $lastSequence = (int) $matches[1];
        }

        return sprintf('%s#%04d', $prefix, $lastSequence + 1);
    }

    protected function generateVoucherNumber(?Carbon $date = null): string
    {
        $date ??= now();
        $year = $date->format('Y');
        $prefix = sprintf('VCH/%s/', $year);

        $lastVoucherNumber = Miscellaneous::query()
            ->whereYear('voucher_date', (int) $year)
            ->whereNotNull('voucher_number')
            ->where('voucher_number', 'like', $prefix . '%')
            ->lockForUpdate()
            ->orderByDesc('id')
            ->value('voucher_number');

        $lastSequence = 0;
        if ($lastVoucherNumber && preg_match('/(\d+)$/', $lastVoucherNumber, $matches)) {
            $lastSequence = (int) $matches[1];
        }

        return sprintf('%s%03d', $prefix, $lastSequence + 1);
    }

    protected function generateReferenceNumber(?Carbon $date = null): string
    {
        $date ??= now();
        $year = $date->format('Y');
        $prefix = sprintf('REF/3P/%s/', $year);

        $lastReferenceNumber = Miscellaneous::query()
            ->whereYear('voucher_date', (int) $year)
            ->whereNotNull('reference_number')
            ->where('reference_number', 'like', $prefix . '%')
            ->lockForUpdate()
            ->orderByDesc('id')
            ->value('reference_number');

        $lastSequence = 0;
        if ($lastReferenceNumber && preg_match('/(\d+)$/', $lastReferenceNumber, $matches)) {
            $lastSequence = (int) $matches[1];
        }

        return sprintf('%s%03d', $prefix, $lastSequence + 1);
    }

    protected function getFinancialYearMeta(?Carbon $date = null): array
    {
        $date ??= now();
        $date = $date->copy();

        if ((int) $date->format('n') < 4) {
            $startYear = (int) $date->format('Y') - 1;
        } else {
            $startYear = (int) $date->format('Y');
        }

        $endYear = $startYear + 1;
        $startDate = Carbon::create($startYear, 4, 1)->startOfDay();
        $endDate = Carbon::create($endYear, 3, 31)->endOfDay();
        $prefix = sprintf('MB-%02d-%02d', $startYear % 100, $endYear % 100);

        return [$startDate, $endDate, $prefix];
    }

    public function storePayment(Request $request, $id)
    {
        $miscellaneous = Miscellaneous::findOrFail($id);

        $request->validate([
            'amount_paid' => 'required|numeric|min:0.01',
            'discount' => 'nullable|numeric|min:0',
            'details' => 'nullable|string|max:500',
        ]);

        $due = $miscellaneous->net_due;
        if ($due <= 0) {
            return redirect()->back()->with('error', 'Bill already marked as paid.');
        }

        $discount = $request->discount ?? 0;
        $totalPayment = $request->amount_paid + $discount;

        if ($totalPayment > $due) {
            return redirect()->back()->with('error', 'Payment exceeds remaining due amount.');
        }

        $miscellaneous->payments()->create([
            'amount_paid' => $request->amount_paid,
            'discount' => $request->discount ?? 0,
            'details' => $request->details,
        ]);

        $miscellaneous->increment('pay_amount', $request->amount_paid);

        $miscellaneous->updatePaymentStatus();

        return redirect()->back()->with('success', 'Payment recorded.');
    }

    public function approve(Miscellaneous $miscellaneous)
    {
        if (!$miscellaneous->verified_by) {
            return redirect()->back()->with('error', 'Bill must be verified before it can be approved.');
        }

        if ($miscellaneous->approved_by) {
            return redirect()->back()->with('info', 'Bill is already approved.');
        }

        $miscellaneous->approved_by = Auth::id();
        $miscellaneous->approved_at = now();
        $miscellaneous->save();

        return redirect()->back()->with('success', 'Miscellaneous bill approved.');
    }

    protected function prepareDetailViewData(Miscellaneous $miscellaneous): array
    {
        $miscellaneous->loadMissing(['payments', 'creator', 'verifier', 'approver', 'expenseLedger', 'tdsLedger', 'serviceProviderVendor']);
        $payments = $miscellaneous->payments->sortByDesc('id')->values();

        return compact('miscellaneous', 'payments');
    }

    /**
     * Prepare data shared between the miscellaneous views.
     */
    protected function prepareViewData(string $title, bool $isAccountView = false): array
    {
        $miscellaneous = Miscellaneous::with(['payments', 'creator', 'verifier', 'approver', 'expenseLedger', 'tdsLedger', 'serviceProviderVendor'])->latest()->get();
        // dd($miscellaneous);
        $miscellaneous->each->updatePaymentStatus();

        $serviceProviders = StVendor::where('is_active', 1)
            ->orderBy('vendor_name')
            ->get();

        $expenseLedgerMasters = ExpenseLedgerMaster::query()
            ->orderBy('ledger_name')
            ->get(['id', 'ledger_name']);

        $tdsDutiesTaxesLedgerMasters = TdsDutiesTaxesLedgerMaster::query()
            ->orderBy('tds_ledger_name')
            ->get(['id', 'tds_ledger_name', 'tds_section_code', 'tds_rate']);

        return array_merge(
            compact(
                'title',
                'miscellaneous',
                'serviceProviders',
                'expenseLedgerMasters',
                'tdsDutiesTaxesLedgerMasters'
            ),
            ['isAccountView' => $isAccountView]
        );
    }
}
