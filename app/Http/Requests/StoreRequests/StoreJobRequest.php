<?php

namespace App\Http\Requests\StoreRequests;

use Illuminate\Foundation\Http\FormRequest;
use App\Constants\Regex;
use App\Models\JobCategory;
use App\Models\File;

class StoreJobRequest extends FormRequest
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
            'title' => ['required', 'string', 'max:50', 'regex:' . Regex::TITLE],
            'description' => ['sometimes', 'filled', 'string', 'max:65535', 'regex:' . Regex::DESCRIPTION],
            'deadline' => ['required', 'date', 'date_format:"Y-m-d"', 'after:yesterday'],
            'job_category_id' => ['required', 'integer', 'numeric', 'min:1', 'exists:job_categories,id'],
            'files' => ['sometimes', 'filled', 'max:10', function () {
                foreach ($this->file('files') as $file) {
                    if (!File::is_valid_file($file,
                        JobCategory::findOrFail($this->job_category_id)->file_types->pluck('mime_type')->toArray()
                    )) {
                        return false;
                    }
                }
                return true;
            }],
            'files.*' => ['file', 'max:100000000'], // 100Mo max
            'client_username' => ['required', 'string', 'max:17', 'regex:' . Regex::USERNAME, 'exists:users,username'],
            'worker_username' => ['sometimes', 'nullable', 'string', 'max:17', 'regex:' . Regex::USERNAME, 'exists:users,username'],
            'validator_username' => ['sometimes', 'nullable', 'string', 'max:17', 'regex:' . Regex::USERNAME, 'exists:users,username'],
        ];
    }
}
