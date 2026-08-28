<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class StItemType
 * 
 * @property int $id
 * @property string|null $type_name
 * @property bool|null $status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class StItemType extends Model
{
	protected $table = 'st_item_types';

	protected $casts = [
		'status' => 'bool'
	];

	protected $fillable = [
		'type_name',
		'status'
	];
}
