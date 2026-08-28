<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class OpdEnquiry
 * 
 * @property int $id
 * @property int $slot_id
 * @property int $department_id
 * @property int $doctor_id
 * @property Carbon|null $appointment_date
 * @property Carbon|null $booking_time
 * @property int|null $booking_by
 * @property string|null $appointment_time
 * @property string|null $uhid
 * @property string|null $name
 * @property string|null $phone
 * @property string|null $gender
 * @property int|null $dob_year
 * @property int|null $dob_month
 * @property int|null $dob_day
 * @property string|null $address
 * @property bool|null $is_register
 * @property bool|null $is_delete
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class OpdEnquiry extends Model
{
	protected $table = 'opd_enquiries';

	protected $casts = [
		'department_id' => 'int',
		'doctor_id' => 'int',
		'appointment_date' => 'datetime',
		'appointment_time' => 'datetime',
		'booking_by' => 'int',
		'dob_year' => 'int',
		'dob_month' => 'int',
		'dob_day' => 'int',
		'is_register' => 'bool',
		'is_delete' => 'bool'
	];

	protected $fillable = [
		'doctor_id',
		'appointment_date',
		'booking_by',
		'appointment_time',
		'uhid',
		'name',
		'phone',
		'gender',
		'dob_year',
		'dob_month',
		'dob_day',
		'address',
		'is_register',
		'is_delete'
	];
}
