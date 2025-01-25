<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ContactUs extends Model
{
    protected $table = 'contact_us';

    protected $fillable = ['customer_user_id', 'name', 'email', 'phone', 'message', 'status'];

    public function customer(): BelongsTo
    {
        $this->belongsTo(Customer::class, 'user_id');
    }
}
