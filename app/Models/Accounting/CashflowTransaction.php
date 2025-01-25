<?php

namespace App\Models\Accounting;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CashflowTransaction extends Model
{
    use HasFactory, SoftDeletes;

    protected $connection = 'accounting';

    protected $fillable = [
        'name',
        'date',
        'description',
        'amount',
        'type',
        'account',
        'voucher_number',
        'payment_mode',
        'owner_approve_reject_at',
        'owner_approval_status',
        'app_reject_note',
        'signature_required',
        'signed_at',
        'signature_url',
        'deleted_at',
    ];

    public function payment_method()
    {
        return $this->hasOne('App\Models\Accounting\BankAccount', 'id', 'payment_mode');
    }
}
