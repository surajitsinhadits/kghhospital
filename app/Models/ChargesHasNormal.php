<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class ChargesHasNormal
 * 
 * @property int $id
 * @property int $charge_id
 * @property string|null $lebel
 * @property string|null $grp_cd
 * @property string|null $test_parameter
 * @property int|null $seq_no
 * @property string|null $comments
 * @property string|null $unit
 * @property string|null $m_ll
 * @property string|null $m_ul
 * @property string|null $f_ll
 * @property string|null $f_ul
 * @property string|null $c_ll
 * @property string|null $c_ul
 * @property string|null $method
 * @property string|null $ins_used
 * @property string|null $lis_cd
 * @property string|null $formula
 *
 * @package App\Models
 */
class ChargesHasNormal extends Model
{
	protected $table = 'charges_has_normals';
	public $timestamps = false;

	protected $casts = [
		'charge_id' => 'int',
		'seq_no' => 'int'
	];

	protected $fillable = [
		'charge_id',
		'lebel',
		'grp_cd',
		'test_parameter',
		'seq_no',
		'comments',
		'unit',
		'm_ll',
		'm_ul',
		'f_ll',
		'f_ul',
		'c_ll',
		'c_ul',
		'method',
		'ins_used',
		'lis_cd',
		'formula'
	];
}
