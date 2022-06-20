<?php

namespace App\Http\Requests\UpdateRequests;

use Illuminate\Foundation\Http\FormRequest;

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
            'switch_uuid' => ['required', 'string', 'exists:users,switch_uuid'], // TODO: regex
            'require_status_email' => ['required', 'boolean'],
            'require_files_email' => ['required', 'boolean'],
            'require_messages_email' => ['required', 'boolean'],
        ];
    }
}
