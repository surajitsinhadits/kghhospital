<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class OtProcedure
 * 
 * @property int $id
 * @property string|null $code
 * @property int $status
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @package App\Models
 */
class OtProcedure extends Model
{
	protected $table = 'ot_procedures';

	protected $casts = [
		'status' => 'int'
	];

	protected $fillable = [
		'code',
		'status'
	];
}
