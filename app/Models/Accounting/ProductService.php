<?php

namespace App\Models\Accounting;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Models\Activity;
use Spatie\Activitylog\Traits\LogsActivity;

class ProductService extends Model
{
    //    use LogsActivity;

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

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['*', 'customer.name'])
            ->setDescriptionForEvent(function (string $eventName) {
                return trans('auth.audit_events.'.$eventName).' Car & Service: '.$this->name.' for '.$this->sale_price;
            })
            ->dontLogIfAttributesChangedOnly(['updated_by', 'updated_at', 'deleted_at'])
            ->dontSubmitEmptyLogs();
    }

    public function tapActivity(Activity $activity, string $eventName)
    {
        $activity->subject_type = str_replace('\Accounting', '', $activity->subject_type);
        //        if( data_get($activity, 'subject.misc.updated_by') ){
        //            $activity->causer_type = 'App\Models\ExtModel\User';
        //            $activity->causer_id = $activity->subject ? data_get($activity, 'subject.misc.updated_by') : null;
        //        }
    }
}
