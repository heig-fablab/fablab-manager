<?php

namespace App\Http\Requests;

use App\Constants\Regex;
use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
            'username' => ['required', 'string', 'regex:' . Regex::USERNAME],
            'email' => ['required', 'email', 'max:254'],
            'name' => ['required', 'string', 'regex:' . Regex::NAME],
            'surname' => ['required', 'string', 'regex:' . Regex::NAME],
            'roles' => ['required', 'array'],
            'roles.*' => ['required', 'string', 'regex:' . Regex::ROLE_NAME, 'exists:roles,name'],
            'roles.*.name' => ['distinct:ignore_case'],
        ];

        if ($this->isMethod('put')) {
            $rules['username'] = array_merge($rules['username'], [
                'exists:users,username'
            ]);
        } else if ($this->isMethod('post')) {
            $rules['username'] = array_merge($rules['username'], [
                'unique:users,username'
            ]);
            $rules['email'] = array_merge($rules['email'], [
                'unique:users,email'
            ]);
        }

        return $rules;
    }
}
