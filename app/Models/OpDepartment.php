<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class OpDepartment
 * 
 * @property int $id
 * @property string|null $department_name
 * @property bool|null $status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class OpDepartment extends Model
{
	protected $table = 'op_departments';

	protected $casts = [
		'status' => 'bool'
	];

	protected $fillable = [
		'department_name',
		'status'
	];
}
