<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DockReceipt extends Model
{
    protected $fillable = [
        'container_id',
        'awb_number',
        'export_reference',
        'forwarding_agent',
        'domestic_routing_instructions',
        'pre_carriage_by',
        'place_of_receipt_by_pre_carrier',
        'exporting_carrier',
        'final_destination',
        'loading_terminal',
        'container_type',
        'number_of_packages',
        'by',
        'date',
        'auto_receiving_date',
        'auto_cut_off',
        'vessel_cut_off',
        'sale_date',
    ];

    public function container(): BelongsTo
    {
        return $this->belongsTo(Container::class);
    }
}
