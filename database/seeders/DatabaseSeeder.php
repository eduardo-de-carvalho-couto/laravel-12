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
        \App\Models\User::factory(500)->create()->each(function ($user) {
            $posts = \App\Models\Post::factory(5)->make();
            $user->posts()->saveMany($posts);

            $posts->each(function ($post) {
                $post->comments()->saveMany(
                    \App\Models\Comment::factory(3)->make()
                );

                $categoryIds = \App\Models\Category::inRandomOrder()->take(rand(1, 3))->pluck('id');
                $post->categories()->sync($categoryIds);
            });
        });
    }
}
