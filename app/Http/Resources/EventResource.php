<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EventResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'type' => $this->type,
            'to_notify' => $this->to_notify,
            'data' => $this->data,
            'user_username' => $this->user_username,
            'created_at' => $this->created_at,
        ];
    }
}
