<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\CategoriesPhoto;

class CategoriesPhotoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create categories
        $categories = [
            'MUALAF',
            'ZAKAT',
            'DONASI'
        ];

        foreach ($categories as $category) {
            CategoriesPhoto::create([
                'name' => $category
            ]);
        }
    }
}
