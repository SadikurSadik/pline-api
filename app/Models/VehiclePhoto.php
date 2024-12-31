<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class VehiclePhoto extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'vehicle_id',
        'name',
        'thumbnail',
        'type',
    ];
}
