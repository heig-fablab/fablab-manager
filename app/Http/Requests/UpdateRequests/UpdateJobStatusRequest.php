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
            'id' => ['required', 'integer', 'exists:jobs,id'],
            'status' => ['required', 'in:new,validated,assigned,ongoing,on-hold,completed'],
            'rating' => ['nullable', 'integer', 'min:1', 'max:6'],
        ];
    }
}
