<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use App\Constants\JobStatus;
use App\Constants\Roles;

class Job extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'title',
        'description',
        'deadline',
        'rating',
        'working_hours',
        'status',
        'job_category_id',
        'client_username',
        'worker_username',
        'validator_username'
    ];

    // Default values
    protected $attributes = [
        'status' => JobStatus::NEW,
    ];

    public const JOBS_SUBMITTED_LIMIT = 10;
    public const JOBS_ASSIGNED_LIMIT = 10;

    // Service methods
    public static function get_unassigned_jobs()
    {
        return Job::where('worker_username', null)
            ->where('status', JobStatus::NEW)
            ->get();
    }

    public static function get_user_jobs(string $username)
    {
        $non_closed_jobs = Job::where('status', '<>', JobStatus::CLOSED)->get();
        return $non_closed_jobs->where('client_username', '=', $username)
            ->orWhere('worker_username', '=', $username)
            ->orWhere('validator_username', '=', $username)
            ->get();
    }

    public static function get_client_jobs(string $username)
    {
        return Job::get_role_jobs($username, Roles::CLIENT);
    }

    public static function get_worker_jobs(string $username)
    {
        return Job::get_role_jobs($username, Roles::WORKER);
    }

    public static function get_validator_jobs(string $username)
    {
        return Job::get_role_jobs($username, Roles::VALIDATOR);
    }

    protected static function get_role_jobs(string $username, string $role_user)
    {
        return Job::where($role_user . '_username', '=', $username)
            ->where('status', '<>', JobStatus::CLOSED)
            ->get();
    }

    // Has Many
    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    public function events()
    {
        return $this->hasMany(Event::class);
    }

    public function files()
    {
        return $this->hasMany(File::class);
    }

    // BelongsTo
    public function client()
    {
        return $this->belongsTo(User::class, 'client_username');
    }

    public function worker()
    {
        return $this->belongsTo(User::class, 'worker_username');
    }

    public function validator()
    {
        return $this->belongsTo(User::class, 'validator_username');
    }

    public function job_category()
    {
        return $this->belongsTo(JobCategory::class);
    }

    // Services methods
    public function participate_in_job(User $user)
    {
        return $this->client_username == $user->username
            || $this->worker_username == $user->username
            || $this->validator_username == $user->username;
    }
}
