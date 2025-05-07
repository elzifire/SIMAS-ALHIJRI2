<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;

class PendaftaranSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('pendaftaran')->insert([
            'name' => 'Ahmad Ridho',
            'nik' => '3201234567890001',
            'gender' => 'Laki-laki',
            'tmptlahir' => 'Bogor',
            'birthdate' => '1995-05-20',
            'pekerjaan' => 'Karyawan Swasta',
            'agama' => 'kristen',
            'kebangsaan' => 'Indonesia',
            'email' => 'ahmad.ridho@example.com',
            'phone' => '081234567890',
            'address' => 'Jl. Kenanga No. 123, Bogor',
            'alamatktp' => 'Jl. Melati No. 45, Bogor',
            'photo' => 'mualaf/default.jpg', // simpan di storage/app/public/mualaf/
            'session_id' => Str::uuid(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }
}
