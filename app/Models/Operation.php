<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Operation
 * 
 * @property int $id
 * @property string|null $name
 * @property string $status
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @package App\Models
 */
class Operation extends Model
{
	protected $table = 'operations';

	protected $fillable = [
		'name',
		'status'
	];
}
