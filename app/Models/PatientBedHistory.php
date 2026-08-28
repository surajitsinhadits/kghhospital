<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class PatientBedHistory
 * 
 * @property int $id
 * @property int $patient_id
 * @property int $bed_id
 * @property Carbon|null $from_date
 * @property Carbon|null $to_date
 * @property string|null $section
 * @property int|null $section_id
 * @property int|null $case_id
 * @property int|null $department_id
 * @property int|null $cons_doctor_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class PatientBedHistory extends Model
{
	protected $table = 'patient_bed_histories';

	protected $casts = [
		'patient_id' => 'int',
		'bed_id' => 'int',
		'from_date' => 'datetime',
		'to_date' => 'datetime',
		'section_id' => 'int',
		'case_id' => 'int',
		'department_id' => 'int',
		'cons_doctor_id' => 'int'
	];

	protected $fillable = [
		'patient_id',
		'bed_id',
		'from_date',
		'to_date',
		'section',
		'section_id',
		'case_id',
		'department_id',
		'cons_doctor_id'
	];
}
