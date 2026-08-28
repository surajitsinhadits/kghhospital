<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class TpaManagement
 * 
 * @property int $id
 * @property string|null $tpa_name
 * @property string|null $contact_person_name
 * @property string|null $contact_person_ph_no
 * @property int $status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class TpaManagement extends Model
{
	protected $table = 'tpa_managements';

	protected $casts = [
		'status' => 'int'
	];

	protected $fillable = [
		'tpa_name',
		'contact_person_name',
		'contact_person_ph_no',
		'status'
	];
}
