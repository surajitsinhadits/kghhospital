<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class IvfStimulationProtocol
 * 
 * @property int $id
 * @property int $ivf_cycle_id
 * @property string $protocol_type
 * @property string|null $gonadotropin_type
 * @property float|null $ai_suggested_dose
 * @property float|null $actual_dose
 * @property string|null $luteal_support_strategy
 * @property int|null $prescribed_by
 * @property int|null $drug_kit_code
 * @property Carbon|null $start_date
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @package App\Models
 */
class IvfStimulationProtocol extends Model
{
	protected $table = 'ivf_stimulation_protocols';

	protected $casts = [
		'ivf_cycle_id' => 'int',
		'ai_suggested_dose' => 'float',
		'actual_dose' => 'float',
		'prescribed_by' => 'int',
		'drug_kit_code' => 'int',
		'start_date' => 'datetime'
	];

	protected $fillable = [
		'ivf_cycle_id',
		'protocol_type',
		'gonadotropin_type',
		'ai_suggested_dose',
		'actual_dose',
		'luteal_support_strategy',
		'prescribed_by',
		'drug_kit_code',
		'start_date'
	];
}
