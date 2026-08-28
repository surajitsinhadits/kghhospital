<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ApiLog
 * 
 * @property int $id
 * @property string $ip
 * @property int $user_id
 * @property string $method
 * @property string $route
 * @property Carbon $called_at
 *
 * @package App\Models
 */
class ApiLog extends Model
{
	protected $table = 'api_logs';
	public $timestamps = false;

	protected $casts = [
		'user_id' => 'int',
		'called_at' => 'datetime'
	];

	protected $fillable = [
		'ip',
		'user_id',
		'method',
		'route',
		'called_at'
	];
}
