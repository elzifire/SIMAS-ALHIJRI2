<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //permission for posts
        Permission::create(['name' => 'posts.index']);
        Permission::create(['name' => 'posts.create']);
        Permission::create(['name' => 'posts.edit']);
        Permission::create(['name' => 'posts.delete']);

        //permission for tags
        Permission::create(['name' => 'tags.index']);
        Permission::create(['name' => 'tags.create']);
        Permission::create(['name' => 'tags.edit']);
        Permission::create(['name' => 'tags.delete']);

        //permission for categories
        Permission::create(['name' => 'categories.index']);
        Permission::create(['name' => 'categories.create']);
        Permission::create(['name' => 'categories.edit']);
        Permission::create(['name' => 'categories.delete']);

        //permission for events
        Permission::create(['name' => 'events.index']);
        Permission::create(['name' => 'events.create']);
        Permission::create(['name' => 'events.edit']);
        Permission::create(['name' => 'events.delete']);

        //leaders
        Permission::create(['name' => 'leaders.index']);
        Permission::create(['name' => 'leaders.create']);
        Permission::create(['name' => 'leaders.edit']);
        Permission::create(['name' => 'leaders.delete']);

        
        //permission for photos
        Permission::create(['name' => 'photos.index']);
        Permission::create(['name' => 'photos.create']);
        Permission::create(['name' => 'photos.delete']);

        // permission for category_video
        Permission::create(['name' => 'category_videos.index']);
        Permission::create(['name' => 'category_videos.create']);
        Permission::create(['name' => 'category_videos.edit']);
        Permission::create(['name' => 'category_videos.delete']);

        //permission for videos
        Permission::create(['name' => 'videos.index']);
        Permission::create(['name' => 'videos.create']);
        Permission::create(['name' => 'videos.edit']);
        Permission::create(['name' => 'videos.delete']);

        //permission for sliders
        Permission::create(['name' => 'sliders.index']);
        Permission::create(['name' => 'sliders.create']);
        Permission::create(['name' => 'sliders.delete']);

        //permission for roles
        Permission::create(['name' => 'roles.index']);
        Permission::create(['name' => 'roles.create']);
        Permission::create(['name' => 'roles.edit']);
        Permission::create(['name' => 'roles.delete']);

        //permission for permissions
        Permission::create(['name' => 'permissions.index']);

        //permission for users
        Permission::create(['name' => 'users.index']);
        Permission::create(['name' => 'users.create']);
        Permission::create(['name' => 'users.edit']);
        Permission::create(['name' => 'users.delete']);

        Permission::create(['name' => 'enters.index']);
        Permission::create(['name' => 'enters.create']);
        Permission::create(['name' => 'enters.edit']);
        Permission::create(['name' => 'enters.delete']);

        // muadzin
        Permission::create(['name' => 'muadzins.create']);
        Permission::create(['name' => 'muadzins.index']);
        Permission::create(['name' => 'muadzins.edit']);
        Permission::create(['name' => 'muadzins.delete']);

        // management
        Permission::create(['name' => 'managements.index']);
        Permission::create(['name' => 'managements.create']);
        Permission::create(['name' => 'managements.delete']);

        // Permission for Contact
        Permission::create(['name' => 'contacts.create']);
        Permission::create(['name' => 'contacts.index']);
        Permission::create(['name' => 'contacts.edit']);
        Permission::create(['name' => 'contacts.delete']);

        // Permission Profil
        Permission::create(['name' => 'profils.create']);
        Permission::create(['name' => 'profils.index']);
        Permission::create(['name' => 'profils.edit']);
        Permission::create(['name' => 'profils.delete']);

        // Permission for Service
        Permission::create(['name' => 'services.create']);
        Permission::create(['name' => 'services.index']);
        Permission::create(['name' => 'services.edit']);
        Permission::create(['name' => 'services.delete']);
    }
}
