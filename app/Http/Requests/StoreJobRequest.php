<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreJobRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        // TODO
        return [
            'title' => ['required'],
            'description' => ['nullable'],
            'deadline' => ['required'],
            'rating' => ['nullable'],
            'status' => ['nullable'],
            'category_id' => ['required'],
            'client_switch_uuid' => ['required', 'max:320'],
            'worker_switch_uuid' => ['nullable', 'max:320'],
            'validator_switch_uuid' => ['nullable', 'max:320'],
        ];
    }
}
