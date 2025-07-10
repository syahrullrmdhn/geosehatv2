<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = auth()->user()
            ->notifications()
            ->orderBy('created_at','desc')
            ->paginate(10);

        return view('notifications.index', compact('notifications'));
    }

    public function markRead($id)
    {
        $n = auth()->user()
            ->notifications()
            ->where('id', $id)
            ->firstOrFail();

        $n->markAsRead();
        return back();
    }
}
