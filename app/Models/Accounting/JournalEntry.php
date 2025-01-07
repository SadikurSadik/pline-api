<?php

namespace App\Models\Accounting;

use Illuminate\Database\Eloquent\Model;

class JournalEntry extends Model
{
    protected $connection = 'accounting';

    protected $fillable = [
        'date',
        'reference',
        'description',
        'journal_id',
        'created_by',
    ];

    public function accounts()
    {
        return $this->hasmany('App\Models\Accounting\JournalItem', 'journal', 'id');
    }
}
