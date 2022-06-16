<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\DeviceResource;
use App\Http\Resources\FileTypeResource;

class JobCategoryResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'acronym' => $this->acronym,
            'name' => $this->name,
            'devices' => $this->devices->pluck('name', 'id'),
            'file_types' => $this->file_types->pluck('name', 'id'),
        ];
    }
}
