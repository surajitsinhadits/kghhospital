<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class OtProcedureName
 * 
 * @property int $id
 * @property string|null $name
 * @property string|null $procedure_code
 * @property int $status
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @package App\Models
 */
class OtProcedureName extends Model
{
	protected $table = 'ot_procedure_names';

	protected $casts = [
		'status' => 'int'
	];

	protected $fillable = [
		'name',
		'procedure_code',
		'status'
	];
}
