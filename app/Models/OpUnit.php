<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class OpUnit
 * 
 * @property int $id
 * @property string|null $unit
 * @property int|null $status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class OpUnit extends Model
{
	protected $table = 'op_units';

	protected $casts = [
		'status' => 'int'
	];

	protected $fillable = [
		'unit',
		'status'
	];
}
