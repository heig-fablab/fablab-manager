<?php

namespace App\Http\Requests\UpdateRequests;

use Illuminate\Foundation\Http\FormRequest;
use App\Constants\Regex;

class UpdateJobRequest extends FormRequest
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
            'id' => ['required', 'integer', 'numeric', 'min:1', 'exists:jobs,id'],
            'title' => ['required', 'string', 'max:50', 'regex:' . Regex::TITLE],
            'description' => ['sometimes', 'nullable', 'string', 'max:65535', 'regex:' . Regex::DESCRIPTION],
            'deadline' => ['required', 'date_format:"Y-m-d"', 'after:yesterday'],
            'job_category_id' => ['required', 'integer', 'numeric', 'min:1', 'exists:job_categories,id'],
            //'client_switch_uuid' => ['required', 'string', 'max:254', 'regex:' . Regex::SWITCH_UUID],
        ];
    }
}
