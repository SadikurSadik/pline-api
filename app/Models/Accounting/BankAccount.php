<?php

namespace App\Models\Accounting;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class BankAccount extends Model
{
    protected $connection = 'accounting';

    public const NON_CASH_ID = 4;

    protected $fillable = [
        'holder_name',
        'bank_name',
        'account_number',
        'opening_balance',
        'contact_number',
        'bank_address',
        'created_by',
    ];

    public function scopeWithoutNonCash(Builder $query)
    {
        $query->where('id', '!=', self::NON_CASH_ID);
    }
}
