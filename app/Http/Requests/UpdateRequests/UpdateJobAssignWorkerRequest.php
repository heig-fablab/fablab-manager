<?php

namespace App\Http\Requests\UpdateRequests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateJobAssignWorkerRequest extends FormRequest
{
    protected $stopOnFirstFailure = true;
    
    public function authorize()
    {
        // Will be managed in a policy
        return true;
    }
    
    public function rules()
    {
        return [
            'id' => ['required'],
            'worker_switch_uuid' => ['required', 'max:320'],
        ];
    }
}