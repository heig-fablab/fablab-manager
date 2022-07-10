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
            'acronym' => ['required', 'string', 'regex:' . Regex::ACRONYM, 'unique:job_categories,acronym'],
            'name' => ['required', 'string', 'regex:' . Regex::JOB_CATEGORY_NAME],
            'description' => ['sometimes', 'filled', 'string', 'regex:' . Regex::DESCRIPTION_TEXT],
            'file_types' => ['required', 'array'],
            'file_types.*' => ['required', 'string', 'regex:' . Regex::FILE_TYPE_NAME, 'exists:file_types,name'],
            'image' => ['required', 'file', function () {
                return File::is_valid_file($this->file('file'),
                    ['image/png', 'image/jpeg', 'image/svg+xml']
                );
            }],
        ];
    }
}
