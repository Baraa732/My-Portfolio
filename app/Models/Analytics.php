<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Analytics extends Model
{
    protected $fillable = [
        'page',
        'ip_address',
        'user_agent',
        'referrer',
        'country',
        'device_type',
        'browser',
        'os'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];
}