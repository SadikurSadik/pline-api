<?php

namespace App\Models\Accounting;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JournalItemDetail extends Model
{
    use HasFactory, SoftDeletes;

    protected $connection = 'accounting';

    protected $fillable = ['journal_item_id', 'type', 'ref_id'];

    public function journal_item()
    {
        return $this->belongsTo(JournalItem::class);
    }
}
