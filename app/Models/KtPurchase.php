<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class KtPurchase
 * 
 * @property int $id
 * @property int|null $po_id
 * @property Carbon|null $date
 * @property int|null $vendor_id
 * @property string|null $invoice_no
 * @property float|null $total
 * @property float|null $sub_total
 * @property float|null $total_gst_amount
 * @property string|null $note
 * @property float|null $discount_amount
 * @property float $discount_value
 * @property string|null $discount_type
 * @property string|null $payment_terms
 * @property string|null $generated_by
 * @property int|null $edit_by
 * @property Carbon|null $edit_at
 * @property int $is_stock
 * @property int|null $is_delete
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class KtPurchase extends Model
{
	protected $table = 'kt_purchases';

	protected $casts = [
		'po_id' => 'int',
		'date' => 'datetime',
		'vendor_id' => 'int',
		'total' => 'float',
		'sub_total' => 'float',
		'total_gst_amount' => 'float',
		'discount_amount' => 'float',
		'discount_value' => 'float',
		'edit_by' => 'int',
		'edit_at' => 'datetime',
		'is_stock' => 'int',
		'is_delete' => 'int'
	];

	protected $fillable = [
		'po_id',
		'date',
		'vendor_id',
		'invoice_no',
		'total',
		'sub_total',
		'total_gst_amount',
		'note',
		'discount_amount',
		'discount_value',
		'discount_type',
		'payment_terms',
		'generated_by',
		'edit_by',
		'edit_at',
		'is_stock',
		'is_delete'
	];
}
