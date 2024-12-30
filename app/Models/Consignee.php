<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Consignee extends Model
{
    /** @use HasFactory<\Database\Factories\ConsigneeFactory> */
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'customer_user_id',
        'name',
        'phone',
        'address',
        'country_id',
        'state_id',
        'city_id',
    ];

    public function customer(): HasOne
    {
        return $this->hasOne(Customer::class, 'user_id', 'customer_user_id');
    }

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }

    public function state(): BelongsTo
    {
        return $this->belongsTo(State::class);
    }

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }
}
