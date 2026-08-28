<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class MedFreeStock
 * 
 * @property int $id
 * @property string|null $purchase_id
 * @property string|null $stored_room
 * @property string|null $unit_qty
 * @property string|null $unit
 * @property string|null $medicine
 * @property string|null $batch_no
 * @property Carbon|null $exp_date
 * @property string|null $mrp
 * @property string|null $p_rate
 * @property string|null $s_rate
 * @property string|null $qty
 * @property string|null $present_qty
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class MedFreeStock extends Model
{
	protected $table = 'med_free_stocks';

	protected $casts = [
		'exp_date' => 'datetime'
	];

	protected $fillable = [
		'purchase_id',
		'stored_room',
		'unit_qty',
		'unit',
		'medicine',
		'batch_no',
		'exp_date',
		'mrp',
		'p_rate',
		's_rate',
		'qty',
		'present_qty'
	];
}
