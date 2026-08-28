<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class StVendor
 * 
 * @property int $id
 * @property string|null $vendor_name
 * @property string|null $email
 * @property string|null $phone
 * @property string|null $pin_code
 * @property string|null $gstin
 * @property string|null $short_name
 * @property string|null $pan_number
 * @property string|null $gst_registration_type
 * @property string|null $state
 * @property string|null $place_of_supply
 * @property bool|null $tds_applicable
 * @property string|null $tds_deductee_type
 * @property string|null $tds_nature_of_payment
 * @property bool|null $is_lower_deduction
 * @property float|null $lower_deduction_rate
 * @property string|null $lower_deduction_cert_no
 * @property string|null $contact_person_name
 * @property string|null $address
 * @property string|null $address_line_2
 * @property float|null $opening_balance
 * @property float|null $credit_limit
 * @property int|null $credit_days
 * @property bool|null $maintain_bill_wise
 * @property bool|null $is_active
 * @property bool|null $is_delete
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class StVendor extends Model
{
	protected $table = 'st_vendors';

	protected $casts = [
		'tds_applicable' => 'bool',
		'is_lower_deduction' => 'bool',
		'lower_deduction_rate' => 'decimal:2',
		'opening_balance' => 'decimal:2',
		'credit_limit' => 'decimal:2',
		'credit_days' => 'int',
		'maintain_bill_wise' => 'bool',
		'is_active' => 'bool',
		'is_delete' => 'bool'
	];

	protected $fillable = [
		'email',
		'password',
		'vendor_name',
		'short_name',
		'phone',
		'state',
		'pin_code',
		'gstin',
		'pan_number',
		'gst_registration_type',
		'place_of_supply',
		'tds_applicable',
		'tds_deductee_type',
		'tds_nature_of_payment',
		'is_lower_deduction',
		'lower_deduction_rate',
		'lower_deduction_cert_no',
		'contact_person_name',
		'address',
		'address_line_2',
		'opening_balance',
		'credit_limit',
		'credit_days',
		'maintain_bill_wise',
		'is_active',
		'is_delete'
	];
}
