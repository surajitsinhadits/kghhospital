<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class KtDietMeal
 * 
 * @property int $id
 * @property int $diet_id
 * @property string|null $breakfast
 * @property string|null $lunch
 * @property string|null $dinner
 * @property string|null $snack
 * @property int|null $updated_by
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @package App\Models
 */
class KtDietMeal extends Model
{
	protected $table = 'kt_diet_meals';

	protected $casts = [
		'diet_id' => 'int',
		'updated_by' => 'int'
	];

	protected $fillable = [
		'diet_id',
		'breakfast',
		'lunch',
		'dinner',
		'snack',
		'updated_by'
	];
}
