<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Ward
 * 
 * @property int $id
 * @property string $ward_name
 * @property int|null $status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class Ward extends Model
{
	protected $table = 'wards';

	protected $casts = [
		'status' => 'int'
	];

	protected $fillable = [
		'ward_name',
		'status'
	];
}
