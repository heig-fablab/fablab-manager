<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use App\Jobs\NotificationsEmailJob;

class Event extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'type',
        'to_notify',
        'data',
        'user_username',
        'job_id'
    ];

    // Mail Service
    public static function create_mail_job(string $user_username)
    {
        static $id_counter = 0;
        //NotificationsEmailJob::dispatch($id_counter, $user_username)->delay(now()->addMinutes(10));
        NotificationsEmailJob::dispatch($id_counter, $user_username)->delay(now()->addSeconds(20));
        $id_counter += 1;
    }

    // Belongs to
    public function job()
    {
        return $this->belongsTo(Job::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_username');
    }
}
