<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class StPurchaseOrderItem
 *
 * @property int $id
 * @property int|null $po_id
 * @property int|null $item_id
 * @property string|null $unit_qty
 * @property int|null $unit_id
 * @property string|null $unit_name
 * @property string|null $sub_unit_qty
 * @property int|null $sub_unit_id
 * @property string|null $sub_unit_name
 * @property int $is_delete
 * @property Carbon|null $created_at
 * @property Carbon|null $update_at
 *
 * @package App\Models
 */
class StPurchaseOrderItem extends Model
{
	protected $table = 'st_purchase_order_items';
	public $timestamps = false;

	protected $casts = [
		'po_id' => 'int',
		'item_id' => 'int',
		'unit_id' => 'int',
		'sub_unit_id' => 'int',
        'total_price' => 'float',
		'is_delete' => 'int',
		'update_at' => 'datetime'
	];

	protected $fillable = [
		'po_id',
		'item_id',
		'unit_qty',
		'unit_id',
		'unit_name',
		'sub_unit_qty',
		'sub_unit_id',
		'sub_unit_name',
		'is_delete',
		'update_at'
	];
}
