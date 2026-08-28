<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class StUnit
 * 
 * @property int $id
 * @property string|null $unit
 * @property int|null $status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class StUnit extends Model
{
	protected $table = 'st_units';

	protected $casts = [
		'status' => 'int'
	];

	protected $fillable = [
		'unit',
		'status'
	];
}
