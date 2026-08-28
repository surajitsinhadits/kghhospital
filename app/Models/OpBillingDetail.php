<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class OpBillingDetail
 * 
 * @property int $id
 * @property int $billing_id
 * @property Carbon|null $date
 * @property int|null $item_id
 * @property string $item_name
 * @property float $standard_charges
 * @property float $discount_percentage
 * @property float $discount_amount
 * @property int $qty
 * @property float $amount
 * @property int $is_delete
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class OpBillingDetail extends Model
{
	protected $table = 'op_billing_details';

	protected $casts = [
		'billing_id' => 'int',
		'date' => 'datetime',
		'item_id' => 'int',
		'standard_charges' => 'float',
		'discount_percentage' => 'float',
		'discount_amount' => 'float',
		'qty' => 'int',
		'amount' => 'float',
		'is_delete' => 'int'
	];

	protected $fillable = [
		'billing_id',
		'date',
		'item_id',
		'item_name',
		'standard_charges',
		'discount_percentage',
		'discount_amount',
		'qty',
		'amount',
		'is_delete'
	];
}
