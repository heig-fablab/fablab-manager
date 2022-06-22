<?php

namespace App\Http\Requests\StoreRequests;

use Illuminate\Foundation\Http\FormRequest;
use App\Constants\Regex;
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
                    if (!File::is_valid_file($file, $this->job_category_id, -1)) {
                        return false;
                    }
                }
                return true;
            }],
            'files.*' => ['file', 'max:100000000'], // 100Mo max
            'client_switch_uuid' => ['required', 'string', 'max:254', 'regex:' . Regex::SWITCH_UUID, 'exists:users,switch_uuid'],
            'worker_switch_uuid' => ['sometimes', 'nullable', 'string', 'max:254', 'regex:' . Regex::SWITCH_UUID, 'exists:users,switch_uuid'],
            'validator_switch_uuid' => ['sometimes', 'nullable', 'string', 'max:254', 'regex:' . Regex::SWITCH_UUID, 'exists:users,switch_uuid'],
        ];
    }
}
