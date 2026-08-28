<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class MedCatagory
 * 
 * @property int $id
 * @property string $medicine_catagory_name
 * @property int|null $status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class MedCatagory extends Model
{
	protected $table = 'med_catagories';

	protected $casts = [
		'status' => 'int'
	];

	protected $fillable = [
		'medicine_catagory_name',
		'status'
	];
}
