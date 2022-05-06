<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
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
            'switch_uuid' => ['required'],
            'email' => ['required'], 
            'name' => ['required'],
            'surname' => ['required'],
            'password' => ['nullable'],
            'roles' => ['required'],
        ];
    }
}
