<?php

namespace App\Models\Accounting;

use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
{
    protected $connection = 'accounting';

    protected $fillable = [
        'name', 'created_by', 'description',
    ];
}
