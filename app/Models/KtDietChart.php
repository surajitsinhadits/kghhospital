<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class KtDietChart
 * 
 * @property int $id
 * @property int $patient_id
 * @property int $diet_id
 * @property Carbon|null $from_date
 * @property Carbon|null $to_date
 * @property string|null $note
 * @property string|null $restrictions
 * @property int $status
 * @property int|null $edit_by
 * @property Carbon|null $edit_at
 * @property int|null $delete_by
 * @property int $created_by
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @package App\Models
 */
class KtDietChart extends Model
{
	protected $table = 'kt_diet_charts';

	protected $casts = [
		'patient_id' => 'int',
		'diet_id' => 'int',
		'from_date' => 'datetime',
		'to_date' => 'datetime',
		'status' => 'int',
		'edit_by' => 'int',
		'edit_at' => 'datetime',
		'delete_by' => 'int',
		'created_by' => 'int'
	];

	protected $fillable = [
		'patient_id',
		'diet_id',
		'from_date',
		'to_date',
		'note',
		'restrictions',
		'status',
		'edit_by',
		'edit_at',
		'delete_by',
		'created_by'
	];
}
