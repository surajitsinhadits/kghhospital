<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class InvestigationRegister
 * 
 * @property int $id
 * @property int|null $department_id
 * @property int|null $doctor_id
 * @property int $patient_id
 * @property int $generate_by
 * @property string|null $type
 * @property Carbon|null $appointment_date
 * @property int|null $referred_by
 * @property int|null $provider
 * @property int|null $market_by
 * @property int|null $edit_by
 * @property Carbon|null $edit_at
 * @property bool|null $is_active
 * @property bool|null $is_delete
 * @property bool $is_original
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class InvestigationRegister extends Model
{
	protected $table = 'investigation_registers';

	protected $casts = [
		'department_id' => 'int',
		'doctor_id' => 'int',
		'patient_id' => 'int',
		'generate_by' => 'int',
		'appointment_date' => 'datetime',
		'referred_by' => 'int',
		'provider' => 'int',
		'market_by' => 'int',
		'edit_by' => 'int',
		'edit_at' => 'datetime',
		'is_active' => 'bool',
		'is_delete' => 'bool',
		'is_original' => 'bool'
	];

	protected $fillable = [
		'department_id',
		'doctor_id',
		'patient_id',
		'generate_by',
		'type',
		'appointment_date',
		'referred_by',
		'provider',
		'market_by',
		'edit_by',
		'edit_at',
		'is_active',
		'is_delete',
		'is_original'
	];
}
