<?php

namespace App\Models\Accounting;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Crypt;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Models\Activity;
use Spatie\Activitylog\Traits\LogsActivity;

class Invoice extends Model
{
    //    use LogsActivity, SoftDeletes;
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

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->setDescriptionForEvent(function (string $eventName) {
                return trans('auth.audit_events.'.$eventName)." <a href='".env('ACCOUNTING_APP_URL').'/invoice/'.Crypt::encrypt($this->id)."'>Invoice No.".$this->invoice_id_str.'</a> for '.optional($this->customer)->name.':'.optional($this->inventory)->name.' for '.$this->total_amount;
            })
            ->logOnly(['*'])
            ->dontLogIfAttributesChangedOnly(['deleted_at', 'deleted_by', 'updated_at'])
            ->dontSubmitEmptyLogs();
    }

    public function tapActivity(Activity $activity, string $eventName)
    {
        $activity->subject_type = str_replace('\Accounting', '', $activity->subject_type);
        //        if( data_get($activity, 'subject.inventory.misc.updated_by') ) {
        //            $activity->causer_type = 'App\Models\ExtModel\User';
        //            $activity->causer_id = $activity->subject ? data_get($activity, 'subject.inventory.misc.updated_by') : null;
        //        }
    }
}
