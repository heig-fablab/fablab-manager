<?php

use Illuminate\Support\Facades\Broadcast;

use App\Models\Job;
use App\Models\Message;

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

/*Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});*/

Broadcast::channel('message.{switch_uuid}', function ($user, $switch_uuid) {
    return $user->switch_uuid === $switch_uuid;
});
  
Broadcast::channel('job.{switch_uuid}', function ($user, $switch_uuid) {
    return $user->switch_uuid === $switch_uuid;
});

Broadcast::channel('job.workers.{switch_uuid}', function ($user, $switch_uuid) {
    return $user->switch_uuid === $switch_uuid;
});
  
