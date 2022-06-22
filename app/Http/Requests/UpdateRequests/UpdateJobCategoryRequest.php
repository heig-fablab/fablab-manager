<?php

namespace App\Http\Requests\UpdateRequests;

use Illuminate\Foundation\Http\FormRequest;
use App\Constants\Regex;

class UpdateJobCategoryRequest extends FormRequest
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
            'id' => ['required', 'integer', 'numeric', 'min:1', 'exists:job_categories,id'],
            'acronym' => ['required', 'string', 'max:3', 'regex:' . Regex::ACRONYM],
            'name' => ['required', 'string', 'max:50', 'regex:' . Regex::JOB_CATEGORY_NAME],
            'devices' => ['required', 'array'],
            'devices.*' => ['required', 'integer', 'numeric', 'min:1', 'exists:devices,id'],
            'file_types' => ['required', 'array'],
            'file_types.*' => ['required', 'string', 'regex:' . Regex::FILE_TYPE_NAME, 'exists:file_types,name'],
        ];
    }
}
