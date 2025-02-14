<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('events')->insert([
            [
                'title'     => 'Seminar Teknologi AI',
                'slug'      => Str::slug('Seminar Teknologi AI'),
                'content'   => 'Seminar ini membahas perkembangan kecerdasan buatan dalam dunia industri.',
                'location'  => 'Jakarta Convention Center',
                'date'      => Carbon::now()->addDays(10)->toDateString(),
                'created_at'=> now(),
                'updated_at'=> now(),
            ],
            [
                'title'     => 'Workshop Laravel 10',
                'slug'      => Str::slug('Workshop Laravel 10'),
                'content'   => 'Pelatihan intensif dalam menggunakan Laravel 10 untuk pengembangan aplikasi web.',
                'location'  => 'Universitas Indonesia',
                'date'      => Carbon::now()->addDays(20)->toDateString(),
                'created_at'=> now(),
                'updated_at'=> now(),
            ],
            [
                'title'     => 'Hackathon Nasional',
                'slug'      => Str::slug('Hackathon Nasional'),
                'content'   => 'Kompetisi pemrograman tingkat nasional dengan berbagai tantangan menarik.',
                'location'  => 'Surabaya Tech Park',
                'date'      => Carbon::now()->addDays(30)->toDateString(),
                'created_at'=> now(),
                'updated_at'=> now(),
            ]
        ]);
    }
}
