<?php

use Illuminate\Support\Facades\Auth;
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

Broadcast::channel('noticeadmin', function ($user) {
    if(Auth::check()) {
        return ['id' => $user->id, 'name' => $user->name];
    }
});

Broadcast::channel('updateproduct', function ($user) {
    if(Auth::check()) {
        return ['id' => $user->id, 'name' => $user->name];
    }
});

Broadcast::channel('noticecustomer{userId}', function ($user) {
    if(Auth::check()) {
        return ['id' => $user->id, 'name' => $user->name];
    }
});

Broadcast::channel('updateproductview{productId}', function ($user) {
    if(Auth::check()) {
        return ['id' => $user->id, 'name' => $user->name];
    }
});

Broadcast::channel('notifyuser{userId}', function ($user) {
    if(Auth::check()) {
        return ['id' => $user->id, 'name' => $user->name];
    }
});

Broadcast::channel('customerorders{userId}', function ($user) {
    if(Auth::check()) {
        return ['id' => $user->id, 'name' => $user->name];
    }
});
