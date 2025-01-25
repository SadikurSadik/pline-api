<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Artisan;

class SyncCustomerToAccountingJob implements ShouldQueue
{
    use Queueable;

    protected int $customerId;

    /**
     * Create a new job instance.
     */
    public function __construct($customerId)
    {
        $this->customerId = $customerId;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Artisan::call('sync:customer '.$this->customerId);
    }
}
