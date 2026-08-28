<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Package
 * 
 * @property int $id
 * @property string $package_name
 * @property float|null $package_amount
 * @property int|null $status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class Package extends Model
{
	protected $table = 'packages';

	protected $casts = [
		'package_amount' => 'float',
		'status' => 'int'
	];

	protected $fillable = [
		'package_name',
		'package_amount',
		'status'
	];
}
