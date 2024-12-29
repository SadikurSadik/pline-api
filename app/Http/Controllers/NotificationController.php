<?php

namespace App\Http\Controllers;

use App\Http\Resources\Notification\NotificationResource;
use App\Services\NotificationService;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function __construct(protected NotificationService $service) {}

    public function index(Request $request)
    {
        $data = $this->service->all($request->all());

        foreach ($data as $key => $item) {
            $data[$key]['is_read'] = ! empty($item->seen_users->where('user_id', auth()->user()->id)->first());
        }

        return successResponse('', NotificationResource::collection($data)->additional([
            'notifications_count' => $this->service->myUnreadNotificationCount(),
        ]));
    }
}
