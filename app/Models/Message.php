<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
   use HasFactory;

   protected $fillable = [
      'name',
      'email',
      'subject',
      'message',
      'is_read',
      'ip_address',
      'user_agent',
      'parent_id', // Add this for thread support
      'is_reply'   // Add this to distinguish replies
   ];

   protected $casts = [
      'is_read' => 'boolean',
      'is_reply' => 'boolean',
   ];

   protected $attributes = [
      'is_read' => false,
      'is_reply' => false,
   ];

   /**
    * Scope for unread messages
    */
   public function scopeUnread($query)
   {
      return $query->where('is_read', false);
   }

   /**
    * Scope for read messages
    */
   public function scopeRead($query)
   {
      return $query->where('is_read', true);
   }

   /**
    * Scope for original messages (not replies)
    */
   public function scopeOriginal($query)
   {
      return $query->where('is_reply', false);
   }

   /**
    * Get replies for this message
    */
   public function replies()
   {
      return $this->hasMany(Message::class, 'parent_id')->orderBy('created_at', 'asc');
   }

   /**
    * Get the original message for a reply
    */
   public function originalMessage()
   {
      return $this->belongsTo(Message::class, 'parent_id');
   }

   /**
    * Mark message as read
    */
   public function markAsRead()
   {
      $this->update(['is_read' => true]);
   }

   /**
    * Mark message as unread
    */
   public function markAsUnread()
   {
      $this->update(['is_read' => false]);
   }
}
