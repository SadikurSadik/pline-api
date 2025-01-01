<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vcc extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'vehicle_id',
        'container_id',
        'shipping_invoice_id',
        'declaration_number',
        'declaration_date',
        'received_date',
        'custom_duty',
        'expire_date',
        'status',
        'deposit_amount',
        'handed_over_to',
        'vehicle_registration_type',
        'issued_by',
        'issued_at',
        'handed_over_by',
        'handed_over_at',
        'container_bg_color',
        'vcc_attachment',
        'bill_of_entry_attachment',
        'other_attachment',
        'vcc_exit_data',
    ];

    protected $casts = [
        'vcc_exit_data' => 'array',
    ];

    public function vehicle(): BelongsTo
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function container(): BelongsTo
    {
        return $this->belongsTo(Container::class);
    }

    public function issued_by(): BelongsTo
    {
        return $this->belongsTo(User::class, 'issued_by');
    }

    public function exit_paper(): HasOne
    {
        return $this->hasOne(VccExitPaper::class);
    }

    /*public function shipping_invoice()
    {
        return $this->belongsTo(Invoice::class, 'shipping_invoice_id');
    }

    public function notes()
    {
        return $this->hasMany(AdminNote::class, 'vcc_id', 'id');
    }*/
}
