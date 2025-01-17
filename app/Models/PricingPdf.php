<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PricingPdf extends Model
{
    use SoftDeletes;

    protected $table = 'pricing_pdfs';

    protected $fillable = ['pdf_url_a', 'pdf_url_b', 'user_id', 'expire_at'];
}
