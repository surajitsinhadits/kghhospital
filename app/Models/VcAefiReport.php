<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class VcAefiReport
 * 
 * @property int $id
 * @property int|null $patient_vaccination_id
 * @property Carbon|null $reported_at
 * @property string|null $symptoms
 * @property string|null $classification
 * @property string|null $onset_interval
 * @property string|null $outcome
 * @property string|null $action_taken
 * @property string|null $investigation_notes
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class VcAefiReport extends Model
{
	protected $table = 'vc_aefi_reports';

	protected $casts = [
		'patient_vaccination_id' => 'int',
		'reported_at' => 'datetime'
	];

	protected $fillable = [
		'patient_vaccination_id',
		'reported_at',
		'symptoms',
		'classification',
		'onset_interval',
		'outcome',
		'action_taken',
		'investigation_notes'
	];
}
