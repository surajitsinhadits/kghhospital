<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class MedFreePurchaseDetail
 * 
 * @property int $id
 * @property string|null $purchase_id
 * @property string|null $medicine_id
 * @property string|null $qty
 * @property string|null $unit
 * @property string|null $batch_no
 * @property string|null $expiry_date
 * @property string|null $rate
 * @property string|null $mrp
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @package App\Models
 */
class MedFreePurchaseDetail extends Model
{
	protected $table = 'med_free_purchase_details';

	protected $fillable = [
		'purchase_id',
		'medicine_id',
		'qty',
		'unit',
		'batch_no',
		'expiry_date',
		'rate',
		'mrp'
	];
}
