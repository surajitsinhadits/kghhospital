<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class IvfSpermCollection
 * 
 * @property int $id
 * @property int $ivf_cycle_id
 * @property string $source
 * @property string $mode
 * @property Carbon|null $collection_time
 * @property float|null $volume
 * @property float|null $motility
 * @property float|null $morphology
 * @property string|null $processing_method
 * @property float|null $casa_score
 * @property string|null $ai_icsi_recommendation
 * @property string|null $notes
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @package App\Models
 */
class IvfSpermCollection extends Model
{
	protected $table = 'ivf_sperm_collections';

	protected $casts = [
		'ivf_cycle_id' => 'int',
		'collection_time' => 'datetime',
		'volume' => 'float',
		'motility' => 'float',
		'morphology' => 'float',
		'casa_score' => 'float'
	];

	protected $fillable = [
		'ivf_cycle_id',
		'source',
		'mode',
		'collection_time',
		'volume',
		'motility',
		'morphology',
		'processing_method',
		'casa_score',
		'ai_icsi_recommendation',
		'notes'
	];
}
