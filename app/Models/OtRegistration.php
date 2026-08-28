<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use App\Models\Concerns\HasOriginalFilterScope;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class OtRegistration
 *
 * @property int $id
 * @property string|null $patient_id
 * @property string|null $ipd_id
 * @property string|null $package_id
 * @property string|null $department_id
 * @property string|null $cons_doc
 * @property string|null $planned_date
 * @property string|null $operation_name
 * @property string|null $amount
 * @property string|null $status
 * @property string $is_admitted
 * @property string|null $register_by
 * @property string|null $updated_by
 * @property int $is_active
 * @property int $is_delete
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @package App\Models
 */
class OtRegistration extends Model
{
    use HasOriginalFilterScope;

	protected $table = 'ot_registrations';

    protected static function booted(): void
    {
        static::applyOriginalFilterScope('ot_registrations.is_original');
    }

	protected $casts = [
		'is_active' => 'int',
		'is_delete' => 'int',
        'is_original' => 'bool'
	];

	protected $fillable = [
		'patient_id',
		'ipd_id',
		'package_id',
		'department_id',
		'cons_doc',
		'planned_date',
		'operation_name',
		'amount',
		'status',
		'is_admitted',
		'register_by',
		'updated_by',
        'status',
		'is_active',
		'is_delete',
        'is_original'
	];
}
