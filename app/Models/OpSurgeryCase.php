<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class OpSurgeryCase
 * 
 * @property int $id
 * @property int $patient_id
 * @property int|null $doctor_id
 * @property Carbon $planning_date
 * @property string $eye
 * @property string $surgery_type
 * @property string $diagnosis
 * @property string|null $priority
 * @property string|null $status
 * @property string|null $consent_file
 * @property int $generated_by
 * @property int $is_delete
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class OpSurgeryCase extends Model
{
	protected $table = 'op_surgery_cases';

	protected $casts = [
		'patient_id' => 'int',
		'doctor_id' => 'int',
		'planning_date' => 'datetime',
		'generated_by' => 'int',
		'is_delete' => 'int'
	];

	protected $fillable = [
		'patient_id',
		'doctor_id',
		'planning_date',
		'eye',
		'surgery_type',
		'diagnosis',
		'priority',
		'status',
		'consent_file',
		'generated_by',
		'is_delete'
	];
}
