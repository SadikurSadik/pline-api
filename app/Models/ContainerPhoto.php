<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ContainerPhoto extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'container_id',
        'name',
        'thumbnail',
        'type',
    ];
}
