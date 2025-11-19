<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Baraa Al-Rifaee',
            'email' => 'baraaalrifaee732@gmail.com',
            'password' => Hash::make('admin123'),
            'title' => 'Full Stack Developer',
            'bio' => 'Passionate full-stack developer with expertise in Laravel, Vue.js, and modern web technologies.',
            'is_admin' => true,
        ]);
    }
}