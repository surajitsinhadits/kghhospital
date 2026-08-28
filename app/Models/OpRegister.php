<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class OpRegister
 * 
 * @property int $id
 * @property int $department_id
 * @property int $doctor_id
 * @property int $patient_id
 * @property int $generate_by
 * @property string|null $type
 * @property Carbon|null $appointment_date
 * @property int|null $enquiry_id
 * @property int|null $referred_by
 * @property int|null $provider
 * @property int|null $market_by
 * @property bool|null $is_ipd_moved
 * @property Carbon|null $next_appointment_date
 * @property int|null $edit_by
 * @property Carbon|null $edit_at
 * @property bool|null $is_active
 * @property bool|null $is_delete
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class OpRegister extends Model
{
	protected $table = 'op_registers';

	protected $casts = [
		'department_id' => 'int',
		'patient_id' => 'int',
		'generate_by' => 'int',
		'appointment_date' => 'datetime',
		'enquiry_id' => 'int',
		'referred_by' => 'int',
		'provider' => 'int',
		'market_by' => 'int',
		'is_ipd_moved' => 'bool',
		'next_appointment_date' => 'datetime',
		'edit_by' => 'int',
		'edit_at' => 'datetime',
		'is_active' => 'bool',
		'is_delete' => 'bool'
	];

	protected $fillable = [
		'department_id',
		'patient_id',
		'generate_by',
		'type',
		'appointment_date',
		'is_active',
		'is_delete',
		'status',
		'prescription'
	];
}
