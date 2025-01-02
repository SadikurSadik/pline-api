<?php

namespace App\Models;

use App\Enums\ContainerPhotoType;
use App\Enums\ContainerStatus;
use App\Enums\ContainerType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Container extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'customer_user_id',
        'booking_number',
        'container_number',
        'seal_number',
        'vessel',
        'voyage',
        'streamship_line',
        'xtn_number',
        'itn',
        'broker_name',
        'oti_number',
        'terminal',
        'destination',
        'ar_number',
        'loading_date',
        'cut_off_date',
        'export_date',
        'eta_date',
        'arrival_date',
        'contact_detail',
        'bol_note',
        'special_instruction',
        'port_of_loading_id',
        'port_of_discharge_id',
        'container_type',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'status' => ContainerStatus::class,
            'container_type' => ContainerType::class,
            'container_vehicles' => 'array',

        ];
    }

    public function port_of_loading(): BelongsTo
    {
        return $this->belongsTo(Port::class, 'port_of_loading_id');
    }

    public function port_of_discharge(): BelongsTo
    {
        return $this->belongsTo(Port::class, 'port_of_discharge_id');
    }

    public function customer(): HasOne
    {
        return $this->hasOne(Customer::class, 'user_id', 'customer_user_id');
    }

    public function vehicles(): HasMany
    {
        return $this->hasMany(Vehicle::class);
    }

    public function container_photos(): HasMany
    {
        return $this->hasMany(ContainerPhoto::class)->where('type', '=', ContainerPhotoType::CONTAINER_PHOTO->value);
    }

    public function empty_container_photos(): HasMany
    {
        return $this->hasMany(ContainerPhoto::class)->where('type', '=', ContainerPhotoType::EMPTY_CONTAINER_PHOTO->value);
    }

    public function loading_photos(): HasMany
    {
        return $this->hasMany(ContainerPhoto::class)->where('type', '=', ContainerPhotoType::LOADING_PHOTO->value);
    }

    public function loaded_photos(): HasMany
    {
        return $this->hasMany(ContainerPhoto::class)->where('type', '=', ContainerPhotoType::LOADED_PHOTO->value);
    }

    public function documents(): HasMany
    {
        return $this->hasMany(ContainerDocument::class);
    }

    public function houstan_custom_cover_letter(): HasOne
    {
        return $this->hasOne(HoustanCustomCoverLetter::class);
    }

    public function dock_receipt(): HasOne
    {
        return $this->hasOne(DockReceipt::class);
    }
}
