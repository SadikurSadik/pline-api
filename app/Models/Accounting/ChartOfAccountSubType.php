<?php

namespace App\Models\Accounting;

use Illuminate\Database\Eloquent\Model;

class ChartOfAccountSubType extends Model
{
    protected $connection = 'accounting';

    protected $fillable = [
        'name',
        'type',
        'created_by',
    ];
}
