<?php

namespace App\Services;

use App\Models\Notification;
use Carbon\Carbon;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class NotificationService
{
    public function all(array $filters = []): Collection|LengthAwarePaginator
    {
        $query = Notification::with('seen_users');

        if (! empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (! empty($filters['subject'])) {
            $query->where(DB::raw('LOWER(subject)'), 'LIKE', '%'.strtolower(trim($filters['subject'])).'%');
        }

        if (! empty($filters['expire_date'])) {
            $query->where('expire_date', $filters['expire_date']);
        }

        $limit = Arr::get($filters, 'limit', 20);
        $query->orderBy(Arr::get($filters, 'order_by_column', 'id'), Arr::get($filters, 'order_by', 'desc'));

        return $limit != '-1' ? $query->paginate($limit) : $query->get();
    }

    public function getById($id)
    {
        return Notification::find($id);
    }

    public function store(array $data)
    {
        return $this->saveNotification($data);
    }

    public function update($id, array $data)
    {
        return $this->saveNotification($data, $id);
    }

    public function destroy($id)
    {
        return Notification::find($id)->delete();
    }

    private function saveNotification($data, $id = null)
    {
        $location = Notification::findOrNew($id);
        $location->fill($data);
        $location->save();

        return $location;
    }

    public function myUnreadNotificationCount($userId = null)
    {
        if (empty($userId)) {
            $userId = auth()->user()->id;
        }

        return Notification::whereDate('expire_date', '>', Carbon::now()->format('Y-m-d'))
            ->whereDoesntHave('seen_users', function ($q) use ($userId) {
                $q->where('user_id', $userId);
            })->count();
    }

    public function nonExpiredNotificationCount()
    {
        return Notification::where('expire_date', '>', date('Y-m-d'))->count();
    }
}
