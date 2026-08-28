<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Billing
 *
 * @property int $id
 * @property string $uid
 * @property string $section
 * @property int $section_id
 * @property Carbon|null $bill_date
 * @property int|null $patient_id
 * @property int|null $doctor_id
 * @property int|null $referred_by
 * @property int|null $market_by
 * @property int|null $provider
 * @property int|null $case_id
 * @property float|null $total
 * @property float $sub_total
 * @property float $miscellaneous_amount
 * @property float $miscellaneous
 * @property string|null $miscellaneous_type
 * @property float $discount_amount
 * @property float $discount
 * @property string|null $discount_type
 * @property string|null $discount_status
 * @property float $total_payment
 * @property float $due_amount
 * @property float $cradit_amount
 * @property float $refund_amount
 * @property string|null $cradituse_bill_id
 * @property string|null $cradituse_bill_amount
 * @property float $grand_total
 * @property string|null $status
 * @property string|null $finance_remark
 * @property string|null $department_party_remark
 * @property string|null $approval_remark
 * @property int $created_by
 * @property int|null $refund_by
 * @property Carbon|null $refund_at
 * @property int|null $edit_by
 * @property Carbon|null $edit_at
 * @property int $edit_status
 * @property int $bill_status
 * @property int $approved_by
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class Billing extends Model
{
	protected $table = 'billings';

	protected $casts = [
		'section_id' => 'int',
		'bill_date' => 'datetime',
		'patient_id' => 'int',
		'doctor_id' => 'int',
		'referred_by' => 'int',
		'market_by' => 'int',
		'provider' => 'int',
		'case_id' => 'int',
		'total' => 'float',
		'sub_total' => 'float',
		'miscellaneous_amount' => 'float',
		'miscellaneous' => 'float',
		'discount_amount' => 'float',
		'discount' => 'float',
		'total_payment' => 'float',
		'due_amount' => 'float',
		'cradit_amount' => 'float',
		'refund_amount' => 'float',
		'grand_total' => 'float',
		'created_by' => 'int',
		'refund_by' => 'int',
		'refund_at' => 'datetime',
		'edit_by' => 'int',
		'edit_at' => 'datetime',
		'edit_status' => 'int',
		'bill_status' => 'int',
		'approved_by' => 'int'
	];

	protected $fillable = [
		'uid',
		'section',
		'section_id',
		'bill_date',
		'patient_id',
		'doctor_id',
		'referred_by',
		'market_by',
		'provider',
		'case_id',
		'total',
		'sub_total',
		'miscellaneous_amount',
		'miscellaneous',
		'miscellaneous_type',
		'discount_amount',
		'discount',
		'discount_type',
		'discount_status',
		'total_payment',
		'due_amount',
		'cradit_amount',
		'refund_amount',
		'cradituse_bill_id',
		'cradituse_bill_amount',
		'grand_total',
		'status',
		'finance_remark',
		'department_party_remark',
		'approval_remark',
		'created_by',
		'refund_by',
		'refund_at',
		'edit_by',
		'edit_at',
		'edit_status',
		'bill_status',
		'approved_by',
	];
}
