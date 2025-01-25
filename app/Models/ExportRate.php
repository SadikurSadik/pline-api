<?php

namespace App\Models;

use App\Enums\VisibilityStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class ExportRate extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'rate',
        'rate_a',
        'rate_b',
        'from_country_id',
        'to_country_id',
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

    public function to_country(): BelongsTo
    {
        return $this->belongsTo(Country::class, 'to_country_id');
    }
}
