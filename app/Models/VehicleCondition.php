<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VehicleCondition extends Model
{
    protected $fillable = [
        'vehicle_id',
        'condition_id',
        'value',
    ];

    public function vehicle(): BelongsTo
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function condition(): BelongsTo
    {
        return $this->belongsTo(Condition::class);
    }
}
