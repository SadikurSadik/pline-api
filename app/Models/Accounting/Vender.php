<?php

namespace App\Models\Accounting;

use Illuminate\Database\Eloquent\Model;

class Vender extends Model
{
    protected $connection = 'accounting';

    protected $fillable = [
        'vender_id',
        'name',
        'email',
        'password',
        'contact',
        'avatar',
        'is_active',
        'created_by',
        'email_verified_at',
        'billing_name',
        'billing_country',
        'billing_state',
        'billing_city',
        'billing_phone',
        'billing_zip',
        'billing_address',
        'shipping_name',
        'shipping_country',
        'shipping_state',
        'shipping_city',
        'shipping_phone',
        'shipping_zip',
        'shipping_address',
        'last_login_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];
}
