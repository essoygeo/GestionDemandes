<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function clear()
    {
        $userId = Auth::id();

        // Marquer comme lues
        Notification::where('user_id', $userId)->update(['is_read' => true]);



        return redirect()->back()->with('success', 'Notifications lues');
    }

    public function Allnotification()
    {
        $user = Auth::user();


        $notifications = $user->notifications()->where('is_read', false)->paginate(10);



        return view('notifications.index',compact('notifications'));
    }

}
