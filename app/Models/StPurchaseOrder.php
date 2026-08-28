<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class StPurchaseOrder
 *
 * @property int $id
 * @property Carbon|null $po_date
 * @property int|null $vendor_id
 * @property string|null $note
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
class StPurchaseOrder extends Model
{
	protected $table = 'st_purchase_orders';

	protected $casts = [
		'po_date' => 'datetime',
		'vendor_id' => 'int',
		'edit_by' => 'int',
		'edit_at' => 'datetime',
		'status' => 'int',
		'is_delete' => 'int'
	];

	protected $fillable = [
		'po_date',
		'vendor_id',
		'note',
		'generated_by',
		'edit_by',
		'edit_at',
		'status',
		'is_delete'
	];
}
