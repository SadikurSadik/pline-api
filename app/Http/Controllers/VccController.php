<?php

namespace App\Http\Controllers;

use App\Services\VccService;
use Illuminate\Http\Request;

class VccController extends Controller
{
    public function __construct(protected VccService $service) {}

    public function index(Request $request)
    {
        return $this->service->all($request->all());
    }
}
