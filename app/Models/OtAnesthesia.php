<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class OtAnesthesia
 * 
 * @property int $id
 * @property string|null $name
 * @property string|null $status
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @package App\Models
 */
class OtAnesthesia extends Model
{
	protected $table = 'ot_anesthesias';

	protected $fillable = [
		'name',
		'status'
	];
}
