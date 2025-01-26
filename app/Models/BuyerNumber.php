<?php

namespace App\Models;

use App\Enums\VisibilityStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class BuyerNumber extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'sheet_id',
        'buyer_id',
        'username',
        'password',
        'auction_name',
        'account_name',
        'account_type',
        'parent_id',
        'company_name',
        'grade_id',
        'note',
        'attachments',
        'status',
    ];

    protected $casts = [
        'status' => VisibilityStatus::class,
        'attachments' => 'array',
    ];

    public function sheet(): HasOne
    {
        return $this->hasOne(Sheet::class, 'id', 'sheet_id');
    }

    public function grade(): HasOne
    {
        return $this->hasOne(Grade::class, 'id', 'grade_id');
    }

    public function vehicles(): HasMany
    {
        return $this->hasMany(Vehicle::class, 'license_number', 'buyer_id');
    }

    public function buyer_customers(): HasMany
    {
        return $this->hasMany(CustomerBuyerNumber::class, 'buyer_number_id', 'id');
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(self::class, 'parent_id', 'id');
    }
}
