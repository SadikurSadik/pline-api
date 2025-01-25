<?php

namespace App\Models\Accounting;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class InvoicePayment extends Model
{
    use SoftDeletes;

    protected $connection = 'accounting';

    protected $fillable = [
        'invoice_id',
        'date',
        'amount',
        'account_id',
        'payment_method',
        'order_id',
        'currency',
        'txn_id',
        'payment_type',
        'receipt',
        'reference',
        'description',
        'signature_required',
        'signed_at',
        'signature_url',
        'created_by',
        'group_payment_ids',
    ];

    protected $casts = ['group_payment_ids' => 'array'];

    public function invoice(): BelongsTo
    {
        return $this->belongsTo(Invoice::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function bankAccount()
    {
        return $this->hasOne('App\Models\Accounting\BankAccount', 'id', 'account_id');
    }
}
