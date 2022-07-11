<?php

namespace App\Http\Requests;

use App\Constants\Regex;
use Illuminate\Foundation\Http\FormRequest;

class MessageRequest extends FormRequest
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
            'text' => ['required', 'string', 'regex:' . Regex::DESCRIPTION_TEXT],
            'job_id' => ['required', 'integer', 'numeric', 'min:1', 'exists:jobs,id'],
            'sender_username' => ['required', 'string', 'regex:' . Regex::USERNAME, 'exists:users,username'],
            'receiver_username' => ['required', 'string', 'regex:' . Regex::USERNAME, 'exists:users,username']
        ];
    }
}
