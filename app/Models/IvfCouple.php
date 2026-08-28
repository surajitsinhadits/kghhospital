<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class IvfCouple
 * 
 * @property int $id
 * @property int|null $uhid_male
 * @property int|null $uhid_female
 * @property string|null $case_type
 * @property string|null $status
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @package App\Models
 */
class IvfCouple extends Model
{
	protected $table = 'ivf_couples';

	protected $casts = [
		'uhid_male' => 'int',
		'uhid_female' => 'int'
	];

	protected $fillable = [
		'uhid_male',
		'uhid_female',
		'case_type',
		'status'
	];
}
