<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PricingPdf extends Model
{
    use SoftDeletes;

    protected $fillable = ['pdf_url_a', 'pdf_url_b', 'pdf_url_c', 'pdf_url_d', 'user_id', 'expire_at'];
}
