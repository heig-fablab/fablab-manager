<?php

namespace App\Http\Requests\UpdateRequests;

use Illuminate\Foundation\Http\FormRequest;
use App\Constants\Regex;

class UpdateJobStatusRequest extends FormRequest
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
            'status' => ['required', 'in:ongoing,on-hold,completed'],
            'worker_username' => ['required', 'string', 'max:17', 'regex:' . Regex::USERNAME, 'exists:users,username'],
            'working_hours' => ['required_if:status,completed', 'numeric', 'min:0', 'max:99'],
        ];
    }
}
