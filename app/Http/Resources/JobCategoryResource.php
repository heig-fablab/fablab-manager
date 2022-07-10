<?php

namespace App\Http\Resources;

use App\Models\File;
use Illuminate\Http\Resources\Json\JsonResource;

class JobCategoryResource extends JsonResource
{
    public function toArray($request)
    {
        $image = null;

        if ($this->file != null) {
            $image = array(
                'id' => $this->file->id,
                'name' => $this->file->name,
                'url' => File::get_file_url($this->file),
            );
        }

        return [
            'id' => $this->id,
            'acronym' => $this->acronym,
            'name' => $this->name,
            'description' => $this->description,
            'file_types' => $this->file_types->pluck('name'),
            'image' => $image,
        ];
    }
}
