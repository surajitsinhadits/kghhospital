<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class VcVaccinationConsent
 * 
 * @property int $id
 * @property int $vaccination_id
 * @property int $patient_id
 * @property string|null $consent_form_path
 * @property string|null $signed_by
 * @property int|null $signed_phone
 * @property Carbon $signed_at
 * @property string|null $signature_image_path
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @package App\Models
 */
class VcVaccinationConsent extends Model
{
	protected $table = 'vc_vaccination_consents';

	protected $casts = [
		'vaccination_id' => 'int',
		'patient_id' => 'int',
		'signed_phone' => 'int',
		'signed_at' => 'datetime'
	];

	protected $fillable = [
		'vaccination_id',
		'patient_id',
		'consent_form_path',
		'signed_by',
		'signed_phone',
		'signed_at',
		'signature_image_path'
	];
}
