<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class StProductIssue
 *
 * @property int $id
 * @property Carbon|null $date
 * @property int|null $department_id
 * @property int|null $requisition_id
 * @property string|null $note
 * @property int|null $generated_by
 * @property int|null $edit_by
 * @property Carbon|null $edit_at
 * @property int|null $status
 * @property int|null $is_delete
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class StProductIssue extends Model
{
	protected $table = 'st_product_issue';

	protected $casts = [
		'date' => 'datetime',
		'department_id' => 'int',
		'requisition_id' => 'int',
		'generated_by' => 'int',
		'edit_by' => 'int',
		'edit_at' => 'datetime',
		'status' => 'int',
		'is_delete' => 'int'
	];

	protected $fillable = [
		'date',
		'department_id',
		'requisition_id',
		'note',
		'generated_by',
		'edit_by',
		'edit_at',
		'status',
		'is_delete'
	];
}
