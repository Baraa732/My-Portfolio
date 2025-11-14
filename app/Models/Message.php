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
      'user_agent'
   ];

   protected $casts = [
      'is_read' => 'boolean',
   ];

   protected $attributes = [
      'is_read' => false,
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
