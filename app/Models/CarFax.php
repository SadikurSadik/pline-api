<?php

namespace App\Models;

use App\Enums\CarFaxStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class CarFax extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'vin',
        'lot_number',
        'year',
        'make',
        'model',
        'color',
        'document_url',
        'requested_by',
        'carfax_subscription_id',
        'note',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'status' => CarFaxStatus::class,
        ];
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'requested_by', 'user_id');
    }

    protected static function boot(): void
    {
        parent::boot();

        CarFax::creating(function ($model) {
            $model->lot_number = (CarFax::max('lot_number') ?? 100000) + 1;
        });
    }
}
