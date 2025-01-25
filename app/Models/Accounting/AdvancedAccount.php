<?php

namespace App\Models\Accounting;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AdvancedAccount extends Model
{
    use HasFactory, SoftDeletes;

    protected $connection = 'accounting';

    protected $fillable = [
        'customer_id',
        'date',
        'voucher_no',
        'note',
        'used_amount',
        'amount',
        'file',
        'status',
        'payment_mode',
        'app_reject_note',
        'owner_approve_reject_at',
        'owner_approval_status',
        'signature_required',
        'signed_at',
        'signature_url',
        'created_by',
        'deleted_by',
    ];

    public function getCashierSignatureAttribute()
    {
        return 'https://vaccount.olfatshipping.com/'.(! empty($this->creator?->signature_url) ? $this->creator->signature_url : 'assets/images/cashier_signature.png');
    }

    public function payment_method()
    {
        return $this->hasOne('App\Models\Accounting\BankAccount', 'id', 'payment_mode');
    }

    public function customer()
    {
        return $this->hasOne('App\Models\Accounting\Customer', 'customer_id', 'customer_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function scopeWithoutNonCash(Builder $query)
    {
        $query->where('payment_mode', '!=', 4);
    }
}
