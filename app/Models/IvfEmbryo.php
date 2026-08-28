<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class IvfEmbryo
 * 
 * @property int $id
 * @property int $fertilization_id
 * @property int $day
 * @property string $grade
 * @property float|null $blastocyst_score
 * @property array|null $ai_grading_json
 * @property string|null $time_lapse_url
 * @property string $status
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @package App\Models
 */
class IvfEmbryo extends Model
{
	protected $table = 'ivf_embryos';

	protected $casts = [
		'fertilization_id' => 'int',
		'day' => 'int',
		'blastocyst_score' => 'float',
		'ai_grading_json' => 'json'
	];

	protected $fillable = [
		'fertilization_id',
		'day',
		'grade',
		'blastocyst_score',
		'ai_grading_json',
		'time_lapse_url',
		'status'
	];
}
