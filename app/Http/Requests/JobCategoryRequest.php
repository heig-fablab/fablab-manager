<?php

namespace App\Http\Requests;

use App\Constants\Regex;
use App\Models\File;
use Illuminate\Foundation\Http\FormRequest;

class JobCategoryRequest extends FormRequest
{
    protected $stopOnFirstFailure = true;

    public function authorize()
    {
        // Will be managed in a policy
        return true;
    }

    public function rules()
    {
        $rules = [
            'acronym' => ['required', 'string', 'regex:' . Regex::ACRONYM],
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

        if ($this->isMethod('put')) {
            $rules = array_merge($rules, [
                'id' => ['required', 'integer', 'numeric', 'min:1', 'exists:job_categories,id'],
            ]);
        } else if ($this->isMethod('post')) {
            $rules['acronym'] = array_merge($rules['acronym'], [
                'unique:job_categories,acronym'
            ]);
        }

        return $rules;
    }
}
