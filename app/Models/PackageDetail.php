<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class PackageDetail
 * 
 * @property int $id
 * @property int $package_id
 * @property int $charge_id
 * @property float|null $rate
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class PackageDetail extends Model
{
	protected $table = 'package_details';

	protected $casts = [
		'package_id' => 'int',
		'charge_id' => 'int',
		'rate' => 'float'
	];

	protected $fillable = [
		'package_id',
		'charge_id',
		'rate'
	];
}
