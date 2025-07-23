<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Activitylog\Models\Activity;

class NotificationController extends Controller
{
   public function index()
{
    $notifications = auth()->user()
        ->notifications()
        ->orderBy('created_at','desc')
        ->paginate(10);

    // Ambil log Spatie (audit log)
    $activityLogs = Activity::with('causer')
        ->latest()
        ->limit(20)
        ->get();

    // Threshold notification (misal notifikasi dengan tag threshold)
    $thresholdNotifications = auth()->user()
        ->notifications()
        ->whereJsonContains('data->type', 'threshold')
        ->latest()
        ->limit(10)
        ->get();

    return view('notifications.index', compact(
        'notifications', 'activityLogs', 'thresholdNotifications'
    ));
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
