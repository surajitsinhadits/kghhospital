<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class StVendorPrice
 * 
 * @property int $id
 * @property int $po_id
 * @property float $total_price
 * @property int $vendor_id
 * @property int $status
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @package App\Models
 */
class StVendorPrice extends Model
{
	protected $table = 'st_vendor_price';

	protected $casts = [
		'po_id' => 'int',
		'total_price' => 'float',
		'vendor_id' => 'int',
		'status' => 'int'
	];

	protected $fillable = [
		'po_id',
		'total_price',
		'vendor_id',
		'status'
	];
}
