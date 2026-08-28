<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class StCompany
 * 
 * @property int $id
 * @property string|null $company_name
 * @property bool|null $status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class StCompany extends Model
{
	protected $table = 'st_companies';

	protected $casts = [
		'status' => 'bool'
	];

	protected $fillable = [
		'company_name',
		'status'
	];
}
