<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class CssdKitboxStatusHistory
 * 
 * @property int $id
 * @property int $kitbox_id
 * @property string|null $old_status
 * @property string $new_status
 * @property int|null $changed_by
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class CssdKitboxStatusHistory extends Model
{
	protected $table = 'cssd_kitbox_status_histories';

	protected $casts = [
		'kitbox_id' => 'int',
		'changed_by' => 'int'
	];

	protected $fillable = [
		'kitbox_id',		
		'status',
		'changed_by'
	];
}
