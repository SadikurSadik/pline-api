<?php

namespace App\Http\Controllers;

use App\Enums\Role;
use App\Models\Customer;
use App\Servivces\DashboardService;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct(protected DashboardService $service){}

    public function statusOverview( Request $request ): \Illuminate\Http\JsonResponse
    {
        $filters = $request->all();
        if ( auth()->user()->role_id == Role::CUSTOMER ) {
            $filters[ 'user_id' ] = auth()->user()->id;
        } elseif ( !empty( $filters[ 'customer_id' ] ) ) {
            $customer = Customer::find( $filters[ 'customer_id' ] );
            if ( $customer ) {
                $filters[ 'user_id' ] = $customer->user_id;
            }
        }
        $data = $this->service->vehicleCounts( $filters );

        return response()->json( $data );
    }
}
