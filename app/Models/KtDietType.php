<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class KtDietType
 * 
 * @property int $id
 * @property string $diet_types
 * @property int $status
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @package App\Models
 */
class KtDietType extends Model
{
	protected $table = 'kt_diet_types';

	protected $casts = [
		'status' => 'int'
	];

	protected $fillable = [
		'diet_types',
		'status'
	];
}
