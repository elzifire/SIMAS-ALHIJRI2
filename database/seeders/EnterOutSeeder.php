<?php 

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class EnterOutSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID'); // Locale Indonesia buat nama realistis
        $enterNames = [
            'Gaji Karyawan', 'Pembayaran Invoice', 'Hasil Investasi', 'Donasi Masjid', 'Penjualan Barang',
            'Pendapatan Sewa', 'Dana Proyek', 'Pembayaran Klien', 'Sumbangan Jemaah', 'Keuntungan Usaha'
        ];
        $outNames = [
            'Sewa Kantor', 'Tagihan Listrik', 'Pembelian Peralatan', 'Biaya Operasional', 'Pembayaran Vendor',
            'Perawatan Gedung', 'Tagihan Air', 'Biaya Transportasi', 'Pembelian Bahan Baku', 'Renovasi Masjid'
        ];

        // Generate 500 data buat enters
        $enters = [];
        for ($i = 0; $i < 500; $i++) {
            $balance = number_format($faker->randomFloat(2, 10000, 999999.99), 2, '.', ''); // 10.000 - 999.999,99
            $date = $faker->dateTimeBetween('-1 year', 'now')->format('Y-m-d');
            $enters[] = [
                'name' => $faker->randomElement($enterNames) . ' ' . $faker->lexify('???'),
                'balance' => $balance,
                'date' => $date,
                'total' => $faker->boolean(70) ? $balance : null, // 70% chance total = balance
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];
        }

        // Generate 500 data buat outs
        $outs = [];
        for ($i = 0; $i < 500; $i++) {
            $balance = number_format($faker->randomFloat(2, 10000, 999999.99), 2, '.', ''); // 10.000 - 999.999,99
            $date = $faker->dateTimeBetween('-1 year', 'now')->format('Y-m-d');
            $outs[] = [
                'name' => $faker->randomElement($outNames) . ' ' . $faker->lexify('???'),
                'balance' => $balance,
                'date' => $date,
                'total' => $faker->boolean(70) ? $balance : null, // 70% chance total = balance
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];
        }

        // Insert data pake chunk biar efisien
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