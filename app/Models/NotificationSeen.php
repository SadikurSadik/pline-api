<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class NotificationSeen extends Model
{
    protected $fillable = [ 'notification_id', 'user_id' ];

    public function notification(): BelongsTo
    {
        return $this->belongsTo( Notification::class );
    }
}
