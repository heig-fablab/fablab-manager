<?php

namespace App\Http\Requests\StoreRequests;

use Illuminate\Foundation\Http\FormRequest;

class StoreJobCategoryRequest extends FormRequest
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
            'acronym' => ['required', 'string', 'max:10'],
            'name' => ['required', 'string', 'max:50'],
            'devices' => ['required', 'array'],
            'devices.*' => ['required', 'integer', 'min:1', 'exists:devices,id'],
            'file_types' => ['required', 'array'],
            'file_types.*' => ['required', 'integer', 'min:1', 'exists:file_types,id'],
        ];
    }
}
