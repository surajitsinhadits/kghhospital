<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Payment
 * 
 * @property int $id
 * @property int $billing_id
 * @property int $patient_id
 * @property string $section
 * @property float $payment_amount
 * @property string|null $payment_mode
 * @property string|null $payment_bank
 * @property int $payment_recived_by
 * @property Carbon $payment_date
 * @property string|null $note
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class Payment extends Model
{
	protected $table = 'payments';

	protected $casts = [
		'billing_id' => 'int',
		'patient_id' => 'int',
		'payment_amount' => 'float',
		'payment_recived_by' => 'int',
		'payment_date' => 'datetime'
	];

	protected $fillable = [
		'billing_id',
		'patient_id',
		'section',
		'payment_amount',
		'payment_mode',
		'payment_bank',
		'payment_recived_by',
		'payment_date',
		'note'
	];
}
