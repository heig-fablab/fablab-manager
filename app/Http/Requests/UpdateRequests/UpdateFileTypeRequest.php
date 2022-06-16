<?php

namespace App\Http\Requests\UpdateRequests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateFileTypeRequest extends FormRequest
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
            'id' => ['required', 'integer', 'min:1', 'exists:file_types,id'],
            'name' => ['required', 'max:255'],
            'mime_type' => ['required', 'max:255'],
        ];
    }
}
