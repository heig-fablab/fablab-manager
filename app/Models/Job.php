<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Job extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'title',
        'description',
        'deadline',
        'rating',
        'status',
        'id_category',
        'client_switch_uuid',
        'worker_switch_uuid',
        'validator_switch_uuid'
    ];

    // Default values
    protected $attributes = [
        'status' => 'new',
    ];

    // Service methods
    public static function get_user_jobs($switch_uuid)
    {
        return Job::where('client_switch_uuid', $switch_uuid)
        ->orWhere('worker_switch_uuid', $switch_uuid)
        ->orWhere('validator_switch_uuid', $switch_uuid)
        ->get();
    }

    public static function get_requestor_jobs($switch_uuid)
    {
        return Job::get_jobs($switch_uuid, 'client');
    }

    public static function get_worker_jobs($switch_uuid)
    {
        return Job::get_jobs($switch_uuid, 'worker');
    }

    public static function get_validator_jobs($switch_uuid)
    {
        return Job::get_jobs($switch_uuid, 'validator');
    }

    protected static function get_jobs($switch_uuid, $role_user)
    {
        return Job::where($role_user.'_switch_uuid', $switch_uuid)->get();
        // To see if we need more infos
        /*->join('categories', 'jobs.id_category', '=', 'categories.id')
        ->join('users as validators', 'jobs.requestor_switch_uuid', '=', 'users.switch_uuid')
        ->join('users as workers', 'jobs.worker_switch_uuid', '=', 'workers.switch_uuid')
        ->join('users as validators', 'jobs.validator_switch_uuid', '=', 'validators.switch_uuid')
        ->select('jobs.*', 'categories.id', 'validators.switch_uuid', 'workers.switch_uuid', 'validators.switch_uuid')*/
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

    public function file()
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

    public function category()
    {
        return $this->belongsTo(JobCategory::class);
    }
}
