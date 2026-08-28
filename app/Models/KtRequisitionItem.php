<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class KtRequisitionItem
 * 
 * @property int $id
 * @property int|null $requisition_id
 * @property int|null $item_id
 * @property int $unit_qty
 * @property string|null $unit
 * @property int|null $unit_id
 * @property int $is_delete
 * @property Carbon|null $created_at
 * @property Carbon|null $update_at
 *
 * @package App\Models
 */
class KtRequisitionItem extends Model
{
	protected $table = 'kt_requisition_items';
	public $timestamps = false;

	protected $casts = [
		'requisition_id' => 'int',
		'item_id' => 'int',
		'unit_qty' => 'int',
		'unit_id' => 'int',
		'is_delete' => 'int',
		'update_at' => 'datetime'
	];

	protected $fillable = [
		'requisition_id',
		'item_id',
		'unit_qty',
		'unit',
		'unit_id',
		'is_delete',
		'update_at'
	];
}
