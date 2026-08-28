<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class KtFoodDelivery
 * 
 * @property int $id
 * @property Carbon $date
 * @property int $patient_id
 * @property int|null $ipd_id
 * @property int $breakfast
 * @property int|null $breakfast_by
 * @property Carbon|null $breakfast_at
 * @property int $lunch
 * @property int|null $lunch_by
 * @property Carbon|null $lunch_at
 * @property int $dinner
 * @property int|null $dinner_by
 * @property Carbon|null $dinner_at
 * @property int $snack
 * @property int|null $snack_by
 * @property Carbon|null $snack_at
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @package App\Models
 */
class KtFoodDelivery extends Model
{
	protected $table = 'kt_food_deliveries';

	protected $casts = [
		'date' => 'datetime',
		'patient_id' => 'int',
		'ipd_id' => 'int',
		'breakfast' => 'int',
		'breakfast_by' => 'int',
		'breakfast_at' => 'datetime',
		'lunch' => 'int',
		'lunch_by' => 'int',
		'lunch_at' => 'datetime',
		'dinner' => 'int',
		'dinner_by' => 'int',
		'dinner_at' => 'datetime',
		'snack' => 'int',
		'snack_by' => 'int',
		'snack_at' => 'datetime'
	];

	protected $fillable = [
		'date',
		'patient_id',
		'ipd_id',
		'breakfast',
		'breakfast_by',
		'breakfast_at',
		'lunch',
		'lunch_by',
		'lunch_at',
		'dinner',
		'dinner_by',
		'dinner_at',
		'snack',
		'snack_by',
		'snack_at'
	];
}
