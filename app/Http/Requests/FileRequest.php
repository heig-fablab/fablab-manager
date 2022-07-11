<?php

namespace App\Http\Requests;

use App\Models\File;
use App\Models\Job;
use Illuminate\Foundation\Http\FormRequest;

class FileRequest extends FormRequest
{
    public function authorize()
    {
        // Will be managed in a policy
        return true;
    }

    public function rules()
    {
        $rules = [];

        if ($this->isMethod('post')) {
            $rules = array_merge($rules, [
                'job_id' => ['required', 'integer', 'numeric', 'min:1', 'exists:jobs,id'],
            ]);
        } else if ($this->isMethod('put')) {
            $rules = array_merge($rules, [
                'id' => ['required', 'integer', 'numeric', 'min:1', 'exists:files,id'],
            ]);
        }

        $rules = array_merge($rules, [
            'file' => ['required', 'file', function ($attribute, $value, $fail) {
                if ($this->job_id == null) {
                    $this->job_id = File::find($this->id)->job->id;
                }

                $accepted_file_types = Job::find($this->job_id)
                    ->job_category->file_types->pluck('name')->toArray();

                if ($accepted_file_types == null) {
                    $fail('Job category related to job not found');
                }
                if (!File::is_valid_file($this->file('file'), $accepted_file_types)) {
                    $fail($attribute . ' is not valid');
                }
                return true;
            }],
        ]);

        return $rules;
    }
}
