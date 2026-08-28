<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Diagonase
 * 
 * @property int $id
 * @property string $diagonasis_name
 * @property string|null $icd_code
 * @property int $status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class Diagonase extends Model
{
	protected $table = 'diagonases';

	protected $casts = [
		'status' => 'int'
	];

	protected $fillable = [
		'diagonasis_name',
		'icd_code',
		'status'
	];
}
