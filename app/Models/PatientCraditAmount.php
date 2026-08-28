<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class PatientCraditAmount
 * 
 * @property int $id
 * @property int $patient_id
 * @property int|null $billing_id
 * @property Carbon|null $date
 * @property float $amount
 * @property string $type
 * @property string|null $remarks
 * @property int|null $use_bill_id
 * @property int|null $generated_by
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class PatientCraditAmount extends Model
{
	protected $table = 'patient_cradit_amounts';

	protected $casts = [
		'patient_id' => 'int',
		'billing_id' => 'int',
		'date' => 'datetime',
		'amount' => 'float',
		'use_bill_id' => 'int',
		'generated_by' => 'int'
	];

	protected $fillable = [
		'patient_id',
		'billing_id',
		'date',
		'amount',
		'type',
		'remarks',
		'use_bill_id',
		'generated_by'
	];
}
