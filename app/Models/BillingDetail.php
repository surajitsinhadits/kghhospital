<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class BillingDetail
 * 
 * @property int $id
 * @property int $billing_id
 * @property int|null $charge_category_id
 * @property int|null $charge_sub_category_id
 * @property Carbon|null $date
 * @property int|null $charge_id
 * @property string $charge_name
 * @property int|null $doctor_id
 * @property float $standard_charges
 * @property float $commision_amount
 * @property float $discount_percentage
 * @property float $discount_amount
 * @property int $qty
 * @property float $amount
 * @property int $is_delete
 * @property bool $is_original
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class BillingDetail extends Model
{
	protected $table = 'billing_details';

	protected $casts = [
		'billing_id' => 'int',
		'charge_category_id' => 'int',
		'charge_sub_category_id' => 'int',
		'date' => 'datetime',
		'charge_id' => 'int',
		'doctor_id' => 'int',
		'standard_charges' => 'float',
		'commision_amount' => 'float',
		'discount_percentage' => 'float',
		'discount_amount' => 'float',
		'qty' => 'int',
		'amount' => 'float',
		'is_delete' => 'int',
		'is_original' => 'bool'
	];

	protected $fillable = [
		'billing_id',
		'charge_category_id',
		'charge_sub_category_id',
		'date',
		'charge_id',
		'charge_name',
		'doctor_id',
		'standard_charges',
		'commision_amount',
		'discount_percentage',
		'discount_amount',
		'qty',
		'amount',
		'is_delete',
		'is_original'
	];
}
