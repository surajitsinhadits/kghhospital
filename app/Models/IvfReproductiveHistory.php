<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class IvfReproductiveHistory
 * 
 * @property int $id
 * @property int|null $patient_id
 * @property array|null $history_json
 * @property int|null $art_attempts
 * @property Carbon|null $last_attempt_date
 * @property string|null $notes
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @package App\Models
 */
class IvfReproductiveHistory extends Model
{
	protected $table = 'ivf_reproductive_histories';

	protected $casts = [
		'patient_id' => 'int',
		'history_json' => 'json',
		'art_attempts' => 'int',
		'last_attempt_date' => 'datetime'
	];

	protected $fillable = [
		'patient_id',
		'history_json',
		'art_attempts',
		'last_attempt_date',
		'notes'
	];
}
