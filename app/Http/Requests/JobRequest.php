<?php

namespace App\Http\Requests;

use App\Constants\Regex;
use App\Models\File;
use App\Models\JobCategory;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class JobRequest extends FormRequest
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
            'title' => ['required', 'string', 'regex:' . Regex::TITLE],
            'description' => ['sometimes', 'filled', 'string', 'regex:' . Regex::DESCRIPTION_TEXT],
            'deadline' => ['required', 'date', 'date_format:"Y-m-d"', 'after:' . Carbon::now()->addDays(5)->format('Y-m-d')],
            'job_category_id' => ['required', 'integer', 'numeric', 'min:1', 'exists:job_categories,id'],

        ];

        if ($this->isMethod('put')) {
            $rules = array_merge($rules, [
                'id' => ['required', 'integer', 'numeric', 'min:1', 'exists:jobs,id'],
            ]);
        } else if ($this->isMethod('post')) {
            $rules = array_merge($rules, [
                'files' => ['sometimes', 'filled', 'max:10', function ($attribute, $value, $fail) {
                    $accepted_file_types = JobCategory::find($this->job_category_id)->file_types->pluck('name')->toArray();
                    if ($accepted_file_types == null) {
                        $fail('Job category related to job not found');
                    }
                    foreach ($this->file('files') as $file) {
                        if (!File::is_valid_file($file, $accepted_file_types)) {
                            $fail($attribute . ' with name ' . $file->getClientOriginalName() . ' is not valid');
                        }
                    }
                    return true;
                }],
                'client_username' => ['required', 'string', 'regex:' . Regex::USERNAME, 'exists:users,username'],
                'worker_username' => ['sometimes', 'nullable', 'string', 'regex:' . Regex::USERNAME, 'exists:users,username'],
                'validator_username' => ['sometimes', 'nullable', 'string', 'regex:' . Regex::USERNAME, 'exists:users,username'],
            ]);
        }

        return $rules;
    }
}
