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
        Schema::create('pendaftaran', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('nik')->unique();
            $table->enum('gender', ['Laki-laki', 'Perempuan']);
            $table->string('tmptlahir');
            $table->date('birthdate');
            $table->string('pekerjaan');
            $table->enum('agama', ['kristen', 'hindu', 'budha', 'konghucu', 'yanglainnya']);
            $table->string('kebangsaan');
            $table->string('email')->unique();
            $table->string('phone');
            $table->text('address');
            $table->text('alamatktp');
            $table->string('photo');
            $table->string('session_id');
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pendaftaran');
    }
};

