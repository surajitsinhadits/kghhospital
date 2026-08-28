<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class CssdCategory
 * 
 * @property int $id
 * @property string $category_name
 * @property string $category_short_code
 * @property int $status
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @package App\Models
 */
class CssdCategory extends Model
{
	protected $table = 'cssd_categories';

	protected $casts = [
		'status' => 'int'
	];

	protected $fillable = [
		'category_name',
		'category_short_code',
		'status'
	];
}
