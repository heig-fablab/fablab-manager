<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\FileResource;
use App\Http\Resources\MessageResource;

class JobResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        //return parent::toArray($request);
     
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'deadline' => $this->deadline,
            'rating' => $this->rating,
            'status' => $this->status,
            'job_category_id' => $this->job_category_id,
            'client_switch_uuid' => $this->client_switch_uuid,
            'worker_switch_uuid' => $this->worker_switch_uuid,
            'validator_switch_uuid' => $this->validator_switch_uuid,
            'files' => FileResource::collection($this->files),
            'messages' => MessageResource::collection($this->messages),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
