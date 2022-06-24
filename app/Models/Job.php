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

    // Service methods
    public static function get_unassigned_jobs()
    {
        return Job::where('worker_username', null)
            ->get();
    }

    public static function get_user_jobs($username)
    {
        return Job::where('client_username', $username)
            ->orWhere('worker_username', $username)
            ->orWhere('validator_username', $username)
            ->where('status', '!=', JobStatus::CLOSED)
            ->get();
    }

    public static function get_client_jobs($username)
    {
        return Job::get_role_jobs($username, Roles::CLIENT);
    }

    public static function get_worker_jobs($username)
    {
        return Job::get_role_jobs($username, Roles::WORKER);
    }

    public static function get_validator_jobs($username)
    {
        return Job::get_role_jobs($username, Roles::VALIDATOR);
    }

    protected static function get_role_jobs($username, $role_user)
    {
        return Job::where($role_user . '_username', $username)
            ->where('status', '!=', JobStatus::CLOSED)
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
    public function requestor()
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
}
