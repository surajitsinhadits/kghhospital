<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class MedVendor
 *
 * @property int $id
 * @property string|null $vendor_name
 * @property string|null $email
 * @property int|null $vendor_ph_no
 * @property int|null $pin
 * @property int|null $vendor_gst
 * @property string|null $contact_name
 * @property string|null $vendor_address
 * @property int $status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class MedVendor extends Model
{
	protected $table = 'med_vendors';

	protected $casts = [
		'vendor_ph_no' => 'int',
		'pin' => 'int',
		'vendor_gst' => 'string',
		'status' => 'int'
	];

	protected $fillable = [
		'vendor_name',
		'email',
		'vendor_ph_no',
		'pin',
		'vendor_gst',
		'contact_name',
		'vendor_address',
		'status'
	];
}
