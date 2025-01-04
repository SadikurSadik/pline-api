<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Note extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'vehicle_id',
        'container_id',
        'description',
        'cust_view',
        'admin_view',
        'created_by',
    ];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d h:i:s',
        'updated_at' => 'datetime:Y-m-d h:i:s',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
