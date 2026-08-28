<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class IvfConsent
 * 
 * @property int $id
 * @property int|null $patient_id
 * @property string|null $consent_type
 * @property string|null $file_path
 * @property Carbon|null $signed_on
 * @property string|null $biometric_log
 * @property string|null $video_log_path
 * @property int|null $verified_by
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @package App\Models
 */
class IvfConsent extends Model
{
	protected $table = 'ivf_consents';

	protected $casts = [
		'patient_id' => 'int',
		'signed_on' => 'datetime',
		'verified_by' => 'int'
	];

	protected $fillable = [
		'patient_id',
		'consent_type',
		'file_path',
		'signed_on',
		'biometric_log',
		'video_log_path',
		'verified_by'
	];
}
