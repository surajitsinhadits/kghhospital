<?php

namespace App\Http\Controllers\HR;

use App\Http\Controllers\Controller;
use App\Models\TdsDutiesTaxesLedgerMaster;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TdsDutiesTaxesLedgerMasterController extends Controller
{
    public function index()
    {
        $items = TdsDutiesTaxesLedgerMaster::latest()->paginate(10);
        return view('hr.tds_duties_taxes_ledger_master.index', compact('items'));
    }

    public function create()
    {
        return view('hr.tds_duties_taxes_ledger_master.create');
    }

    public function store(Request $request)
    {
        $validated = $this->validateData($request);
        TdsDutiesTaxesLedgerMaster::create($validated);

        return redirect()->route('tds-duties-taxes-ledger-master.index')
            ->with('success', 'TDS Duties & Taxes Ledger Master created successfully.');
    }

    public function show($id)
    {
        $item = TdsDutiesTaxesLedgerMaster::findOrFail($id);
        return view('hr.tds_duties_taxes_ledger_master.show', compact('item'));
    }

    public function edit($id)
    {
        $item = TdsDutiesTaxesLedgerMaster::findOrFail($id);
        return view('hr.tds_duties_taxes_ledger_master.edit', compact('item'));
    }

    public function update(Request $request, $id)
    {
        $item = TdsDutiesTaxesLedgerMaster::findOrFail($id);

        $validated = $this->validateData($request, $id);
        $item->update($validated);

        return redirect()->route('tds-duties-taxes-ledger-master.index')
            ->with('success', 'TDS Duties & Taxes Ledger Master updated successfully.');
    }

    public function destroy($id)
    {
        $item = TdsDutiesTaxesLedgerMaster::findOrFail($id);
        $item->delete();

        return redirect()->route('tds-duties-taxes-ledger-master.index')
            ->with('success', 'TDS Duties & Taxes Ledger Master deleted successfully.');
    }

    private function validateData(Request $request, $id = null)
    {
        $validated = $request->validate([
            'tds_ledger_name' => [
                'required',
                'string',
                'max:100',
                Rule::unique('tds_duties_taxes_ledger_masters', 'tds_ledger_name')->ignore($id),
            ],
            'under_group' => ['required', 'in:Duties & Taxes'],

            'tds_section_code' => [
                'required',
                'in:192 - Salaries,193 - Interest on Securities,194 - Dividend,194A - Interest other than Sec,194B - Winnings Lottery,194C - Contractors,194D - Insurance Commission,194G - Commission on Lottery,194H - Commission/Brokerage,194I - Rent,194IA - Transfer of Immovable Property,194J - Professional/Technical Fees,194K - Income from MF Units,194LA - Compensation (Land Acq),194M - Payment to Contractor/Professional (Indiv),194N - Cash Withdrawal,194O - E-Commerce,194Q - Purchase of Goods,194R - Benefits/Perquisites,194S - VDA (Crypto),195 - Non-Resident Payments,206C - TCS on various items'
            ],
            'tds_section_desc' => ['required', 'string', 'max:100'],
            'deductee_type' => [
                'required',
                'in:Company,Non-Company (Resident),Non-Resident (Individual),Non-Resident (Company),Cooperative Society,HUF,Trust,AOP/BOI'
            ],
            'tds_rate' => ['required', 'numeric', 'min:0', 'max:100'],

            'surcharge_applicable' => ['required', 'in:0,1'],
            'surcharge_rate' => ['nullable', 'numeric', 'min:0', 'max:100'],

            'cess_applicable' => ['required', 'in:0,1'],
            'cess_rate' => ['nullable', 'numeric', 'min:0', 'max:100'],

            'tds_payment_code' => ['required', 'string', 'max:50'],
            'tds_type' => ['required', 'in:TDS,TCS'],

            'annual_threshold' => ['nullable', 'numeric', 'min:0'],
            'single_txn_threshold' => ['nullable', 'numeric', 'min:0'],

            'nature_of_payment' => ['required', 'string', 'max:255'],
            'opening_balance' => ['nullable', 'numeric'],
        ]);

        if ((string) $request->surcharge_applicable === '1') {
            $request->validate([
                'surcharge_rate' => ['required', 'numeric', 'min:0', 'max:100'],
            ]);
        }

        if ((string) $request->cess_applicable === '1') {
            $request->validate([
                'cess_rate' => ['required', 'numeric', 'min:0', 'max:100'],
            ]);
        }

        $validated['under_group'] = 'Duties & Taxes';
        $validated['surcharge_applicable'] = (int) $request->surcharge_applicable;
        $validated['cess_applicable'] = (int) $request->cess_applicable;

        if ((string) $request->surcharge_applicable !== '1') {
            $validated['surcharge_rate'] = null;
        }

        if ((string) $request->cess_applicable !== '1') {
            $validated['cess_rate'] = null;
        }

        return $validated;
    }
}
