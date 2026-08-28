<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class DischargeReport
 * 
 * @property int $id
 * @property string $section
 * @property int $section_id
 * @property Carbon $discharge_date
 * @property string $discharge_type
 * @property string|null $refferal_hospital_name
 * @property Carbon|null $next_appointment_date
 * @property string|null $icd_code
 * @property string|null $complaiints_duraiton
 * @property string|null $presenting_illness
 * @property string|null $physical_examinaiton_at_admission
 * @property string|null $summary_inves_during_hos
 * @property string|null $course_complications
 * @property string|null $dischage_advice
 * @property int $save_type
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class DischargeReport extends Model
{
	protected $table = 'discharge_reports';

	protected $casts = [
		'section_id' => 'int',
		'discharge_date' => 'datetime',
		'next_appointment_date' => 'datetime',
		'save_type' => 'int'
	];

	protected $fillable = [
		'section',
		'section_id',
		'discharge_date',
		'discharge_type',
		'refferal_hospital_name',
		'next_appointment_date',
		'icd_code',
		'complaiints_duraiton',
		'presenting_illness',
		'physical_examinaiton_at_admission',
		'summary_inves_during_hos',
		'course_complications',
		'dischage_advice',
		'save_type'
	];
}
