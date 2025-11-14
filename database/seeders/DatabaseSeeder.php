<?php
// database/seeders/DatabaseSeeder.php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Section;
use App\Models\Skill;
use App\Models\Project;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create Admin User
        User::create([
            'name' => 'Baraa Al-Rifaee',
            'email' => 'baraaalrifaee732@gmail.com',
            'password' => Hash::make('JACK BA RA A'),
            'title' => 'Full Stack Developer',
            'bio' => 'Passionate about creating amazing web experiences with modern technologies.',
            'phone' => '+963 994 134 966',
            'location' => 'Damascus, Syria',
        ]);

        // Create default sections
        $sections = [
            [
                'name' => 'home',
                'title' => 'Welcome to My Portfolio',
                'content' => 'I create amazing web experiences with modern technologies and clean code.',
                'is_active' => true,
            ],
            [
                'name' => 'about',
                'title' => 'About Me',
                'content' => "I'm a passionate full-stack developer with expertise in modern web technologies. I love creating efficient, scalable, and user-friendly applications.",
                'is_active' => true,
            ],
        ];

        foreach ($sections as $section) {
            Section::create($section);
        }

        // Create sample skills
        $skills = [
            [
                'name' => 'Laravel',
                'percentage' => 90,
                'icon' => 'fab fa-laravel',
                'is_active' => true,
                'order' => 1,
            ],
            [
                'name' => 'Vue.js',
                'percentage' => 85,
                'icon' => 'fab fa-vuejs',
                'is_active' => true,
                'order' => 2,
            ],
            [
                'name' => 'React',
                'percentage' => 80,
                'icon' => 'fab fa-react',
                'is_active' => true,
                'order' => 3,
            ],
            [
                'name' => 'Node.js',
                'percentage' => 75,
                'icon' => 'fab fa-node-js',
                'is_active' => true,
                'order' => 4,
            ],
        ];

        foreach ($skills as $skill) {
            Skill::create($skill);
        }

        // Create sample projects
        $projects = [
            [
                'title' => 'E-Commerce Platform',
                'description' => 'A full-featured e-commerce platform built with Laravel and Vue.js with payment integration and admin dashboard.',
                'technologies' => 'Laravel, Vue.js, MySQL, Stripe',
                'project_url' => 'https://example.com',
                'github_url' => 'https://github.com/example',
                'is_active' => true,
                'order' => 1,
            ],
            [
                'title' => 'Task Management App',
                'description' => 'A collaborative task management application with real-time updates and team collaboration features.',
                'technologies' => 'React, Node.js, Socket.io, MongoDB',
                'project_url' => 'https://example.com',
                'github_url' => 'https://github.com/example',
                'is_active' => true,
                'order' => 2,
            ],
        ];

        foreach ($projects as $project) {
            Project::create($project);
        }
    }
}
