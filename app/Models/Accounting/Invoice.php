<?php

namespace App\Models\Accounting;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Invoice extends Model
{
    use SoftDeletes;

    protected $connection = 'accounting';

    protected $fillable = [
        'invoice_id',
        'invoice_id_str',
        'customer_id',
        'inventory_id',
        'issue_date',
        'due_date',
        'ref_number',
        'aed_rate',
        'status',
        'category_id',
        'ak_type',
        'total_amount',
        'total_paid',
        'total_due',
        'line_items',
        'created_by',
        'update_by',
        'updated_at',
    ];

    protected $casts = [
        'line_items' => 'array',
    ];

    public static $statues = [
        'Draft',
        'Unpaid',
        'Unpaid',
        'Partially Paid',
        'Paid',
    ];

    public function items()
    {
        return $this->hasMany('App\Models\Accounting\InvoiceProduct', 'invoice_id', 'id');
    }

    public function getSubTotal()
    {
        $subTotal = 0;
        foreach ($this->items as $product) {
            $subTotal += ($product->price * $product->quantity);
        }

        return round($subTotal, 2);
    }

    public function getTotalTax()
    {
        return 0;
    }

    public function getTotalDiscount()
    {
        return round($this->discount, 2);
    }

    public function getTotal()
    {
        return round($this->getSubTotal() - $this->getTotalDiscount(), 2);
    }

    public function getDue()
    {
        $due = 0;
        foreach ($this->payments as $payment) {
            $due += $payment->amount;
        }

        return round($this->getTotal() - $due, 2);
    }

    public function getPaid()
    {
        $paid = 0;
        foreach ($this->payments as $payment) {
            $paid += $payment->amount;
        }

        return round($paid, 2);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'customer_id');
    }

    public function inventory()
    {
        return $this->belongsTo(ProductService::class);
    }

    public function totalTaxRate($taxes)
    {
        $taxRate = 0;

        return $taxRate;
    }

    public function payments()
    {
        return $this->hasMany('App\Models\Accounting\InvoicePayment', 'invoice_id', 'id');
    }

    public function invoiceTotalCreditNote()
    {
        return $this->hasMany('App\Models\Accounting\CreditNote', 'invoice', 'id')->sum('amount');
    }
}
