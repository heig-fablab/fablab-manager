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
        'requestor_email',
        'worker_email',
        'validator_email'
    ];

    /**
     * The model's default values for attributes.
     *
     * @var array
     */
    protected $attributes = [
        'status' => 'new',
    ];

    // Service methods
    public static function get_user_jobs($email)
    {
        return Job::where('requestor_email', $email)
        ->orWhere('worker_email', $email)
        ->orWhere('validator_email', $email)
        ->get();
    }

    public static function get_requestor_jobs($email)
    {
        return Job::get_jobs($email, 'requestor');
    }

    public static function get_worker_jobs($email)
    {
        return Job::get_jobs($email, 'worker');
    }

    public static function get_validator_jobs($email)
    {
        return Job::get_jobs($email, 'validator');
    }

    protected static function get_jobs($email, $role_user)
    {
        return Job::where($role_user.'_email', $email)->get();
        // To see if we need more infos
        /*->join('categories', 'jobs.id_category', '=', 'categories.id')
        ->join('users as validators', 'jobs.requestor_email', '=', 'users.email')
        ->join('users as workers', 'jobs.worker_email', '=', 'workers.email')
        ->join('users as validators', 'jobs.validator_email', '=', 'validators.email')
        ->select('jobs.*', 'categories.id', 'validators.email', 'workers.email', 'validators.email')*/
        
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

    // BelongsTo
    public function requestor()
    {
        return $this->belongsTo(User::class, 'requestor_email');
    }

    public function worker()
    {
        return $this->belongsTo(User::class, 'worker_email');
    }

    public function validator()
    {
        return $this->belongsTo(User::class, 'validator_email');
    }

    public function category()
    {
        return $this->belongsTo(JobCategory::class, 'id_category');
    }

    public function file()
    {
        return $this->belongsTo(File::class, 'id_file');
    }
}
