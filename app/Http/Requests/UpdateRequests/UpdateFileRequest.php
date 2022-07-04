<?php

namespace App\Http\Requests\UpdateRequests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\File;
use App\Models\Job;

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
            'job_id' => ['required', 'integer', 'numeric', 'min:1', 'exists:jobs,id'],
            // 100Mo max
            'file' => ['required', 'file', 'max:100000', function () {
                return File::is_valid_file($this->file('file'),
                    Job::findOrFail($this->job_id)
                        ->job_category->file_types->pluck('mime_type')->toArray()
                );
            }],
        ];
    }
}
