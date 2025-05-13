<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

         \App\Models\Category::factory(20)->create();

        \App\Models\User::factory(4000)->create()->each(function ($user) {
            $posts = \App\Models\Post::factory(10)->make();
            $user->posts()->saveMany($posts);

            $posts->each(function ($post) {
                $post->comments()->saveMany(
                    \App\Models\Comment::factory(5)->make()
                );

                $categoryIds = \App\Models\Category::inRandomOrder()->take(rand(1, 5))->pluck('id');
                $post->categories()->sync($categoryIds);
            });
        });
    }
}
