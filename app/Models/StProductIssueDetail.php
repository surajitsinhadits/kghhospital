<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class StProductIssueDetail
 *
 * @property int $id
 * @property int|null $issue_id
 * @property int|null $item_id
 * @property string|null $part_no
 * @property Carbon|null $exp_date
 * @property int|null $unit_qty
 * @property int|null $sub_unit_qty
 * @property string|null $sub_unit
 * @property string|null $unit
 * @property int|null $is_delete
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class StProductIssueDetail extends Model
{
	protected $table = 'st_product_issue_details';

	protected $casts = [
		'issue_id' => 'int',
		'item_id' => 'int',
		'exp_date' => 'datetime',
		'unit_qty' => 'int',
		'sub_unit_qty' => 'int',
		'is_delete' => 'int'
	];

	protected $fillable = [
		'issue_id',
		'item_id',
		'part_no',
		'exp_date',
		'unit_qty',
		'sub_unit_qty',
		'sub_unit',
		'unit',
		'is_delete'
	];
}
