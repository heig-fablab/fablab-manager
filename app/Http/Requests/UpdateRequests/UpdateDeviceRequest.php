<?php

namespace App\Http\Requests\UpdateRequests;

use Illuminate\Foundation\Http\FormRequest;
use App\Constants\Regex;

class UpdateDeviceRequest extends FormRequest
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
            'id' => ['required', 'integer', 'numeric', 'min:1', 'exists:devices,id'],
            'name' => ['required', 'string', 'max:50', 'regex:' . Regex::DEVICE_NAME],
            'image_path'  => ['required'],
            'description' => ['sometimes', 'filled', 'string', 'max:65535', 'regex:' . Regex::DESCRIPTION],
            'job_categories' => ['required', 'array'],
            'job_categories.*' => ['required', 'string', 'regex:' . Regex::ACRONYM, 'exists:job_categories,acronym'],
        ];
    }
}
