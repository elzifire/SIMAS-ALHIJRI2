<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class VideosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('videos')->insert([
            [
                'title' => 'Sample Video 1',
                'embed' => 'https://www.youtube.com/embed/dQw4w9WgXcQ',
                'desc' => 'This is a description for Sample Video 1.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Sample Video 2',
                'embed' => 'https://www.youtube.com/embed/dQw4w9WgXcQ',
                'desc' => 'This is a description for Sample Video 2.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Sample Video 3',
                'embed' => 'https://www.youtube.com/embed/dQw4w9WgXcQ',
                'desc' => 'This is a description for Sample Video 3.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            
            
        ]);
    }
}
