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
            'sender_username' => $this->sender_username,
            'receiver_username' => $this->receiver_username,
            'job' => array(
                'id' => $this->job->id,
                'title' => $this->job->title,
            ),
        ];
    }
}
