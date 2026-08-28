<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class BlLabScreening
 * 
 * @property int $id
 * @property string $bag_barcode
 * @property string $blood_group
 * @property string|null $nat_result
 * @property string|null $elisa_result
 * @property string|null $hiv_result
 * @property string|null $hbsag_result
 * @property string|null $hcv_result
 * @property string|null $syphilis_result
 * @property string|null $malaria_result
 * @property string|null $crossmatch_result
 * @property string|null $qc_checks_log
 * @property bool|null $quarantine_flag
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class BlLabScreening extends Model
{
	protected $table = 'bl_lab_screenings';

	protected $casts = [
		'quarantine_flag' => 'bool'
	];

	protected $fillable = [
		'bag_barcode',
		'blood_group',
		'nat_result',
		'elisa_result',
		'hiv_result',
		'hbsag_result',
		'hcv_result',
		'syphilis_result',
		'malaria_result',
		'crossmatch_result',
		'qc_checks_log',
		'quarantine_flag'
	];
}
