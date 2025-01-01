<?php

namespace App\Models;

use App\Enums\BooleanStatus;
use App\Enums\VehicleDocumentType;
use App\Enums\VehiclePhotoType;
use App\Enums\VehicleStatus;
use App\Enums\VehicleTowBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vehicle extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'version_number',
        'customer_user_id',
        'container_id',
        'export_id',
        'lot_number',
        'vin_number',
        'year',
        'make',
        'model',
        'color',
        'value',
        'service_provider',
        'auction_name',
        'weight',
        'license_number',
        'check_number',
        'purchase_date',
        'handed_over_date',
        'towed_from',
        'country_id',
        'state_id',
        'city_id',
        'location_id',
        'title_amount',
        'storage_amount',
        'additional_charges',
        'condition',
        'damaged',
        'pictures',
        'towed',
        'title_received',
        'title_received_date',
        'title_number',
        'title_state',
        'towing_request_date',
        'pickup_date',
        'deliver_date',
        'tow_by',
        'tow_fee',
        'title_type_id',
        'keys',
        'note',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'status' => VehicleStatus::class,
            'condition' => BooleanStatus::class,
            'damaged' => BooleanStatus::class,
            'pictures' => BooleanStatus::class,
            'towed' => BooleanStatus::class,
            'keys' => BooleanStatus::class,
            'title_received' => BooleanStatus::class,
            'tow_by' => VehicleTowBy::class,
        ];
    }

    public function getTitleAttribute(): string
    {
        return sprintf('%s %s %s', $this->year, $this->make, $this->model);
    }

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

    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class);
    }

    public function title_type(): BelongsTo
    {
        return $this->belongsTo(TitleType::class);
    }

    public function yard_photos(): HasMany
    {
        return $this->hasMany(VehiclePhoto::class)->where('type', '=', VehiclePhotoType::YARD_PHOTO->value);
    }

    public function auction_photos(): HasMany
    {
        return $this->hasMany(VehiclePhoto::class)->where('type', '=', VehiclePhotoType::AUCTION_PHOTO->value);
    }

    public function pickup_photos(): HasMany
    {
        return $this->hasMany(VehiclePhoto::class)->where('type', '=', VehiclePhotoType::PICKUP_PHOTO->value);
    }

    public function arrived_photos(): HasMany
    {
        return $this->hasMany(VehiclePhoto::class)->where('type', '=', VehiclePhotoType::ARRIVED_PHOTO->value);
    }

    public function documents(): HasMany
    {
        return $this->hasMany(VehicleDocument::class)->where('type', '=', VehicleDocumentType::DOCUMENT->value);
    }

    public function invoices(): HasMany
    {
        return $this->hasMany(VehicleDocument::class)->where('type', '=', VehicleDocumentType::INVOICE->value);
    }

    public function vehicle_conditions(): HasMany
    {
        return $this->hasMany(VehicleCondition::class);
    }

    public function vehicle_features(): HasMany
    {
        return $this->hasMany(VehicleFeature::class);
    }

    protected static function boot(): void
    {
        parent::boot();

        Vehicle::creating(function ($model) {
            $lotNumber = (Vehicle::max('lot_number') ?? 100000) + 1;
            $model->lot_number = $lotNumber;
        });
    }
}
