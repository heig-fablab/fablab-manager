<?php

namespace App\Http\Requests\StoreRequests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
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
            'switch_uuid' => ['required'],
            'email' => ['required'], 
            'name' => ['required'],
            'surname' => ['required'],
            'password' => ['nullable'],
            'roles' => ['required'],
        ];
    }
}
