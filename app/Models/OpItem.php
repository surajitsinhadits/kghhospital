<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class OpItem
 * 
 * @property int $id
 * @property int|null $type_id
 * @property int|null $category_id
 * @property int|null $sub_category_id
 * @property string|null $item_name
 * @property string|null $low_level
 * @property int|null $company_id
 * @property string|null $hsn_sac_no
 * @property int|null $unit_id
 * @property int|null $sub_unit_id
 * @property int|null $sub_unit_no
 * @property bool|null $is_active
 * @property bool|null $is_delete
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class OpItem extends Model
{
	protected $table = 'op_items';

	protected $casts = [
		'type_id' => 'int',
		'category_id' => 'int',
		'sub_category_id' => 'int',
		'company_id' => 'int',
		'unit_id' => 'int',
		'sub_unit_id' => 'int',
		'sub_unit_no' => 'int',
		'is_active' => 'bool',
		'is_delete' => 'bool'
	];

	protected $fillable = [
		'type_id',
		'category_id',
		'sub_category_id',
		'item_name',
		'low_level',
		'company_id',
		'hsn_sac_no',
		'unit_id',
		'sub_unit_id',
		'sub_unit_no',
		'is_active',
		'is_delete'
	];
}
