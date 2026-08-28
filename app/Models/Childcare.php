<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Childcare
 * 
 * @property int $id
 * @property string|null $name
 * @property string|null $guardian_name
 * @property string|null $blood_group
 * @property string|null $gender
 * @property Carbon|null $date_of_birth
 * @property int|null $dob_year
 * @property int|null $dob_month
 * @property int|null $dob_day
 * @property string|null $address
 * @property string|null $district
 * @property string|null $state
 * @property string|null $pin_code
 * @property int|null $doctor_id
 * @property string|null $diagnosis
 * @property string|null $operation
 * @property string|null $weight
 * @property string|null $baby_status
 * @property string|null $delivery_mode
 * @property Carbon|null $admission_date
 * @property Carbon|null $discharge_date
 * @property int|null $edit_by
 * @property Carbon|null $edit_at
 * @property bool|null $is_active
 * @property bool|null $is_delete
 * @property int|null $created_by
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class Childcare extends Model
{
	protected $table = 'childcares';

	protected $casts = [
		'date_of_birth' => 'datetime',
		'dob_year' => 'int',
		'dob_month' => 'int',
		'dob_day' => 'int',
		'doctor_id' => 'int',
		'admission_date' => 'datetime',
		'discharge_date' => 'datetime',
		'edit_by' => 'int',
		'edit_at' => 'datetime',
		'is_active' => 'bool',
		'is_delete' => 'bool',
		'created_by' => 'int'
	];

	protected $fillable = [
		'name',
		'guardian_name',
		'blood_group',
		'gender',
		'date_of_birth',
		'dob_year',
		'dob_month',
		'dob_day',
		'address',
		'district',
		'state',
		'pin_code',
		'doctor_id',
		'diagnosis',
		'operation',
		'weight',
		'baby_status',
		'delivery_mode',
		'admission_date',
		'discharge_date',
		'edit_by',
		'edit_at',
		'is_active',
		'is_delete',
		'created_by'
	];
}
