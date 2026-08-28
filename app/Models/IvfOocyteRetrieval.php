<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class IvfOocyteRetrieval
 * 
 * @property int $id
 * @property int $ivf_cycle_id
 * @property Carbon|null $scheduled_at
 * @property Carbon|null $performed_at
 * @property int|null $surgeon_id
 * @property string|null $anesthesia_type
 * @property int|null $follicles_aspirated
 * @property int|null $mature_oocytes
 * @property int|null $immature_oocytes
 * @property string|null $barcode_batch
 * @property string|null $complication_notes
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @package App\Models
 */
class IvfOocyteRetrieval extends Model
{
	protected $table = 'ivf_oocyte_retrievals';

	protected $casts = [
		'ivf_cycle_id' => 'int',
		'scheduled_at' => 'datetime',
		'performed_at' => 'datetime',
		'surgeon_id' => 'int',
		'follicles_aspirated' => 'int',
		'mature_oocytes' => 'int',
		'immature_oocytes' => 'int'
	];

	protected $fillable = [
		'ivf_cycle_id',
		'scheduled_at',
		'performed_at',
		'surgeon_id',
		'anesthesia_type',
		'follicles_aspirated',
		'mature_oocytes',
		'immature_oocytes',
		'barcode_batch',
		'complication_notes'
	];
}
