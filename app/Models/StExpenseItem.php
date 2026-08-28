<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class StExpenseItem
 *
 * @property int $id
 * @property int $expense_id
 * @property int $item_id
 * @property int $unit_qty
 * @property int $unit_id
 * @property int $sub_unit_qty
 * @property int $sub_unit_id
 * @property int $is_delete
 * @property Carbon $created_at
 * @property Carbon $update_at
 *
 * @package App\Models
 */
class StExpenseItem extends Model
{
	protected $table = 'st_expense_items';
	public $timestamps = false;

	protected $casts = [
		'expense_id' => 'int',
		'item_id' => 'int',
		'unit_qty' => 'int',
		'unit_id' => 'int',
		'sub_unit_qty' => 'int',
		'sub_unit_id' => 'int',
		'is_delete' => 'int'
	];

	protected $fillable = [
		'expense_id',
		'item_id',
		'unit_qty',
		'unit_id',
        'unit_name',
		'sub_unit_qty',
		'sub_unit_id',
        'sub_unit_name'
	];
}
