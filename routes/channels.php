<?php

use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('message.{username}', function ($user, $username) {
    return $user->username === $username;
});

Broadcast::channel('job.{username}', function ($user, $username) {
    return $user->username === $username;
});

Broadcast::channel('job.workers', function ($user, $username) {
    return $user->has_given_role(\App\Constants\Roles::WORKER);
});
