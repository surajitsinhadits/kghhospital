<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class IvfMonitoringLog
 * 
 * @property int $id
 * @property int $ivf_cycle_id
 * @property Carbon $date
 * @property int|null $left_follicle_count
 * @property int|null $right_follicle_count
 * @property float|null $largest_follicle_mm
 * @property float|null $estradiol
 * @property float|null $lh
 * @property float|null $progesterone
 * @property string|null $usg_file_path
 * @property bool|null $injection_given
 * @property string|null $dose_adjustment_notes
 * @property float|null $ai_ohss_prediction
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @package App\Models
 */
class IvfMonitoringLog extends Model
{
	protected $table = 'ivf_monitoring_logs';

	protected $casts = [
		'ivf_cycle_id' => 'int',
		'date' => 'datetime',
		'left_follicle_count' => 'int',
		'right_follicle_count' => 'int',
		'largest_follicle_mm' => 'float',
		'estradiol' => 'float',
		'lh' => 'float',
		'progesterone' => 'float',
		'injection_given' => 'bool',
		'ai_ohss_prediction' => 'float'
	];

	protected $fillable = [
		'ivf_cycle_id',
		'date',
		'left_follicle_count',
		'right_follicle_count',
		'largest_follicle_mm',
		'estradiol',
		'lh',
		'progesterone',
		'usg_file_path',
		'injection_given',
		'dose_adjustment_notes',
		'ai_ohss_prediction'
	];
}
