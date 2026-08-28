<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class MedIssue
 * 
 * @property int $id
 * @property string|null $req_id
 * @property string|null $issue_department_id
 * @property int|null $is_issued
 * @property string|null $issue_prefix
 * @property string|null $issue_date
 * @property string|null $total_amount
 * @property string|null $note
 * @property string|null $generate_by
 * @property string|null $edit_by
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class MedIssue extends Model
{
	protected $table = 'med_issues';

	protected $casts = [
		'is_issued' => 'int'
	];

	protected $fillable = [
		'req_id',
		'issue_department_id',
		'is_issued',
		'issue_prefix',
		'issue_date',
		'total_amount',
		'note',
		'generate_by',
		'edit_by'
	];
}
