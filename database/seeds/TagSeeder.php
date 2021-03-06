<?php

use App\Tag;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        for ($i = 0; $i <= 10; $i++) {
            $new_tag = new Tag();
            $new_tag->name = $faker->word();
            $new_tag->slug = Str::slug($new_tag->name);
            $new_tag->save();
        }
    }
}