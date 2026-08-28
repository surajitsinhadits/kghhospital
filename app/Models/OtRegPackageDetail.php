<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class OtRegPackageDetail
 * 
 * @property int $id
 * @property int $ot_reg_id
 * @property string|null $ot_package_id
 * @property string|null $charge_id
 * @property string|null $charge_name
 * @property string|null $rate
 * @property int $status
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @package App\Models
 */
class OtRegPackageDetail extends Model
{
	protected $table = 'ot_reg_package_details';

	protected $casts = [
		'ot_reg_id' => 'int',
		'status' => 'int'
	];

	protected $fillable = [
		'ot_reg_id',
		'ot_package_id',
		'charge_id',
		'charge_name',
		'rate',
		'status'
	];
}
