<?php

namespace App\Http\Requests\StoreRequests;

use Illuminate\Foundation\Http\FormRequest;
use App\Constants\Regex;

class StoreMessageRequest extends FormRequest
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
