<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKeuanganTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('keuangan', function (Blueprint $table) {
            $table->id();
            $table->string('keterangan');
            $table->decimal('jumlah', 10, 2);
            $table->enum('jenis', ['masuk', 'keluar']);
            $table->date('tanggal');
            $table->decimal('saldo', 10, 2)->nullable(); // Kolom saldo dari TotalSaldo
            $table->timestamps();
        });

        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('keuangan');
           }
}
