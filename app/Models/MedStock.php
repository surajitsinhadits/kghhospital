<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class MedStock
 * 
 * @property int $id
 * @property string|null $grm_id
 * @property string|null $purchase_id
 * @property string|null $po_details_id
 * @property string|null $emg_challan_id
 * @property string|null $stored_room
 * @property string|null $stock_status
 * @property string|null $catagory
 * @property string|null $unit_qty
 * @property string|null $unit
 * @property string|null $sub_unit
 * @property string|null $sub_unit_qty
 * @property string|null $medicine
 * @property string|null $batch_no
 * @property Carbon|null $exp_date
 * @property string|null $mrp
 * @property string|null $discount
 * @property string|null $discount_per
 * @property string|null $p_rate
 * @property string|null $s_rate
 * @property string|null $cgst
 * @property string|null $cgst_value
 * @property string|null $sgst
 * @property string|null $sgst_value
 * @property string|null $igst
 * @property string|null $igst_value
 * @property string|null $amount
 * @property string|null $qty
 * @property string|null $present_qty
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class MedStock extends Model
{
	protected $table = 'med_stocks';

	protected $casts = [
		'exp_date' => 'datetime'
	];

	protected $fillable = [
		'grm_id',
		'purchase_id',
		'po_details_id',
		'emg_challan_id',
		'stored_room',
		'stock_status',
		'catagory',
		'unit_qty',
		'unit',
		'sub_unit',
		'sub_unit_qty',
		'medicine',
		'batch_no',
		'exp_date',
		'mrp',
		'discount',
		'discount_per',
		'p_rate',
		's_rate',
		'cgst',
		'cgst_value',
		'sgst',
		'sgst_value',
		'igst',
		'igst_value',
		'amount',
		'qty',
		'present_qty'
	];
}
