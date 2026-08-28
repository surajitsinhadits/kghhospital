<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class CaseReference
 * 
 * @property int $id
 * @property int $patient_id
 * @property string $section
 * @property int $section_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class CaseReference extends Model
{
	protected $table = 'case_references';

	protected $casts = [
		'patient_id' => 'int',
		'section_id' => 'int'
	];

	protected $fillable = [
		'patient_id',
		'section',
		'section_id'
	];
}
