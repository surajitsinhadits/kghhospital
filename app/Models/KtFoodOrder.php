<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class KtFoodOrder
 * 
 * @property int $id
 * @property Carbon $date
 * @property string $name
 * @property string|null $phone
 * @property float $sub_total
 * @property float $gst_amount
 * @property int|null $gst
 * @property float $discount_amount
 * @property int|null $discount
 * @property string|null $discount_type
 * @property float $total
 * @property float $total_payment
 * @property float $total_due
 * @property float|null $collect_amount
 * @property Carbon|null $collect_at
 * @property string $order_mode
 * @property int $status
 * @property Carbon|null $status_at
 * @property Carbon|null $process_at
 * @property int $process_time_minute
 * @property int|null $is_delete
 * @property int|null $created_by
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @package App\Models
 */
class KtFoodOrder extends Model
{
	protected $table = 'kt_food_orders';

	protected $casts = [
		'date' => 'datetime',
		'sub_total' => 'float',
		'gst_amount' => 'float',
		'gst' => 'int',
		'discount_amount' => 'float',
		'discount' => 'int',
		'total' => 'float',
		'total_payment' => 'float',
		'total_due' => 'float',
		'collect_amount' => 'float',
		'collect_at' => 'datetime',
		'status' => 'int',
		'status_at' => 'datetime',
		'process_at' => 'datetime',
		'process_time_minute' => 'int',
		'is_delete' => 'int',
		'created_by' => 'int'
	];

	protected $fillable = [
		'date',
		'name',
		'phone',
		'sub_total',
		'gst_amount',
		'gst',
		'discount_amount',
		'discount',
		'discount_type',
		'total',
		'total_payment',
		'total_due',
		'collect_amount',
		'collect_at',
		'order_mode',
		'status',
		'status_at',
		'process_at',
		'process_time_minute',
		'is_delete',
		'created_by'
	];
}
