<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class OpItemCategory
 * 
 * @property int $id
 * @property string $category_name
 * @property int|null $parent_id
 * @property bool|null $status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class OpItemCategory extends Model
{
	protected $table = 'op_item_categories';

	protected $casts = [
		'parent_id' => 'int',
		'status' => 'bool'
	];

	protected $fillable = [
		'category_name',
		'parent_id',
		'status'
	];
}
