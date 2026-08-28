<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class BlDonation
 * 
 * @property int $id
 * @property int|null $donor_id
 * @property string $bag_barcode
 * @property string|null $blood_group
 * @property string|null $collection_site
 * @property string|null $component_type
 * @property string|null $component_seperation_status
 * @property Carbon $donation_date
 * @property Carbon|null $expiry_date
 * @property Carbon|null $test_at
 * @property int|null $test_by
 * @property Carbon|null $approved_at
 * @property int|null $approved_by
 * @property string $status
 * @property int $stock_updated
 * @property int $is_used
 * @property int $is_delete
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class BlDonation extends Model
{
	protected $table = 'bl_donations';

	protected $casts = [
		'donor_id' => 'int',
		'donation_date' => 'datetime',
		'expiry_date' => 'datetime',
		'test_at' => 'datetime',
		'test_by' => 'int',
		'approved_at' => 'datetime',
		'approved_by' => 'int',
		'stock_updated' => 'int',
		'is_used' => 'int',
		'is_delete' => 'int'
	];

	protected $fillable = [
		'donor_id',
		'bag_barcode',
		'blood_group',
		'collection_site',
		'component_type',
		'component_seperation_status',
		'donation_date',
		'expiry_date',
		'test_at',
		'test_by',
		'approved_at',
		'approved_by',
		'status',
		'stock_updated',
		'is_used',
		'is_delete'
	];
}
