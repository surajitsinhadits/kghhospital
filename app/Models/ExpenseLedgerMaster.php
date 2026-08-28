<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExpenseLedgerMaster extends Model
{
    protected $fillable = [
        'ledger_name',
        'ledger_group',
        'tds_applicable',
        'tds_nature_payment',
        'tds_rate',
        'tds_threshold',
        'gst_applicable',
        'gst_charge_type',
        'sac_hsn_code',
        'gst_rate',
        'igst_ledger_name',
        'cgst_ledger_name',
        'sgst_ledger_name',
        'rcm_output_gst_ledger',
        'cost_centre_applicable',
        'default_cost_centre',
        'opening_balance',
        'description',
    ];

    protected $casts = [
        'tds_applicable' => 'boolean',
        'gst_applicable' => 'boolean',
        'cost_centre_applicable' => 'boolean',
        'tds_rate' => 'decimal:2',
        'tds_threshold' => 'decimal:2',
        'gst_rate' => 'decimal:2',
        'opening_balance' => 'decimal:2',
    ];
}
