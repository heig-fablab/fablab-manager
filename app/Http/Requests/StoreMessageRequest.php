<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMessageRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // Will be managed in a policy
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
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
