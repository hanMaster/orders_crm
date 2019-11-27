<?php


namespace App\Services;
use App\Notifications\CommentAdded;
use App\Order;
use App\User;
use Illuminate\Support\Facades\Auth;
use Notification;

class NotifSender
{
    public static function send(Order $order){
        $users = User::whereNotIn('id',[Auth::id(), 1])->get();
        Notification::send($users,new CommentAdded($order));
    }
}
