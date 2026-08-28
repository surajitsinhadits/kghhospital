<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class OtProgress
 * 
 * @property int $id
 * @property int|null $kit_id
 * @property string|null $device_used
 * @property string|null $anesthetic_drugs
 * @property string|null $fluid_administrative
 * @property string|null $vitals
 * @property string|null $incision_time
 * @property string|null $closure_time
 * @property int|null $blood_loss
 * @property string|null $discrepency_flags
 * @property string|null $created_by
 * @property string|null $updated_by
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @package App\Models
 */
class OtProgress extends Model
{
	protected $table = 'ot_progress';

	protected $casts = [
		'kit_id' => 'int',
		'blood_loss' => 'int'
	];

	protected $fillable = [
		'kit_id',
		'device_used',
		'anesthetic_drugs',
		'fluid_administrative',
		'vitals',
		'incision_time',
		'closure_time',
		'blood_loss',
		'discrepency_flags',
		'created_by',
		'updated_by'
	];
}
