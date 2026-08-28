<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class KtFoodOrderItem
 * 
 * @property int $id
 * @property int $order_id
 * @property int $item_id
 * @property int $qty
 * @property float $rate
 *
 * @package App\Models
 */
class KtFoodOrderItem extends Model
{
	protected $table = 'kt_food_order_items';
	public $timestamps = false;

	protected $casts = [
		'order_id' => 'int',
		'item_id' => 'int',
		'qty' => 'int',
		'rate' => 'float'
	];

	protected $fillable = [
		'order_id',
		'item_id',
		'qty',
		'rate'
	];
}
