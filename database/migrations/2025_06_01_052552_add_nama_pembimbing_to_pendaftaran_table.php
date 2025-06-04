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
    Schema::table('pendaftaran', function (Blueprint $table) {
        // Ganti 'kolom_terakhir_yang_ada' dengan nama kolom terakhir di tabel pendaftaran Anda
        // agar kolom baru ini posisinya rapi.
        $table->string('nama_pembimbing_ikrar')->nullable()->after('photo');
    });
}

    /**
     * Reverse the migrations.
     */
   public function down(): void
{
    Schema::table('pendaftaran', function (Blueprint $table) {
        $table->dropColumn('nama_pembimbing_ikrar');
    });
    }
};
