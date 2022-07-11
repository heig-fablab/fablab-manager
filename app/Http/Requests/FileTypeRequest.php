<?php

namespace App\Http\Requests;

use App\Constants\Regex;
use Illuminate\Foundation\Http\FormRequest;

class FileTypeRequest extends FormRequest
{
    protected $stopOnFirstFailure = true;

    public function authorize()
    {
        // Will be managed in a policy
        return true;
    }

    public function rules()
    {
        $rules = [
            'name' => ['required', 'string', 'regex:' . Regex::FILE_TYPE_NAME],
            'mime_type' => ['required', 'string', 'max:255', 'regex:' . Regex::MIME_TYPE],
        ];

        if ($this->isMethod('put')) {
            $rules = array_merge($rules, [
                'id' => ['required', 'integer', 'numeric', 'min:1', 'exists:file_types,id'],
            ]);
        }

        return $rules;
    }
}
