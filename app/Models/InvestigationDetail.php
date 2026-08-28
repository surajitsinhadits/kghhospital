<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class InvestigationDetail
 * 
 * @property int $id
 * @property int $investigation_id
 * @property int $charge_normal_id
 * @property string|null $test_result_value
 * @property string|null $comment
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class InvestigationDetail extends Model
{
	protected $table = 'investigation_details';

	protected $casts = [
		'investigation_id' => 'int',
		'charge_normal_id' => 'int'
	];

	protected $fillable = [
		'investigation_id',
		'charge_normal_id',
		'test_result_value',
		'comment'
	];
}
