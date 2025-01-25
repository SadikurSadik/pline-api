<?php

namespace App\Models\Accounting;

use Illuminate\Database\Eloquent\Model;

class JournalItem extends Model
{
    protected $connection = 'accounting';

    protected $fillable = [
        'journal',
        'account',
        'description',
        'debit',
        'credit',
    ];

    public function accounts()
    {
        return $this->hasOne('App\Models\Accounting\ChartOfAccount', 'id', 'account');
    }
}
