<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Log;

class NotificationService
{
    /**
     * Send notification to admin users
     */
    public function sendToAdmins($notification)
    {
        try {
            $adminUsers = User::where('is_admin', true)->get();
            
            if ($adminUsers->isNotEmpty()) {
                Notification::send($adminUsers, $notification);
                Log::info('Notification sent to admin users', [
                    'notification' => get_class($notification),
                    'admin_count' => $adminUsers->count()
                ]);
                return true;
            }
            
            Log::warning('No admin users found for notification');
            return false;
            
        } catch (\Exception $e) {
            Log::error('Failed to send notification to admins', [
                'error' => $e->getMessage(),
                'notification' => get_class($notification)
            ]);
            return false;
        }
    }

    /**
     * Send notification to specific user
     */
    public function sendToUser($user, $notification)
    {
        try {
            $user->notify($notification);
            Log::info('Notification sent to user', [
                'user_id' => $user->uuid,
                'notification' => get_class($notification)
            ]);
            return true;
            
        } catch (\Exception $e) {
            Log::error('Failed to send notification to user', [
                'user_id' => $user->uuid ?? 'unknown',
                'error' => $e->getMessage(),
                'notification' => get_class($notification)
            ]);
            return false;
        }
    }

    /**
     * Send notification to multiple users
     */
    public function sendToUsers($users, $notification)
    {
        try {
            Notification::send($users, $notification);
            Log::info('Notification sent to multiple users', [
                'user_count' => $users->count(),
                'notification' => get_class($notification)
            ]);
            return true;
            
        } catch (\Exception $e) {
            Log::error('Failed to send notification to users', [
                'error' => $e->getMessage(),
                'notification' => get_class($notification)
            ]);
            return false;
        }
    }

    /**
     * Get unread notifications for user
     */
    public function getUnreadForUser($user)
    {
        return $user->unreadNotifications;
    }

    /**
     * Mark notification as read
     */
    public function markAsRead($user, $notificationId)
    {
        try {
            $notification = $user->notifications()->find($notificationId);
            if ($notification) {
                $notification->markAsRead();
                return true;
            }
            return false;
            
        } catch (\Exception $e) {
            Log::error('Failed to mark notification as read', [
                'user_id' => $user->uuid,
                'notification_id' => $notificationId,
                'error' => $e->getMessage()
            ]);
            return false;
        }
    }

    /**
     * Mark all notifications as read for user
     */
    public function markAllAsRead($user)
    {
        try {
            $user->unreadNotifications->markAsRead();
            return true;
            
        } catch (\Exception $e) {
            Log::error('Failed to mark all notifications as read', [
                'user_id' => $user->uuid,
                'error' => $e->getMessage()
            ]);
            return false;
        }
    }
}