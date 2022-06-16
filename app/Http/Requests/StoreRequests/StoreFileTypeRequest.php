<?php

namespace App\Http\Requests\StoreRequests;

use Illuminate\Foundation\Http\FormRequest;

class StoreFileTypeRequest extends FormRequest
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
            'name' => ['required', 'max:255'],
            'mime_type' => ['required', 'max:255'],
        ];
    }
}
