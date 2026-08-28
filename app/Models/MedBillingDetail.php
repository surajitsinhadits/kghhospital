<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class MedBillingDetail
 * 
 * @property int $id
 * @property int $med_billing_id
 * @property int|null $med_category_id
 * @property int|null $med_name_id
 * @property string $med_name
 * @property string|null $batch_no
 * @property string|null $expairy_date
 * @property int $unit_details
 * @property int $unit_qty
 * @property string|null $unit
 * @property int $sub_unit_qty
 * @property string|null $sub_unit
 * @property int $mrp
 * @property float $discount_percentage
 * @property float $amount
 * @property int $total_qty
 * @property int $is_delete
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class MedBillingDetail extends Model
{
	protected $table = 'med_billing_details';

	protected $casts = [
		'med_billing_id' => 'int',
		'med_category_id' => 'int',
		'med_name_id' => 'int',
		'unit_details' => 'int',
		'unit_qty' => 'int',
		'sub_unit_qty' => 'int',
		'mrp' => 'int',
		'discount_percentage' => 'float',
		'amount' => 'float',
		'total_qty' => 'int',
		'is_delete' => 'int'
	];

	protected $fillable = [
		'med_billing_id',
		'med_category_id',
		'med_name_id',
		'med_name',
		'batch_no',
		'expairy_date',
		'unit_details',
		'unit_qty',
		'unit',
		'sub_unit_qty',
		'sub_unit',
		'mrp',
		'discount_percentage',
		'amount',
		'total_qty',
		'is_delete'
	];
}
