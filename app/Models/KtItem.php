<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class KtItem
 * 
 * @property int $id
 * @property int|null $category_id
 * @property string|null $item_name
 * @property string|null $hsn_sac_no
 * @property int|null $unit_id
 * @property bool|null $status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class KtItem extends Model
{
	protected $table = 'kt_items';

	protected $casts = [
		'category_id' => 'int',
		'unit_id' => 'int',
		'status' => 'bool'
	];

	protected $fillable = [
		'category_id',
		'item_name',
		'hsn_sac_no',
		'unit_id',
		'status'
	];
}
