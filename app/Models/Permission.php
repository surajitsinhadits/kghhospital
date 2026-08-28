<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Permission
 * 
 * @property int $id
 * @property string $permissions
 * @property int|null $parent_id
 * @property string|null $guard_name
 *
 * @package App\Models
 */
class Permission extends Model
{
	protected $table = 'permissions';
	public $timestamps = false;

	protected $casts = [
		'parent_id' => 'int'
	];

	protected $fillable = [
		'permissions',
		'parent_id',
		'guard_name'
	];
}
