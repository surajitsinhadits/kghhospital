<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class BlDonationCamp
 * 
 * @property int $id
 * @property string $camp_name
 * @property string $organized_by
 * @property Carbon $organized_date
 * @property string $location
 * @property Carbon $start_time
 * @property Carbon $end_time
 * @property string $contact_person
 * @property string $contact_phone
 * @property int|null $expected_donors
 * @property int|null $actual_donors
 * @property string|null $remarks
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @package App\Models
 */
class BlDonationCamp extends Model
{
	protected $table = 'bl_donation_camps';

	protected $casts = [
		'organized_date' => 'datetime',
		'start_time' => 'datetime',
		'end_time' => 'datetime',
		'expected_donors' => 'int',
		'actual_donors' => 'int'
	];

	protected $fillable = [
		'camp_name',
		'organized_by',
		'organized_date',
		'location',
		'start_time',
		'end_time',
		'contact_person',
		'contact_phone',
		'expected_donors',
		'actual_donors',
		'remarks'
	];
}
