<?php

namespace App\Http\Requests\StoreRequests;

use Illuminate\Foundation\Http\FormRequest;

class StoreJobRequest extends FormRequest
{
    protected $stopOnFirstFailure = true;

    public function authorize()
    {
        // Will be managed in a policy
        return true;
    }

    public function rules()
    {
        // TODO
        return [
            'title' => ['required', 'string', 'max:100'],
            'description' => ['nullable', 'string', 'max:500'],
            'deadline' => ['required', 'date'], // TODO: check date format
            'job_category_id' => ['required', 'integer', 'exists:job_categories,id'],
            'client_switch_uuid' => ['required', 'max:320'],
            'files' => ['nullable'],
            /*'worker_switch_uuid' => ['nullable', 'max:320'],
            'validator_switch_uuid' => ['nullable', 'max:320'],*/
        ];
    }
}
