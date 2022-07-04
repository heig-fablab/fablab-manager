<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class FileResource extends JsonResource
{
    // TODO: verify if file is downloaded or not
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            //'hash' => $this->hash,
            //'directory' => $this->directory,
            'file_type' => array(
                'id' => $this->file_type->id,
                'name' => $this->file_type->name,
                'mime_type' => $this->file_type->mime_type,
            ),
            'job' => array(
                'id' => $this->job->id,
                'title' => $this->job->title,
            ),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
