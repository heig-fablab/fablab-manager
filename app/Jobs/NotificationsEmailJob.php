<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class NotificationsEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    // TODO: https://laravel.com/docs/9.x/queues

    public $backoff = 3;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    // TODO: function like this:
    /*public static function dispatchMailJob($id)
    {
        NotifyEmailJob::dispatch($id)->delay(now()->addMinutes(10));
        //NotifyEmailJob::dispatch($id)->delay(now()->addSeconds(30));
    }*/

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //
    }
}
