<?php

namespace App\Http\Resources\Complain;

use Carbon\Carbon;
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
            'created_at' => Carbon::parse($this->created_at)->format('Y-m-d h:i a'),
            'conversations' => ConversationResource::collection($this->conversations),
        ];
    }
}
