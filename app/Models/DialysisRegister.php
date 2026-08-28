<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class DialysisRegister
 *
 * @property int $id
 * @property Carbon $admission_date
 * @property int $patient_id
 * @property int|null $insurance_id
 * @property string|null $insurance_no
 * @property string $type
 * @property int|null $department_id
 * @property int|null $doctor_id
 * @property int|null $ward_id
 * @property int|null $bed_id
 * @property int|null $referred_by
 * @property int|null $provider
 * @property int|null $market_by
 * @property string|null $responsible_person
 * @property string|null $responsible_person_relation
 * @property string|null $responsible_person_ph_no
 * @property int|null $responsible_person_age
 * @property string|null $responsible_person_address
 * @property int|null $created_by
 * @property int|null $edit_by
 * @property Carbon|null $edit_at
 * @property string $dialysis_type
 * @property int $discharge_status
 * @property int $discharge_by
 * @property Carbon|null $discharge_at
 * @property int|null $moved_id
 * @property int $is_active
 * @property int $is_delete
 * @property bool $is_original
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class DialysisRegister extends Model
{
	protected $table = 'dialysis_registers';

	protected $casts = [
		'admission_date' => 'datetime',
		'patient_id' => 'int',
		'insurance_id' => 'int',
		'department_id' => 'int',
		'doctor_id' => 'int',
		'ward_id' => 'int',
		'bed_id' => 'int',
		'referred_by' => 'int',
		'provider' => 'int',
		'market_by' => 'int',
		'responsible_person_age' => 'int',
		'created_by' => 'int',
		'edit_by' => 'int',
		'edit_at' => 'datetime',
		'discharge_status' => 'int',
		'discharge_by' => 'int',
		'discharge_at' => 'datetime',
		'moved_id' => 'int',
		'is_active' => 'int',
		'is_delete' => 'int',
		'is_original' => 'bool'
	];

	protected $fillable = [
		'admission_date',
		'patient_id',
		'insurance_id',
		'insurance_no',
		'type',
		'department_id',
		'doctor_id',
		'ward_id',
		'bed_id',
		'referred_by',
		'provider',
		'market_by',
		'responsible_person',
		'responsible_person_relation',
		'responsible_person_ph_no',
		'responsible_person_age',
		'responsible_person_address',
		'created_by',
		'edit_by',
		'edit_at',
		'dialysis_type',
		'discharge_status',
		'discharge_by',
		'discharge_at',
		'moved_id',
		'is_active',
		'is_delete',
		'is_original'
	];
}
