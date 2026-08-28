<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class KtPurchaseOrderItem
 * 
 * @property int $id
 * @property int|null $po_id
 * @property int|null $item_id
 * @property string|null $unit_qty
 * @property string|null $unit
 * @property int|null $unit_id
 * @property int $is_delete
 * @property Carbon|null $created_at
 * @property Carbon|null $update_at
 *
 * @package App\Models
 */
class KtPurchaseOrderItem extends Model
{
	protected $table = 'kt_purchase_order_items';
	public $timestamps = false;

	protected $casts = [
		'po_id' => 'int',
		'item_id' => 'int',
		'unit_id' => 'int',
		'is_delete' => 'int',
		'update_at' => 'datetime'
	];

	protected $fillable = [
		'po_id',
		'item_id',
		'unit_qty',
		'unit',
		'unit_id',
		'is_delete',
		'update_at'
	];
}
