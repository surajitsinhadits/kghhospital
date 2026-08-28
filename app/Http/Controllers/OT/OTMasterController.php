<?php

namespace App\Http\Controllers\OT;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\OtPackageDetail;
use App\Models\OtPackage;
use App\Models\Charge;
use App\Models\ChargesHasSection;
use App\Models\OtProcedureName;




class OTMasterController extends Controller
{
    public function create_package()
    {
        $title = 'Operation Package';
        $t1 = 'Operation Packages List';
        $t2 = 'Add Operation Package';
        $btn['action'] = Route('ot.update-create-package');
        $btn['name'] = 'Add Package';
        $edit['data'] = null;
        $edit['url'] = Route('ot.edit-create-package');
        $response = OtPackage::orderBy('id', 'desc')->get();
        $charges = Charge::orderBy('id', 'desc')->where('is_active', 1)->where('is_delete', 0)->get();
        $OtPackages = OtPackage::join('ot_package_details', 'ot_packages.id', '=', 'ot_package_details.package_id')
            ->join('charges', 'ot_package_details.charge_id', '=', 'charges.id')
            ->select('ot_packages.*', 'ot_package_details.charge_id', 'ot_package_details.rate', 'charges.charge_name')
            ->get();
        $data = compact('title', 't1', 't2', 'btn', 'response', 'charges', 'OtPackages', 'edit');
        return view('ot.create-ot-packages')->with($data);
    }
    public function edit_create_package($id = 0)
    {
        if (!$id) {
            return redirect()->route('ot.create-ot-package');
        }
        $id = ed($id, false);
        $title = 'Edit Operation Package';
        $t1 = 'Operation Packages List';
        $t2 = 'Edit Operation Package';
        $btn['action'] = Route('ot.update-create-package', $id);
        $btn['name'] = 'Edit Operation Package';
        $edit['data'] =  OtPackage::find($id);
        $edit['url'] = Route('ot.edit-create-package');
        $edit['reset'] = Route('ot.create-ot-package');
        $response = OtPackage::orderBy('id', 'desc')->get();
        $charges = Charge::orderBy('id', 'desc')->where('is_active', 1)->where('is_delete', 0)->get();
        $OtPackages = OtPackage::join('ot_package_details', 'ot_packages.id', '=', 'ot_package_details.package_id')
            ->join('charges', 'ot_package_details.charge_id', '=', 'charges.id')
            ->select('ot_packages.*', 'ot_package_details.charge_id', 'ot_package_details.rate', 'charges.charge_name')
            ->get();
        $packageDetails = OtPackageDetail::where('package_id', $id)->get();
        $data = compact('title', 't1', 't2', 'btn', 'response', 'charges', 'OtPackages', 'edit', 'packageDetails');
        return view('ot.create-ot-packages')->with($data);
    }
    public function update_create_package(Request $request, $id = null)
    {

        // echo $id;
        // print_r($request->all());die;

        if( !empty($id) && !empty($request->type) && $request->type == 'time' ){

            $request->validate([
                'package_name' => 'required|unique:ot_packages,package_name,' . $id,
                'type' => 'required',
                'duration' => 'required|integer',
                'charge_id' => 'required|array',
                'rate' => 'required|array'
            ]);

        } elseif( !empty($id) ){

            $request->validate([
                'package_name' => 'required|unique:ot_packages,package_name,' . $id,
                'type' => 'required',
                'charge_id' => 'required|array',
                'rate' => 'required|array'
            ]);

        } elseif( !empty($request->type) && $request->type == 'time' ){

            $request->validate([
                'package_name' => 'required|unique:ot_packages,package_name',
                'type' => 'required',
                'duration' => 'required|integer',
                'charge_id' => 'required|array',
                'rate' => 'required|array'
            ]);

        } else {

            $request->validate([
                'package_name' => 'required|unique:ot_packages,package_name',
                'type' => 'required',
                'charge_id' => 'required|array',
                'rate' => 'required|array'
            ]);

        }

        $package = $id ? OtPackage::find($id) : new OtPackage();

        if (!$package) {
            return redirect()->route('ot.create-ot-package')->with('error', 'Package not found!');
        }

        $package->package_name = $request->package_name;
        $package->package_amount = $request->total_amount;
        $package->type = $request->type;
        $package->duration = !empty($request->duration) ? $request->duration : NULL;


        if ($package->save()) {

            $packageId = $package->id;

            if ($id) {
                OtPackageDetail::where('package_id', $id)->delete();
            }

            foreach ($request->charge_id as $key => $chargeId) {
                OtPackageDetail::create([
                    'package_id' => $packageId,
                    'charge_id' => $chargeId,
                    'rate' => $request->rate[$key]
                ]);
            }

            return redirect()->route('ot.create-ot-package')->with('success', $id ? 'Successfully Updated!' : 'Successfully Created!');
        } else {
            return redirect()->route('ot.create-ot-package')->with('error', 'Something went wrong, try again!');
        }
    }
    public function package_amount(Request $request)
    {
        $charges = ChargesHasSection::where('charge_id', $request->selectedCharge_Id)->sum('charge_amount');
        return response()->json($charges);
    }
    public function get_package_details(Request $request)
    {
        $charges = OtPackageDetail::select('c.id', 'c.charge_name', 'ot_package_details.rate as charge_amount')
            ->join('charges as c', 'c.id', '=', 'ot_package_details.charge_id')

            ->where('ot_package_details.package_id', $request->package_id)

            ->get();
        return response()->json($charges);
    }

     public function get_procedures(Request $request){
        $procedures = OtProcedureName::where('procedure_code', $request->procedure_code)->where('status', 0)->get();
        return response()->json([
            'success' => true,
            'procedures' => $procedures,
        ]);
    }
}
