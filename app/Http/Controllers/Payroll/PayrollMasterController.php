<?php

namespace App\Http\Controllers\Payroll;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SalaryMaster;
use App\Models\SalaryType;
use App\Models\SalaryRule;
use App\Models\SalaryStructure;

class PayrollMasterController extends Controller
{
    //Salary Structure
    public function salary_master()
    {
        $title = 'Salary Master';
        $t1 = 'Salary Master List';
        $t2 = 'Add Salary Master';
        $form = ['salary_master_name'];
        $head = ['Sl. No.', 'Salary Master Name', 'Action'];
        $btn['name'] = 'Add Salary Master';
        $btn['action'] = Route('payroll.update-salary-master');
        $edit['data'] = null;
        $edit['url'] = Route('payroll.edit-salary-master');
        $edit['salary_structure'] = Route('payroll.salary-structure');
        $response = SalaryMaster::latest()->get();
        $table = 'salary_masters';
        $data = compact('title', 't1', 't2', 'form', 'head', 'btn', 'edit', 'response', 'table');
        return view('master-from')->with($data);
    }
    public function edit_salary_master($id = 0)
    {
        if (!$id) {
            return redirect()->route('payroll.salary-master');
        }
        $id = ed($id, false);
        $title = 'Edit Salary Master';
        $t1 = 'Salary Master List';
        $t2 = 'Edit Salary Master';
        $form = ['salary_master_name'];
        $head = ['Sl. No.', 'Salary Master Name', 'Action'];
        $btn['name'] = 'Update Salary Master';
        $btn['action'] = Route('payroll.update-salary-master', $id);
        $edit['data'] =  SalaryMaster::find($id);
        $edit['reset'] = Route('payroll.salary-master');
        $edit['url'] = Route('payroll.edit-salary-master');
        $response = SalaryMaster::latest()->get();
        $table = 'salary_masters';
        $data = compact('title', 't1', 't2', 'form', 'head', 'btn', 'edit', 'response', 'table');
        return view('master-from')->with($data);
    }
    public function update_salary_master(Request $request, $id = 0)
    {
        $request->validate([
            'salary_master_name' => 'required|max:100',
        ]);
        $id ? $data = SalaryMaster::find($id) : $data = new SalaryMaster();
        $data->salary_master_name = ucwords(str_replace("_", " ", $request->salary_master_name));
        if ($data->save()) {
            return redirect()->route('payroll.salary-master')->with('success', 'Successfully Updated!');
        } else {
            return redirect()->route('payroll.salary-master')->with('error', 'Something wrong try again!');
        }
    }

    //Salary Type
    public function salary_type()
    {
        $title = 'Salary Type';
        $t1 = 'Salary Type List';
        $t2 = 'Add Salary Type';
        $form = ['salary_type_name', 'salary_type_description'];
        $head = ['Sl. No.', 'Salary Type Name', 'Description', 'Action'];
        $btn['name'] = 'Add Salary Type';
        $btn['action'] = Route('payroll.update-salary-type');
        $edit['data'] = null;
        $edit['url'] = Route('payroll.edit-salary-master');
        $edit['rule'] = Route('payroll.salary-rule');
        $response = SalaryType::latest()->get();
        $table = 'salary_types';
        $data = compact('title', 't1', 't2', 'form', 'head', 'btn', 'edit', 'response', 'table');
        return view('master-from')->with($data);
    }
    public function edit_salary_type($id = 0)
    {
        if (!$id) {
            return redirect()->route('payroll.salary-type');
        }
        $id = ed($id, false);
        $title = 'Edit Salary Type';
        $t1 = 'Salary Type List';
        $t2 = 'Edit Salary Type';
        $form = ['salary_type_name', 'salary_type_description'];
        $head = ['Sl. No.', 'Salary Type Name', 'Description', 'Action'];
        $btn['name'] = 'Update Salary Type';
        $btn['action'] = Route('payroll.update-salary-type', $id);
        $edit['data'] =  SalaryType::find($id);
        $edit['reset'] = Route('payroll.salary-type');
        $edit['url'] = Route('payroll.edit-salary-type');
        $response = SalaryType::latest()->get();
        $table = 'salary_types';
        $data = compact('title', 't1', 't2', 'form', 'head', 'btn', 'edit', 'response', 'table');
        return view('master-from')->with($data);
    }
    public function update_salary_type(Request $request, $id = 0)
    {
        $request->validate([
            'salary_type_name' => 'required|max:100',
        ]);
        $id ? $data = SalaryType::find($id) : $data = new SalaryType();
        $data->salary_type_name = ucwords(str_replace("_", " ", $request->salary_type_name));
        $data->salary_type_description = $request->salary_type_description;
        if ($data->save()) {
            return redirect()->route('payroll.salary-master')->with('success', 'Successfully Updated!');
        } else {
            return redirect()->route('payroll.salary-master')->with('error', 'Something wrong try again!');
        }
    }

    // Salary Rules
    public function salary_rule($salary_type_id = 0)
    {
        $title = 'Add Rules';
        $t1 = 'Rules List';
        $t2 = 'Add Rules';
        $form = ['rule', 'salary_description'];
        $head = ['Sl. No.', 'Rule', 'Description', 'Action'];
        $btn['name'] = 'Add Rule';
        $btn['action'] = Route('payroll.update-salary-rule', ed($salary_type_id, false));
        $edit['data'] = null;
        $edit['url'] = Route('payroll.edit-salary-rule');
        $response = SalaryRule::where('salary_type_id', ed($salary_type_id, false))->latest()->get();
        $table = 'salary_rules';
        $data = compact('title', 't1', 't2', 'form', 'head', 'btn', 'edit', 'response', 'table');
        return view('master-from')->with($data);
    }
    public function edit_salary_rule($id = 0)
    {
        if (!$id) {
            return redirect()->route('payroll.salary-rule');
        }
        $id = ed($id, false);
        $title = 'Edit Rules';
        $t1 = 'Rules List';
        $t2 = 'Edit Rules';
        $form = ['rule', 'salary_description'];
        $head = ['Sl. No.', 'Rule', 'Description', 'Action'];
        $btn['name'] = 'Update Rule';
        $edit['data'] =  SalaryRule::find($id);
        $btn['action'] = Route('payroll.update-salary-rule', [$edit['data']->salary_type_id, $id]);
        $edit['reset'] = Route('payroll.salary-rule');
        $edit['url'] = Route('payroll.edit-salary-rule');
        $response = SalaryRule::where('salary_type_id', $id)->latest()->get();
        $table = 'salary_rules';
        $data = compact('title', 't1', 't2', 'form', 'head', 'btn', 'edit', 'response', 'table');
        return view('master-from')->with($data);
    }
    public function update_salary_rule(Request $request, $salary_type_id = 0, $id = 0)
    {
        $request->validate([
            'rule' => 'required|max:255',
        ]);
        $id ? $data = SalaryRule::find($id) : $data = new SalaryRule();
        $data->rule = $request->rule;
        $data->salary_description = $request->salary_description;
        $data->salary_type_id = $salary_type_id;
        if ($data->save()) {
            return redirect()->route('payroll.salary-rule', ed($salary_type_id, true))->with('success', 'Successfully Updated!');
        } else {
            return redirect()->route('payroll.salary-rule', ed($salary_type_id, true))->with('error', 'Something wrong try again!');
        }
    }

    // Salary Structure
    public function salary_structure($salary_master_id = 0)
    {
        $title = 'Create Salary Structure';
        $t1 = 'Salary Structure List';
        $t2 = 'Add Salary Structure';
        $form = ['salary_type_name', 'rule'];
        $head = ['Sl. No.', 'Salary Type Name', 'Salary Rule Name', 'Action'];
        $btn['name'] = 'Add Salary Structure';
        $btn['action'] = Route('payroll.update-salary-structure', ed($salary_master_id, false));
        $edit['data'] = null;
        $edit['url'] = Route('payroll.edit-salary-structure');
        $response = SalaryStructure::select('salary_structures.*', 'salary_types.salary_type_name', 'salary_rules.rule')
            ->where('salary_master_id', ed($salary_master_id, false))
            ->join('salary_types', 'salary_structures.salary_type_id', '=', 'salary_types.id')
            ->join('salary_rules', 'salary_structures.salary_rules_id', '=', 'salary_rules.id')
            ->latest()->get();
        $extra['salary_type'] = SalaryType::get();
        $table = 'salary_structures';
        $data = compact('title', 't1', 't2', 'form', 'head', 'btn', 'edit', 'response', 'table', 'extra');
        return view('master-from')->with($data);
    }
    public function edit_salary_structure($id = 0)
    {
        if (!$id) {
            return redirect()->route('payroll.salary-rule');
        }
        $id = ed($id, false);
        $title = 'Edit Salary Structure';
        $t1 = 'Salary Structure List';
        $t2 = 'Edit Salary Structure';
        $form = [];
        $head = ['Sl. No.', 'Salary Type Name', 'Salary Rule Name', 'Action'];
        $btn['name'] = 'Update Salary Structure';
        $edit['data'] =  SalaryStructure::find($id);
        $btn['action'] = Route('payroll.update-salary-rule', [$edit['data']->salary_type_id, $id]);
        $edit['reset'] = Route('payroll.salary-structure');
        $edit['url'] = Route('payroll.edit-salary-structure');
        $response = SalaryStructure::latest()->get();
        $table = 'salary_structures';
        $data = compact('title', 't1', 't2', 'form', 'head', 'btn', 'edit', 'response', 'table');
        return view('master-from')->with($data);
    }
    public function update_salary_structure(Request $request, $salary_master_id = 0, $id = 0)
    {
        $request->validate([
            'salary_type_id' => 'required',
            'salary_rules_id' => 'required',
        ]);
        $id ? $data = SalaryStructure::find($id) : $data = new SalaryStructure();
        $data->salary_master_id = $request->salary_master_id;
        $data->salary_type_id = $request->salary_type_id;
        $data->salary_rules_id = $request->salary_rules_id;
        if ($data->save()) {
            return redirect()->route('payroll.salary-structure', ed($salary_master_id, true))->with('success', 'Successfully Updated!');
        } else {
            return redirect()->route('payroll.salary-structure', ed($salary_master_id, true))->with('error', 'Something wrong try again!');
        }
    }
}
