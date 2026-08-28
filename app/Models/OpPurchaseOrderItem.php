<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class OpPurchaseOrderItem
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
 * @property int $punit_qty
 * @property int $psubunit_qty
 * @property int $is_delete
 * @property Carbon|null $created_at
 * @property Carbon|null $update_at
 *
 * @package App\Models
 */
class OpPurchaseOrderItem extends Model
{
	protected $table = 'op_purchase_order_items';
	public $timestamps = false;

	protected $casts = [
		'po_id' => 'int',
		'item_id' => 'int',
		'unit_id' => 'int',
		'sub_unit_id' => 'int',
		'punit_qty' => 'int',
		'psubunit_qty' => 'int',
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
		'punit_qty',
		'psubunit_qty',
		'is_delete',
		'update_at'
	];
}
