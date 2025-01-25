<?php

namespace App\Models\Accounting;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LedgerConfiguration extends Model
{
    use HasFactory;

    protected $connection = 'accounting';

    protected $fillable = [
        'inventory_account',
        'sales_account',
        'consumption_account',
        'buyer_membership_account',
        'buyer_deposit_account',
        'buyer_balance_account',
        'buyer_service_charge_account',
        'buyer_storage_fee_account',
        'buyer_late_payment_fee_account',
        'buyer_other_charges_account',
        'buyer_relist_fee_account',
        'buyer_receivable_account',
        'buyer_tax_account',
        'buyer_discount_account',
        'seller_payable_account',
        'seller_fees_account',
        'petty_cash_account',
        'cash_in_hand_account',
        'bank_ledger_account',
        'bank_interest_account',
        'bank_charges_account',
    ];
}
