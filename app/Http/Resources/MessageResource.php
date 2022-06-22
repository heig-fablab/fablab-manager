<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MessageResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'text' => $this->text,
            'sender_switch_uuid' => $this->sender_switch_uuid,
            'receiver_switch_uuid' => $this->receiver_switch_uuid,
            'job' => array(
                'id' => $this->job->id,
                'title' => $this->job->title,
            ),
        ];
    }
}
