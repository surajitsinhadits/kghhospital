<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class VcVendor
 * 
 * @property int $id
 * @property string|null $vendor_name
 * @property string|null $email
 * @property string|null $phone
 * @property string|null $pin_code
 * @property string|null $gstin
 * @property string|null $contact_person_name
 * @property string|null $address
 * @property bool|null $is_active
 * @property bool|null $is_delete
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class VcVendor extends Model
{
	protected $table = 'vc_vendors';

	protected $casts = [
		'is_active' => 'bool',
		'is_delete' => 'bool'
	];

	protected $fillable = [
		'vendor_name',
		'email',
		'phone',
		'pin_code',
		'gstin',
		'contact_person_name',
		'address',
		'is_active',
		'is_delete'
	];
}
