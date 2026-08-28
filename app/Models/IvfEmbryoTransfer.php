<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class IvfEmbryoTransfer
 * 
 * @property int $id
 * @property int $ivf_cycle_id
 * @property string $transfer_type
 * @property int $number_transferred
 * @property string $embryo_ids
 * @property float|null $endometrial_thickness
 * @property float|null $ai_receptivity_score
 * @property string|null $transfer_difficulty
 * @property int|null $doctor_id
 * @property string|null $progesterone_plan
 * @property Carbon|null $beta_hcg_date
 * @property string|null $pregnancy_result
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @package App\Models
 */
class IvfEmbryoTransfer extends Model
{
	protected $table = 'ivf_embryo_transfers';

	protected $casts = [
		'ivf_cycle_id' => 'int',
		'number_transferred' => 'int',
		'endometrial_thickness' => 'float',
		'ai_receptivity_score' => 'float',
		'doctor_id' => 'int',
		'beta_hcg_date' => 'datetime'
	];

	protected $fillable = [
		'ivf_cycle_id',
		'transfer_type',
		'number_transferred',
		'embryo_ids',
		'endometrial_thickness',
		'ai_receptivity_score',
		'transfer_difficulty',
		'doctor_id',
		'progesterone_plan',
		'beta_hcg_date',
		'pregnancy_result'
	];
}
