<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ChargeCommission
 *
 * @property int $id
 * @property int $bill_id
 * @property int $patient_id
 * @property int $charge_id
 * @property int|null $referred_by
 * @property int|null $market_by
 * @property int|null $provider
 * @property float|null $charge_amount
 * @property float|null $discount_amount
 * @property int $created_by
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @package App\Models
 */
class ChargeCommission extends Model
{
	protected $table = 'charge_commission';

	protected $casts = [
		'charge_id' => 'int',
		'charge_amount' => 'float',
		'discount_amount' => 'float'
	];

	protected $fillable = [
		'charge_id',
		'charge_amount',
		'discount_amount'
	];
}
