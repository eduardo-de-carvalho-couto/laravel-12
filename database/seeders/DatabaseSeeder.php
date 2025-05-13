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
        \App\Models\Category::factory(20)->create();

        \App\Models\User::factory(1_000)->create()->each(function ($user) {
            $posts = \App\Models\Post::factory(10)->make(); // 10 posts por usuário
            $user->posts()->saveMany($posts);

            $posts->each(function ($post) {
                $post->comments()->saveMany(
                    \App\Models\Comment::factory(5)->make() // 5 comentários por post
                );

                $categoryIds = \App\Models\Category::inRandomOrder()->take(rand(2, 5))->pluck('id');
                $post->categories()->sync($categoryIds);
            });
        });
    }
}
