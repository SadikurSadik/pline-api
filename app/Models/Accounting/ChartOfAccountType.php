<?php

namespace App\Models\Accounting;

use Illuminate\Database\Eloquent\Model;

class ChartOfAccountType extends Model
{
    protected $connection = 'accounting';

    protected $fillable = [
        'name',
        'created_by',
    ];
}
