<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Status;

class StatusesTableSeeder extends Seeder
{
    public function run(): void
    {
        $statuses = [
            ['name' => 'Menunggu'],   // pending
            ['name' => 'Disetujui'],  // approved
            ['name' => 'Ditolak'],    // rejected
        ];

        foreach ($statuses as $status) {
            Status::firstOrCreate(['name' => $status['name']]);
        }
    }
}
