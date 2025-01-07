<?php

namespace App\Http\Controllers;

use App\Enums\Role;
use App\Http\Resources\Pricing\PricingResource;
use App\Models\Customer;
use App\Models\PricingPdf;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\DB;

class PricingController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        $category = 'a';
        if (optional(auth()->user())->role === Role::CUSTOMER) {
            $customer = Customer::where('user_id', auth()->user()->id)->firstOrFail();
            if (in_array($customer->category, ['a', 'b'])) {
                $category = $customer->category;
            }
        }

        $data = PricingPdf::select([
            'id',
            DB::raw("pdf_url_{$category} AS pdf_url"),
            'expire_at',
            'created_at',
        ])->orderBy('id', 'desc')
            ->get();

        return PricingResource::collection($data);
    }
}
