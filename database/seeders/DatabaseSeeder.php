<?php
// database/seeders/DatabaseSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Baraa Al-Rifaee',
            'email' => 'baraaalrifaee732@gmail.com',
            'password' => Hash::make('JACK BA RA A'),
            'title' => 'Full Stack Web Developer',
            'bio' => 'Passionate about creating amazing web experiences with modern technologies.',
            'phone' => '+963 994 134 966',
            'location' => 'Damascus, Syria',
            'email_verified_at' => now(),
        ]);
    }
}
