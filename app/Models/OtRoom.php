<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class OtRoom
 * 
 * @property int $id
 * @property string|null $name
 * @property string|null $is_used
 * @property int $status
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @package App\Models
 */
class OtRoom extends Model
{
	protected $table = 'ot_rooms';

	protected $casts = [
		'status' => 'int'
	];

	protected $fillable = [
		'name',
		'is_used',
		'status'
	];
}
