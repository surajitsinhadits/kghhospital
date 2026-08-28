<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class KtPurchaseDetail
 * 
 * @property int $id
 * @property int|null $purchase_id
 * @property int|null $item_id
 * @property int|null $unit_qty
 * @property string|null $unit
 * @property Carbon|null $exp_date
 * @property float|null $rate
 * @property float|null $mrp
 * @property float|null $net_amount
 * @property float|null $discount_percentage
 * @property float|null $discount_amount
 * @property float|null $gst
 * @property float|null $gst_amount
 * @property float|null $amount
 * @property int|null $is_delete
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class KtPurchaseDetail extends Model
{
	protected $table = 'kt_purchase_details';

	protected $casts = [
		'purchase_id' => 'int',
		'item_id' => 'int',
		'unit_qty' => 'int',
		'exp_date' => 'datetime',
		'rate' => 'float',
		'mrp' => 'float',
		'net_amount' => 'float',
		'discount_percentage' => 'float',
		'discount_amount' => 'float',
		'gst' => 'float',
		'gst_amount' => 'float',
		'amount' => 'float',
		'is_delete' => 'int'
	];

	protected $fillable = [
		'purchase_id',
		'item_id',
		'unit_qty',
		'unit',
		'exp_date',
		'rate',
		'mrp',
		'net_amount',
		'discount_percentage',
		'discount_amount',
		'gst',
		'gst_amount',
		'amount',
		'is_delete'
	];
}
