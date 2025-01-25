<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PhotosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Insert categories into categories_photos table
        DB::table('categories_photos')->insert([
            ['name' => 'Mualaf', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Zakat', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Donasi', 'created_at' => now(), 'updated_at' => now()],
        ]);

        // Insert photos into photos table
        // DB::table('photos')->insert([
        //     [
        //         'image' => 'nature1.jpg',
        //         'heading' => 'Beautiful Mountain',
        //         'caption' => 'A stunning view of a mountain during sunset.',
        //         'date' => '2025-01-15',
        //         'category_id' => 1,
        //         'created_at' => now(),
        //         'updated_at' => now(),
        //     ],
        //     [
        //         'image' => 'architecture1.jpg',
        //         'heading' => 'Modern Building',
        //         'caption' => 'An impressive piece of modern architecture.',
        //         'date' => '2025-01-16',
        //         'category_id' => 2,
        //         'created_at' => now(),
        //         'updated_at' => now(),
        //     ],
        //     [
        //         'image' => 'people1.jpg',
        //         'heading' => 'Happy Crowd',
        //         'caption' => 'A group of happy people enjoying an outdoor event.',
        //         'date' => '2025-01-17',
        //         'category_id' => 3,
        //         'created_at' => now(),
        //         'updated_at' => now(),
        //     ],
        // ]);
        // buatkan data dummy untuk tabel photos 500 data
        for ($i = 1; $i <= 500; $i++) {
            DB::table('photos')->insert([
                [
                    'image' => 'nature1.jpg',
                    'heading' => 'Beautiful Mountain',
                    'caption' => 'A stunning view of a mountain during sunset.',
                    'date' => '2025-01-15',
                    'category_id' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'image' => 'architecture1.jpg',
                    'heading' => 'Modern Building',
                    'caption' => 'An impressive piece of modern architecture.',
                    'date' => '2025-01-16',
                    'category_id' => 2,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'image' => 'people1.jpg',
                    'heading' => 'Happy Crowd',
                    'caption' => 'A group of happy people enjoying an outdoor event.',
                    'date' => '2025-01-17',
                    'category_id' => 3,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
            ]);
        }
    }
}
