<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class PatientNote
 * 
 * @property int $id
 * @property int $patient_id
 * @property string|null $title
 * @property string|null $p_document
 * @property string|null $note
 * @property int|null $is_delete
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class PatientNote extends Model
{
	protected $table = 'patient_notes';

	protected $casts = [
		'patient_id' => 'int',
		'is_delete' => 'int'
	];

	protected $fillable = [
		'patient_id',
		'title',
		'p_document',
		'note',
		'is_delete'
	];
}
