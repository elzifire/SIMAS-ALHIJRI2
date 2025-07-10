<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class PaymentZakatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $zakatTypes = ['penghasilan', 'fitrah', 'maal', 'emas', 'perdagangan'];

        for ($i = 1; $i <= 20; $i++) {
            DB::table('payment_zakats')->insert([
                'name' => 'Pembayar ' . $i,
                'phone' => '08' . rand(1111111111, 9999999999),
                'zakat_type' => $zakatTypes[array_rand($zakatTypes)],
                'amount' => rand(50000, 1000000),
                'proof' => 'uploads/bukti/bukti_' . $i . '.jpg',
                'is_verified' => rand(0, 1),
                'note' => Str::random(20),
                'created_at' => Carbon::now()->subDays(rand(0, 30)),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}
