<?php

namespace App\Http\Requests\UpdateRequests;

use Illuminate\Foundation\Http\FormRequest;
use App\Constants\Regex;

class UpdateUserRequest extends FormRequest
{
    protected $stopOnFirstFailure = true;

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'username' => ['required', 'string', 'max:17', 'regex:' . Regex::USERNAME, 'exists:users,username'],
            'email' => ['required', 'email', 'max:254'],
            'name' => ['required', 'string', 'max:50', 'regex:' . Regex::NAME],
            'surname' => ['required', 'string', 'max:50', 'regex:' . Regex::NAME],
            'roles' => ['required', 'array'],
            'roles.*' => ['required', 'string', 'regex:' . Regex::ROLE_NAME, 'exists:roles,name'],
            'roles.*.name' => ['distinct:ignore_case'],
        ];
    }
}
