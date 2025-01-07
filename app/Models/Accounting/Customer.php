<?php

namespace App\Models\Accounting;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Customer extends Model
{
    use LogsActivity;

    protected $connection = 'accounting';

    protected $fillable = [
        'customer_id',
        'customer_user_id',
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

    public function getActivitylogOptions(): LogOptions
    {
        $message = '';
        $user = auth()?->user();
        if (! empty($user)) {
            $message = $user->name.' has %s Customer# ';
        }

        return LogOptions::defaults()
            ->setDescriptionForEvent(fn (string $eventName) => sprintf($message, $eventName))
            ->logOnly(['*'])
            ->dontLogIfAttributesChangedOnly(['updated_at', 'last_login_at', 'created_by', 'avatar'])
            ->dontSubmitEmptyLogs();
    }
}
