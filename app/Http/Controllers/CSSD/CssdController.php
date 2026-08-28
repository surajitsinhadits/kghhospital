<?php

namespace App\Http\Controllers\CSSD;

use App\Http\Controllers\Controller;
use App\Models\CssdCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Yajra\Datatables\DataTables;
use DB;
use App\Models\CssdInstrument;
use App\Models\CssdKitbox;
use App\Models\CssdKitboxInstrument;
use App\Models\CssdKitboxStatusHistory;
use Auth;
use Illuminate\Support\Str;
use PhpOffice\PhpSpreadsheet\Calculation\Category;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class CssdController extends Controller
{

    public function category()
    {
        $title = 'Category';
        $t1 = 'Category List';
        $t2 = 'Add Category';
        $form = ['category_name', 'category_short_code'];
        $head = ['Sl. No.', 'Name', 'Short Code', 'Action'];
        $btn['name'] = 'Add Category';
        $btn['action'] = Route('cssd.add-update-category');
        $edit['data'] = null;
        $edit['url'] = Route('cssd.edit-category');
        $response = CssdCategory::orderBy('id', 'desc')->get();
        $table = "cssd_categories";
        $data = compact('title', 't1', 't2', 'form', 'head', 'btn', 'edit', 'table', 'response');
        return view('master-from')->with($data);
    }

    public function save_update_category(Request $request, $id = 0)
    {
        // dd($request->all(),$id);
        $category = ($id == 0) ? (new CssdCategory()) : CssdCategory::find($id);
        $category->category_name = $request['category_name'];
        $category->category_short_code = $request['category_short_code'];
        $category->save();
        return redirect()->route('cssd.category')->with('success', 'Successfully Updated!');
    }

    public function edit_category($id)
    {
        if (!$id) {
            return redirect()->route('hr.charges-catagory');
        }
        $id = ed($id, false);
        $title = 'Category';
        $t1 = 'Category List';
        $t2 = 'Edit Category';
        $form = ['category_name', 'category_short_code'];
        $head = ['Sl. No.', 'Name', 'Short Code', 'Action'];
        $btn['name'] = 'Update Category';
        $btn['action'] = Route('cssd.add-update-category', $id);
        $edit['data'] = CssdCategory::find($id);
        $edit['url'] = Route('cssd.edit-category');
        $response = CssdCategory::orderBy('id', 'desc')->get();
        $table = "CssdCategory";
        $data = compact('title', 't1', 't2', 'form', 'head', 'btn', 'edit', 'table', 'response');
        return view('master-from')->with($data);
    }

    public function medical_instruments()
    {
        $title = 'Medical Instruments';
        $t1 = 'Instruments List';
        $t2 = 'Add Instruments';
        $form = ['name', 'description'];
        $head = ['Sl. No.', 'Instruments', 'Description', 'Action'];
        $btn['name'] = 'Add Instruments';
        $btn['action'] = Route('cssd.update-medical-instruments');
        $edit['data'] = null;
        $edit['url'] = Route('cssd.edit-medical-instruments');
        $response = CssdInstrument::orderBy('id', 'desc')->get();
        $table = "cssd_instruments";
        $data = compact('title', 't1', 't2', 'form', 'head', 'btn', 'edit', 'table', 'response');
        return view('master-from')->with($data);
    }

    public function update_medical_instruments(Request $request, $id = 0)
    {
        $request->validate([
            'name' => 'required|max:100',
            'description' => 'required|max:1000',
        ]);

        $id ? $data = CssdInstrument::find($id) : $data = new CssdInstrument();
        $data->name = $request->name;
        $data->description = $request->description;
        if ($data->save()) {
            return redirect()->route('cssd.medical_instruments')->with('success', 'Successfully Updated!');
        } else {
            return redirect()->route('cssd.medical_instruments')->with('error', 'Something wrong try again!');
        }
    }

    public function edit_medical_instruments($id = 0)
    {
        if (!$id) {
            return redirect()->route('cssd.master_entry');
        }
        $id = ed($id, false);
        $title = 'Edit Medical Instruments';
        $t1 = 'Medical Instruments List';
        $t2 = 'Edit Medical Instruments';
        $form = ['name', 'description'];
        $head = ['Sl. No.', 'Instruments', 'Description', 'Action'];
        $btn['name'] = 'Update';
        $btn['action'] = Route('cssd.update-medical-instruments', $id);
        $edit['data'] =  CssdInstrument::find($id);
        $edit['reset'] = Route('cssd.medical_instruments');
        $edit['url'] = Route('cssd.edit-medical-instruments');
        $response = CssdInstrument::orderBy('id', 'desc')->get();
        $table = "vials";
        $data = compact('title', 't1', 't2', 'form', 'head', 'btn', 'edit', 'response', 'table');
        return view('master-from')->with($data);
    }

    public function kit_box()
    {
        $title = 'Medical Instruments';
        $instruments = CssdInstrument::where('status', 1)->get();
        $category = CssdCategory::where('status', 1)->get();

        $kitboxes = CssdKitbox::get();

        foreach ($kitboxes as $kitbox) {
            $kitboxInstruments = CssdKitboxInstrument::where('kitbox_id', $kitbox->id)->get();
            foreach ($kitboxInstruments as $instrumentItem) {
                $instrumentItem->instrument = CssdInstrument::find($instrumentItem->instrument_id);
            }
            $kitbox->kitboxInstruments = $kitboxInstruments;
        }

        $data = compact('title', 'instruments', 'kitboxes', 'category');
        return view('cssd.kit_box')->with($data);
    }
    public function kitboxes_create(Request $request)
    {
    
        $validated = $request->validate([
            'name'                          => 'required|string|max:255',
            'description'                   => 'nullable|string',
            'instruments.*.instrument_id'   => 'required|integer|exists:cssd_instruments,id|distinct',
            'instruments.*.quantity'        => 'required|integer|min:1',
        ]);

        if( $request->id ){

            $allInstruments = CssdKitboxInstrument::where('kitbox_id', $request->id)->get();
            $existsInstrument = [];
            foreach ($allInstruments as $instrument) {
                $existsInstrument[] = $instrument->instrument_id;
            }

            $validated['instruments'] = array_values($validated['instruments']);
            foreach ($validated['instruments'] as $instrument) {
                if( in_array($instrument['instrument_id'], $existsInstrument) ){
                    return redirect()->back()->with('error', 'Duplicate instrument entry not possible.');
                }
                
            }

            $kitBox = CssdKitbox::find($request->id);
            $status = $kitBox->status;

            $kitBox->name           = $request->name;
            $kitBox->description    = $request->description;
            $kitBox->category       = $request->category;
            $kitBox->save();

            CssdKitboxStatusHistory::create([
                'kitbox_id'     => $request->id,
                'status'        => $status,
                'changed_by'    => Auth::id(),
            ]);

            // Add instruments to the CssdKitbox
            $validated['instruments'] = array_values($validated['instruments']);
            foreach ($validated['instruments'] as $instrument) {
                CssdKitboxInstrument::create([
                    'kitbox_id'     => $request->id,
                    'instrument_id' => $instrument['instrument_id'],
                    'quantity'      => $instrument['quantity'],
                ]);
            }

            return redirect()->back()->with('success', 'CssdKitbox and instruments updated successfully.');

        } else {

            $category1 = CssdCategory::find($request['category']);
            $_max_counter = CssdKitbox::where('prefix', 'like', '%' . $category1->category_short_code . '%')
                ->max('counter');
            
            if (!$_max_counter) {
                $prefix = 'KGH-' . $category1->category_short_code . '-';
                $counter = 1;
            } else {
                $prefix = 'KGH-' . $category1->category_short_code . '-';
                $counter = $_max_counter + 1;
            }
            
            // Create the CssdKitbox
            $kitbox = CssdKitbox::create([
                'box_id'        => Str::random(strlen($prefix)),
                'prefix'        => $prefix,
                'counter'       => $counter,
                'category'      => $request->category,
                'name'          => $validated['name'],
                'description'   => $validated['description'] ?? null,
            ]);

            $getStatus = CssdKitbox::find($kitbox->id);
            $status = $getStatus->status;
            CssdKitboxStatusHistory::create([
                'kitbox_id'     => $kitbox->id,
                'status'        => $status,
                'changed_by'    => Auth::id(),
            ]);


            // Add instruments to the CssdKitbox
            $validated['instruments'] = array_values($validated['instruments']);
            foreach ($validated['instruments'] as $instrument) {
                CssdKitboxInstrument::create([
                    'kitbox_id'     => $kitbox->id,
                    'instrument_id' => $instrument['instrument_id'],
                    'quantity'      => $instrument['quantity'],
                ]);
            }

            return redirect()->back()->with('success', 'CssdKitbox and instruments added successfully.');

        }
        
    }

    public function kitboxes_edit($id)
    {
        $title = 'Medical Instruments';
        $instruments = CssdInstrument::where('status', 1)->get();
        $category = CssdCategory::where('status', 1)->get();

        $kitboxes = CssdKitbox::get();

        foreach ($kitboxes as $kitbox) {
            $kitboxInstruments = CssdKitboxInstrument::where('kitbox_id', $kitbox->id)->get();
            foreach ($kitboxInstruments as $instrumentItem) {
                $instrumentItem->instrument = CssdInstrument::find($instrumentItem->instrument_id);
            }
            $kitbox->kitboxInstruments = $kitboxInstruments;
        }

        $edit = CssdKitbox::find($id);
        $edit_instruments = $kitbox->kitboxInstruments->map(function ($item) {
            return [
                'instrument_id' => $item->instrument_id,
                'quantity' => $item->quantity,
                'instrument_name' => $item->instrument->name,
            ];
        });

        // dd($edit_instruments,$kitbox->kitboxInstruments[0]->instrument->name);

        $data = compact('title', 'instruments', 'kitboxes', 'category', 'edit');
        return view('cssd.kit_box')->with($data);
    }

    public function kitboxes_details($id)
    {
        $title = 'Box Details';
        $instruments = CssdInstrument::all();

        // It's a single box, so better naming
        $kitboxes = CssdKitbox::find($id);

        if (!$kitboxes) {
            // abort(404, 'Kitbox not found');
            return redirect()->back()->with('error', 'No Kitbox found');
        }

        $kitboxInstruments = CssdKitboxInstrument::where('kitbox_id', $kitboxes->id)->get();

        foreach ($kitboxInstruments as $instrumentItem) {
            $instrumentItem->instrument = CssdInstrument::find($instrumentItem->instrument_id);
        }

        $kitboxes->kitboxInstruments = $kitboxInstruments;

        $used_history = CssdKitboxStatusHistory::select('cssd_kitbox_status_histories.*', 'users.name')
            ->join('users', 'users.id', 'cssd_kitbox_status_histories.changed_by')
            ->where('kitbox_id', $id)
            ->get();

        $start = null;
        $end = null;
        $collecting = false;

        foreach ($used_history as $row) {
            if ($row->status == 2 && !$collecting) {
                // Start collecting when we find the first 2
                $start = $row->id;
                $collecting = true;
            } elseif ($collecting) {
                // End collecting when we find the last 1 after a 0
                if ($row->status == 2) {
                    $collecting = false; // Reset to find the next set
                    $end = $end ?? $start;
                } else {
                    $end = $row->id;
                }
            }
        }

        $results = CssdKitboxStatusHistory::select('cssd_kitbox_status_histories.*', 'users.name')
            ->join('users', 'users.id', 'cssd_kitbox_status_histories.changed_by')
            ->whereBetween('cssd_kitbox_status_histories.id', [$start, $end])->where('kitbox_id', $id)
            ->get()
            ->toArray();

        $used_history = json_decode(json_encode($results), false);

        // dd($used_history);
        $data = compact('title', 'instruments', 'kitboxes', 'used_history');
        return view('cssd.kit_box_details')->with($data);
    }

    public function sterilization()
    {
        $title = 'Sterilization';
        $instruments = CssdInstrument::all();

        $kitboxes = CssdKitbox::where('status', '1')->get();

        foreach ($kitboxes as $kitbox) {
            $kitboxInstruments = CssdKitboxInstrument::where('kitbox_id', $kitbox->id)->get();
            foreach ($kitboxInstruments as $instrumentItem) {
                $instrumentItem->instrument = CssdInstrument::find($instrumentItem->instrument_id);
            }
            $kitbox->kitboxInstruments = $kitboxInstruments;
        }

        $data = compact('title', 'instruments', 'kitboxes');
        return view('cssd.sterilization')->with($data);
    }
    public function markSterilized($id)
    {
        $kitbox = CssdKitbox::findOrFail($id);

        $kitbox->status = '2';
        $kitbox->updated_at = now();
        $kitbox->save();
        CssdKitboxStatusHistory::insert([
            'kitbox_id' => $kitbox->id,
            'status' => 2,
            'changed_by' => Auth::id(),
        ]);
        return redirect()->back()->with('success', 'Kit box marked as sterilized.');
    }
    public function sendToSterilized($id)
    {
        $kitbox = CssdKitbox::findOrFail($id);

        $kitbox->status = '1';
        $kitbox->updated_at = now();
        $kitbox->save();
        CssdKitboxStatusHistory::insert([
            'kitbox_id' => $kitbox->id,
            'status' => 1,
            'changed_by' => Auth::id(),
        ]);
        return redirect()->back()->with('success', 'Kit box Send for Sterilization.');
    }

    public function in_use_kit($kitbox_id, $section, $section_id, $billing_id = null)
    {
        $kitbox = CssdKitbox::findOrFail($kitbox_id);
        if ($kitbox->status == '0') {
            return "Kit already in use";
        }
        $kitbox->status = '2';
        $kitbox->updated_at = now();
        $kitbox->save();
        $data = CssdKitboxStatusHistory::insert([
            'kitbox_id' => $kitbox_id,
            'section' => $section,
            'section_id' => $section_id,
            'status' => 0,
            'billing_id' => 0,
            'changed_by' => Auth::id(),
        ]);

        if ($data) {
            return 'Successfully Saved';
        }
    }
}
