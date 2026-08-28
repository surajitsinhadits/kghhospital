<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class CssdKitboxInstrument
 * 
 * @property int $id
 * @property int $kitbox_id
 * @property int $instrument_id
 * @property int|null $quantity
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class CssdKitboxInstrument extends Model
{
	protected $table = 'cssd_kitbox_instruments';

	protected $casts = [
		'kitbox_id' => 'int',
		'instrument_id' => 'int',
		'quantity' => 'int'
	];

	protected $fillable = [
		'kitbox_id',
		'instrument_id',
		'quantity'
	];
}
