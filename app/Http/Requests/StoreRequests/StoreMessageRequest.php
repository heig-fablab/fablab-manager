<?php

namespace App\Http\Requests\StoreRequests;

use Illuminate\Foundation\Http\FormRequest;

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
        // TODO
        return [
            'text' => ['required', 'string', 'max:255'],
            'job_id' => ['required', 'integer'],
            'sender_switch_uuid' => ['required', 'string', 'max:320'],
            'receiver_switch_uuid' => ['required', 'string', 'max:320']
        ];
    }
}
