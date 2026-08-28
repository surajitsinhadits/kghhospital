<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class MedExpiredOrBed
 * 
 * @property int $id
 * @property string|null $purchase_id
 * @property string|null $unit
 * @property string|null $medicine
 * @property string|null $batch_no
 * @property Carbon|null $exp_date
 * @property string|null $qty
 * @property string|null $mrp
 * @property string|null $discount
 * @property string|null $discount_per
 * @property string|null $p_rate
 * @property string|null $s_rate
 * @property string|null $cgst
 * @property string|null $cgst_value
 * @property string|null $sgst
 * @property string|null $sgst_value
 * @property string|null $igst
 * @property string|null $igst_value
 * @property string|null $amount
 * @property string|null $status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class MedExpiredOrBed extends Model
{
	protected $table = 'med_expired_or_bed';

	protected $casts = [
		'exp_date' => 'datetime'
	];

	protected $fillable = [
		'purchase_id',
		'unit',
		'medicine',
		'batch_no',
		'exp_date',
		'qty',
		'mrp',
		'discount',
		'discount_per',
		'p_rate',
		's_rate',
		'cgst',
		'cgst_value',
		'sgst',
		'sgst_value',
		'igst',
		'igst_value',
		'amount',
		'status'
	];
}
