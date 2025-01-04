<?php

namespace App\Http\Controllers;

use App\Http\Resources\BuyerNumber\BuyerNumberResource;
use App\Services\BuyerNumberService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class BuyerNumberController extends Controller
{
    public function __construct(protected BuyerNumberService $service) {}

    public function index(Request $request): AnonymousResourceCollection
    {
        $data = $this->service->all($request->all());

        return BuyerNumberResource::collection($data);
    }

}
