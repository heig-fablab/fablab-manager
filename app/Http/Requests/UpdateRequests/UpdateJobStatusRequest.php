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
        ];
    }
}
