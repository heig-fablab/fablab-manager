<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class FileResource extends JsonResource
{
    // TODO: verify if file is downloaded or not
    public function toArray($request)
    {
        $job = null;

        if ($this->job_id != null) {
            $job = array(
                'id' => $this->job->id,
                'title' => $this->job->title,
            );
        }

        return [
            'id' => $this->id,
            'name' => $this->name,
            'file_type' => array(
                'id' => $this->file_type->id,
                'name' => $this->file_type->name,
                'mime_type' => $this->file_type->mime_type,
            ),
            'job' => $job,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
