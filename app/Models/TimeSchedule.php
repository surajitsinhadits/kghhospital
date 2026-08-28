<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class TimeSchedule
 * 
 * @property int $id
 * @property string $doctor_id
 * @property string $date
 * @property string $day
 * @property string $from_time
 * @property string $to_time
 * @property string $time_per_slot
 * @property string $patient_per_slot
 * @property string|null $booked
 * @property string $is_active
 * @property string|null $is_delete
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class TimeSchedule extends Model
{
	protected $table = 'time_schedules';

	protected $fillable = [
		'doctor_id',
		'date',
		'day',
		'from_time',
		'to_time',
		'time_per_slot',
		'patient_per_slot',
		'booked',
		'is_active',
		'is_delete'
	];
}
