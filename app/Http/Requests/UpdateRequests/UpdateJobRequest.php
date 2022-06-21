<?php

namespace App\Http\Requests\UpdateRequests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateJobRequest extends FormRequest
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
            'title' => ['required', 'string', 'max:100'],
            'description' => ['nullable', 'string', 'max:500'],
            'deadline' => ['required', 'date'], // TODO: check date format
            'job_category_id' => ['required', 'integer', 'min:1', 'exists:job_categories,id'],
            'client_switch_uuid' => ['required', 'max:320'], // TODO: regex
        ];
    }
}
