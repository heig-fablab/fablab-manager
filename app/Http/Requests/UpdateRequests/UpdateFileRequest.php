<?php

namespace App\Http\Requests\UpdateRequests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateFileRequest extends FormRequest
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
            'id' => ['required', 'integer', 'min:0', 'exists:files,id'],
            'file' => ['required', 'file'],
            'job_id' => ['required', 'integer', 'min:0', 'exists:jobs,id'],
        ];
    }
}
