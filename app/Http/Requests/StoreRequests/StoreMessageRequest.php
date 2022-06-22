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
            'text' => ['required', 'string', 'max:65535', 'regex:' . Regex::DESCRIPTION],
            'job_id' => ['required', 'integer', 'numeric', 'min:1', 'exists:jobs,id'],
            'sender_switch_uuid' => ['required', 'string', 'max:254', 'regex:' . Regex::SWITCH_UUID, 'exists:users,switch_uuid'],
            'receiver_switch_uuid' => ['required', 'string', 'max:254', 'regex:' . Regex::SWITCH_UUID, 'exists:users,switch_uuid']
        ];
    }
}
