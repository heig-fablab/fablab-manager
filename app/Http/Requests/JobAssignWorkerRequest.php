<?php

namespace App\Http\Requests;

use App\Constants\Regex;
use Illuminate\Foundation\Http\FormRequest;

class JobAssignWorkerRequest extends FormRequest
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
            'worker_username' => ['required', 'string', 'regex:' . Regex::USERNAME, 'exists:users,username'],
        ];
    }
}
