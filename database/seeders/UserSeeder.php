<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create a teacher user
        User::create([
            'name' => 'Teacher Demo',
            'email' => 'teacher@example.com',
            'password' => Hash::make('password'),
            'role' => 'teacher',
            'email_verified_at' => now(),
        ]);

        // Create a student user
        User::create([
            'name' => 'Student Demo',
            'email' => 'student@example.com',
            'password' => Hash::make('password'),
            'role' => 'student',
            'email_verified_at' => now(),
        ]);

        // Create admin teacher
        User::create([
            'name' => 'Admin',
            'email' => 'admin@edustream.com',
            'password' => Hash::make('admin123'),
            'role' => 'teacher',
            'email_verified_at' => now(),
        ]);
    }
}
