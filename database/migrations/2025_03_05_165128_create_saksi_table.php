<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Validation\Rules\Unique;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('saksi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pendaftaran_id')->constrained('pendaftaran')->onDelete('cascade'); //relasi ke table pendaftaran
            $table->string('saksi_name');
            $table->string('saksi_nik');
            $table->enum('gender_saksi', ['Laki-laki', 'Perempuan']);
            $table->string('pekerjaan_saksi');
            $table->string('alamatsaksi');
            $table->string('saksi_name2');
            $table->string('saksinik2');
            $table->enum('gender_saksi2', ['Laki-laki', 'Perempuan']);
            $table->string('pekerjaan_saksi2');
            $table->string('alamatsaksi2');
            $table->string('session_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('saksi');
    }
};
