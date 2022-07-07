<?php

namespace App\Http\Requests\StoreRequests;

use App\Models\Job;
use Illuminate\Foundation\Http\FormRequest;
use App\Models\File;

class StoreFileRequest extends FormRequest
{
    public function authorize()
    {
        // Will be managed in a policy
        return true;
    }

    public function rules()
    {
        return [
            'job_id' => ['required', 'integer', 'numeric', 'min:1', 'exists:jobs,id'],
            // 10Mo max
            'file' => ['required', 'file', 'max:10_000', function ($attribute, $value, $fail) {
                $accepted_file_types = Job::findOrFail($this->job_id)
                    ->job_category->file_types->pluck('name')->toArray();
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
