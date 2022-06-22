<?php

namespace App\Http\Requests\UpdateRequests;

use Illuminate\Foundation\Http\FormRequest;
use App\Constants\Regex;

class UpdateUserEmailNotificationsRequest extends FormRequest
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
            'switch_uuid' => ['required', 'string', 'max:254', 'regex:' . Regex::SWITCH_UUID, 'exists:users,switch_uuid'],
            'require_status_email' => ['required', 'boolean'],
            'require_files_email' => ['required', 'boolean'],
            'require_messages_email' => ['required', 'boolean'],
        ];
    }
}
