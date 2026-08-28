<?php

namespace App\Http\Controllers\HR;

use App\Http\Controllers\Controller;
use App\Models\ExpenseLedgerMaster;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ExpenseLedgerMasterController extends Controller
{
    public function index()
    {
        $items = ExpenseLedgerMaster::latest()->paginate(10);
        return view('hr.expense_ledger_master.index', compact('items'));
    }

    public function create()
    {
        return view('hr.expense_ledger_master.create');
    }

    public function store(Request $request)
    {
        $validated = $this->validateData($request);

        ExpenseLedgerMaster::create($validated);

        return redirect()->route('expense-ledger-master.index')
            ->with('success', 'Expense Ledger Master created successfully.');
    }

    public function show($id)
    {
        $item = ExpenseLedgerMaster::findOrFail($id);
        return view('hr.expense_ledger_master.show', compact('item'));
    }

    public function edit($id)
    {
        $item = ExpenseLedgerMaster::findOrFail($id);
        return view('hr.expense_ledger_master.edit', compact('item'));
    }

    public function update(Request $request, $id)
    {
        $item = ExpenseLedgerMaster::findOrFail($id);

        $validated = $this->validateData($request, $id);
        $item->update($validated);

        return redirect()->route('expense-ledger-master.index')
            ->with('success', 'Expense Ledger Master updated successfully.');
    }

    public function destroy($id)
    {
        $item = ExpenseLedgerMaster::findOrFail($id);
        $item->delete();

        return redirect()->route('expense-ledger-master.index')
            ->with('success', 'Expense Ledger Master deleted successfully.');
    }

    private function validateData(Request $request, $id = null)
    {
        $rules = [
            'ledger_name' => [
                'required',
                'string',
                'max:100',
                Rule::unique('expense_ledger_masters', 'ledger_name')->ignore($id),
            ],
            'ledger_group' => ['required', 'in:Direct Expenses,Indirect Expenses,Purchase Accounts,Manufacturing Expenses'],

            'tds_applicable' => ['required', 'in:0,1'],
            'tds_nature_payment' => ['nullable', 'string', 'max:255'],
            'tds_rate' => ['nullable', 'numeric', 'min:0', 'max:100'],
            'tds_threshold' => ['nullable', 'numeric', 'min:0'],

            'gst_applicable' => ['required', 'in:0,1'],
            'gst_charge_type' => ['nullable', 'in:Forward,RCM,Both'],
            'sac_hsn_code' => ['nullable', 'string', 'max:20'],
            'gst_rate' => ['nullable', 'in:0,5,12,18,28'],

            'igst_ledger_name' => ['nullable', 'string', 'max:255'],
            'cgst_ledger_name' => ['nullable', 'string', 'max:255'],
            'sgst_ledger_name' => ['nullable', 'string', 'max:255'],
            'rcm_output_gst_ledger' => ['nullable', 'string', 'max:255'],

            'cost_centre_applicable' => ['nullable', 'in:0,1'],
            'default_cost_centre' => ['nullable', 'string', 'max:255'],

            'opening_balance' => ['nullable', 'numeric'],
            'description' => ['nullable', 'string', 'max:250'],
        ];

        if ((string) $request->tds_applicable === '1') {
            $rules['tds_nature_payment'] = ['required', 'string', 'max:255'];
            $rules['tds_rate'] = ['required', 'numeric', 'min:0', 'max:100'];
            $rules['tds_threshold'] = ['nullable', 'numeric', 'min:0'];
        }

        if ((string) $request->gst_applicable === '1') {
            $rules['gst_charge_type'] = ['required', 'in:Forward,RCM,Both'];
            $rules['sac_hsn_code'] = ['required', 'string', 'max:20'];
            $rules['gst_rate'] = ['required', 'in:0,5,12,18,28'];

            if ($request->gst_charge_type === 'RCM') {
                $rules['rcm_output_gst_ledger'] = ['required', 'string', 'max:255'];
            }

            if (in_array($request->gst_charge_type, ['Forward', 'Both'])) {
                $rules['igst_ledger_name'] = ['required', 'string', 'max:255'];
                $rules['cgst_ledger_name'] = ['required', 'string', 'max:255'];
                $rules['sgst_ledger_name'] = ['required', 'string', 'max:255'];
            }

            if ($request->gst_charge_type === 'Both') {
                $rules['rcm_output_gst_ledger'] = ['required', 'string', 'max:255'];
            }
        }

        $validated = $request->validate($rules);

        $validated['tds_applicable'] = (int) $request->tds_applicable;
        $validated['gst_applicable'] = (int) $request->gst_applicable;
        $validated['cost_centre_applicable'] = (int) ($request->cost_centre_applicable ?? 0);

        if ((string) $request->tds_applicable !== '1') {
            $validated['tds_nature_payment'] = null;
            $validated['tds_rate'] = null;
            $validated['tds_threshold'] = null;
        }

        if ((string) $request->gst_applicable !== '1') {
            $validated['gst_charge_type'] = null;
            $validated['sac_hsn_code'] = null;
            $validated['gst_rate'] = null;
            $validated['igst_ledger_name'] = null;
            $validated['cgst_ledger_name'] = null;
            $validated['sgst_ledger_name'] = null;
            $validated['rcm_output_gst_ledger'] = null;
        } else {
            if ($request->gst_charge_type === 'RCM') {
                $validated['igst_ledger_name'] = null;
                $validated['cgst_ledger_name'] = null;
                $validated['sgst_ledger_name'] = null;
            }

            if ($request->gst_charge_type === 'Forward') {
                $validated['rcm_output_gst_ledger'] = null;
            }
        }

        return $validated;
    }
}
