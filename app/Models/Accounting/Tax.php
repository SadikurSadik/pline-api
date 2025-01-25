<?php

namespace App\Models\Accounting;

use Illuminate\Database\Eloquent\Model;

class Tax extends Model
{
    protected $connection = 'accounting';

    protected $fillable = [
        'name', 'rate', 'created_by',
    ];
}
