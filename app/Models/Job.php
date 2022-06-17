<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

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
        'client_switch_uuid',
        'worker_switch_uuid',
        'validator_switch_uuid'
    ];

    // Job Status values
    public const S_NEW = 'new';
    public const S_VALIDATED = 'validated';
    public const S_ASSIGNED = 'assigned';
    public const S_ONGOING = 'ongoing';
    public const S_ON_HOLD = 'on-hold';
    public const S_COMPLETED = 'completed';
    public const S_CLOSED = 'closed';

    // Default values
    protected $attributes = [
        'status' => Job::S_NEW,
    ];

    // Service methods
    public static function get_unassigned_jobs()
    {
        return Job::where('worker_switch_uuid', null)
            ->get();
    }

    public static function get_user_jobs($switch_uuid)
    {
        return Job::where('client_switch_uuid', $switch_uuid)
            ->orWhere('worker_switch_uuid', $switch_uuid)
            ->orWhere('validator_switch_uuid', $switch_uuid)
            ->where('status', '!=', Job::S_CLOSED)
            ->get();
    }

    public static function get_client_jobs($switch_uuid)
    {
        return Job::get_role_jobs($switch_uuid, 'client');
    }

    public static function get_worker_jobs($switch_uuid)
    {
        return Job::get_role_jobs($switch_uuid, 'worker');
    }

    public static function get_validator_jobs($switch_uuid)
    {
        return Job::get_role_jobs($switch_uuid, 'validator');
    }

    protected static function get_role_jobs($switch_uuid, $role_user)
    {
        return Job::where($role_user . '_switch_uuid', $switch_uuid)
            ->where('status', '!=', Job::S_CLOSED)
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
        return $this->belongsTo(User::class, 'client_switch_uuid');
    }

    public function worker()
    {
        return $this->belongsTo(User::class, 'worker_switch_uuid');
    }

    public function validator()
    {
        return $this->belongsTo(User::class, 'validator_switch_uuid');
    }

    public function job_category()
    {
        return $this->belongsTo(JobCategory::class);
    }
}
