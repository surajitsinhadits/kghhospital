<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class PatientDoctorStatus
 * 
 * @property int $id
 * @property string $section
 * @property int $section_id
 * @property int $doctor_id
 * @property int|null $patient_id
 * @property string|null $patient_type
 * @property Carbon|null $date
 * @property string|null $in_time
 * @property string|null $out_time
 * @property int $status
 * @property int $is_delete
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class PatientDoctorStatus extends Model
{
	protected $table = 'patient_doctor_statuses';

	protected $casts = [
		'section_id' => 'int',
		'doctor_id' => 'int',
		'patient_id' => 'int',
		'date' => 'datetime',
		'status' => 'int',
		'is_delete' => 'int'
	];

	protected $fillable = [
		'section',
		'section_id',
		'doctor_id',
		'patient_id',
		'patient_type',
		'date',
		'in_time',
		'out_time',
		'status',
		'is_delete'
	];
}
