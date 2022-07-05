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
        // Set up variable that can be null
        $worker = null;
        $validator = null;
        $messages = null;
        $files = null;

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
            ///$messages = $this->messages->pluck('id', 'text');
        }

        if ($this->files != null) {
            $files = $this->files;
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
            'events' => EventResource::collection($this->events),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
