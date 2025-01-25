<?php

namespace App\Models\Accounting;

use Illuminate\Database\Eloquent\Model;

class ChartOfAccount extends Model
{
    protected $connection = 'accounting';

    protected $fillable = [
        'name',
        'code',
        'type',
        'sub_type',
        'is_enabled',
        'customer_id',
        'description',
        'created_by',
    ];

    public function types()
    {
        return $this->hasOne('App\Models\Accounting\ChartOfAccountType', 'id', 'type');
    }

    public function accounts()
    {
        return $this->hasOne('App\Models\Accounting\JournalItem', 'account', 'id');
    }

    public function balance()
    {
        $journalItem = JournalItem::select(\DB::raw('sum(credit) as totalCredit'), \DB::raw('sum(debit) as totalDebit'), \DB::raw('sum(credit) - sum(debit) as netAmount'))->where('account', $this->id);
        $journalItem = $journalItem->first();
        $data['totalCredit'] = $journalItem->totalCredit;
        $data['totalDebit'] = $journalItem->totalDebit;
        $data['netAmount'] = $journalItem->netAmount;

        return $data;
    }

    public function subType()
    {
        return $this->hasOne('App\Models\Accounting\ChartOfAccountSubType', 'id', 'sub_type');
    }
}
