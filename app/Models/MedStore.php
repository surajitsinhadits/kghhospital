<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class MedStore
 * 
 * @property int $id
 * @property string $medicine_store_name
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class MedStore extends Model
{
	protected $table = 'med_stores';

	protected $fillable = [
		'medicine_store_name'
	];
}
