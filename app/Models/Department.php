<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Department
 * 
 * @property int $id
 * @property string $department_name
 * @property string $department_code
 * @property bool|null $status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class Department extends Model
{
	protected $table = 'departments';

	protected $casts = [
		'status' => 'bool'
	];

	protected $fillable = [
		'department_name',
		'department_code',
		'status'
	];
}
