<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class MedMedicine
 * 
 * @property int $id
 * @property string $medicine_name
 * @property string $medicine_catagory
 * @property string|null $medicine_company
 * @property string|null $medicine_composition
 * @property string|null $medicine_group
 * @property string|null $min_level
 * @property string|null $unit
 * @property string|null $sub_unit
 * @property int $unit_details
 * @property string|null $tax
 * @property string|null $note
 * @property string|null $medicine_photo
 * @property int $status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class MedMedicine extends Model
{
	protected $table = 'med_medicines';

	protected $casts = [
		'unit_details' => 'int',
		'status' => 'int'
	];

	protected $fillable = [
		'medicine_name',
		'medicine_catagory',
		'medicine_company',
		'medicine_composition',
		'medicine_group',
		'min_level',
		'unit',
		'sub_unit',
		'unit_details',
		'tax',
		'note',
		'medicine_photo',
		'status'
	];
}
