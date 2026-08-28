<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class StRequisitionItem
 * 
 * @property int $id
 * @property int|null $requisition_id
 * @property int|null $item_id
 * @property int $unit_qty
 * @property int|null $unit_id
 * @property string|null $unit_name
 * @property int $sub_unit_qty
 * @property int|null $sub_unit_id
 * @property string|null $sub_unit_name
 * @property int $is_delete
 * @property Carbon|null $created_at
 * @property Carbon|null $update_at
 *
 * @package App\Models
 */
class StRequisitionItem extends Model
{
	protected $table = 'st_requisition_items';
	public $timestamps = false;

	protected $casts = [
		'requisition_id' => 'int',
		'item_id' => 'int',
		'unit_qty' => 'int',
		'unit_id' => 'int',
		'sub_unit_qty' => 'int',
		'sub_unit_id' => 'int',
		'is_delete' => 'int',
		'update_at' => 'datetime'
	];

	protected $fillable = [
		'requisition_id',
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
