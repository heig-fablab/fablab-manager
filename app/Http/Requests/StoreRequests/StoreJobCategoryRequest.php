<?php

namespace App\Http\Requests\StoreRequests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\File;
use App\Constants\Regex;

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
            'acronym' => ['required', 'string', 'max:3', 'regex:' . Regex::ACRONYM, 'unique:job_categories,acronym'],
            'name' => ['required', 'string', 'max:50', 'regex:' . Regex::JOB_CATEGORY_NAME],
            'description' => ['sometimes', 'filled', 'string', 'max:65535', 'regex:' . Regex::DESCRIPTION],
            'file_types' => ['required', 'array'],
            'file_types.*' => ['required', 'string', 'regex:' . Regex::FILE_TYPE_NAME, 'exists:file_types,name'],
            'image' => ['required', 'file', 'max:100000', function () {
                return File::is_valid_file($this->file('file'),
                    ['image/png', 'image/jpeg', 'image/svg+xml']
                );
            }],
        ];
    }
}
