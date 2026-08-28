<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class OpPurchase
 * 
 * @property int $id
 * @property Carbon|null $date
 * @property int|null $vendor_id
 * @property string|null $invoice_no
 * @property int|null $po_id
 * @property float|null $total
 * @property float|null $sub_total
 * @property float|null $total_sgst_amount
 * @property float|null $total_igst_amount
 * @property float|null $total_cgst_amount
 * @property string|null $note
 * @property float|null $discount_amount
 * @property string|null $discount_type
 * @property string|null $payment_terms
 * @property string|null $generated_by
 * @property int|null $edit_by
 * @property Carbon|null $edit_at
 * @property int|null $status
 * @property int|null $is_delete
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class OpPurchase extends Model
{
	protected $table = 'op_purchases';

	protected $casts = [
		'date' => 'datetime',
		'vendor_id' => 'int',
		'po_id' => 'int',
		'total' => 'float',
		'sub_total' => 'float',
		'total_sgst_amount' => 'float',
		'total_igst_amount' => 'float',
		'total_cgst_amount' => 'float',
		'discount_amount' => 'float',
		'edit_by' => 'int',
		'edit_at' => 'datetime',
		'status' => 'int',
		'is_delete' => 'int'
	];

	protected $fillable = [
		'date',
		'vendor_id',
		'invoice_no',
		'po_id',
		'total',
		'sub_total',
		'total_sgst_amount',
		'total_igst_amount',
		'total_cgst_amount',
		'note',
		'discount_amount',
		'discount_type',
		'payment_terms',
		'generated_by',
		'edit_by',
		'edit_at',
		'status',
		'is_delete'
	];
}
