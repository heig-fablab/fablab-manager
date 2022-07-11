<?php

namespace App\Http\Requests;

use App\Constants\Regex;
use Illuminate\Foundation\Http\FormRequest;

class UserEmailNotificationsRequest extends FormRequest
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
            'username' => ['required', 'string', 'regex:' . Regex::USERNAME, 'exists:users,username'],
            'require_status_email' => ['required', 'boolean'],
            'require_files_email' => ['required', 'boolean'],
            'require_messages_email' => ['required', 'boolean'],
        ];
    }
}
