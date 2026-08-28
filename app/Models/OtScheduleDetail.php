<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class OtScheduleDetail
 * 
 * @property int $id
 * @property int|null $ot_reg_id
 * @property int|null $ot_surg_req_id
 * @property int|null $ot_preparation_id
 * @property int|null $patient_id
 * @property string|null $ot_room
 * @property string|null $ot_date
 * @property string|null $ot_day
 * @property string|null $from_time
 * @property string|null $to_time
 * @property string|null $flags
 * @property string|null $dept_id
 * @property string|null $sergeon_id
 * @property string|null $anaesthesia_id
 * @property string|null $nurse_id
 * @property string|null $technician_id
 * @property int|null $created_by
 * @property int $is_active
 * @property int $is_delete
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @package App\Models
 */
class OtScheduleDetail extends Model
{
	protected $table = 'ot_schedule_details';

	protected $casts = [
		'ot_reg_id' => 'int',
		'ot_surg_req_id' => 'int',
		'ot_preparation_id' => 'int',
		'patient_id' => 'int',
		'created_by' => 'int',
		'is_active' => 'int',
		'is_delete' => 'int'
	];

	protected $fillable = [
		'ot_reg_id',
		'ot_surg_req_id',
		'ot_preparation_id',
		'patient_id',
		'ot_room',
		'ot_date',
		'ot_day',
		'from_time',
		'to_time',
		'flags',
		'dept_id',
		'sergeon_id',
		'anaesthesia_id',
		'nurse_id',
		'technician_id',
		'created_by',
		'is_active',
		'is_delete'
	];
}
