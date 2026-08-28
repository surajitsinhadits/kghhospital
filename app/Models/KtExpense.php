<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class KtExpense
 * 
 * @property int $id
 * @property Carbon|null $date
 * @property int|null $total_meal
 * @property float|null $total
 * @property float|null $sub_total
 * @property float|null $total_gst_amount
 * @property string|null $note
 * @property string|null $generated_by
 * @property int|null $edit_by
 * @property Carbon|null $edit_at
 * @property int $is_issue
 * @property int|null $is_delete
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class KtExpense extends Model
{
	protected $table = 'kt_expenses';

	protected $casts = [
		'date' => 'datetime',
		'total_meal' => 'int',
		'total' => 'float',
		'sub_total' => 'float',
		'total_gst_amount' => 'float',
		'edit_by' => 'int',
		'edit_at' => 'datetime',
		'is_issue' => 'int',
		'is_delete' => 'int'
	];

	protected $fillable = [
		'date',
		'total_meal',
		'total',
		'sub_total',
		'total_gst_amount',
		'note',
		'generated_by',
		'edit_by',
		'edit_at',
		'is_issue',
		'is_delete'
	];
}
