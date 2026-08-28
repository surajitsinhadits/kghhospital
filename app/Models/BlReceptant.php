<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class BlReceptant
 * 
 * @property int $id
 * @property string $unique_id
 * @property int $blood_inventory_id
 * @property int $section_id
 * @property string $section_name
 * @property Carbon $donated_date
 * @property int $quantity
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @package App\Models
 */
class BlReceptant extends Model
{
	protected $table = 'bl_receptant';

	protected $casts = [
		'blood_inventory_id' => 'int',
		'section_id' => 'int',
		'donated_date' => 'datetime',
		'quantity' => 'int'
	];

	protected $fillable = [
		'unique_id',
		'blood_inventory_id',
		'section_id',
		'section_name',
		'donated_date',
		'quantity'
	];
}
