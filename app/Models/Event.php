<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use App\Jobs\NotificationsEmailJob;
use Illuminate\Support\Facades\Log;

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

        log::Debug('Dispatching mail job');

        if (env('APP_ENV') == 'production') {
            dispatch(new NotificationsEmailJob($id_counter, $user_username))
                ->delay(Carbon::now()->addMinutes(10));
        } else {
            dispatch(new NotificationsEmailJob($id_counter, $user_username))
                ->delay(Carbon::now()->addSeconds(30));
        }
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
