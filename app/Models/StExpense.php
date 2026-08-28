<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class StExpense
 *
 * @property int $id
 * @property int $dept_id
 * @property int $date
 * @property int $generated_by
 * @property int|null $edit_by
 * @property Carbon|null $edit_at
 * @property int $status
 * @property int $is_delete
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @package App\Models
 */
class StExpense extends Model
{
	protected $table = 'st_expenses';

	protected $casts = [
		'dept_id'       => 'int',
        'issue_id'       => 'int',
		'expense_date'  => 'datetime',
		'generated_by'  => 'int',
		'edit_by'       => 'int',
		'edit_at'       => 'datetime',
		'status'        => 'int',
		'is_delete'     => 'int'
	];

	protected $fillable = [
		'dept_id',
        'issue_id',
        'requisition_id',
        'user_type',
        'doctor_id',
        'patient_id',
        'staff_id',
		'expense_date',
		'generated_by',
        'is_delete'
	];
}
