<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class ChargesHasSection
 * 
 * @property int $id
 * @property int $charge_id
 * @property int $charge_section_id
 * @property float|null $charge_amount
 *
 * @package App\Models
 */
class ChargesHasSection extends Model
{
	protected $table = 'charges_has_sections';
	public $timestamps = false;

	protected $casts = [
		'charge_id' => 'int',
		'charge_section_id' => 'int',
		'charge_amount' => 'float'
	];

	protected $fillable = [
		'charge_id',
		'charge_section_id',
		'charge_amount'
	];
}
