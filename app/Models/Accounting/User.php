<?php

namespace App\Models\Accounting;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $connection = 'accounting';

    protected $fillable = [
        'name',
        'email',
        'password',
        'type',
        'avatar',
        'lang',
        'delete_status',
        'created_by',
        'signature_url',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];
}
