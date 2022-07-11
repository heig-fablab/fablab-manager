<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class JobRatingRequest extends FormRequest
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
            'id' => ['required', 'integer', 'numeric', 'min:1', 'exists:jobs,id'],
            'rating' => ['required', 'integer', 'numeric', 'min:1', 'max:6'],
        ];
    }
}
