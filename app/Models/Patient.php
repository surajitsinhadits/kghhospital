<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * Class Patient
 * 
 * @property int $id
 * @property string|null $uhid
 * @property string|null $name
 * @property string|null $guardian_name
 * @property string|null $guardian_contact_no
 * @property string|null $guardian_realation
 * @property string|null $marital_status
 * @property string|null $blood_group
 * @property string|null $gender
 * @property Carbon|null $date_of_birth
 * @property int|null $dob_year
 * @property int|null $dob_month
 * @property int|null $dob_day
 * @property string|null $phone
 * @property string|null $alternative_no
 * @property string|null $email
 * @property string|null $address
 * @property string|null $district
 * @property string|null $state
 * @property string|null $country
 * @property string|null $pin_code
 * @property string|null $identification_name
 * @property string|null $identification_number
 * @property string|null $remarks
 * @property bool|null $is_active
 * @property bool|null $is_delete
 * @property int|null $created_by
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class Patient extends Authenticatable
{
	use HasApiTokens, Notifiable;
	protected $table = 'patients';

	protected static function booted()
	{
		static::created(function ($patient) {

			$lastUhid = self::where('is_original', 1)
                ->where('id', '!=', $patient->id)
                ->whereNotNull('uhid')
                ->where('uhid', '>', 0)
                ->max('uhid');

            $patient->uhid = $lastUhid ? $lastUhid + 1 : $patient->id;

			$patient->saveQuietly();
		});
	}

	protected $casts = [
        'date_of_birth' => 'datetime',
        'dob_year' => 'int',
        'dob_month' => 'int',
        'dob_day' => 'int',
        'is_active' => 'bool',
        'is_delete' => 'bool',
        'created_by' => 'int',
        'is_original' => 'int',
    ];

	protected $fillable = [
        'uhid',
        'name',
        'guardian_name',
        'guardian_contact_no',
        'guardian_realation',
        'marital_status',
        'blood_group',
        'gender',
        'date_of_birth',
        'dob_year',
        'dob_month',
        'dob_day',
        'phone',
        'alternative_no',
        'email',
        'address',
        'district',
        'state',
        'country',
        'pin_code',
        'identification_name',
        'identification_number',
        'remarks',
        'is_active',
        'is_delete',
        'is_original',
        'created_by',
        'last_update'
    ];
}
