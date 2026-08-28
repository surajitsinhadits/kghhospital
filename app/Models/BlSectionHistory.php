<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class BlSectionHistory
 * 
 * @property int $id
 * @property int $bill_id
 * @property int $section_id
 * @property string $section
 * @property int $receptant_id
 * @property int $created_by
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @package App\Models
 */
class BlSectionHistory extends Model
{
	protected $table = 'bl_section_history';

	protected $casts = [
		'bill_id' => 'int',
		'section_id' => 'int',
		'receptant_id' => 'int',
		'created_by' => 'int'
	];

	protected $fillable = [
		'bill_id',
		'section_id',
		'section',
		'receptant_id',
		'created_by'
	];
}
