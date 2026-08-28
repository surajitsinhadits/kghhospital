<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Notice
 * 
 * @property int $id
 * @property string $notice
 * @property string $priority_level
 * @property int $post_by
 * @property int|null $is_active
 * @property int|null $is_delete
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class Notice extends Model
{
	protected $table = 'notices';

	protected $casts = [
		'post_by' => 'int',
		'is_active' => 'int',
		'is_delete' => 'int'
	];

	protected $fillable = [
		'notice',
		'priority_level',
		'post_by',
		'is_active',
		'is_delete'
	];
}
