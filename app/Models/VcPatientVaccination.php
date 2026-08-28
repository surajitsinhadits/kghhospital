<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class VcPatientVaccination
 * 
 * @property int $id
 * @property int $patient_id
 * @property int $vaccine_id
 * @property int|null $vaccine_lot_id
 * @property Carbon $scheduled_date
 * @property Carbon|null $administered_date
 * @property string|null $administered_by
 * @property string|null $notes
 * @property string|null $batch_no
 * @property float $amount
 * @property string $status
 * @property int|null $created_by
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @package App\Models
 */
class VcPatientVaccination extends Model
{
	protected $table = 'vc_patient_vaccinations';

	protected $casts = [
		'patient_id' => 'int',
		'vaccine_id' => 'int',
		'vaccine_lot_id' => 'int',
		'scheduled_date' => 'datetime',
		'administered_date' => 'datetime',
		'amount' => 'float',
		'created_by' => 'int'
	];

	protected $fillable = [
		'patient_id',
		'vaccine_id',
		'vaccine_lot_id',
		'scheduled_date',
		'administered_date',
		'administered_by',
		'notes',
		'batch_no',
		'amount',
		'status',
		'created_by'
	];
}
