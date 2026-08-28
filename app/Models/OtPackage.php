<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class OtPackage
 * 
 * @property int $id
 * @property string $package_name
 * @property string|null $type
 * @property string|null $duration
 * @property float|null $package_amount
 * @property int|null $status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class OtPackage extends Model
{
	protected $table = 'ot_packages';

	protected $casts = [
		'package_amount' => 'float',
		'status' => 'int'
	];

	protected $fillable = [
		'package_name',
		'type',
		'duration',
		'package_amount',
		'status'
	];
}
