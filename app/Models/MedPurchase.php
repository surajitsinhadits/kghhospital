<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class MedPurchase
 * 
 * @property int $id
 * @property string|null $purchase_order_id
 * @property string|null $prefix
 * @property string|null $stock_room_id
 * @property string|null $date
 * @property string|null $vendor
 * @property string|null $total
 * @property string|null $discount_amount
 * @property string|null $discount_type
 * @property string|null $sub_total
 * @property string|null $note
 * @property string|null $feedback
 * @property string|null $delivery_date
 * @property string|null $status
 * @property string|null $grm_status
 * @property string|null $total_igst_amount
 * @property string|null $total_sgst_amount
 * @property string|null $total_cgst_amount
 * @property string|null $generated_by
 * @property string|null $purpose
 * @property string|null $payment_terms
 * @property string|null $invoice_no
 * @property string|null $stock_update_by
 * @property string|null $is_updated_in_stock
 * @property string|null $is_delete
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class MedPurchase extends Model
{
	protected $table = 'med_purchases';

	protected $fillable = [
		'purchase_order_id',
		'prefix',
		'stock_room_id',
		'date',
		'vendor',
		'total',
		'discount_amount',
		'discount_type',
		'sub_total',
		'note',
		'feedback',
		'delivery_date',
		'status',
		'grm_status',
		'total_igst_amount',
		'total_sgst_amount',
		'total_cgst_amount',
		'generated_by',
		'purpose',
		'payment_terms',
		'invoice_no',
		'stock_update_by',
		'is_updated_in_stock',
		'is_delete'
	];
}
