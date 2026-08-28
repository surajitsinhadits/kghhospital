<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class BlBloodCompatibility
 * 
 * @property int $id
 * @property string $donor_group
 * @property string $recipient_group
 *
 * @package App\Models
 */
class BlBloodCompatibility extends Model
{
	protected $table = 'bl_blood_compatibility';
	public $timestamps = false;

	protected $fillable = [
		'donor_group',
		'recipient_group'
	];
}
