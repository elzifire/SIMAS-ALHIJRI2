<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('mualafs', function (Blueprint $table) {
            $table->id();
            $table->string("nama_lengkap");
            $table->string("no_ktp");
            $table->enum("jenis_kelamin", ["L", "P"]);
            $table->string("tempat_lahir");
            $table->date("tanggal_lahir");
            $table->string("pekerjaan");
            $table->enum("agama_sebelumnya", ["Islam", "Kristen", "Katolik", "Hindu", "Budha", "Konghucu", "Lainnya"]);
            $table->string("kebangsaan");
            $table->string("email");
            $table->string("no_hp");
            $table->string("foto")->nullable();
            $table->text("alamat");
            $table->text("alamat_domisili")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mualafs');
    }
};
