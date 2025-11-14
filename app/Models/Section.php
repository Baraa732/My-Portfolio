<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
   use HasFactory;

   protected $fillable = [
      'name',
      'title',
      'content',
      'type',
      'order',
      'background_color',
      'text_color',
      'is_active',
      'show_in_nav',
   ];

   protected $casts = [
      'is_active' => 'boolean',
      'show_in_nav' => 'boolean',
      'order' => 'integer',
   ];

   protected $attributes = [
      'is_active' => true,
      'show_in_nav' => true,
      'order' => 0,
      'background_color' => '#140f17',
      'text_color' => '#ffffff',
   ];
}
