<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ChargesSection
 * 
 * @property int $id
 * @property string $charges_section_name
 * @property bool|null $status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class ChargesSection extends Model
{
	protected $table = 'charges_sections';

	protected $casts = [
		'status' => 'bool'
	];

	protected $fillable = [
		'charges_section_name',
		'status'
	];
}
