<?php

namespace App\Models\Accounting;

use Illuminate\Database\Eloquent\Model;

class CreditNote extends Model
{
    protected $connection = 'accounting';

    protected $fillable = [
        'invoice',
        'customer',
        'amount',
        'date',
    ];
}
