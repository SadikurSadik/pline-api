<?php

namespace App\Services;

use App\Models\Accounting\Customer;
use App\Models\Accounting\ProductService;
use App\Models\Accounting\User;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AccountingService
{
    public function syncUser($data): void
    {
        $user = User::where('id', $data['id'])->firstOrNew();
        $user->id = $data['id'];
        $user->name = ! empty($data['name']) ? $data['name'] : '';
        $user->email = $data['email'];
        $user->password = Hash::make($data['password']);
        $user->type = $data['type'];
        $user->created_by = 1;
        $user->lang = 'en';
        $insert = $user->save();

        if ($insert) {
            DB::connection('accounting')
                ->table('model_has_roles')
                ->insertOrIgnore([
                    'role_id' => 4,
                    'model_type' => 'App\Models\User',
                    'model_id' => $user->id,
                ]);
        }
    }

    public function deleteUser($id): void
    {
        User::where(['id' => $id])->delete();
    }

    public function syncCustomer($data)
    {
        $customer = Customer::where('customer_user_id', $data['user_id'])->firstOrNew();
        if (empty($customer->customer_id)) {
            $customer->customer_id = Customer::max('customer_id') + 1;
        }
        $customer->customer_user_id = $data['user_id'];
        $customer->name = $data['name'];
        $customer->contact = $data['contact'];
        $customer->email = $data['email'];
        $customer->tax_number = Arr::get($data, 'tax_number');
        $customer->password = Hash::make(random_bytes(10));
        $customer->created_by = 1;
        $customer->billing_name = Arr::get($data, 'name');
        $customer->billing_country = Arr::get($data, 'country');
        $customer->billing_state = Arr::get($data, 'state');
        $customer->billing_city = Arr::get($data, 'city');
        $customer->billing_phone = $data['contact'];
        $customer->billing_zip = '';
        $customer->billing_address = '';
        $customer->lang = 'en';
        $customer->save();

        return $customer;
    }

    public function syncVehicle($data)
    {
        $vehicle = ProductService::where('vehicle_id', $data['id'])->firstOrNew();
        $vehicle->vehicle_id = $data['id'];
        $vehicle->name = $data['vin'];
        $vehicle->sku = $data['lot_number'];
        $vehicle->customer_id = $data['customer_id'];
        $vehicle->type = 'Car';
        $vehicle->unit_id = 1;
        $vehicle->category_id = 1;
        $vehicle->purchase_price = $data['value'];
        $vehicle->sale_price = $data['value'];
        $vehicle->quantity = 1;
        $vehicle->created_by = 1;
        $vehicle->description = $data['description'];
        $vehicle->misc = $data['misc'] ?? [];
        $vehicle->created_at = $data['created_at'];
        $vehicle->updated_at = $data['updated_at'];
        $vehicle->save();

        return $vehicle;
    }
}
