<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class IvfDonor
 * 
 * @property int $id
 * @property string|null $name
 * @property string|null $gender
 * @property Carbon|null $dob
 * @property string|null $phone
 * @property string|null $email
 * @property string|null $national_id
 * @property string|null $marital_status
 * @property string|null $address
 * @property string|null $blood_group
 * @property float|null $bmi
 * @property int|null $parity
 * @property string|null $screening_tests
 * @property int|null $usage_count
 * @property int|null $max_allowed
 * @property string|null $compensation_record
 * @property int|null $consent_form_id
 * @property string|null $type
 * @property string $status
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @package App\Models
 */
class IvfDonor extends Model
{
	protected $table = 'ivf_donors';

	protected $casts = [
		'dob' => 'datetime',
		'bmi' => 'float',
		'parity' => 'int',
		'usage_count' => 'int',
		'max_allowed' => 'int',
		'consent_form_id' => 'int'
	];

	protected $fillable = [
		'name',
		'gender',
		'dob',
		'phone',
		'email',
		'national_id',
		'marital_status',
		'address',
		'blood_group',
		'bmi',
		'parity',
		'screening_tests',
		'usage_count',
		'max_allowed',
		'compensation_record',
		'consent_form_id',
		'type',
		'status'
	];
}
