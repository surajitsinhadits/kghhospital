<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class KtSupplier
 * 
 * @property int $id
 * @property string $supplier
 * @property int $status
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @package App\Models
 */
class KtSupplier extends Model
{
	protected $table = 'kt_suppliers';

	protected $casts = [
		'status' => 'int'
	];

	protected $fillable = [
		'supplier',
		'status'
	];
}
