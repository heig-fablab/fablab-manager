<?php

namespace App\Http\Requests\UpdateRequests;

use Illuminate\Foundation\Http\FormRequest;
use App\Constants\Regex;

class UpdateFileTypeRequest extends FormRequest
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
            'id' => ['required', 'integer', 'numeric', 'min:1', 'exists:file_types,id'],
            'name' => ['required', 'string', 'max:10', 'regex:' . Regex::FILE_TYPE_NAME],
            'mime_type' => ['required', 'string', 'max:255', 'regex:' . Regex::MIME_TYPE],
        ];
    }
}
