<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class PostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        $categoryIds = DB::table('categories')->pluck('id')->toArray();

        for ($i = 0; $i < 50; $i++) {
            DB::table('posts')->insert([
                'image' => $faker->imageUrl(640, 480, 'posts', true),
                'title' => $title = $faker->sentence,
                'slug' => Str::slug($title),
                'category_id' => $faker->randomElement($categoryIds),
                'content' => $faker->paragraphs(3, true),
                'date' => $faker->dateTimeBetween('-1 year', 'now'),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
