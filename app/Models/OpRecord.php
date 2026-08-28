<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class OpRecord
 * 
 * @property int $id
 * @property int $type_id
 * @property int $patient_id
 * @property Carbon $test_date
 * @property string|null $rx
 * @property string|null $spherical
 * @property string|null $cylindrical
 * @property string|null $axis
 * @property string|null $add_power
 * @property string|null $pupil_distance
 * @property string|null $remarks
 * @property int|null $created_by
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @package App\Models
 */
class OpRecord extends Model
{
	protected $table = 'op_records';

	protected $casts = [
		'type_id' => 'int',
		'patient_id' => 'int',
		'test_date' => 'datetime',
		'created_by' => 'int'
	];

	protected $fillable = [
		'type_id',
		'patient_id',
		'rx',
		'spherical',
		'cylindrical',
		'axis',
		'add_power',
		'pupil_distance',
		'remarks',
		'created_by'
	];
}
