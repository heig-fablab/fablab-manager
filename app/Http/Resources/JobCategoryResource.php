<?php

namespace App\Http\Resources;

use App\Models\File;
use Illuminate\Http\Resources\Json\JsonResource;

class JobCategoryResource extends JsonResource
{
    // TODO: verify if file is downloaded or not
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'acronym' => $this->acronym,
            'name' => $this->name,
            'description' => $this->description,
            'file_types' => $this->file_types->pluck('name'),
            'image' => File::get_file($this->file),//FileResource::collection($this->file),
        ];
    }
}
