<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class EmrLog
 * 
 * @property int $id
 * @property int|null $emr_id
 * @property int|null $edit_by
 * @property int|null $edit_at
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @package App\Models
 */
class EmrLog extends Model
{
	protected $table = 'emr_logs';

	protected $casts = [
		'emr_id' => 'int',
		'edit_by' => 'int',
		'edit_at' => 'int'
	];

	protected $fillable = [
		'emr_id',
		'edit_by',
		'edit_at'
	];
}
