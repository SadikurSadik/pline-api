<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class CustomerBuyerNumber extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'customer_id',
        'buyer_number_id',
        'assigned_at',
        'unassigned_at',
    ];

    public function customer(): HasOne
    {
        return $this->hasOne(Customer::class, 'user_id', 'customer_id');
    }

    public function buyer_number(): HasOne
    {
        return $this->hasOne(BuyerNumber::class, 'id', 'buyer_number_id');
    }
}
