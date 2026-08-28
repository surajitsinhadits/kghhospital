<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Vial
 * 
 * @property int $id
 * @property string $vial_name
 * @property bool|null $status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class Vial extends Model
{
	protected $table = 'vials';

	protected $casts = [
		'status' => 'bool'
	];

	protected $fillable = [
		'vial_name',
		'status'
	];
}
