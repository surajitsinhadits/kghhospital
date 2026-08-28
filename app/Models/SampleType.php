<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class SampleType
 * 
 * @property int $id
 * @property string $sample_name
 * @property bool|null $status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class SampleType extends Model
{
	protected $table = 'sample_types';

	protected $casts = [
		'status' => 'bool'
	];

	protected $fillable = [
		'sample_name',
		'status'
	];
}
