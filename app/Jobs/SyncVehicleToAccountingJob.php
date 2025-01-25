<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Artisan;

class SyncVehicleToAccountingJob implements ShouldQueue
{
    use Queueable;

    protected int $vehicleId;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($vehicleId)
    {
        $this->vehicleId = $vehicleId;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Artisan::call('sync:vehicle '.$this->vehicleId);
    }
}
