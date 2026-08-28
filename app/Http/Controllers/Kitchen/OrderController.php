<?php

namespace App\Http\Controllers\Kitchen;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Yajra\Datatables\DataTables;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Models\IpdRegister;
use App\Models\KtFoodDelivery;
use App\Models\KtMealItem;
use App\Models\KtFoodOrder;
use App\Models\KtFoodOrderItem;
use Carbon\Carbon;
use DB;

class OrderController extends Controller
{
    // Orders
    public function manage_orders(){
        $meals = KtMealItem::where('status', 0)->orderBy('rate', 'DESC')->get();
        $orders = KtFoodOrder::whereDate('date', date('Y-m-d'))
            ->latest()
            ->get()
            ->map(function ($order) {
                $order->meals = KtFoodOrderItem::select('mi.meal_name')
                    ->join('kt_meal_items as mi','mi.id','=','kt_food_order_items.item_id')
                    ->where('order_id', $order->id)
                    ->pluck('meal_name');
                return $order;
            });
        $data = compact('meals','orders');
        // dd($data);
        return view('kitchen.manage-orders')->with($data);
    }
    public function due_collection($id){
        $id = ed($id, false);
        $orders = KtFoodOrder::find($id);
        $orders->collect_amount = $orders->total_due;
        $orders->collect_at = date('Y-m-d H:i:s');
        $orders->total_due = 0;
        $orders->update();
        return redirect()->back()->with('success','Successfully Updated');
    }
    public function meal_price(Request $request){
        $meal_price = KtMealItem::where('id', $request->mealId)->first();
        return response()->json([
            'status' => $meal_price ? true : false,
            'meal_price' => $meal_price ? $meal_price->rate : 0,
        ]);
    }
    public function save_orders(Request $request){
        $request->validate([
            'name' => 'required|max:100',
            'sub_total' => 'required',
            'total' => 'required',
            'payment' => 'required',
        ]);

        $dis = ($request->discount_type === 'percentage')
            ? $request->sub_total * ($request->discount / 100)
            : ($request->discount ?? 0);

        $gst = ($request->gst)
            ? ($request->sub_total - $dis) * ($request->gst / 100)
            : 0;


        $order = New KtFoodOrder();
        $order->date = date('Y-m-d H:i:s');
        $order->name = $request->name;
        $order->phone = $request->phone;
        $order->sub_total = $request->sub_total;
        $order->gst_amount = $gst;
        $order->gst = $request->gst;
        $order->discount_amount = $dis;
        $order->discount = $request->discount;
        $order->discount_type = $request->discount_type;
        $order->total = $request->total;
        $order->total_payment = $request->payment;
        $order->total_due = ($request->total - $request->payment);
        $order->created_by = Auth::user()->id;
        if($order->save()){
            foreach($request->meal ?? [] as $key => $value){
                KtFoodOrderItem::insert([
                    'order_id' => $order->id,
                    'item_id' => $value,
                    'qty' => $request->qty[$key],
                    'rate' => $request->rate[$key]
                ]);
            }
            return redirect()->back()->with('success','Successfully Updated');
        }
        return redirect()->back()->with('error','Failed! Try again');
    }
    public function food_delivery()
    {
        $dateInput = request()->get('date');
        $search_data = $dateInput ? Carbon::parse($dateInput) : Carbon::today();
        $today = Carbon::today()->toDateString();
        $patients = IpdRegister::select('ipd_registers.id', 'ipd_registers.patient_id', 'p.uhid as patient_uhid', 'p.name', 'p.phone', 'p.gender', 'p.dob_year', 'w.ward_name', 'b.bed_name','dt.diet_types')
            ->leftJoin(DB::raw("(
                SELECT * FROM kt_diet_charts AS dc1
                WHERE dc1.id = (
                    SELECT MAX(dc2.id)
                    FROM kt_diet_charts AS dc2
                    WHERE dc2.patient_id = dc1.patient_id
                    AND dc2.from_date <= '$today'
                    AND dc2.to_date >= '$today'
                )
            ) as dc"), 'dc.patient_id', '=', 'ipd_registers.patient_id')
            ->leftJoin('kt_diet_types as dt', 'dt.id', '=', 'dc.diet_id')
            ->join('patients as p', 'p.id', '=', 'ipd_registers.patient_id')
            ->join('wards as w', 'w.id', '=', 'ipd_registers.ward_id')
            ->join('beds as b', 'b.id', '=', 'ipd_registers.bed_id')
            ->where('ipd_registers.discharge_status', 0)
            ->where('ipd_registers.is_active', 1)
            ->where('ipd_registers.is_delete', 0)
            ->get()
            ->map(function ($patient) use ($search_data) {
                $foodDelivery = KtFoodDelivery::select('breakfast','lunch','dinner','snack')
                    ->where('patient_id', $patient->patient_id)
                    ->whereDate('date', $search_data)
                    ->latest('id')
                    ->first();

                $patient->last_delivery = $foodDelivery;
                return $patient;
            });
        $data = compact('patients','search_data');
        // dd($data);
        return view('kitchen.food-delivery')->with($data);
    }
    public function update_delivery(Request $request)
    {
        $data = trim($request->data_id);
        $data = explode('_', $data);
        $check = KtFoodDelivery::whereDate('date', Carbon::today())->where('patient_id', $data[0])->first();
        if($check){
            $upid = $check->id;
        }else{
            $insert = new KtFoodDelivery();
            $insert->date = date('Y-m-d');
            $insert->patient_id = $data[0];
            $insert->ipd_id = @$data[1] ?? null;
            $insert->save();
            $upid = $insert->id;
        }
        $value = $request->value;
        $update = KtFoodDelivery::find($upid);
        switch ($request->type) {
            case "breakfast":
                $update->breakfast = $value;
                $update->breakfast_by = Auth::user()->id;
                $update->breakfast_at = now();
                break;

            case "lunch":
                $update->lunch = $value;
                $update->lunch_by = Auth::user()->id;
                $update->lunch_at = now();
                break;

            case "dinner":
                $update->dinner = $value;
                $update->dinner_by = Auth::user()->id;
                $update->dinner_at = now();
                break;

            case "snack":
                $update->snack = $value;
                $update->snack_by = Auth::user()->id;
                $update->snack_at = now();
                break;
        }
        if($update->update()){
            return true;
        }else{
            return false;
        }
    }
    public function update_multi_delivery(Request $request)
    {
        if(count($request->data) > 0){
            $data_array = $request->data;
            DB::beginTransaction();
            try {
                foreach($data_array as $item){
                    $data = trim($item['value']);
                    $data = explode('_', $data);
                    $check = KtFoodDelivery::whereDate('date', Carbon::today())->where('patient_id', $data[0])->first();
                    if($check){
                        $upid = $check->id;
                    }else{
                        $insert = new KtFoodDelivery();
                        $insert->date = date('Y-m-d');
                        $insert->patient_id = $data[0];
                        $insert->ipd_id = @$data[1] ?? null;
                        $insert->save();
                        $upid = $insert->id;
                    }
                    $value = $item['checked'];
                    $update = KtFoodDelivery::find($upid);
                    switch ($request->type) {
                        case "breakfast":
                            $update->breakfast = $value;
                            $update->breakfast_by = Auth::user()->id;
                            $update->breakfast_at = now();
                            break;

                        case "lunch":
                            $update->lunch = $value;
                            $update->lunch_by = Auth::user()->id;
                            $update->lunch_at = now();
                            break;

                        case "dinner":
                            $update->dinner = $value;
                            $update->dinner_by = Auth::user()->id;
                            $update->dinner_at = now();
                            break;

                        case "snack":
                            $update->snack = $value;
                            $update->snack_by = Auth::user()->id;
                            $update->snack_at = now();
                            break;
                    }
                    $update->update();
                }
                DB::commit();
                return true;
            } catch (Exception $e) {
                DB::rollback();
                return false;
            }
        }else{
            return false;
        }
    }
    public function orders_report(Request $request){
        if ($request->ajax()) {
            $baseQuery = KtFoodOrder::where('is_delete', '0');

            // Filter by data
            if (!empty($request->order_type)) {
                $baseQuery->where('order_mode', $request->order_type);
            }
            if (!empty($request->payment_status)) {
                $request->payment_status == 'due' ?
                    $baseQuery->where('total_due', '>', 0)
                    : $baseQuery->where('total_due', '=', 0);
            }
            if (!empty($request->order_status)) {
                $baseQuery->where('status', $request->order_status);
            }
            if (!empty($request->from_date)) {
                $baseQuery->whereDate('date', '>=', date('Y-m-d', strtotime($request->from_date)));
            }
            if (!empty($request->to_date)) {
                $baseQuery->whereDate('date', '<=', date('Y-m-d', strtotime($request->to_date)));
            }

            return Datatables::of($baseQuery->orderBy('id', 'DESC'))
                ->addIndexColumn()
                ->addColumn('order_date', function ($row) {
                    $dateBtn = dateFor($row->date, true);
                    return $dateBtn;
                })
                ->addColumn('meals', function ($row) {
                    $mealsBtn = KtFoodOrderItem::select('mi.meal_name')
                        ->join('kt_meal_items as mi','mi.id','=','kt_food_order_items.item_id')
                        ->where('order_id', $row->id)
                        ->pluck('meal_name');
                    return $mealsBtn;
                })
                ->rawColumns(['order_date','meals'])
                ->make(true);
        }
        return view('kitchen.orders-report');
    }
}
