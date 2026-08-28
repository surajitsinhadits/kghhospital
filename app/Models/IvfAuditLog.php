<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class IvfAuditLog
 * 
 * @property int $id
 * @property string $action_type
 * @property string $entity_name
 * @property int $entity_id
 * @property int|null $user_id
 * @property string|null $before_state
 * @property string|null $after_state
 * @property Carbon|null $timestamp
 * @property string|null $ip_address
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @package App\Models
 */
class IvfAuditLog extends Model
{
	protected $table = 'ivf_audit_logs';

	protected $casts = [
		'entity_id' => 'int',
		'user_id' => 'int',
		'timestamp' => 'datetime'
	];

	protected $fillable = [
		'action_type',
		'entity_name',
		'entity_id',
		'user_id',
		'before_state',
		'after_state',
		'timestamp',
		'ip_address'
	];
}
