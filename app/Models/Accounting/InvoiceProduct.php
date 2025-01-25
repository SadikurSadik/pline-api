<?php

namespace App\Models\Accounting;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InvoiceProduct extends Model
{
    use SoftDeletes;

    protected $connection = 'accounting';

    protected $fillable = [
        'product_id',
        'invoice_id',
        'quantity',
        'price',
        'discount',
        'total',
    ];

    public function product()
    {
        return $this->hasOne('App\Models\Accounting\ProductService', 'id', 'product_id');
    }
}
