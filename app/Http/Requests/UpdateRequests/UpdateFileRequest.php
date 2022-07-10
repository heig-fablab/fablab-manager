<?php

namespace App\Http\Requests\UpdateRequests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\File;
use App\Models\Job;
use Illuminate\Support\Facades\Log;

class UpdateFileRequest extends FormRequest
{
    public function authorize()
    {
        // Will be managed in a policy
        return true;
    }

    public function rules()
    {
        return [
            'id' => ['required', 'integer', 'numeric', 'min:1', 'exists:files,id'],
            // TODO: perhaps create a specific rule
            'file' => ['required', 'file', function ($attribute, $value, $fail) {
                $file = File::find($this->id);
                $accepted_file_types = Job::find($file->job_id)
                    ->job_category
                    ->file_types
                    ->pluck('name')
                    ->toArray();
                if ($accepted_file_types == null) {
                    $fail('Job category related to job not found');
                }
                if (!File::is_valid_file($this->file('file'), $accepted_file_types)) {
                    $fail($attribute . ' is not valid');
                }
                return true;
            }],
        ];
    }
}
