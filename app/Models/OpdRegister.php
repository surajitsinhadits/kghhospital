<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use App\Models\Concerns\HasOriginalFilterScope;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class OpdRegister
 *
 * @property int $id
 * @property int $department_id
 * @property int $doctor_id
 * @property int $patient_id
 * @property int $generate_by
 * @property string|null $type
 * @property int|null $opd_type
 * @property Carbon|null $appointment_date
 * @property int|null $enquiry_id
 * @property int|null $ticket_no
 * @property int|null $referred_by
 * @property int|null $provider
 * @property int|null $market_by
 * @property bool|null $is_ipd_moved
 * @property Carbon|null $next_appointment_date
 * @property int|null $edit_by
 * @property Carbon|null $edit_at
 * @property bool|null $is_active
 * @property bool|null $is_delete
 * @property bool $is_original
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 */
class OpdRegister extends Model
{
    use HasOriginalFilterScope;

    protected $table = 'opd_registers';

    protected static function booted(): void
    {
        static::applyOriginalFilterScope('opd_registers.is_original');
    }

    protected $casts = [
        'department_id' => 'int',
        'doctor_id' => 'int',
        'patient_id' => 'int',
        'generate_by' => 'int',
        'opd_type' => 'int',
        'appointment_date' => 'datetime',
        'enquiry_id' => 'int',
        'ticket_no' => 'int',
        'referred_by' => 'int',
        'provider' => 'int',
        'market_by' => 'int',
        'is_ipd_moved' => 'bool',
        'next_appointment_date' => 'datetime',
        'edit_by' => 'int',
        'edit_at' => 'datetime',
        'is_active' => 'bool',
        'is_delete' => 'bool',
        'is_original' => 'bool',
    ];

    protected $fillable = [
        'department_id',
        'doctor_id',
        'patient_id',
        'generate_by',
        'type',
        'opd_type',
        'appointment_date',
        'enquiry_id',
        'ticket_no',
        'referred_by',
        'provider',
        'market_by',
        'is_ipd_moved',
        'next_appointment_date',
        'edit_by',
        'edit_at',
        'is_active',
        'is_delete',
        'is_original',
    ];


}
