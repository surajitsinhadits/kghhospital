<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class MedPurchaseDetail
 * 
 * @property int $id
 * @property string|null $purchase_id
 * @property string|null $purchase_order_details_id
 * @property string|null $item_id
 * @property string|null $free_qty
 * @property string|null $unit_qty
 * @property string|null $unit
 * @property string|null $sub_unit_qty
 * @property string|null $sub_unit
 * @property string|null $expiry_date
 * @property string|null $batch_no
 * @property string|null $rate
 * @property string|null $mrp
 * @property string|null $net_amount
 * @property string|null $discount_amount
 * @property string|null $discount_per
 * @property string|null $cgst
 * @property string|null $sgst
 * @property string|null $igst
 * @property string|null $cgst_amount
 * @property string|null $sgst_amount
 * @property string|null $igst_amount
 * @property string|null $amount
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class MedPurchaseDetail extends Model
{
	protected $table = 'med_purchase_details';

	protected $fillable = [
		'purchase_id',
		'purchase_order_details_id',
		'item_id',
		'free_qty',
		'unit_qty',
		'unit',
		'sub_unit_qty',
		'sub_unit',
		'expiry_date',
		'batch_no',
		'rate',
		'mrp',
		'net_amount',
		'discount_amount',
		'discount_per',
		'cgst',
		'sgst',
		'igst',
		'cgst_amount',
		'sgst_amount',
		'igst_amount',
		'amount'
	];
}
