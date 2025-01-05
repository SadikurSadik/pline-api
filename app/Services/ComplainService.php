<?php

namespace App\Services;

use App\Enums\ReadStatus;
use App\Filters\FilterByCustomerUser;
use App\Filters\FilterByStatus;
use App\Filters\FilterBySubject;
use App\Models\Complain;
use App\Models\Conversation;

class ComplainService
{
    public function all(array $filters = [])
    {
        $query = Complain::with(['customer']);

        return app(FilterPipelineService::class)->apply($query, [
            FilterByStatus::class,
            FilterByCustomerUser::class,
            FilterBySubject::class,
        ], $filters);
    }

    public function getById($id)
    {
        return Complain::with(['customer', 'conversations.sender'])->find($id);
    }

    public function store(array $data)
    {
        return $this->saveComplain($data);
    }

    public function update($id, array $data)
    {
        return $this->saveComplain($data, $id);
    }

    public function destroy($id)
    {
        return Complain::find($id)->delete();
    }

    private function saveComplain($data, $id = null)
    {
        $complain = Complain::findOrNew($id);
        $complain->fill($data);
        $complain->save();

        return $complain;
    }

    public function adminUnreadCount()
    {
        return Complain::where('read_by_admin', ReadStatus::UNREAD)->count();
    }

    public function storeConversation(array $data, $id = null)
    {
        $msg = Conversation::findOrNew($id);
        $msg->fill($data);
        $msg->save();

        return $msg;
    }
}
