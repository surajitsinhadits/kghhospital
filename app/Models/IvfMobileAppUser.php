<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class IvfMobileAppUser
 * 
 * @property int $id
 * @property int $patient_id
 * @property string $role
 * @property string|null $device_token
 * @property string|null $login_otp
 * @property Carbon|null $last_active
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @package App\Models
 */
class IvfMobileAppUser extends Model
{
	protected $table = 'ivf_mobile_app_users';

	protected $casts = [
		'patient_id' => 'int',
		'last_active' => 'datetime'
	];

	protected $hidden = [
		'device_token'
	];

	protected $fillable = [
		'patient_id',
		'role',
		'device_token',
		'login_otp',
		'last_active'
	];
}
