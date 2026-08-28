<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TdsDutiesTaxesLedgerMaster extends Model
{
    protected $fillable = [
        'tds_ledger_name',
        'under_group',
        'tds_section_code',
        'tds_section_desc',
        'deductee_type',
        'tds_rate',
        'surcharge_applicable',
        'surcharge_rate',
        'cess_applicable',
        'cess_rate',
        'tds_payment_code',
        'tds_type',
        'annual_threshold',
        'single_txn_threshold',
        'nature_of_payment',
        'opening_balance',
    ];
}
