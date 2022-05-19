<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class FileResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            //'hash' => $this->hash,
            //'directory' => $this->directory,
            'file_type' => $this->file_type,
            'job' => $this->job,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
