<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ChargesCatagory
 * 
 * @property int $id
 * @property string $charges_catagories_name
 * @property string|null $description
 * @property int|null $parent_id
 * @property bool|null $status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class ChargesCatagory extends Model
{
	protected $table = 'charges_catagories';

	protected $casts = [
		'parent_id' => 'int',
		'status' => 'bool'
	];

	protected $fillable = [
		'charges_catagories_name',
		'description',
		'parent_id',
		'status'
	];
}
