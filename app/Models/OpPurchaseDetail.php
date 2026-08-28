<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class OpPurchaseDetail
 * 
 * @property int $id
 * @property int|null $purchase_id
 * @property int|null $item_id
 * @property int|null $unit_qty
 * @property int|null $sub_unit_qty
 * @property string|null $sub_unit
 * @property string|null $unit
 * @property string|null $part_no
 * @property int|null $test_qty
 * @property Carbon|null $exp_date
 * @property float|null $rate
 * @property float|null $mrp
 * @property float|null $net_amount
 * @property float|null $discount_percentage
 * @property float|null $discount_amount
 * @property float|null $cgst
 * @property float|null $sgst
 * @property float|null $igst
 * @property float|null $cgst_amount
 * @property float|null $sgst_amount
 * @property float|null $igst_amount
 * @property float|null $amount
 * @property int|null $is_delete
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class OpPurchaseDetail extends Model
{
	protected $table = 'op_purchase_details';

	protected $casts = [
		'purchase_id' => 'int',
		'item_id' => 'int',
		'unit_qty' => 'int',
		'sub_unit_qty' => 'int',
		'test_qty' => 'int',
		'exp_date' => 'datetime',
		'rate' => 'float',
		'mrp' => 'float',
		'net_amount' => 'float',
		'discount_percentage' => 'float',
		'discount_amount' => 'float',
		'cgst' => 'float',
		'sgst' => 'float',
		'igst' => 'float',
		'cgst_amount' => 'float',
		'sgst_amount' => 'float',
		'igst_amount' => 'float',
		'amount' => 'float',
		'is_delete' => 'int'
	];

	protected $fillable = [
		'purchase_id',
		'item_id',
		'unit_qty',
		'sub_unit_qty',
		'sub_unit',
		'unit',
		'part_no',
		'test_qty',
		'exp_date',
		'rate',
		'mrp',
		'net_amount',
		'discount_percentage',
		'discount_amount',
		'cgst',
		'sgst',
		'igst',
		'cgst_amount',
		'sgst_amount',
		'igst_amount',
		'amount',
		'is_delete'
	];
}
