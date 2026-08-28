<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class KtMealItem
 * 
 * @property int $id
 * @property string $meal_name
 * @property float $rate
 * @property int $status
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @package App\Models
 */
class KtMealItem extends Model
{
	protected $table = 'kt_meal_items';

	protected $casts = [
		'rate' => 'float',
		'status' => 'int'
	];

	protected $fillable = [
		'meal_name',
		'rate',
		'status'
	];
}
