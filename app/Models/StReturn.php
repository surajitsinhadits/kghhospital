<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class StReturn
 *
 * @property int $id
 * @property int $mas_id
 * @property int $issue_id
 * @property int $item_id
 * @property string $type
 * @property string $part_no
 * @property int $unit_qty
 * @property int $sub_unit_qty
 * @property float $total
 * @property float $sub_total
 * @property float $cgst
 * @property float $cgst_value
 * @property float $sgst
 * @property float $sgst_value
 * @property float $igst
 * @property float $igst_value
 * @property int $status
 * @property string $note
 * @property Carbon|null $exchange_completed_at
 * @property int|null $exchange_completed_by
 * @property int|null $approved_by
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @package App\Models
 */
class StReturn extends Model
{
	protected $table = 'st_returns';

	protected $casts = [
		'mas_id' => 'int',
		'issue_id' => 'int',
		'item_id' => 'int',
		'unit_qty' => 'int',
		'sub_unit_qty' => 'int',
		'total' => 'float',
		'sub_total' => 'float',
		'cgst' => 'float',
		'cgst_value' => 'float',
		'sgst' => 'float',
		'sgst_value' => 'float',
		'igst' => 'float',
		'igst_value' => 'float',
		'status' => 'int',
		'repair_completed_at' => 'datetime',
		'repair_completed_by' => 'int',
		'repair_time' => 'int',
		'repair_amount' => 'float',
		'approved_by' => 'int'
	];

	protected $fillable = [
		'mas_id',
		'issue_id',
		'item_id',
		'type',
		'part_no',
		'unit_qty',
		'sub_unit_qty',
		'total',
		'sub_total',
		'cgst',
		'cgst_value',
		'sgst',
		'sgst_value',
		'igst',
		'igst_value',
		'status',
		'note',
		'repair_completed_at',
		'repair_completed_by',
		'repair_from',
		'repair_time',
		'repair_amount',
		'repair_bill',
		'approved_by'
	];
}
