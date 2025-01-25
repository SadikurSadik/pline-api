<?php

namespace App\Models;

use App\Enums\VisibilityStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class ShippingRate extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'amount',
        'amount_40feet',
        'amount_45feet',
        'from_country_id',
        'from_state_id',
        'from_yard_id',
        'from_port_id',
        'to_country_id',
        'to_state_id',
        'to_yard_id',
        'to_port_id',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'status' => VisibilityStatus::class,
        ];
    }

    public function from_country(): BelongsTo
    {
        return $this->belongsTo(Country::class, 'from_country_id');
    }

    public function from_state(): BelongsTo
    {
        return $this->belongsTo(State::class, 'from_state_id');
    }

    public function from_port(): BelongsTo
    {
        return $this->belongsTo(Port::class, 'from_port_id');
    }

    public function to_country(): BelongsTo
    {
        return $this->belongsTo(Country::class, 'to_country_id');
    }

    public function to_state(): BelongsTo
    {
        return $this->belongsTo(State::class, 'to_state_id');
    }

    public function to_port(): BelongsTo
    {
        return $this->belongsTo(Port::class, 'to_port_id');
    }
}
