<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ContainerDocument extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'container_id',
        'name',
        'type',
    ];
}
