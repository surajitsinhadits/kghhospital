<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Investigation
 * 
 * @property int $id
 * @property string $type
 * @property int $charge_id
 * @property int $bill_id
 * @property int|null $bill_details_id
 * @property int $patient_id
 * @property int $bill_created_by
 * @property Carbon|null $bill_created_date
 * @property int|null $sample_collected_by
 * @property Carbon|null $sample_collected_at
 * @property int|null $report_generate_by
 * @property Carbon|null $report_generate_at
 * @property int|null $lab_receive_by
 * @property Carbon|null $lab_receive_at
 * @property string|null $special_remarks
 * @property int|null $report_deliverd_by
 * @property Carbon|null $report_deliverd_at
 * @property Carbon|null $expected_delivery_at
 * @property int|null $report_status
 * @property string|null $note
 * @property string|null $extra_note
 * @property string|null $remarks
 * @property string|null $attach_document
 * @property string|null $report_template_result
 * @property string|null $section
 * @property int|null $section_id
 * @property int|null $doctor_id
 * @property int|null $referral_id
 * @property Carbon|null $approved_at
 * @property int|null $approved_doctor_by
 * @property int $is_delete
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class Investigation extends Model
{
	protected $table = 'investigations';

	protected $casts = [
		'charge_id' => 'int',
		'bill_id' => 'int',
		'bill_details_id' => 'int',
		'patient_id' => 'int',
		'bill_created_by' => 'int',
		'bill_created_date' => 'datetime',
		'sample_collected_by' => 'int',
		'sample_collected_at' => 'datetime',
		'report_generate_by' => 'int',
		'report_generate_at' => 'datetime',
		'lab_receive_by' => 'int',
		'lab_receive_at' => 'datetime',
		'report_deliverd_by' => 'int',
		'report_deliverd_at' => 'datetime',
		'expected_delivery_at' => 'datetime',
		'report_status' => 'int',
		'section_id' => 'int',
		'doctor_id' => 'int',
		'referral_id' => 'int',
		'approved_at' => 'datetime',
		'approved_doctor_by' => 'int',
		'is_delete' => 'int',
		'is_original' => 'bool'
	];

	protected $fillable = [
		'type',
		'charge_id',
		'bill_id',
		'bill_details_id',
		'patient_id',
		'bill_created_by',
		'bill_created_date',
		'sample_collected_by',
		'sample_collected_at',
		'report_generate_by',
		'report_generate_at',
		'lab_receive_by',
		'lab_receive_at',
		'special_remarks',
		'report_deliverd_by',
		'report_deliverd_at',
		'expected_delivery_at',
		'report_status',
		'note',
		'extra_note',
		'remarks',
		'attach_document',
		'report_template_result',
		'section',
		'section_id',
		'doctor_id',
		'referral_id',
		'approved_at',
		'approved_doctor_by',
		'is_delete',
		'is_original'
	];
}
