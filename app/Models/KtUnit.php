<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class KtUnit
 * 
 * @property int $id
 * @property string $unit
 * @property int $status
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @package App\Models
 */
class KtUnit extends Model
{
	protected $table = 'kt_units';

	protected $casts = [
		'status' => 'int'
	];

	protected $fillable = [
		'unit',
		'status'
	];
}
