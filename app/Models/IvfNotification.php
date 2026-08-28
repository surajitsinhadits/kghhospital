<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class IvfNotification
 * 
 * @property int $id
 * @property int $recipient_id
 * @property string|null $title
 * @property string|null $message
 * @property string $type
 * @property Carbon|null $sent_at
 * @property string|null $status
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @package App\Models
 */
class IvfNotification extends Model
{
	protected $table = 'ivf_notifications';

	protected $casts = [
		'recipient_id' => 'int',
		'sent_at' => 'datetime'
	];

	protected $fillable = [
		'recipient_id',
		'title',
		'message',
		'type',
		'sent_at',
		'status'
	];
}
