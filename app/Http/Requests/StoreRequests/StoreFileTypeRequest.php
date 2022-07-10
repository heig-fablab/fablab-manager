<?php

namespace App\Http\Requests\StoreRequests;

use Illuminate\Foundation\Http\FormRequest;
use App\Constants\Regex;

class StoreFileTypeRequest extends FormRequest
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
            'name' => ['required', 'string', 'regex:' . Regex::FILE_TYPE_NAME],
            'mime_type' => ['required', 'string', 'max:255', 'regex:' . Regex::MIME_TYPE],
        ];
    }
}
