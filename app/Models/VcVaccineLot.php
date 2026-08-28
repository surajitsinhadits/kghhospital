<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class VcVaccineLot
 * 
 * @property int $id
 * @property int|null $vaccine_id
 * @property int|null $purchase_details_id
 * @property string|null $batch_number
 * @property Carbon|null $exp_date
 * @property int|null $unit_qty
 * @property string|null $unit
 * @property int|null $sub_unit_qty
 * @property string|null $sub_unit
 * @property int $unit_relation
 * @property float|null $s_rate
 * @property int|null $total_qty
 * @property int|null $available_qty
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class VcVaccineLot extends Model
{
	protected $table = 'vc_vaccine_lots';

	protected $casts = [
		'vaccine_id' => 'int',
		'purchase_details_id' => 'int',
		'exp_date' => 'datetime',
		'unit_qty' => 'int',
		'sub_unit_qty' => 'int',
		'unit_relation' => 'int',
		's_rate' => 'float',
		'total_qty' => 'int',
		'available_qty' => 'int'
	];

	protected $fillable = [
		'vaccine_id',
		'purchase_details_id',
		'batch_number',
		'exp_date',
		'unit_qty',
		'unit',
		'sub_unit_qty',
		'sub_unit',
		'unit_relation',
		's_rate',
		'total_qty',
		'available_qty'
	];
}
