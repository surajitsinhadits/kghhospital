<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class BlDonor
 * 
 * @property int $id
 * @property int|null $camp_id
 * @property string $name
 * @property string|null $gender
 * @property Carbon|null $dob
 * @property string|null $gov_id
 * @property string|null $health_questionnaire_responses
 * @property string|null $deferral_reason
 * @property string|null $blood_group
 * @property string $contact_number
 * @property string|null $email
 * @property string $address
 * @property string|null $state
 * @property string|null $district
 * @property string|null $pin_code
 * @property Carbon|null $last_donation_date
 * @property int $status
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @package App\Models
 */
class BlDonor extends Model
{
	protected $table = 'bl_donors';

	protected $casts = [
		'camp_id' => 'int',
		'dob' => 'datetime',
		'last_donation_date' => 'datetime',
		'status' => 'int'
	];

	protected $fillable = [
		'camp_id',
		'name',
		'gender',
		'dob',
		'gov_id',
		'health_questionnaire_responses',
		'deferral_reason',
		'blood_group',
		'contact_number',
		'email',
		'address',
		'state',
		'district',
		'pin_code',
		'last_donation_date',
		'status'
	];
}
