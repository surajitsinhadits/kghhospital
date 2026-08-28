<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class PatientAdvanceAmount
 * 
 * @property int $id
 * @property int $patient_id
 * @property int|null $section_id
 * @property float $amount
 * @property float $use_amount
 * @property float $def_amount
 * @property string|null $use_bill_id
 * @property int $generated_by
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class PatientAdvanceAmount extends Model
{
	protected $table = 'patient_advance_amounts';

	protected $casts = [
		'patient_id' => 'int',
		'section_id' => 'int',
		'amount' => 'float',
		'use_amount' => 'float',
		'def_amount' => 'float',
		'generated_by' => 'int'
	];

	protected $fillable = [
		'patient_id',
		'section_id',
		'amount',
		'use_amount',
		'def_amount',
		'use_bill_id',
		'generated_by'
	];
}
