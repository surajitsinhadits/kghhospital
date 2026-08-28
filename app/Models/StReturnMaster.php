<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class StReturnMaster
 * 
 * @property int $id
 * @property int $dept_id
 * @property Carbon $return_date
 * @property string|null $remarks
 * @property int $status
 * @property int $return_by
 * @property int|null $edit_by
 * @property Carbon|null $edit_at
 * @property int $is_delete
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @package App\Models
 */
class StReturnMaster extends Model
{
	protected $table = 'st_return_masters';

	protected $casts = [
		'dept_id' => 'int',
		'return_date' => 'datetime',
		'status' => 'int',
		'return_by' => 'int',
		'edit_by' => 'int',
		'edit_at' => 'datetime',
		'is_delete' => 'int'
	];

	protected $fillable = [
		'dept_id',
		'return_date',
		'remarks',
		'status',
		'return_by',
		'edit_by',
		'edit_at',
		'is_delete'
	];
}
