<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class IvfSurrogate
 * 
 * @property int $id
 * @property int $patient_id
 * @property string $contract_number
 * @property string|null $legal_documents_path
 * @property int|null $linked_ivf_cycle
 * @property string|null $antenatal_logs
 * @property string|null $compensation_installments
 * @property string|null $guardian_info
 * @property string|null $delivery_plan_notes
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @package App\Models
 */
class IvfSurrogate extends Model
{
	protected $table = 'ivf_surrogates';

	protected $casts = [
		'patient_id' => 'int',
		'linked_ivf_cycle' => 'int'
	];

	protected $fillable = [
		'patient_id',
		'contract_number',
		'legal_documents_path',
		'linked_ivf_cycle',
		'antenatal_logs',
		'compensation_installments',
		'guardian_info',
		'delivery_plan_notes'
	];
}
