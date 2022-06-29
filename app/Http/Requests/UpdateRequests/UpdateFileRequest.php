<?php

namespace App\Http\Requests\UpdateRequests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\File;

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
            'id' => ['required', 'integer', 'numeric', 'min:1', 'exists:files,id'],
            // 100Mo max
            'file' => ['required', 'file', 'max:100000', function () {
                return File::is_valid_file($this->file('file'), -1, $this->job_id);
            }],
            'job_id' => ['required', 'integer', 'numeric', 'min:1', 'exists:jobs,id'],
        ];
    }
}
