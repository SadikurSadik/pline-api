<?php

namespace App\Console\Commands;

use App\Models\Customer;
use App\Services\AccountingService;
use Illuminate\Console\Command;

class SyncCustomerToAccounting extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:customer {id?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle(AccountingService $service)
    {
        $id = $this->argument('id');

        $query = Customer::with(['user', 'country', 'state', 'city']);

        if ($id) {
            $query->where('id', $id);
        }

        foreach ($query->cursor() as $customer) {
            try {
                $service->syncCustomer([
                    'user_id' => $customer->user_id,
                    'name' => $customer->name,
                    'contact' => $customer->phone ?? '',
                    'email' => $customer->user->email,
                    'password' => random_bytes(10),
                    'country' => data_get($customer, 'country.name') ?? '',
                    'state' => data_get($customer, 'state.name') ?? '',
                    'city' => data_get($customer, 'city.name') ?? '',
                ]);
                $this->info("ID {$customer->id} synced successfully.");
            } catch (\Exception $e) {
                $this->error($e->getMessage());
            }
        }
    }
}
