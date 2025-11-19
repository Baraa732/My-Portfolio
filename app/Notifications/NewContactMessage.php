<?php
// app/Notifications/NewContactMessage.php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewContactMessage extends Notification implements ShouldQueue
{
    use Queueable;

    public $message;

    public function __construct($message)
    {
        $this->message = $message;
    }

    public function via($notifiable)
    {
        return ['database', 'broadcast'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'message_id' => $this->message->id,
            'subject' => 'New Contact Message',
            'message' => "New message from {$this->message->name}",
            'email' => $this->message->email,
            'created_at' => $this->message->created_at->format('M j, Y g:i A'),
        ];
    }

    public function toArray($notifiable)
    {
        return [
            'message_id' => $this->message->id,
            'subject' => 'New Contact Message',
            'message' => "New message from {$this->message->name}",
            'email' => $this->message->email,
            'created_at' => $this->message->created_at->format('M j, Y g:i A'),
        ];
    }
}
