<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Photo;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(RolesTableSeeder::class);
        $this->call(PermissionsTableSeeder::class);
        $this->call(UserTableSeeder::class);
        $this->call(CategoriesTableSeeder::class);
        // $this->call(EventSeeder::class);
        // $this->call(TagsTableSeeder::class);
        // $this->call(PostsTableSeeder::class);
        // $this->call(PostTagTableSeeder::class);
        // $this->call(CategoriesPhotoSeeder::class);
        // $this->call(PhotosSeeder::class);
        $this->call(PendaftaranSeeder::class);
    }
}