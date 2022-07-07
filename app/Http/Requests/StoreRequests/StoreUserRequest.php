<?php

namespace App\Http\Requests\StoreRequests;

use Illuminate\Foundation\Http\FormRequest;
use App\Constants\Regex;

class StoreUserRequest extends FormRequest
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
            'username' => ['required', 'string', 'max:17', 'regex:' . Regex::USERNAME, 'unique:users,username'],
            'email' => ['required', 'email', 'max:254', 'unique:users,email'],
            'name' => ['required', 'string', 'max:50', 'regex:' . Regex::NAME],
            'surname' => ['required', 'string', 'max:50', 'regex:' . Regex::NAME],
            'require_status_email' => ['sometimes', 'filled', 'boolean'],
            'require_files_email' => ['sometimes', 'filled', 'boolean'],
            'require_messages_email' => ['sometimes', 'filled', 'boolean'],
            //'roles' => ['required', 'array'],
            //'roles.*' => ['required', 'string', 'regex:' . Regex::ROLE_NAME, 'exists:roles,name'],
            //'roles.*.name' => ['distinct:ignore_case'],
        ];
    }
}
