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
        Schema::create('money', function (Blueprint $table) {
            $table->id();
            $table->string('Keterangan');
            $table->decimal('jumlah')->comment('Jumlah dalam rupiah');
            $table->enum('jenis', ['masuk', 'keluar']);
            $table->decimal('total_masuk')->default(0); // Add this field
            $table->decimal('total_keluar')->default(0); // Add this field
            $table->decimal('saldo')->default(0); // Add this field
            $table->date('tanggal');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('money');
    }
};
