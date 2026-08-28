<?php

namespace App\Http\Controllers\Kitchen;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Yajra\Datatables\DataTables;
use Illuminate\Http\Request;
use App\Models\KtSupplier;
use App\Models\KtDietType;
use App\Models\KtDietMeal;
use App\Models\KtMealItem;
use App\Models\KtDietChart;
use App\Models\IpdRegister;
use App\Models\Patient;
use App\Models\KtFoodDelivery;
use App\Models\KtUnit;
use App\Models\KtItemCategory;
use App\Models\KtItem;
use App\Models\KtExpense;
use App\Models\KtExpensesDetail;
use App\Models\KtPurchase;
use Carbon\Carbon;
use DB;

class KitchenController extends Controller
{
    // expenses & stock
    public function present_stock()
    {
        $items = KtItem::select('kt_items.*','u1.unit')
            ->join('kt_units as u1','u1.id','=','kt_items.unit_id')
            ->get();
        $stocks = KtPurchase::select('pd.item_id','i.item_name','pd.unit_qty','pd.unit','pd.amount')
            ->join('kt_purchase_details as pd','pd.purchase_id','=','kt_purchases.id')
            ->join('kt_items as i','i.id','=','pd.item_id')
            ->where('kt_purchases.is_stock', 1)
            ->where('kt_purchases.is_delete', 0)
            ->where('pd.is_delete', 0)
            ->get();
        $issues = KtExpense::select('ed.item_id','i.item_name','ed.unit_qty','ed.unit','ed.amount')
            ->join('kt_expenses_details as ed','ed.expenses_id','=','kt_expenses.id')
            ->join('kt_items as i','i.id','=','ed.item_id')
            ->where('kt_expenses.is_issue', 1)
            ->where('kt_expenses.is_delete', 0)
            ->where('ed.is_delete', 0)
            ->get();
        $pasent_stock = [];
        foreach($items as $item){
            $stock_unit = $stocks->where('item_id', $item->id)->sum('unit_qty') ?? 0;
            $issue_unit = $issues->where('item_id', $item->id)->sum('unit_qty') ?? 0;
            $stock_total = $stocks->where('item_id', $item->id)->sum('amount') ?? 0;
            $issue_total = $issues->where('item_id', $item->id)->sum('amount') ?? 0;

            // Calculate remaining sub-units
            $remaining_unit = max($stock_unit - $issue_unit, 0);

            $qty = $remaining_unit.' '.$item->unit;
            $total_amount = $stock_total - $issue_total;

            $pasent_stock[] = [
                'id' => $item->id,
                'item' => $item->item_name,
                'qty' => $qty,
                'amount' => $total_amount,
                'check_qty' => $remaining_unit,
            ];
        }
        $data = compact('pasent_stock');
        // dd($data);
        return view('kitchen.present-stock')->with($data);
    }
    public function daily_expenses(Request $request)
    {
        if ($request->ajax()) {
            $baseQuery = KtExpense::select(
                'kt_expenses.*',
                'u.name as created_by'
            )
            ->join('users as u', 'u.id', '=', 'kt_expenses.generated_by')
            ->where('kt_expenses.is_delete', 0)
            ->orderBy('kt_expenses.id', 'DESC');

            // Filter by data
            if (!empty($request->from_date)) {
                $baseQuery->whereDate('kt_expenses.date', '>=', date('Y-m-d', strtotime($request->from_date)));
            }
            if (!empty($request->to_date)) {
                $baseQuery->whereDate('kt_expenses.date', '<=', date('Y-m-d', strtotime($request->to_date)));
            }

            return Datatables::of($baseQuery)
                ->addIndexColumn()
                ->addColumn('status', function($row){
                    if($row->is_issue == 1){
                        $html = '<span class="badge badge-gradient-success mt-2 me-1">ISSUED</span>';
                    }else{
                        $html = '<span class="badge badge-gradient-danger mt-2 me-1">NOT ISSUE</span>';
                    }
                    return $html;
                })
                ->addColumn('action', function($row){
                    $actionBtn = '<a href="' . route('kt.daily-expenses-details', ed($row->id, true)) . '" class="btn btn-sm btn-outline-info mx-1" title="View"><i class="bx bxs-info-circle"></i></a>';
                    if($row->is_issue == 0){
                        $actionBtn .= '<a href="' . route('kt.edit-daily-expenses', ed($row->id, true)) . '" class="btn btn-sm btn-outline-warning mx-1" title="Edit"><i class="bx bxs-edit"></i></a>';
                        $actionBtn .= '<a onclick="return confirm(\'Are you sure you want to delete this record?\');" href="' . route('kt.delete-daily-expenses', ed($row->id, true)) . '" class="btn btn-sm btn-outline-danger mx-1" title="Delete"><i class="bx bxs-trash"></i></a>';
                    }
                    return $actionBtn;
                })
                ->rawColumns(['action','status'])
                ->make(true);
            }
        return view('kitchen.expenses-list');
    }
    public function add_daily_expenses(Request $request)
    {
        $title = 'Add Expenses';
        $item_list = KtItem::where('status',0)->orderBy('id', 'DESC')->get();
        $data = compact('item_list','title');
        return view('kitchen.expenses-form')->with($data);
    }
    public function edit_daily_expenses($id)
    {
        $id = ed($id, false);
        $edit = KtExpense::where('id', $id)->where('is_delete', 0)->first();
        if($edit->is_issue == 1){
            return back()->with('error', "Expense Updated not Edit this Expense!");
        }
        $edit_info = KtExpensesDetail::select('kt_expenses_details.*','kt_items.item_name')
            ->join('kt_items','kt_items.id','=','kt_expenses_details.item_id')
            ->where('kt_expenses_details.expenses_id', $id)
            ->where('kt_expenses_details.is_delete', 0)
            ->get();
        $title = 'Edit Purchase';
        $item_list = KtItem::where('status',0)->orderBy('id', 'DESC')->get();

        $data = compact('item_list','title','edit','edit_info');
        return view('kitchen.expenses-form')->with($data);
    }
    public function daily_expenses_details($id)
    {
        $id = ed($id, false);
        $data = KtExpense::select(
            'kt_expenses.*',
            'u.name as created_by'
        )
        ->join('users as u', 'u.id', '=', 'kt_expenses.generated_by')
        ->where('kt_expenses.id', $id)
        ->first();
        $item_list = KtExpensesDetail::select(
            'kt_expenses_details.*',
            'kt_items.item_name'
        )
        ->join('kt_items', 'kt_items.id', '=', 'kt_expenses_details.item_id')
        ->where('kt_expenses_details.expenses_id', $id)
        ->where('kt_expenses_details.is_delete', 0)
        ->get();
        $data = compact('data','item_list');
        return view('kitchen.expenses-info')->with($data);
    }
    public function update_daily_expenses(Request $request, $id = 0)
    {
        $request->validate([
            'date' => 'required',
        ]);
        try {
            DB::beginTransaction();

            $expenses = $id ? KtExpense::find($id) : new KtExpense();
            $expenses->date = date('Y-m-d H:i:s',strtotime($request->date));
            $expenses->total_meal = $request->total_meal;
            // $expenses->total = $request->total;
            // $expenses->sub_total = $request->sub_total;
            // $expenses->total_gst_amount = $request->total_gst_amount;
            $expenses->note = $request->note;
            if($id){
                $expenses->edit_by = Auth::user()->id;
                $expenses->edit_at = date('Y-m-d h:i:s');
            }else{
                $expenses->generated_by = Auth::user()->id;
            }
            $expenses->is_issue = (int)$request->action_type;
            $expenses->save();
            $expenses_id = $expenses->id;
            if (!empty($request->uppid) && is_array($request->uppid)) {
                KtExpensesDetail::where('expenses_id', $expenses_id)
                    ->whereNotIn('id', $request->uppid)
                    ->update(['is_delete' => 1]);
            }
            foreach ($request->item_name as $key => $items) {
                if(@$request->uppid[$key]){
                    $purchase_details = KtExpensesDetail::find($request->uppid[$key]);
                }else{
                    $purchase_details = new KtExpensesDetail();
                }
                $purchase_details->expenses_id = $expenses_id;
                $purchase_details->item_id = $request->item_name[$key];
                $purchase_details->unit_qty = $request->unit_qty[$key];
                $purchase_details->unit = $request->unit[$key];
                // $purchase_details->rate = $request->rate[$key];
                // $purchase_details->mrp = $request->mrp[$key];
                // $purchase_details->net_amount = $request->net_amount[$key];
                // $purchase_details->gst = $request->gst[$key];
                // $purchase_details->gst_amount = $request->gst_amount[$key];
                // $purchase_details->amount = $request->amount[$key];
                $purchase_details->save();
            }
            DB::commit();
            return redirect()->route('kt.daily-expenses')->with('success', 'Expenses Saved Successfully!');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Something went wrong. Try again!');
        }
    }
    public function delete_daily_expenses($id)
    {
        $id = ed($id, false);
        $data = KtExpense::where('id',$id)->first();

        if ($data) {
            if($data->status == 1){
                return back()->with('error', "Expenses Updated not Delete this Expenses!");
            }else{
                $data->update([
                    'is_delete' => 1
                ]);
                return redirect()->route('kt.daily-expenses')->with('success', 'The Expenses Deleted Successfully');
            }
        } else {
            return back()->with('error', "Something Went Wrong");
        }
    }

    // Meal Items
    public function diet_patients()
    {
        $title = 'Diet Patients';
        $diet_patients = KtDietChart::select('kt_diet_charts.*','p.name','p.dob_year','p.dob_month','p.dob_day','p.gender','d.diet_types')
            ->join('patients as p','p.id','=','kt_diet_charts.patient_id')
            ->join('kt_diet_types as d','d.id','=','kt_diet_charts.diet_id')
            ->where('kt_diet_charts.status',0)
            ->where('p.is_original', 1)
            ->orderBy('id', 'DESC')
            ->get();
        $data = compact('title', 'diet_patients');
        return view('kitchen.diet-patients')->with($data);
    }
    public function diet_charts_assign()
    {
        $patient_id = IpdRegister::where('discharge_status', 0)->where('is_active', 1)->where('is_delete', 0)->pluck('patient_id');
        $patients = Patient::select('id','name','dob_year','gender')
            ->whereIn('id', $patient_id)
            ->where('is_original', 1)
            ->orderBy('id', 'DESC')
            ->get();
        $diet_types = KtDietType::where('status', 0)->orderBy('id', 'desc')->get();
        $edit = null;
        $data = compact('diet_types', 'patients','edit');
        return view('kitchen.add-diet')->with($data);
    }
    public function edit_charts_assign($id)
    {
        $id = ed($id, false);
        $patient_id = IpdRegister::where('discharge_status', 0)->where('is_active', 1)->where('is_delete', 0)->pluck('patient_id');
        $patients = Patient::select('id','name','dob_year','gender')
            ->whereIn('id',$patient_id)
            ->where('is_original', 1)
            ->orderBy('id', 'DESC')
            ->get();
        $diet_types = KtDietType::where('status', 0)->orderBy('id', 'desc')->get();
        $edit = KtDietChart::where('id',$id)->first();
        $data = compact('diet_types', 'patients','edit');
        return view('kitchen.add-diet')->with($data);
    }
    public function update_charts_assign(Request $request, $id = 0)
    {
        $request->validate([
            'patient' => 'required',
            'diet_type' => 'required',
            'from_date' => 'required',
            'to_date' => 'required',
        ]);

        $id ? $data = KtDietChart::find($id) : $data = new KtDietChart();
        $data->patient_id = $request->patient;
        $data->diet_id = $request->diet_type;
        $data->from_date = $request->from_date;
        $data->to_date = $request->to_date;
        $data->note = $request->note;
        $data->restrictions = $request->restrictions;
        if($id){
            $data->edit_by = Auth::user()->id;
            $data->edit_at = date('Y-m-d H:i:s');
        }else{
            $data->created_by = Auth::user()->id;
        }
        if ($data->save()) {
            return redirect()->route('kt.diet-patients')->with('success', 'Successfully Updated!');
        } else {
            return redirect()->route('kt.diet-patients')->with('error', 'Something wrong try again!');
        }
    }
    public function delete_charts_assign(Request $request, $id)
    {
        $id = ed($id, false);
        $data = KtDietChart::find($id);
        $data->status = 1;
        $data->delete_by = Auth::user()->id;
        if ($data->update()) {
            return redirect()->route('kt.diet-patients')->with('success', 'Successfully Deleted!');
        } else {
            return redirect()->route('kt.diet-patients')->with('error', 'Something wrong try again!');
        }
    }
    public function get_diet_info(Request $request)
    {
        $response = KtDietChart::select('p.name','p.dob_year','p.gender','d.diet_types','kt_diet_charts.from_date','kt_diet_charts.to_date','kt_diet_charts.note','kt_diet_charts.restrictions','dm.breakfast','dm.lunch','dm.dinner','dm.snack')
            ->join('patients as p','p.id','=','kt_diet_charts.patient_id')
            ->join('kt_diet_types as d','d.id','=','kt_diet_charts.diet_id')
            ->join('kt_diet_meals as dm','dm.diet_id','=','kt_diet_charts.diet_id')
            ->where('kt_diet_charts.id',$request->id)
            ->first();
        return response()->json([
            'status' => 'success',
            'data' => $response
        ]);
    }

    // Meal Items
    public function meal_items()
    {
        $title = 'Meal Items';
        $t1 = 'Meal Items List';
        $t2 = 'Add Meal';
        $form = ['meal_name','rate'];
        $head = ['Sl. No.', 'Meal', 'Rate', 'Action'];
        $btn['name'] = 'Add Meal';
        $btn['action'] = Route('kt.update-meal-items');
        $edit['data'] = null;
        $edit['url'] = Route('kt.edit-meal-items');
        $response = KtMealItem::orderBy('id', 'desc')->get();
        $table = "kt_meal_items";
        $data = compact('title', 't1', 't2', 'form', 'head', 'btn', 'edit', 'response', 'table');
        return view('master-from')->with($data);
    }
    public function edit_meal_items($id = 0)
    {
        if (!$id) {
            return redirect()->route('kt.meal-items');
        }
        $id = ed($id, false);
        $title = 'Edit Meal';
        $t1 = 'Meal List';
        $t2 = 'Edit Meal';
        $form = ['meal_name','rate'];
        $head = ['Sl. No.', 'Meal', 'Rate', 'Action'];
        $btn['name'] = 'Update Meal';
        $btn['action'] = Route('kt.update-meal-items', $id);
        $edit['data'] =  KtMealItem::find($id);
        $edit['reset'] = Route('kt.meal-items');
        $edit['url'] = Route('kt.edit-meal-items');
        $response = KtMealItem::orderBy('id', 'desc')->get();
        $table = "kt_meal_items";
        $data = compact('title', 't1', 't2', 'form', 'head', 'btn', 'edit', 'response', 'table');
        return view('master-from')->with($data);
    }
    public function update_meal_items(Request $request, $id = 0)
    {
        $request->validate([
            'meal_name' => 'required|max:100',
            'rate' => 'required|numeric',
        ]);

        $id ? $data = KtMealItem::find($id) : $data = new KtMealItem();
        $data->meal_name = $request->meal_name;
        $data->rate = $request->rate;
        if ($data->save()) {
            return redirect()->route('kt.meal-items')->with('success', 'Successfully Updated!');
        } else {
            return redirect()->route('kt.meal-items')->with('error', 'Something wrong try again!');
        }
    }

    // Diet Meal
    public function diet_meal(Request $request)
    {
        $diet_types = KtDietType::where('status', 0)->get();
        $diet_meal = null;
        if ($request->isMethod('post')) {
            $diet_meal = KtDietMeal::find($request->diet_type);
        }
        $data = compact('diet_types','diet_meal');
        return view('kitchen.diet-meal')->with($data);
    }
    public function update_diet_meal(Request $request, $id)
    {
        $diet_meal = KtDietMeal::find($id);
        $diet_meal->breakfast = $request->breakfast;
        $diet_meal->lunch = $request->lunch;
        $diet_meal->dinner = $request->dinner;
        $diet_meal->snack = $request->snack;
        $diet_meal->updated_by = Auth::user()->id;
        if ($diet_meal->update()) {
            return redirect()->route('kt.diet-meal')->with('success', 'Successfully Updated!');
        } else {
            return redirect()->route('kt.diet-meal')->with('error', 'Something wrong try again!');
        }
    }

    // Diet Types
    public function diet_types()
    {
        $title = 'Diet Type';
        $t1 = 'Diet Type List';
        $t2 = 'Add Diet Type';
        $form = ['diet_types'];
        $head = ['Sl. No.', 'Diet Type', 'Action'];
        $btn['name'] = 'Add Diet Type';
        $btn['action'] = Route('kt.update-diet-types');
        $edit['data'] = null;
        $edit['url'] = Route('kt.edit-diet-types');
        $response = KtDietType::orderBy('id', 'desc')->get();
        $table = "kt_diet_types";
        $data = compact('title', 't1', 't2', 'form', 'head', 'btn', 'edit', 'response', 'table');
        return view('master-from')->with($data);
    }
    public function edit_diet_types($id = 0)
    {
        if (!$id) {
            return redirect()->route('kt.diet-types');
        }
        $id = ed($id, false);
        $title = 'Edit Diet Type';
        $t1 = 'Diet Type List';
        $t2 = 'Edit Diet Type';
        $form = ['diet_types'];
        $head = ['Sl. No.', 'Diet Type', 'Action'];
        $btn['name'] = 'Update Diet Type';
        $btn['action'] = Route('kt.update-diet-types', $id);
        $edit['data'] =  KtDietType::find($id);
        $edit['reset'] = Route('kt.diet-types');
        $edit['url'] = Route('kt.edit-diet-types');
        $response = KtDietType::orderBy('id', 'desc')->get();
        $table = "kt_diet_types";
        $data = compact('title', 't1', 't2', 'form', 'head', 'btn', 'edit', 'response', 'table');
        return view('master-from')->with($data);
    }
    public function update_diet_types(Request $request, $id = 0)
    {
        if( !empty($id) ){
            $request->validate([
                'diet_types' => 'required|max:60|unique:kt_diet_types,diet_types,' . $id,
            ]);
        }else{
            $request->validate([
                'diet_types' => 'required|max:60|unique:kt_diet_types,diet_types',
            ]);
        }

        $id ? $data = KtDietType::find($id) : $data = new KtDietType();
        $data->diet_types = $request->diet_types;
        if ($data->save()) {
            if(!$id){
                $meal = New KtDietMeal();
                $meal->diet_id = $data->id;
                $meal->save();
            }
            return redirect()->route('kt.diet-types')->with('success', 'Successfully Updated!');
        } else {
            return redirect()->route('kt.diet-types')->with('error', 'Something wrong try again!');
        }
    }

    // items
    public function items()
    {
        $title = 'Items';
        $t1 = 'Items List';
        $t2 = 'Add Item';
        $form = ['item_name','category_name','unit'];
        $head = ['Sl. No.', 'Item', 'Category', 'Unit', 'Action'];
        $btn['name'] = 'Add Item';
        $btn['action'] = Route('kt.update-item');
        $edit['data'] = null;
        $edit['url'] = Route('kt.edit-item');
        $response = KtItem::select('kt_items.*','c.category_name','u.unit')
            ->join('kt_item_categories as c','c.id','=','kt_items.category_id')
            ->join('kt_units as u','u.id','=','kt_items.unit_id')
            ->orderBy('id', 'desc')
            ->get();
        $extra['categories'] = KtItemCategory::where('status', 0)->get();
        $extra['units'] = KtUnit::where('status', 0)->get();
        $table = "kt_items";
        $data = compact('title', 't1', 't2', 'form', 'head', 'btn', 'edit', 'response', 'table','extra');
        return view('master-from')->with($data);
    }
    public function item_info($item_id)
    {
        $id = ed($item_id, false);
        $item_details = KtItem::select(
                'kt_items.*',
                'c.category_name',
                'u.unit'
            )
            ->join('kt_item_categories as c', 'c.id', '=', 'kt_items.category_id')
            ->join('kt_units as u', 'u.id', '=', 'kt_items.unit_id')
            ->where('kt_items.id', $id)
            ->first();
        if($item_details){
            $stocks = KtPurchase::select('kt_purchases.id','kt_purchases.date','kt_purchases.invoice_no','pd.item_id','i.item_name','pd.unit_qty','pd.unit','pd.rate','pd.mrp','pd.net_amount','pd.discount_amount','pd.gst_amount','pd.amount')
                ->join('kt_purchase_details as pd','pd.purchase_id','=','kt_purchases.id')
                ->join('kt_items as i','i.id','=','pd.item_id')
                ->where('pd.item_id', $id)
                ->where('kt_purchases.is_stock', 1)
                ->where('kt_purchases.is_delete', 0)
                ->where('pd.is_delete', 0)
                ->get();
            $issues = KtExpense::select('kt_expenses.id','kt_expenses.date','kt_expenses.total_meal','ed.item_id','i.item_name','ed.unit_qty','ed.unit','u.name as created_by')
                ->join('kt_expenses_details as ed','ed.expenses_id','=','kt_expenses.id')
                ->join('kt_items as i','i.id','=','ed.item_id')
                ->join('users as u','u.id','=','kt_expenses.generated_by')
                ->where('ed.item_id', $id)
                ->where('kt_expenses.is_issue', 1)
                ->where('kt_expenses.is_delete', 0)
                ->where('ed.is_delete', 0)
                ->get();

            $stock_unit = $stocks->sum('unit_qty') ?? 0;
            $issue_unit = $issues->sum('unit_qty') ?? 0;

            // Calculate remaining sub-units
            $remaining_unit = max($stock_unit - $issue_unit, 0);
            $pasent_stock = $remaining_unit.' '.$item_details->unit;
        }else{
            $stocks = $issues = [];
            $pasent_stock = null;
        }

        $data = compact('item_details','stocks','issues','pasent_stock');
        // dd($data);
        return view('kitchen.item-info')->with($data);
    }
    public function item_unit(Request $request)
    {
        $item = KtItem::where('kt_items.id', $request->itemId)
            ->leftJoin('kt_units as unit', 'kt_items.unit_id', '=', 'unit.id')
            ->select([
                'kt_items.unit_id',
                'unit.unit',
            ])
            ->first();

        if ($item) {
            return response()->json([
                'unit' => $item->unit,
                'unit_id' => $item->unit_id,
            ]);
        }

        return response()->json([
            'unit' => '',
            'unit_id' => '',
        ]);
    }
    public function get_item_unit(Request $request)
    {
        $items = KtItem::select('kt_items.*','u1.unit')
            ->join('kt_units as u1','u1.id','=','kt_items.unit_id')
            ->where('kt_items.id', $request->itemId)
            ->first();
        $stocks = KtPurchase::select('pd.item_id','i.item_name','pd.unit_qty','pd.unit','pd.amount')
            ->join('kt_purchase_details as pd','pd.purchase_id','=','kt_purchases.id')
            ->join('kt_items as i','i.id','=','pd.item_id')
            ->where('pd.item_id', $request->itemId)
            ->where('kt_purchases.is_stock', 1)
            ->where('kt_purchases.is_delete', 0)
            ->where('pd.is_delete', 0)
            ->get();
        $issues = KtExpense::select('ed.item_id','i.item_name','ed.unit_qty','ed.unit','ed.amount')
            ->join('kt_expenses_details as ed','ed.expenses_id','=','kt_expenses.id')
            ->join('kt_items as i','i.id','=','ed.item_id')
            ->where('ed.item_id', $request->itemId)
            ->where('kt_expenses.is_issue', 1)
            ->where('kt_expenses.is_delete', 0)
            ->where('ed.is_delete', 0)
            ->get();

        $stock_unit = $stocks->sum('unit_qty') ?? 0;
        $issue_unit = $issues->sum('unit_qty') ?? 0;

        // Calculate remaining sub-units
        $remaining_unit = max($stock_unit - $issue_unit, 0);
        $avi_qty = $remaining_unit.' '.$items->unit;

        return response()->json([
            'unit' => $items->unit,
            'avi_qty' => $avi_qty,
            'check_qty' => $remaining_unit,
        ]);
    }
    public function edit_item($id = 0)
    {
        if (!$id) {
            return redirect()->route('kt.items');
        }
        $id = ed($id, false);
        $title = 'Edit Item';
        $t1 = 'Items List';
        $t2 = 'Edit Item';
        $form = ['item_name','category_name','unit'];
        $head = ['Sl. No.', 'Item', 'Action'];
        $btn['name'] = 'Update Item';
        $btn['action'] = Route('kt.update-item', $id);
        $edit['data'] =  KtItem::find($id);
        $edit['reset'] = Route('kt.items');
        $edit['url'] = Route('kt.edit-item');
        $response = KtItem::select('kt_items.*','c.category_name','u.unit')
            ->join('kt_item_categories as c','c.id','=','kt_items.category_id')
            ->join('kt_units as u','u.id','=','kt_items.unit_id')
            ->orderBy('id', 'desc')
            ->get();
        $extra['categories'] = KtItemCategory::where('status', 0)->get();
        $extra['units'] = KtUnit::where('status', 0)->get();
        $table = "kt_items";
        $data = compact('title', 't1', 't2', 'form', 'head', 'btn', 'edit', 'response', 'table','extra');
        return view('master-from')->with($data);
    }
    public function update_item(Request $request, $id = 0)
    {
        $request->validate([
            'item_name' => 'required|max:60',
            'category_id' => 'required',
            'unit_id' => 'required',
        ]);

        $id ? $data = KtItem::find($id) : $data = new KtItem();
        $data->category_id = $request->category_id;
        $data->item_name = strtoupper($request->item_name);
        $data->unit_id = $request->unit_id;
        if ($data->save()) {
            return redirect()->route('kt.items')->with('success', 'Successfully Updated!');
        } else {
            return redirect()->route('kt.items')->with('error', 'Something wrong try again!');
        }
    }

    // category
    public function categories()
    {
        $title = 'Categories';
        $t1 = 'Categories List';
        $t2 = 'Add Category';
        $form = ['category_name'];
        $head = ['Sl. No.', 'Category', 'Action'];
        $btn['name'] = 'Add Category';
        $btn['action'] = Route('kt.update-category');
        $edit['data'] = null;
        $edit['url'] = Route('kt.edit-category');
        $response = KtItemCategory::orderBy('id', 'desc')->get();
        $table = "kt_item_categories";
        $data = compact('title', 't1', 't2', 'form', 'head', 'btn', 'edit', 'response', 'table');
        return view('master-from')->with($data);
    }
    public function edit_category($id = 0)
    {
        if (!$id) {
            return redirect()->route('kt.categories');
        }
        $id = ed($id, false);
        $title = 'Edit Category';
        $t1 = 'Categories List';
        $t2 = 'Edit Category';
        $form = ['category_name'];
        $head = ['Sl. No.', 'Category', 'Action'];
        $btn['name'] = 'Update Category';
        $btn['action'] = Route('kt.update-category', $id);
        $edit['data'] =  KtItemCategory::find($id);
        $edit['reset'] = Route('kt.categories');
        $edit['url'] = Route('kt.edit-category');
        $response = KtItemCategory::orderBy('id', 'desc')->get();
        $table = "kt_item_categories";
        $data = compact('title', 't1', 't2', 'form', 'head', 'btn', 'edit', 'response', 'table');
        return view('master-from')->with($data);
    }
    public function update_category(Request $request, $id = 0)
    {
        $request->validate([
            'category_name' => 'required|max:60',
        ]);

        $id ? $data = KtItemCategory::find($id) : $data = new KtItemCategory();
        $data->category_name = $request->category_name;
        if ($data->save()) {
            return redirect()->route('kt.categories')->with('success', 'Successfully Updated!');
        } else {
            return redirect()->route('kt.categories')->with('error', 'Something wrong try again!');
        }
    }

    // Units
    public function units()
    {
        $title = 'Units';
        $t1 = 'Units List';
        $t2 = 'Add Unit';
        $form = ['unit'];
        $head = ['Sl. No.', 'Unit', 'Action'];
        $btn['name'] = 'Add Unit';
        $btn['action'] = Route('kt.update-unit');
        $edit['data'] = null;
        $edit['url'] = Route('kt.edit-unit');
        $response = KtUnit::orderBy('id', 'desc')->get();
        $table = "kt_units";
        $data = compact('title', 't1', 't2', 'form', 'head', 'btn', 'edit', 'response', 'table');
        return view('master-from')->with($data);
    }
    public function edit_unit($id = 0)
    {
        if (!$id) {
            return redirect()->route('kt.units');
        }
        $id = ed($id, false);
        $title = 'Edit Unit';
        $t1 = 'Units List';
        $t2 = 'Edit Unit';
        $form = ['unit'];
        $head = ['Sl. No.', 'Unit', 'Action'];
        $btn['name'] = 'Update Unit';
        $btn['action'] = Route('kt.update-unit', $id);
        $edit['data'] =  KtUnit::find($id);
        $edit['reset'] = Route('kt.units');
        $edit['url'] = Route('kt.edit-unit');
        $response = KtUnit::orderBy('id', 'desc')->get();
        $table = "kt_units";
        $data = compact('title', 't1', 't2', 'form', 'head', 'btn', 'edit', 'response', 'table');
        return view('master-from')->with($data);
    }
    public function update_unit(Request $request, $id = 0)
    {
        $request->validate([
            'unit' => 'required|max:60',
        ]);

        $id ? $data = KtUnit::find($id) : $data = new KtUnit();
        $data->unit = $request->unit;
        if ($data->save()) {
            return redirect()->route('kt.units')->with('success', 'Successfully Updated!');
        } else {
            return redirect()->route('kt.units')->with('error', 'Something wrong try again!');
        }
    }

    // Suppliers
    public function suppliers()
    {
        $title = 'Suppliers';
        $t1 = 'Suppliers List';
        $t2 = 'Add Supplier';
        $form = ['supplier'];
        $head = ['Sl. No.', 'Supplier', 'Action'];
        $btn['name'] = 'Add Supplier';
        $btn['action'] = Route('kt.update-supplier');
        $edit['data'] = null;
        $edit['url'] = Route('kt.edit-supplier');
        $response = KtSupplier::orderBy('id', 'desc')->get();
        $table = "kt_suppliers";
        $data = compact('title', 't1', 't2', 'form', 'head', 'btn', 'edit', 'response', 'table');
        return view('master-from')->with($data);
    }
    public function edit_supplier($id = 0)
    {
        if (!$id) {
            return redirect()->route('kt.suppliers');
        }
        $id = ed($id, false);
        $title = 'Edit Supplier';
        $t1 = 'Suppliers List';
        $t2 = 'Edit Supplier';
        $form = ['supplier'];
        $head = ['Sl. No.', 'Supplier', 'Action'];
        $btn['name'] = 'Update Supplier';
        $btn['action'] = Route('kt.update-supplier', $id);
        $edit['data'] =  KtSupplier::find($id);
        $edit['reset'] = Route('kt.suppliers');
        $edit['url'] = Route('kt.edit-supplier');
        $response = KtSupplier::orderBy('id', 'desc')->get();
        $table = "kt_suppliers";
        $data = compact('title', 't1', 't2', 'form', 'head', 'btn', 'edit', 'response', 'table');
        return view('master-from')->with($data);
    }
    public function update_supplier(Request $request, $id = 0)
    {
        $request->validate([
            'supplier' => 'required|max:60',
        ]);

        $id ? $data = KtSupplier::find($id) : $data = new KtSupplier();
        $data->supplier = $request->supplier;
        if ($data->save()) {
            return redirect()->route('kt.suppliers')->with('success', 'Successfully Updated!');
        } else {
            return redirect()->route('kt.suppliers')->with('error', 'Something wrong try again!');
        }
    }
}
