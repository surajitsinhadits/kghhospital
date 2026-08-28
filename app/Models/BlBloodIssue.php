<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class BlBloodIssue
 * 
 * @property int $id
 * @property string $section
 * @property int $section_id
 * @property int $billing_id
 * @property int $donation_id
 * @property int $patient_id
 * @property int $created_by
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @package App\Models
 */
class BlBloodIssue extends Model
{
	protected $table = 'bl_blood_issue';

	protected $casts = [
		'section_id' => 'int',
		'billing_id' => 'int',
		'donation_id' => 'int',
		'patient_id' => 'int',
		'created_by' => 'int'
	];

	protected $fillable = [
		'section',
		'section_id',
		'billing_id',
		'donation_id',
		'patient_id',
		'created_by'
	];
}
