<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class MedBilling
 * 
 * @property int $id
 * @property Carbon|null $bill_date
 * @property int|null $external_patient_id
 * @property int|null $internal_patient_id
 * @property int|null $doctor_id
 * @property float $sub_total
 * @property float $discount_amount
 * @property float $discount
 * @property string|null $discount_type
 * @property string|null $discount_status
 * @property float $total_payment
 * @property float $due_amount
 * @property int $credit_amount
 * @property float $refund_amount
 * @property float $grand_total
 * @property string|null $status
 * @property int $created_by
 * @property int|null $refund_by
 * @property Carbon|null $refund_at
 * @property int|null $edit_by
 * @property Carbon|null $edit_at
 * @property int $edit_status
 * @property string|null $bill_status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class MedBilling extends Model
{
	protected $table = 'med_billings';

	protected $casts = [
		'bill_date' => 'datetime',
		'external_patient_id' => 'int',
		'internal_patient_id' => 'int',
		'doctor_id' => 'int',
		'sub_total' => 'float',
		'discount_amount' => 'float',
		'discount' => 'float',
		'total_payment' => 'float',
		'due_amount' => 'float',
		'credit_amount' => 'int',
		'refund_amount' => 'float',
		'grand_total' => 'float',
		'created_by' => 'int',
		'refund_by' => 'int',
		'refund_at' => 'datetime',
		'edit_by' => 'int',
		'edit_at' => 'datetime',
		'edit_status' => 'int'
	];

	protected $fillable = [
		'bill_date',
		'external_patient_id',
		'internal_patient_id',
		'doctor_id',
		'sub_total',
		'discount_amount',
		'discount',
		'discount_type',
		'discount_status',
		'total_payment',
		'due_amount',
		'credit_amount',
		'refund_amount',
		'grand_total',
		'status',
		'created_by',
		'refund_by',
		'refund_at',
		'edit_by',
		'edit_at',
		'edit_status',
		'bill_status'
	];
}
