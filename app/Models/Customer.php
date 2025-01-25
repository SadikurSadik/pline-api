<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    /** @use HasFactory<\Database\Factories\CustomerFactory> */
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'customer_id',
        'user_id',
        'name',
        'company_name',
        'phone',
        'phone_two',
        'trn',
        'address',
        'buyer_ids',
        'country_id',
        'state_id',
        'city_id',
        'category',
        'documents',
        'block_issue_vcc',
    ];

    protected $casts = [
        'buyer_ids' => 'array',
        'documents' => 'array',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
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

    public function vehicles(): HasMany
    {
        return $this->hasMany(Vehicle::class, 'customer_user_id', 'user_id');
    }

    public function containers(): HasMany
    {
        return $this->hasMany(Vehicle::class, 'customer_user_id', 'user_id');
    }

    public function consignees(): HasMany
    {
        return $this->hasMany(Consignee::class, 'customer_user_id', 'user_id');
    }

    protected static function boot(): void
    {
        parent::boot();

        Customer::creating(function ($model) {
            $model->customer_id = (Customer::max('customer_id') ?? 2025000) + 1;
        });
    }
}
