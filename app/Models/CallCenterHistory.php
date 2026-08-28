<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class CallCenterHistory
 * 
 * @property int $id
 * @property int $cc_id
 * @property Carbon $call_at
 * @property int $call_by
 * @property string|null $remarks
 * @property int $action
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class CallCenterHistory extends Model
{
	protected $table = 'call_center_history';

	protected $casts = [
		'cc_id' => 'int',
		'call_at' => 'datetime',
		'call_by' => 'int',
		'action' => 'int'
	];

	protected $fillable = [
		'cc_id',
		'call_at',
		'call_by',
		'remarks',
		'action'
	];
}
