<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class IvfCryopreservation
 * 
 * @property int $id
 * @property int $embryo_id
 * @property string $type
 * @property string $method
 * @property string $cryovial_code
 * @property string|null $tank_number
 * @property string|null $rack_position
 * @property int|null $freezing_consent_id
 * @property float|null $predicted_viability
 * @property Carbon|null $expiry_alert_date
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @package App\Models
 */
class IvfCryopreservation extends Model
{
	protected $table = 'ivf_cryopreservations';

	protected $casts = [
		'embryo_id' => 'int',
		'freezing_consent_id' => 'int',
		'predicted_viability' => 'float',
		'expiry_alert_date' => 'datetime'
	];

	protected $fillable = [
		'embryo_id',
		'type',
		'method',
		'cryovial_code',
		'tank_number',
		'rack_position',
		'freezing_consent_id',
		'predicted_viability',
		'expiry_alert_date'
	];
}
