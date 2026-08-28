<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class StDepartment
 * 
 * @property int $id
 * @property string|null $department_name
 * @property bool|null $status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class StDepartment extends Model
{
	protected $table = 'st_departments';

	protected $casts = [
		'status' => 'bool'
	];

	protected $fillable = [
		'department_name',
		'status'
	];
}
