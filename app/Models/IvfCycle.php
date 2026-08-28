<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class IvfCycle
 * 
 * @property int $id
 * @property int|null $couple_id
 * @property int|null $cycle_number
 * @property string|null $cycle_type
 * @property string|null $status
 * @property Carbon|null $start_date
 * @property Carbon|null $end_date
 * @property float|null $ai_ohss_risk_score
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @package App\Models
 */
class IvfCycle extends Model
{
	protected $table = 'ivf_cycles';

	protected $casts = [
		'couple_id' => 'int',
		'cycle_number' => 'int',
		'start_date' => 'datetime',
		'end_date' => 'datetime',
		'ai_ohss_risk_score' => 'float'
	];

	protected $fillable = [
		'couple_id',
		'cycle_number',
		'cycle_type',
		'status',
		'start_date',
		'end_date',
		'ai_ohss_risk_score'
	];
}
