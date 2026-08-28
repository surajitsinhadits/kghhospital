<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class OtPreparation
 *
 * @property int $id
 * @property int|null $ot_reg_id
 * @property int|null $ot_surg_req_id
 * @property int|null $patient_id
 * @property string|null $who_validation
 * @property string|null $asa_score
 * @property string|null $co_morbidity
 * @property string|null $consent_file
 * @property string|null $reschedule_reason
 * @property string $test_confirmation
 * @property int|null $created_by
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @package App\Models
 */
class OtPreparation extends Model
{
	protected $table = 'ot_preparation';

	protected $casts = [
		'ot_reg_id' => 'int',
		'ot_surg_req_id' => 'int',
		'patient_id' => 'int',

	];

	protected $fillable = [
		'ot_reg_id',
		'ot_surg_req_id',
		'patient_id',
		'who_validation',
		'asa_score',
		'co_morbidity',
		'consent_file',
        'reschedule_check',
		'reschedule_reason',
		'test_confirmation',
		'created_by'
	];
}
