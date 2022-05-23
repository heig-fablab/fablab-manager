<?php

namespace App\Http\Requests\StoreRequests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDeviceRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:255'],
            'image_path'  => ['required'],
            'description' => ['required', 'string', 'max:500'],
            'job_categories' => ['required', 'array'],
            'job_categories.*' => ['required', 'integer', 'min:1', 'exists:job_categories,id'],
        ];
    }
}
