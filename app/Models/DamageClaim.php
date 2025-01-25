<?php

namespace App\Models;

use App\Enums\DamageClaimStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class DamageClaim extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'vehicle_id',
        'customer_user_id',
        'claim_amount',
        'approved_amount',
        'description',
        'note',
        'photos',
        'attachment',
        'status',
        'approve_reject_by',
        'approve_reject_at',
    ];

    protected function casts(): array
    {
        return [
            'photos' => 'array',
            'approve_reject_at' => 'datetime',
            'status' => DamageClaimStatus::class,
        ];
    }

    public function getTitleAttribute(): string
    {
        return sprintf('%s %s %s', $this->vehicle?->year, $this->vehicle?->make, $this->vehicle?->model);
    }

    public function vehicle(): BelongsTo
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function customer(): HasOne
    {
        return $this->hasOne(Customer::class, 'user_id', 'customer_user_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approve_reject_by', 'id');
    }
}
