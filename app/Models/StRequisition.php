<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class StRequisition
 *
 * @property int $id
 * @property Carbon|null $requisition_date
 * @property int|null $department_id
 * @property string|null $note
 * @property string|null $created_by
 * @property int|null $edit_by
 * @property Carbon|null $edit_at
 * @property bool|null $is_given
 * @property int|null $is_delete
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class StRequisition extends Model
{
	protected $table = 'st_requisitions';

	protected $casts = [
		'requisition_date' => 'datetime',
		'department_id' => 'int',
		'edit_by' => 'int',
		'edit_at' => 'datetime',
		'verified_by' => 'int',
		'verified_at' => 'datetime',
		'approved_by' => 'int',
		'approved_at' => 'datetime',
		'reject_by' => 'int',
		'reject_at' => 'datetime',
		'is_delete' => 'int'
	];

	protected $fillable = [
		'requisition_date',
		'department_id',
		'note',
		'created_by',
		'edit_by',
		'edit_at',
		'verified_by',
		'verified_at',
		'approved_by',
		'approved_at',
		'reject_by',
		'reject_at',
		'reject_note',
		'is_given',
		'is_delete'
	];
}
