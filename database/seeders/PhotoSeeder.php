<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class PhotoSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void 
    {
        // Seed categories_photos table
        DB::table('categories_photos')->insert([
            [
                'title' => 'Nature',
                'slug' => Str::slug('Nature'),
                'desc' => 'Photos related to nature and landscapes.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Architecture',
                'slug' => Str::slug('Architecture'),
                'desc' => 'Photos of various architectural designs.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'People',
                'slug' => Str::slug('People'),
                'desc' => 'Portraits and photos of people.',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);

        // Seed photos table
        DB::table('photos')->insert([
            [
                'image' => 'nature1.jpg',
                'heading' => 'Sunset in the Mountains',
                'caption' => 'A beautiful sunset behind the mountains.',
                'date' => '2024-09-01',
                'category_id' => 1, // Assuming 1 refers to 'Nature' category
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'image' => 'architecture1.jpg',
                'heading' => 'Modern Skyscraper',
                'caption' => 'A tall, modern skyscraper in the city.',
                'date' => '2024-09-10',
                'category_id' => 2, // Assuming 2 refers to 'Architecture' category
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'image' => 'people1.jpg',
                'heading' => 'Smiling Child',
                'caption' => 'A child smiling at the camera during a sunny day.',
                'date' => '2024-09-15',
                'category_id' => 3, // Assuming 3 refers to 'People' category
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
