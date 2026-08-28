<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class EmrMaster
 *
 * @property int $id
 * @property int|null $patient_id
 * @property string|null $section
 * @property int|null $section_id
 * @property string|null $vitals
 * @property string|null $complaints
 * @property string|null $diagnosis
 * @property string|null $medicines
 * @property string|null $advice
 * @property string|null $test_name
 * @property int|null $doctor_id
 * @property int|null $created_by
 * @property Carbon|null $created_at
 * @property Carbon $updated_at
 *
 * @package App\Models
 */
class EmrMaster extends Model
{
    protected $table = 'emr_masters';

    protected $casts = [
        'patient_id' => 'int',
        'section_id' => 'int',
        'doctor_id' => 'int',
        'created_by' => 'int',
        'vitals' => 'array',
        'complaints' => 'array',
        'diagnosis' => 'array',
        'medicines' => 'array',
        'test_name' => 'array',
    ];

    protected $fillable = [
        'patient_id',
        'section',
        'section_id',
        'vitals',
        'complaints',
        'diagnosis',
        'medicines',
        'advice',
        'test_name',
        'doctor_id',
        'created_by'
    ];
}
