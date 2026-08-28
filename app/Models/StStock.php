<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class StStock
 *
 * @property int $id
 * @property int|null $po_id
 * @property Carbon|null $date
 * @property int|null $item_id
 * @property Carbon|null $exp_date
 * @property string|null $part_no
 * @property float $total
 * @property float $sub_total
 * @property float $cgst
 * @property float $cgst_value
 * @property float $sgst
 * @property float $sgst_value
 * @property float $igst
 * @property float $igst_value
 * @property int $unit_qty
 * @property string|null $unit
 * @property int $sub_unit_qty
 * @property string|null $sub_unit
 * @property int $unit_sub_no
 * @property float $unit_mrp
 * @property float $unit_rate
 * @property int|null $generated_by
 * @property int $present_qty
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class StStock extends Model
{
	protected $table = 'st_stocks';

	protected $casts = [
		'po_id' => 'int',
		'date' => 'datetime',
		'item_id' => 'int',
		'exp_date' => 'datetime',
		'total' => 'float',
		'sub_total' => 'float',
		'cgst' => 'float',
		'cgst_value' => 'float',
		'sgst' => 'float',
		'sgst_value' => 'float',
		'igst' => 'float',
		'igst_value' => 'float',
		'unit_qty' => 'int',
		'sub_unit_qty' => 'int',
		'unit_sub_no' => 'int',
		'unit_mrp' => 'float',
		'unit_rate' => 'float',
		'generated_by' => 'int',
        'present_qty' => 'int',
	];

	protected $fillable = [
		'po_id',
		'date',
		'item_id',
		'exp_date',
		'part_no',
		'total',
		'sub_total',
		'cgst',
		'cgst_value',
		'sgst',
		'sgst_value',
		'igst',
		'igst_value',
		'unit_qty',
		'unit',
		'sub_unit_qty',
		'sub_unit',
		'unit_sub_no',
		'unit_mrp',
		'unit_rate',
		'present_stock_unit_qty',
		'present_stock_subunit_qty',
		'generated_by'
	];
}
