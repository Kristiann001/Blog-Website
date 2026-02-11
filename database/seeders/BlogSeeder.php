<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class BlogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Create Admin User
        $admin = User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('password'),
                'role' => 'admin',
            ]
        );
 
        // 1.1 Create Default Customer User
        User::firstOrCreate(
            ['email' => 'customer@example.com'],
            [
                'name' => 'Test Customer',
                'password' => Hash::make('password'),
                'role' => 'user',
            ]
        );
         // 2. Create Categories
        $tech = Category::firstOrCreate(['slug' => 'technology'], ['name' => 'Technology']);
        $lifestyle = Category::firstOrCreate(['slug' => 'lifestyle'], ['name' => 'Lifestyle']);
        $travel = Category::firstOrCreate(['slug' => 'travel'], ['name' => 'Travel']);

        // 3. Create Sample Posts
        Post::create([
            'title' => 'Welcome to My Modern Blog',
            'slug' => 'welcome-to-my-modern-blog',
            'content' => "This is a sample post demonstrating the new blog platform.\n\nIt supports **Markdown** content and has a clean, modern design.",
            'excerpt' => 'A short introduction to the new platform.',
            'status' => 'published',
            'published_at' => now(),
            'user_id' => $admin->id,
            'category_id' => $tech->id,
            'featured_image' => null, // Or strict path if available
            'views_count' => 120
        ]);

        Post::create([
            'title' => 'The Future of AI',
            'slug' => 'the-future-of-ai',
            'content' => "AI is changing the world...\n\nLorem ipsum dolor sit amet, consectetur adipiscing elit.",
            'excerpt' => 'Exploring the impact of Artificial Intelligence.',
            'status' => 'published',
            'published_at' => now()->subDays(2),
            'user_id' => $admin->id,
            'category_id' => $tech->id,
            'views_count' => 45
        ]);

        Post::create([
            'title' => 'Top 10 Travel Destinations',
            'slug' => 'top-10-travel-destinations',
            'content' => "1. Paris\n2. Tokyo\n3. New York...",
            'excerpt' => 'Where to go for your next vacation.',
            'status' => 'draft',
            'published_at' => null,
            'user_id' => $admin->id,
            'category_id' => $travel->id,
        ]);
    }
}
