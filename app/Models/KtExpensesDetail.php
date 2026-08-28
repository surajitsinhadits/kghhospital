<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class KtExpensesDetail
 * 
 * @property int $id
 * @property int|null $expenses_id
 * @property int|null $item_id
 * @property int|null $unit_qty
 * @property string|null $unit
 * @property float|null $rate
 * @property float|null $mrp
 * @property float|null $net_amount
 * @property float|null $gst
 * @property float|null $gst_amount
 * @property float|null $amount
 * @property int|null $is_delete
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class KtExpensesDetail extends Model
{
	protected $table = 'kt_expenses_details';

	protected $casts = [
		'expenses_id' => 'int',
		'item_id' => 'int',
		'unit_qty' => 'int',
		'rate' => 'float',
		'mrp' => 'float',
		'net_amount' => 'float',
		'gst' => 'float',
		'gst_amount' => 'float',
		'amount' => 'float',
		'is_delete' => 'int'
	];

	protected $fillable = [
		'expenses_id',
		'item_id',
		'unit_qty',
		'unit',
		'rate',
		'mrp',
		'net_amount',
		'gst',
		'gst_amount',
		'amount',
		'is_delete'
	];
}
