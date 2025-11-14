<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class MessageController extends Controller
{
    /**
     * Get all messages
     */
    public function index(): JsonResponse
    {
        try {
            $messages = Message::orderBy('is_read', 'asc')
                ->orderBy('created_at', 'desc')
                ->get();

            return response()->json($messages);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to fetch messages',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get a specific message
     */
    public function show($id): JsonResponse
    {
        try {
            $message = Message::findOrFail($id);

            // Mark as read when viewed
            if (!$message->is_read) {
                $message->markAsRead();
            }

            return response()->json($message);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Message not found',
                'message' => $e->getMessage()
            ], 404);
        }
    }

    /**
     * Mark message as read
     */
    public function markAsRead($id): JsonResponse
    {
        try {
            $message = Message::findOrFail($id);
            $message->markAsRead();

            return response()->json([
                'success' => true,
                'message' => 'Message marked as read'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to mark message as read'
            ], 500);
        }
    }

    /**
     * Mark all messages as read
     */
    public function markAllAsRead(): JsonResponse
    {
        try {
            Message::where('is_read', false)->update(['is_read' => true]);

            return response()->json([
                'success' => true,
                'message' => 'All messages marked as read'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to mark all messages as read'
            ], 500);
        }
    }

    /**
     * Delete a message
     */
    public function destroy($id): JsonResponse
    {
        try {
            $message = Message::findOrFail($id);
            $message->delete();

            return response()->json([
                'success' => true,
                'message' => 'Message deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete message'
            ], 500);
        }
    }

    /**
     * Get message statistics
     */
    public function stats(): JsonResponse
    {
        try {
            $stats = [
                'total' => Message::count(),
                'unread' => Message::unread()->count(),
                'read' => Message::read()->count(),
                'today' => Message::whereDate('created_at', today())->count(),
            ];

            return response()->json($stats);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to fetch message statistics'
            ], 500);
        }
    }
}
