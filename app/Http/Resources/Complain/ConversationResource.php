<?php

namespace App\Http\Resources\Complain;

use App\Enums\Role;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ConversationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'model_id' => $this->model_id,
            'message' => $this->message,
            'sender_id' => $this->sender_id,
            'username' => $this->sender?->username,
            'class' => $this->getClassName($this->sender?->role_id),
            'created_at' => $this->created_at,
        ];
    }

    private function getClassName($senderRole): string
    {
        $class = 'you';

        if ((auth()->user()->role_id == Role::CUSTOMER && $senderRole == Role::CUSTOMER) || (auth()->user()->role_id != Role::CUSTOMER && $senderRole != Role::CUSTOMER)) {
            $class = 'me';
        }

        return $class;
    }
}
