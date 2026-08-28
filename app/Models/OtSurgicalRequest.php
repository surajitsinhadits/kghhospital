<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class OtSurgicalRequest
 *
 * @property int $id
 * @property int $ot_reg_id
 * @property int|null $patient_id
 * @property int|null $procedure_code
 * @property int|null $procedure_name
 * @property string|null $proposed_ot_date
 * @property string|null $from_time
 * @property string|null $to_time
 * @property int|null $department
 * @property int|null $surgeon
 * @property int|null $anaesthetist
 * @property int|null $nurse
 * @property int|null $ot_technician
 * @property int|null $ot_room
 * @property string|null $anesthesia_type
 * @property int|null $ot_package
 * @property int|null $blood_unit
 * @property string $consent
 * @property string|null $status
 * @property int|null $done_by
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @package App\Models
 */
class OtSurgicalRequest extends Model
{
	protected $table = 'ot_surgical_request';

	protected $casts = [
		'is_active' => 'int',
		'is_delete' => 'int'
	];

	protected $fillable = [
		'ot_reg_id',
		'patient_id',
		'procedure_code',
		'procedure_name',
		'proposed_ot_date',
		'from_time',
		'to_time',
		'department',
		'surgeon',
		'anaesthetist',
		'nurse',
		'ot_technician',
		'ot_room',
		'anesthesia_type',
		'ot_package',
		'blood_unit',
		'consent',
		'ot_status',
		'done_by'
	];
}
