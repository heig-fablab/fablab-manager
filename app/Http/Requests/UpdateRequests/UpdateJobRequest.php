<?php

namespace App\Http\Requests\UpdateRequests;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use App\Constants\Regex;

class UpdateJobRequest extends FormRequest
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
            'title' => ['required', 'string', 'regex:' . Regex::TITLE],
            'description' => ['sometimes', 'filled', 'string', 'regex:' . Regex::DESCRIPTION_TEXT],
            'deadline' => ['required', 'date_format:"Y-m-d"', 'after:' . Carbon::now()->addDays(5)->format('Y-m-d')],
            'job_category_id' => ['required', 'integer', 'numeric', 'min:1', 'exists:job_categories,id'],
        ];
    }
}
