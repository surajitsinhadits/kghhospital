<?php

namespace App\Models;

use App\Models\Miscellaneous;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MiscellaneousPayment extends Model
{
    use HasFactory;

    protected $fillable = [
        'miscellaneous_id',
        'amount_paid',
        'discount',
        'details',
    ];

    protected $casts = [
        'amount_paid' => 'decimal:2',
        'discount' => 'decimal:2',
        'paid_at' => 'datetime',
    ];

    public function miscellaneous()
    {
        return $this->belongsTo(Miscellaneous::class);
    }
}
