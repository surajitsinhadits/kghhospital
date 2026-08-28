<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Referral
 * 
 * @property int $id
 * @property string $referral_name
 * @property string|null $type
 * @property string|null $reffer_type
 * @property string|null $phone_no
 * @property string|null $address
 * @property string|null $standard_commission
 * @property string|null $opd_commission
 * @property string|null $emg_commission
 * @property string|null $ipd_commission
 * @property string|null $pharmacy_commission
 * @property string|null $pathology_commission
 * @property string|null $radiology_commission
 * @property string|null $ambulance_commission
 * @property string|null $blood_bank_commission
 * @property int $is_active
 * @property int $is_delete
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class Referral extends Model
{
	protected $table = 'referrals';

	protected $casts = [
		'is_active' => 'int',
		'is_delete' => 'int'
	];

	protected $fillable = [
		'referral_name',
		'type',
		'reffer_type',
		'phone_no',
		'address',
		'standard_commission',
		'opd_commission',
		'emg_commission',
		'ipd_commission',
		'pharmacy_commission',
		'pathology_commission',
		'radiology_commission',
		'ambulance_commission',
		'blood_bank_commission',
		'is_active',
		'is_delete'
	];
}
