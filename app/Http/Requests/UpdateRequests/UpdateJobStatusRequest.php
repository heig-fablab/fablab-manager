<?php

namespace App\Http\Requests\UpdateRequests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateJobStatusRequest extends FormRequest
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
            'id' => ['required', 'integer', 'min:1', 'exists:jobs,id'],
            'status' => ['required', 'in:ongoing,on-hold,completed'],
            'worker_switch_uuid' => ['required', 'max:320'], // TODO: regex
            'working_hours' => ['filled', 'numeric', 'min:0', 'max:99'],
        ];
    }
}
