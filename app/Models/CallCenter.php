<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class CallCenter
 * 
 * @property int $id
 * @property string|null $section
 * @property int|null $section_id
 * @property string|null $patient_name
 * @property int|null $patient_id
 * @property int|null $phone
 * @property Carbon|null $appointment_date
 * @property string|null $department
 * @property string|null $note
 * @property int $status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class CallCenter extends Model
{
	protected $table = 'call_centers';

	protected $casts = [
		'section_id' => 'int',
		'patient_id' => 'int',
		'phone' => 'int',
		'appointment_date' => 'datetime',
		'status' => 'int'
	];

	protected $fillable = [
		'section',
		'section_id',
		'patient_name',
		'patient_id',
		'phone',
		'appointment_date',
		'department',
		'note',
		'status'
	];
}
