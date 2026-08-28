<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class VcVaccine
 * 
 * @property int $id
 * @property string $vaccine_name
 * @property string|null $brand_name
 * @property string|null $manufacturer
 * @property string|null $age_group
 * @property string|null $storage_temp
 * @property int $no_of_doses
 * @property string|null $interval_days
 * @property string|null $injection_site
 * @property string $route
 * @property string|null $disease_prevented
 * @property string|null $drawbacks
 * @property string|null $remarks
 * @property string|null $unit
 * @property string|null $sub_unit
 * @property string|null $unit_subunit_relation
 * @property int $status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class VcVaccine extends Model
{
	protected $table = 'vc_vaccines';

	protected $casts = [
		'no_of_doses' => 'int',
		'status' => 'int'
	];

	protected $fillable = [
		'vaccine_name',
		'brand_name',
		'manufacturer',
		'age_group',
		'storage_temp',
		'no_of_doses',
		'interval_days',
		'injection_site',
		'route',
		'disease_prevented',
		'drawbacks',
		'remarks',
		'unit',
		'sub_unit',
		'unit_subunit_relation',
		'status'
	];
}
