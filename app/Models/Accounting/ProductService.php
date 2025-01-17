<?php

namespace App\Models\Accounting;

use Illuminate\Database\Eloquent\Model;

class ProductService extends Model
{
    protected $connection = 'accounting';

    protected $fillable = [
        'vehicle_id',
        'customer_id',
        'name',
        'sku',
        'sale_price',
        'purchase_price',
        'tax_id',
        'category_id',
        'unit_id',
        'type',
        'misc',
        'created_by',
        'created_at',
        'updated_at',
    ];

    protected $casts = ['misc' => 'array'];

    public function taxes()
    {
        return $this->hasOne('App\Models\Accounting\Tax', 'id', 'tax_id')->first();
    }

    public function unit()
    {
        return $this->hasOne('App\Models\Accounting\ProductServiceUnit', 'id', 'unit_id')->first();
    }

    public function category()
    {
        return $this->hasOne('App\Models\Accounting\ProductServiceCategory', 'id', 'category_id');
    }

    public function customer()
    {
        return $this->hasOne(Customer::class, 'customer_id', 'customer_id');
    }
}
