<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class OpPowerType
 * 
 * @property int $id
 * @property string|null $type_name
 * @property bool|null $status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class OpPowerType extends Model
{
	protected $table = 'op_power_type';

	protected $casts = [
		'status' => 'bool'
	];

	protected $fillable = [
		'type_name',
		'status'
	];
}
