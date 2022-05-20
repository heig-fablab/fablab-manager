<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\JobCategoryResource;

class DeviceResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'image_path' => $this->image_path,
            'description' => $this->description,
            'job_categories' => JobCategoryResource::collection($this->categories),
        ];
    }
}
