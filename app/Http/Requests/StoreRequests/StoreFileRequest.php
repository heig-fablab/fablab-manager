<?php

namespace App\Http\Requests\StoreRequests;

use Illuminate\Foundation\Http\FormRequest;

class StoreFileRequest extends FormRequest
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
            'id_job' => ['required'],
            'file' => ['required'],
            // TODO: verify mime_type via ->extension()
            // TODO: verify file_type via ->getClientOriginalExtension
            /* function ($attribute, $value, $fail) {
            if ($value === 'foo') {
                $fail('The '.$attribute.' is invalid.');
            }
            },*/ // use closure to test extension types of files
            //$extension = $file->extension(); // Determine the file's extension based on the file's MIME type...
        ];
    }
}
