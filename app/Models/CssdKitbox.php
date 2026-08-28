<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class CssdKitbox
 * 
 * @property int $id
 * @property string $box_id
 * @property string|null $name
 * @property string|null $description
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string $status
 *
 * @package App\Models
 */
class CssdKitbox extends Model
{
	protected $table = 'cssd_kitboxes';

	protected $fillable = [
		'box_id',
		'prefix',
		'counter',
		'category',
		'name',
		'description',
		'status'
	];
}
