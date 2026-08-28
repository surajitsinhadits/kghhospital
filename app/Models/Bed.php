<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use App\Models\Concerns\HasOriginalFilterScope;

/**
 * Class Bed
 *
 * @property int $id
 * @property string $bed_name
 * @property int $ward_id
 * @property string|null $is_used
 * @property int|null $status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class Bed extends Model
{
	use HasOriginalFilterScope;
	protected $table = 'beds';

	protected static function booted(): void
    {
        static::applyOriginalFilterScope('beds.is_original');
    }

	protected $casts = [
		'ward_id' => 'int',
		'status' => 'int'
	];

	protected $fillable = [
		'bed_name',
		'ward_id',
		'is_used',
		'status'
	];
}
