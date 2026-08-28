<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class MedIssueDetail
 * 
 * @property int $id
 * @property string|null $issue_id
 * @property string|null $req_details_id
 * @property string|null $medicine_name
 * @property string|null $batch_no
 * @property string|null $expiry_date
 * @property int $cgst
 * @property int $cgst_value
 * @property int $sgst
 * @property int $sgst_value
 * @property int $igst
 * @property int $igst_value
 * @property string|null $unit
 * @property string|null $unit_qty
 * @property int $sub_unit_qty
 * @property string|null $sub_unit
 * @property int $rate
 * @property int $mrp
 * @property int $net_amount
 * @property int $t_amount
 * @property int $total_qty
 * @property int $is_delete
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class MedIssueDetail extends Model
{
	protected $table = 'med_issue_details';

	protected $casts = [
		'cgst' => 'int',
		'cgst_value' => 'int',
		'sgst' => 'int',
		'sgst_value' => 'int',
		'igst' => 'int',
		'igst_value' => 'int',
		'sub_unit_qty' => 'int',
		'rate' => 'int',
		'mrp' => 'int',
		'net_amount' => 'int',
		't_amount' => 'int',
		'total_qty' => 'int',
		'is_delete' => 'int'
	];

	protected $fillable = [
		'issue_id',
		'req_details_id',
		'medicine_name',
		'batch_no',
		'expiry_date',
		'cgst',
		'cgst_value',
		'sgst',
		'sgst_value',
		'igst',
		'igst_value',
		'unit',
		'unit_qty',
		'sub_unit_qty',
		'sub_unit',
		'rate',
		'mrp',
		'net_amount',
		't_amount',
		'total_qty',
		'is_delete'
	];
}
