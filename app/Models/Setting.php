<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Setting
 * 
 * @property int $id
 * @property string $tag
 * @property string|null $value
 *
 * @package App\Models
 */
class Setting extends Model
{
	protected $table = 'settings';
	public $timestamps = false;

	protected $fillable = [
		'tag',
		'value'
	];
}
