<?php

namespace App\Http\Requests\StoreRequests;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use App\Constants\Regex;
use App\Models\JobCategory;
use App\Models\File;

class StoreJobRequest extends FormRequest
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
            'title' => ['required', 'string', 'max:50', 'regex:' . Regex::TITLE],
            'description' => ['sometimes', 'filled', 'string', 'max:65535', 'regex:' . Regex::DESCRIPTION],
            'deadline' => ['required', 'date', 'date_format:"Y-m-d"', 'after:' . Carbon::now()->addDays(5)->format('Y-m-d')],
            'job_category_id' => ['required', 'integer', 'numeric', 'min:1', 'exists:job_categories,id'],
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
            'files.*' => ['file', 'max:10_000_000'], // 10Mo max
            'client_username' => ['required', 'string', 'max:17', 'regex:' . Regex::USERNAME, 'exists:users,username'],
            'worker_username' => ['sometimes', 'nullable', 'string', 'max:17', 'regex:' . Regex::USERNAME, 'exists:users,username'],
            'validator_username' => ['sometimes', 'nullable', 'string', 'max:17', 'regex:' . Regex::USERNAME, 'exists:users,username'],
        ];
    }
}
