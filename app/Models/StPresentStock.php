<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class StPresentStock
 * 
 * @property int $id
 * @property int $item_id
 * @property int $present_unit_qty
 * @property int $present_subunit_qty
 * @property int $present_total
 * @property string $type
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @package App\Models
 */
class StPresentStock extends Model
{
	protected $table = 'st_present_stocks';

	protected $casts = [
		'item_id' => 'int',
		'present_unit_qty' => 'int',
		'present_subunit_qty' => 'int',
		'present_total' => 'int'
	];

	protected $fillable = [
		'item_id',
		'present_unit_qty',
		'present_subunit_qty',
		'present_total',
		'type'
	];
}
