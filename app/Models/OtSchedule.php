<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class OtSchedule
 * 
 * @property int $id
 * @property string|null $ot_reg_id
 * @property string|null $patient_id
 * @property string|null $from_date
 * @property string|null $from_time
 * @property string|null $to_date
 * @property string|null $to_time
 * @property string|null $status
 * @property int $is_active
 * @property int $is_delete
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @package App\Models
 */
class OtSchedule extends Model
{
	protected $table = 'ot_schedules';

	protected $casts = [
		'is_active' => 'int',
		'is_delete' => 'int'
	];

	protected $fillable = [
		'ot_reg_id',
		'patient_id',
		'from_date',
		'from_time',
		'to_date',
		'to_time',
		'status',
		'is_active',
		'is_delete'
	];
}
