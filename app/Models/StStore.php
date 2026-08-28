<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class StStore
 * 
 * @property int $id
 * @property string|null $store_name
 * @property bool $status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class StStore extends Model
{
	protected $table = 'st_stores';

	protected $casts = [
		'status' => 'bool'
	];

	protected $fillable = [
		'store_name',
		'status'
	];
}
