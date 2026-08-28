<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class MedRequisition
 * 
 * @property int $id
 * @property string|null $requisition_prefix
 * @property Carbon|null $date
 * @property string|null $dept_id
 * @property string|null $requested_by
 * @property string|null $genarated_by
 * @property string|null $edit_by
 * @property string|null $note
 * @property string|null $is_given
 * @property int|null $is_delete
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class MedRequisition extends Model
{
	protected $table = 'med_requisitions';

	protected $casts = [
		'date' => 'datetime',
		'is_delete' => 'int'
	];

	protected $fillable = [
		'requisition_prefix',
		'date',
		'dept_id',
		'requested_by',
		'genarated_by',
		'edit_by',
		'note',
		'is_given',
		'is_delete'
	];
}
