<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class BlBloodInventory
 * 
 * @property int $id
 * @property int $section_id
 * @property string $section
 * @property string $blood_group
 * @property string|null $component_type
 * @property int $quantity
 * @property string $unit
 * @property Carbon $donation_date
 * @property Carbon $expiry_date
 * @property Carbon|null $move_to_stock_date
 * @property Carbon|null $return_to_inventory_date
 * @property int $is_used
 * @property int|null $stock_blood
 * @property int $added_by
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @package App\Models
 */
class BlBloodInventory extends Model
{
	protected $table = 'bl_blood_inventory';

	protected $casts = [
		'section_id' => 'int',
		'quantity' => 'int',
		'donation_date' => 'datetime',
		'expiry_date' => 'datetime',
		'move_to_stock_date' => 'datetime',
		'return_to_inventory_date' => 'datetime',
		'is_used' => 'int',
		'stock_blood' => 'int',
		'added_by' => 'int'
	];

	protected $fillable = [
		'section_id',
		'section',
		'blood_group',
		'component_type',
		'quantity',
		'unit',
		'donation_date',
		'expiry_date',
		'move_to_stock_date',
		'return_to_inventory_date',
		'is_used',
		'stock_blood',
		'added_by'
	];
}
