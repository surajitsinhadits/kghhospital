<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class OpCompany
 * 
 * @property int $id
 * @property string|null $company_name
 * @property bool|null $status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class OpCompany extends Model
{
	protected $table = 'op_companies';

	protected $casts = [
		'status' => 'bool'
	];

	protected $fillable = [
		'company_name',
		'status'
	];
}
