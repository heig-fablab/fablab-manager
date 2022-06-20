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
            'require_status_email' => $this->require_status_email,
            'require_files_email' => $this->require_files_email,
            'require_messages_email' => $this->require_messages_email,
            'roles' => $this->roles->pluck('name'),
        ];
    }
}
