<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class MedRequisitionDetail
 * 
 * @property int $id
 * @property int $requisition_id
 * @property string $medicine_name
 * @property string|null $unit_qty
 * @property string $unit
 * @property string|null $sub_unit_qty
 * @property string|null $sub_unit
 * @property string|null $is_delete
 * @property int $is_issued
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class MedRequisitionDetail extends Model
{
	protected $table = 'med_requisition_details';

	protected $casts = [
		'requisition_id' => 'int',
		'is_issued' => 'int'
	];

	protected $fillable = [
		'requisition_id',
		'medicine_name',
		'unit_qty',
		'unit',
		'sub_unit_qty',
		'sub_unit',
		'is_delete',
		'is_issued'
	];
}
