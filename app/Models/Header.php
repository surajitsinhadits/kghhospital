<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Header
 * 
 * @property int $id
 * @property string $header_name
 * @property string|null $logo
 * @property bool|null $status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class Header extends Model
{
	protected $table = 'headers';

	protected $casts = [
		'status' => 'bool'
	];

	protected $fillable = [
		'header_name',
		'logo',
		'status'
	];
}
