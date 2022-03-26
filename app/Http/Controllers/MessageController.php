<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Inquire;
use App\Events\MessageSent;
use App\Models\Notification;
use App\Models\ReplyInquire;
use Illuminate\Http\Request;
use App\Events\NoticeCustomer;
use App\Events\UserNotification;
use App\Http\Resources\Inquire\InquireCollection;

class MessageController extends Controller
{
    public function list()
    {
        $user = auth()->user();
        $data = Inquire::where('user_id', $user->id)->orderBy('updated_at', 'DESC')->get();
        $data = new InquireCollection($data);
        return view('frontend.messages', ['data' => $data]);
    }

    public function adminList()
    {
        $data = Inquire::orderBy('updated_at', 'DESC')->get();
        $data = new InquireCollection($data);
        return view('frontend.messages', ['data' => $data]);
    }

    public function storeReply(Request $request)
    {
        $user = auth()->user();
        ReplyInquire::create([
            'message' => $request->input('message'),
            'inquire_id' => $request->input('inquire_id'),
            'user_id' => $user->id
        ]);

        $inquire = Inquire::where('id', $request->input('inquire_id'))->first();
        $inquire->update([
            'unseen' => $inquire->unseen + 1,
            'user_last_message' => $user->id
        ]);

        if($user->id == 1) {
            $notification = Notification::where('user_id', $inquire->user_id)->first();
            $notification->update([
                'message' =>  $notification->message + 1
            ]);

            broadcast(new NoticeCustomer($inquire))->toOthers();
            $user = User::where('id', $inquire->user_id)->first();
            broadcast(new UserNotification($user))->toOthers();
        } else {
            broadcast(new MessageSent($inquire))->toOthers();
        }

        return 'successfully sent';
    }

    public function adminStoreReply(Request $request)
    {
        $user = auth()->user();

        $inquire = Inquire::where('id', $request->input('inquire_id'))->first();
        $inquire->update([
            'unseen' => $inquire->user_last_message == $user->id ? $inquire->unseen + 1 : 0,
            'user_last_message' => 1
        ]);

        ReplyInquire::create([
            'message' => $request->input('message'),
            'inquire_id' => $request->input('inquire_id'),
            'user_id' => 1
        ]);

        return 'successfully sent';
    }

    public function store(Request $request)
    {
        $user = auth()->user();
        $inquire = Inquire::create([
            'message' => $request->input('message'),
            'product_id' => $request->input('product_id'),
            'user_id' => $user->id,
            'unseen' => 1,
            'user_last_message' => $user->id
        ]);

        broadcast(new MessageSent($inquire))->toOthers();

        return 'successfully sent';
    }

    public function adminInquires()
    {
        $data = Inquire::orderBy('updated_at', 'DESC')->get();
        return new InquireCollection($data);
    }

    public function customerInquires()
    {
        $user = auth()->user();
        $data = Inquire::where('user_id', $user->id)->orderBy('updated_at', 'DESC')->get();
        return new InquireCollection($data);
    }

    public function seenInquire(Inquire $inquire)
    {
        return $inquire->update([
            'unseen' => 0
        ]);
    }
}
