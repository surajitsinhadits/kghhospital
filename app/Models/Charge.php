<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Charge
 * 
 * @property int $id
 * @property string $charge_type
 * @property string|null $charge_section
 * @property string $charge_name
 * @property int $category_id
 * @property int $sub_category_id
 * @property int|null $requisition_section_id
 * @property int|null $sample_id
 * @property string|null $sample_required
 * @property int|null $vial_id
 * @property string|null $note
 * @property string|null $instrument_used
 * @property string|null $template
 * @property bool|null $is_active
 * @property bool|null $is_delete
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class Charge extends Model
{
	protected $table = 'charges';

	protected $casts = [
		'category_id' => 'int',
		'sub_category_id' => 'int',
		'requisition_section_id' => 'int',
		'sample_id' => 'int',
		'vial_id' => 'int',
		'is_active' => 'bool',
		'is_delete' => 'bool'
	];

	protected $fillable = [
		'charge_type',
		'charge_section',
		'charge_name',
		'category_id',
		'sub_category_id',
		'requisition_section_id',
		'sample_id',
		'sample_required',
		'vial_id',
		'note',
		'instrument_used',
		'template',
		'is_active',
		'is_delete'
	];
}
