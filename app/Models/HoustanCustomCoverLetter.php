<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HoustanCustomCoverLetter extends Model
{
    protected $fillable = [
        'container_id',
        'vehicle_location',
        'exporter_id',
        'exporter_type_issuer',
        'transportation_value',
        'exporter_dob',
        'ultimate_consignee_dob',
        'consignee_id',
        'notify_party',
        'manifest_consignee',
    ];

    public function consignee_item(): BelongsTo
    {
        return $this->belongsTo(Consignee::class, 'consignee_id');
    }

    public function notify_party_item(): BelongsTo
    {
        return $this->belongsTo(Consignee::class, 'notify_party');
    }

    public function manifest_consignee_item(): BelongsTo
    {
        return $this->belongsTo(Consignee::class, 'manifest_consignee');
    }
}
