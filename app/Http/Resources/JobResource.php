<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class JobResource extends JsonResource
{
    public function toArray($request)
    {
        // Set up variable that can be null
        $worker = null;
        $validator = null;
        $messages = null;
        $files = null;
        $events = null;

        // Adding values to variable if not null
        if ($this->worker_username != null) {
            $worker = array(
                'username' =>  $this->worker_username,
                'name' => $this->worker->name,
                'surname' => $this->worker->surname,
            );
        }

        if ($this->validator_username != null) {
            $validator = array(
                'username' => $this->validator_username,
                'name' => $this->validator->name,
                'surname' => $this->validator->surname,
            );
        }

        if ($this->messages != null) {
            $messages = MessageResource::collection($this->messages);
        }

        if ($this->files != null) {
            $files = FileResource::collection($this->files);
        }

        if ($this->events != null) {
            $events = EventResource::collection($this->events);
        }

        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'deadline' => $this->deadline,
            'rating' => $this->rating,
            'working_hours' => $this->working_hours,
            'status' => $this->status,
            'job_category' => array(
                'id' => $this->job_category->id,
                'acronym' => $this->job_category->acronym,
                'name' => $this->job_category->name,
            ),
            'client' => array(
                'username' => $this->client_username,
                'name' => $this->client->name,
                'surname' => $this->client->surname,
            ),
            'worker' => $worker,
            'validator' => $validator,
            'files' => $files,
            'messages' => $messages,
            'events' => $events,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
