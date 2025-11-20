<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Facades\NotificationService;

class NotificationController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $notifications = NotificationService::getUnreadForUser($user);
        
        return response()->json([
            'notifications' => $notifications,
            'count' => $notifications->count()
        ]);
    }

    public function markAsRead(Request $request, $id)
    {
        $user = Auth::user();
        $success = NotificationService::markAsRead($user, $id);
        
        return response()->json([
            'success' => $success,
            'message' => $success ? 'Notification marked as read' : 'Failed to mark notification as read'
        ]);
    }

    public function markAllAsRead(Request $request)
    {
        $user = Auth::user();
        $success = NotificationService::markAllAsRead($user);
        
        return response()->json([
            'success' => $success,
            'message' => $success ? 'All notifications marked as read' : 'Failed to mark notifications as read'
        ]);
    }
}