<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class VcPurchaseDetail
 * 
 * @property int $id
 * @property int|null $purchase_id
 * @property int|null $vaccine_id
 * @property int|null $unit_qty
 * @property string|null $unit
 * @property int|null $sub_unit_qty
 * @property string|null $sub_unit
 * @property string|null $batch_number
 * @property Carbon|null $exp_date
 * @property float|null $s_rate
 * @property float|null $p_rate
 * @property float|null $net_amount
 * @property float|null $discount_percentage
 * @property float|null $discount_amount
 * @property float|null $cgst
 * @property float|null $sgst
 * @property float|null $igst
 * @property float|null $cgst_amount
 * @property float|null $sgst_amount
 * @property float|null $igst_amount
 * @property float|null $amount
 * @property int|null $is_delete
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class VcPurchaseDetail extends Model
{
	protected $table = 'vc_purchase_details';

	protected $casts = [
		'purchase_id' => 'int',
		'vaccine_id' => 'int',
		'unit_qty' => 'int',
		'sub_unit_qty' => 'int',
		'exp_date' => 'datetime',
		's_rate' => 'float',
		'p_rate' => 'float',
		'net_amount' => 'float',
		'discount_percentage' => 'float',
		'discount_amount' => 'float',
		'cgst' => 'float',
		'sgst' => 'float',
		'igst' => 'float',
		'cgst_amount' => 'float',
		'sgst_amount' => 'float',
		'igst_amount' => 'float',
		'amount' => 'float',
		'is_delete' => 'int'
	];

	protected $fillable = [
		'purchase_id',
		'vaccine_id',
		'unit_qty',
		'unit',
		'sub_unit_qty',
		'sub_unit',
		'batch_number',
		'exp_date',
		's_rate',
		'p_rate',
		'net_amount',
		'discount_percentage',
		'discount_amount',
		'cgst',
		'sgst',
		'igst',
		'cgst_amount',
		'sgst_amount',
		'igst_amount',
		'amount',
		'is_delete'
	];
}
