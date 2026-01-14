<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Admin User
        \App\Models\User::create([
            'name' => 'Admin User',
            'email' => 'admin@blog.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        // Regular User
        \App\Models\User::create([
            'name' => 'Test User',
            'email' => 'user@blog.com',
            'password' => bcrypt('password'),
            'role' => 'user',
        ]);

        $this->call([
          ServicesTableSeeder::class,
        ]);
    }
}
