<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;
use App\Models\Mualaf;

class MualafControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_stores_a_new_mualaf_record_successfully()
    {
        $payload = [
            'nama_lengkap' => 'John Doe',
            'no_ktp' => '1234567890123456',
            'jenis_kelamin' => 'L',
            'tempat_lahir' => 'Jakarta',
            'tanggal_lahir' => '1990-01-01',
            'pekerjaan' => 'Karyawan',
            'agama_sebelumnya' => 'Kristen',
            'kebangsaan' => 'Indonesia',
            'email' => 'johndoe@example.com',
            'no_hp' => '081234567890',
            'alamat' => 'Jalan Raya No. 1',
            'alamat_domisili' => 'Jalan Mawar No. 2',
            'foto' => UploadedFile::fake()->image('foto.jpg'),
        ];

        $response = $this->postJson('/api/mualaf', $payload);

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'message',
                'data' => [
                    'id', 'nama_lengkap', 'no_ktp', 'jenis_kelamin',
                    'tempat_lahir', 'tanggal_lahir', 'pekerjaan',
                    'agama_sebelumnya', 'kebangsaan', 'email', 'no_hp',
                    'alamat', 'alamat_domisili', 'foto',
                ],
            ]);

        $this->assertDatabaseHas('mualafs', [
            'nama_lengkap' => 'John Doe',
            'no_ktp' => '1234567890123456',
            'jenis_kelamin' => 'L',
            'tempat_lahir' => 'Jakarta',
            'tanggal_lahir' => '1990-01-01',
            'pekerjaan' => 'Karyawan',
            'agama_sebelumnya' => 'Kristen',
            'kebangsaan' => 'Indonesia',
            'email' => 'johndoe@example.com',
            'no_hp' => '081234567890',
            'alamat' => 'Jalan Raya No. 1',
            'alamat_domisili' => 'Jalan Mawar No. 2',
        ]);
    }

    /** @test */
    public function it_validates_request_data()
    {
        $response = $this->postJson('/api/mualaf', []);

        $response
            ->assertStatus(422)
            ->assertJsonValidationErrors([
                'nama_lengkap', 'no_ktp', 'jenis_kelamin', 'tempat_lahir',
                'tanggal_lahir', 'pekerjaan', 'agama_sebelumnya',
                'kebangsaan', 'email', 'no_hp', 'alamat'
            ]);
    }
}
