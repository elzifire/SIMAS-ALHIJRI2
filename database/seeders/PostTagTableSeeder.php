<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PostTagTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $postIds = DB::table('posts')->pluck('id')->toArray();
        $tagIds = DB::table('tags')->pluck('id')->toArray();

        foreach ($postIds as $postId) {
            $randomTags = array_rand($tagIds, rand(1, 3));
            foreach ((array)$randomTags as $tagId) {
                DB::table('post_tag')->insert([
                    'post_id' => $postId,
                    'tag_id' => $tagIds[$tagId],
                ]);
            }
        }
    }
}
