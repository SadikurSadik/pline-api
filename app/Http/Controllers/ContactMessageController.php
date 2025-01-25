<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreQueryMessage;
use App\Models\ContactUs;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class ContactMessageController extends Controller
{
    public function store(StoreQueryMessage $request): JsonResponse
    {
        $data = $request->validated();
        $data['name'] = $data['first_name'].' '.$data['last_name'];
        unset($data['first_name']);
        unset($data['last_name']);
        try {
            ContactUs::create($data);

            return response()->json([
                'success' => true,
                'message' => __('Message sent successfully.')
            ]);
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            return response()->json([
                'success' => false,
                'message' => __('Unable to create contact message.'),
                'error' => $e->getMessage(),
            ]);
        }
    }
}
