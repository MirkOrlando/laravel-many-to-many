<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Post;
use Faker\Generator as Faker;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        for ($i = 0; $i < 20; $i++) {
            $post = new Post;
            $post->title = $faker->sentence(4);
            $post->slug = Str::slug($post->title, '-');
            $post->content = $faker->text(500);
            $post->cover_img = $faker->imageUrl(600, 400, 'cover_post', true, 'cover', true, 'jpg');
            $post->save();
        }
    }
}