<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
//use App\Http\Resources\MessageResource;
use App\Http\Resources\EventResource;

class JobResource extends JsonResource
{
    //TODO: The timeline, files and messages must be attached to each job as additional properties
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'deadline' => $this->deadline,
            'rating' => $this->rating,
            'working_hours' => $this->working_hours,
            'status' => $this->status,
            'job_category_id' => $this->job_category_id,
            'client_username' => $this->client_username,
            'worker_username' => $this->worker_username,
            'validator_username' => $this->validator_username,
            'files' => $this->files->pluck('name', 'id'),
            //'messages' => MessageResource::collection($this->messages),
            'messages' => $this->messages->pluck('id'),
            'events' => EventResource::collection($this->events),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
