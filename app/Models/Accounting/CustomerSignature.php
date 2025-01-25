<?php

namespace App\Models\Accounting;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerSignature extends Model
{
    use HasFactory;

    protected $connection = 'accounting';

    protected $fillable = [
        'type',
        'misc',
        'created_by',
    ];

    protected $casts = ['misc' => 'array'];
}
