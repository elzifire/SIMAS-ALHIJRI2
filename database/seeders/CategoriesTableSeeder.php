<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = collect(['Mualaf', 'Dakwah', 'Sosial', 'Pendidikan', 'Kesehatan', 'Ekonomi', 'Lingkungan', 'Bencana Alam', 'Kemanusiaan', 'Keluarga', 'Anak', 'Remaja', 'Lansia', 'Perempuan', 'Pria', 'Difabel', 'Korban Kekerasan', 'Korban Narkoba', 'Korban HIV/AIDS', 'Korban']);

        $categories->each(function ($category) {
            DB::table('categories')->insert([
                'name' => $category,
                'slug' => Str::slug($category),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        });
    }
}
