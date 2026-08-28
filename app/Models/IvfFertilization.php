<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class IvfFertilization
 * 
 * @property int $id
 * @property int $ivf_cycle_id
 * @property string $method
 * @property int|null $oocytes_inseminated
 * @property int|null $fertilized_count
 * @property string|null $culture_medium
 * @property string|null $culture_notes
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @package App\Models
 */
class IvfFertilization extends Model
{
	protected $table = 'ivf_fertilizations';

	protected $casts = [
		'ivf_cycle_id' => 'int',
		'oocytes_inseminated' => 'int',
		'fertilized_count' => 'int'
	];

	protected $fillable = [
		'ivf_cycle_id',
		'method',
		'oocytes_inseminated',
		'fertilized_count',
		'culture_medium',
		'culture_notes'
	];
}
