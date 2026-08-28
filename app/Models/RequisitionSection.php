<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class RequisitionSection
 * 
 * @property int $id
 * @property string $requisition_section_name
 * @property bool|null $status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class RequisitionSection extends Model
{
	protected $table = 'requisition_sections';

	protected $casts = [
		'status' => 'bool'
	];

	protected $fillable = [
		'requisition_section_name',
		'status'
	];
}
