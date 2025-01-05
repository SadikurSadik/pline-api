<?php

namespace App\Http\Resources\Complain;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ComplainResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'customer_user_id' => $this->customer_user_id,
            'subject' => $this->subject,
            'customer_name' => $this->customer?->name,
            'message' => $this->message,
            'status' => $this->status,
            'read_by_admin' => $this->read_by_admin,
            'created_at' => $this->created_at,
            'conversations' => ConversationResource::collection($this->conversations),
        ];
    }
}
