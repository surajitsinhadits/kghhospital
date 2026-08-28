<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class DialysisMachineHistory
 *
 * @property int $id
 * @property int $dialysis_id
 * @property int $patient_id
 * @property int $bed_id
 * @property string|null $machine_no
 * @property Carbon|null $start_time
 * @property Carbon|null $end_time
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class DialysisMachineHistory extends Model
{
	protected $table = 'dialysis_machine_history';

	protected $casts = [
		'dialysis_id' => 'int',
		'patient_id' => 'int',
		'bed_id' => 'int'
	];

	protected $fillable = [
		'dialysis_id',
		'patient_id',
		'bed_id',
		'machine_no',
		'start_time',
		'end_time'
	];
}
