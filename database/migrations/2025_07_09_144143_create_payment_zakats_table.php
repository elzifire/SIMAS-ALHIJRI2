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
        Schema::create('payment_zakats', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // nama pembayar
            $table->string('phone'); // nomor telepon
            $table->enum('zakat_type', ['penghasilan', 'fitrah', 'maal', 'emas', 'perdagangan']); // jenis zakat
            $table->decimal('amount', 12, 2); // jumlah yang dibayarkan
            $table->string('proof')->nullable(); // path ke bukti transfer (jika via transfer)
            $table->boolean('is_verified')->default(false); // status validasi oleh admin
            $table->text('note')->nullable(); // catatan tambahan
            $table->timestamps(); // created_at & updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_zakats');
    }
};
