<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'switch_uuid' => $this->switch_uuid,
            'email' => $this->email,
            'name' => $this->name,
            'surname' => $this->surname,
        ];
    }
}
