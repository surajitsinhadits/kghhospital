<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class StVendorItemsPrice
 * 
 * @property int $id
 * @property int $item_id
 * @property int $vendor_price_id
 * @property float $unit_price
 * @property int $status
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @package App\Models
 */
class StVendorItemsPrice extends Model
{
	protected $table = 'st_vendor_items_price';

	protected $casts = [
		'item_id' => 'int',
		'vendor_price_id' => 'int',
		'unit_price' => 'float',
		'status' => 'int'
	];

	protected $fillable = [
		'item_id',
		'vendor_price_id',
		'unit_price',
		'status'
	];
}
