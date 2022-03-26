<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function getNotification()
    {
        return response()->json(Notification::where('user_id', auth()->user()->id)->first());
    }

    public function seenMessage()
    {
        $notification = Notification::where('user_id', auth()->user()->id)->first();
        $notification->update([
            'message' => 0
        ]);

        return;
    }


    public function seenOrder()
    {
        $notification = Notification::where('user_id', auth()->user()->id)->first();
        $notification->update([
            'order' => 0
        ]);

        return;
    }
}
