<?php

namespace App\Http\Resources\Note;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AdminNoteResource extends JsonResource
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
            'create_by' => $this->user->name,
            'description' => $this->description,
            'created_at' => dateTimeFormat($this->created_at),
        ];
    }
}
