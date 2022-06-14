<?php

namespace App\Http\Requests\StoreRequests;

use Illuminate\Foundation\Http\FormRequest;

class StoreFileRequest extends FormRequest
{
    public function authorize()
    {
        // Will be managed in a policy
        return true;
    }

    // TODO
    public function rules()
    {
        return [
            'file' => ['required', 'file'],
            'job_id' => ['required', 'integer', 'min:0'],
        ];
    }
}
