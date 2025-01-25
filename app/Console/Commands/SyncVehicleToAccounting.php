<?php

namespace App\Console\Commands;

use App\Models\Accounting\Customer;
use App\Models\Vehicle;
use App\Services\AccountingService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class SyncVehicleToAccounting extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:vehicle {id?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function handle(AccountingService $service): void
    {
        $id = $this->argument('id');

        $query = Vehicle::with(['export', 'customer', 'vehicle_image']);

        if ($id) {
            $query->where('id', $id);
        }

        foreach ($query->cursor() as $vehicle) {
            try {
                $accountCustomer = Customer::where('customer_user_id', $vehicle->customer_user_id)->first();
                if (empty($accountCustomer)) {
                    $accountCustomer = $service->syncCustomer([
                        'user_id' => $vehicle->customer->user_id,
                        'name' => $vehicle->customer->name,
                        'contact' => $vehicle->customer->phone ?? '',
                        'email' => $vehicle->customer->user->email,
                        'password' => random_bytes(10),
                        'country' => data_get($vehicle->customer, 'country.name') ?? '',
                        'state' => data_get($vehicle->customer, 'state.name') ?? '',
                        'city' => data_get($vehicle->customer, 'city.name') ?? '',
                    ]);
                }
                $photoUrl = url('images/car-default-photo.png');
                $image = $vehicle->yard_photos->first();
                if ($image && Storage::exists($image->name)) {
                    $photoUrl = Storage::url($image->name);
                }
                $service->syncVehicle([
                    'id' => $vehicle->id,
                    'vin' => $vehicle->vin_number,
                    'lot_number' => $vehicle->lot_number,
                    'customer_id' => $accountCustomer->customer_id,
                    'value' => $vehicle->value ?? 0,
                    'description' => $vehicle->year.' '.$vehicle->make.' '.$vehicle->model,
                    'misc' => array_merge(
                        $vehicle->only([
                            'id',
                            'vin_number',
                            'lot_number',
                            'color',
                            'value',
                            'year',
                            'make',
                            'model',
                            'status',
                            'customer_user_id',
                            'container_number',
                        ]),
                        [
                            'photo_url' => $photoUrl,
                            'arrival_date' => optional($vehicle->container)->arrival_date ?? '',
                            'location_name' => data_get($vehicle, 'state.short_code', '').' - '.data_get($vehicle, 'city.name', ''),
                        ]
                    ),
                    'created_at' => $vehicle->created_at,
                    'updated_at' => $vehicle->updated_at,
                ]);
                $this->info("ID {$vehicle->id} synced successfully.");
            } catch (\Exception $e) {
                $this->error($e->getMessage());
            }
        }
    }
}
