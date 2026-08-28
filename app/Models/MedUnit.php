<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class MedUnit
 * 
 * @property int $id
 * @property string $medicine_unit_name
 * @property int|null $status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class MedUnit extends Model
{
	protected $table = 'med_units';

	protected $casts = [
		'status' => 'int'
	];

	protected $fillable = [
		'medicine_unit_name',
		'status'
	];
}
