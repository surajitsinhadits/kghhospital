<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class StAssetNo
 * 
 * @property int $id
 * @property int $item_id
 * @property string|null $asset_no
 * @property int $status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class StAssetNo extends Model
{
	protected $table = 'st_asset_no';

	protected $casts = [
		'item_id' => 'int',
	];

	protected $fillable = [
		'item_id',
		'asset_int_no',
		'asset_no',
	];
}
