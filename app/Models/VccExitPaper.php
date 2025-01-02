<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class VccExitPaper extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'vcc_id',
        'received_date',
        'refund_amount',
        'status',
        'submission_date',
        'custom_duty_amount',
        'receivable_claim_amount',
        'amount_received_in_bank',
        'date_amount_received_in_bank',
        'received_from',
        'received_by',
        'received_at',
        'submitted_by',
        'submitted_at',
    ];

    public function vcc(): BelongsTo
    {
        return $this->belongsTo(Vcc::class);
    }
}
