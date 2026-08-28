<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class OtPackageDetail
 * 
 * @property int $id
 * @property int $package_id
 * @property int|null $charge_id
 * @property float|null $rate
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class OtPackageDetail extends Model
{
	protected $table = 'ot_package_details';

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
