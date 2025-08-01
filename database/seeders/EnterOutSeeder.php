<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class EnterOutSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        $enterNames = [
            'Donasi Jemaah', 'Infak Jumat', 'Sumbangan Acara Besar', 'Gaji Karyawan Donasi',
            'Pembayaran Sewa Aula', 'Hasil Usaha Koperasi', 'Dana CSR Perusahaan',
            'Penjualan Barang Wakaf', 'Donasi Online', 'Subsidi Pemerintah'
        ];

        $outNames = [
            'Listrik Bulanan', 'Air Bulanan', 'Beli Al-Quran', 'Bayar Gaji Petugas',
            'Konsumsi Acara', 'Perbaikan AC', 'Renovasi Ringan', 'Transportasi Ustadz',
            'Cetak Pamflet', 'Biaya Internet'
        ];

        // Matikan foreign key check, truncate, dan reset auto-increment
        DB::statement('SET FOREIGN_KEY_CHECKS = 0;');
        DB::table('enters')->truncate();
        DB::table('outs')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS = 1;');

        // Generate surplus data
        $enters = [];
        for ($i = 0; $i < 700; $i++) {
            $balance = number_format($faker->randomFloat(2, 50000, 3000000), 2, '.', '');
            $date = $faker->dateTimeBetween('-1 year', 'now')->format('Y-m-d');
            $enters[] = [
                'name' => $faker->randomElement($enterNames) . ' ' . $faker->lexify('???'),
                'balance' => $balance,
                'date' => $date,
                'total' => $faker->boolean(90) ? $balance : null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];
        }

        $outs = [];
        for ($i = 0; $i < 400; $i++) {
            $balance = number_format($faker->randomFloat(2, 10000, 750000), 2, '.', '');
            $date = $faker->dateTimeBetween('-1 year', 'now')->format('Y-m-d');
            $outs[] = [
                'name' => $faker->randomElement($outNames) . ' ' . $faker->lexify('???'),
                'balance' => $balance,
                'date' => $date,
                'total' => $faker->boolean(85) ? $balance : null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];
        }

        // Insert data in chunk
        $chunkSize = 100;
        try {
            foreach (array_chunk($enters, $chunkSize) as $chunk) {
                DB::table('enters')->insert($chunk);
            }
            foreach (array_chunk($outs, $chunkSize) as $chunk) {
                DB::table('outs')->insert($chunk);
            }
        } catch (\Exception $e) {
            Log::error('Gagal insert data seeder: ' . $e->getMessage());
            throw new \Exception('Gagal menjalankan seeder: ' . $e->getMessage());
        }
    }
}
