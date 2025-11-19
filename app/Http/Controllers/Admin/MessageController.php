<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Mail;

class MessageController extends Controller
{
    /**
     * Get all messages with replies
     */
    public function index(): JsonResponse
    {
        try {
            $messages = Message::with('replies')
                ->original()
                ->orderBy('is_read', 'asc')
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
     * Get a specific message with its replies
     */
    public function show($id): JsonResponse
    {
        try {
            $message = Message::with('replies')->findOrFail($id);

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
     * Send a reply to a message
     */
    public function reply(Request $request, $id): JsonResponse
    {
        try {
            $originalMessage = Message::findOrFail($id);

            $validated = $request->validate([
                'message' => 'required|string|min:10|max:2000'
            ]);

            // Create reply message
            $reply = Message::create([
                'name' => 'Admin',
                'email' => config('mail.from.address'),
                'subject' => 'Re: ' . $originalMessage->subject,
                'message' => $validated['message'],
                'is_reply' => true,
                'parent_id' => $originalMessage->id,
                'is_read' => true
            ]);

            // Send email reply
            $this->sendReplyEmail($originalMessage, $validated['message']);

            return response()->json([
                'success' => true,
                'message' => 'Reply sent successfully',
                'data' => $reply
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to send reply',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Send reply email to the original sender
     */
    private function sendReplyEmail(Message $originalMessage, string $replyMessage): void
    {
        try {
            $data = [
                'name' => $originalMessage->name,
                'email' => $originalMessage->email,
                'subject' => $originalMessage->subject,
                'original_message' => $originalMessage->message,
                'reply_message' => $replyMessage,
                'reply_date' => now()->format('F j, Y \a\t g:i A')
            ];

            Mail::send('emails.message-reply', $data, function ($message) use ($data) {
                $message->to($data['email'])
                    ->subject('Re: ' . $data['subject'])
                    ->from(config('mail.from.address'), config('mail.from.name'));
            });
        } catch (\Exception $e) {
            \Log::error('Failed to send reply email: ' . $e->getMessage());
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
                'total' => Message::original()->count(),
                'unread' => Message::original()->unread()->count(),
                'read' => Message::original()->read()->count(),
                'today' => Message::original()->whereDate('created_at', today())->count(),
                'replies' => Message::where('is_reply', true)->count(),
            ];

            return response()->json($stats);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to fetch message statistics'
            ], 500);
        }
    }
}
