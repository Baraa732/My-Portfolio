<?php
// app/Models/PersonalInfo.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PersonalInfo extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'title',
        'home_text',
        'about_text',
        'home_image',
        'about_image',
        'cv_file',
        'email',
        'phone',
        'location'
    ];
}
