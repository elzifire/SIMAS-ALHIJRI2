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
        // Tambah index di enters
        Schema::table('enters', function (Blueprint $table) {
            $table->index('balance');
            $table->index('created_at');
            $table->index('date');
        });

        // Tambah index di outs
        Schema::table('outs', function (Blueprint $table) {
            $table->index('balance');
            $table->index('created_at');
            $table->index('date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('enters', function (Blueprint $table) {
            $table->dropIndex(['balance']);
            $table->dropIndex(['created_at']);
            $table->dropIndex(['date']);
        });

        Schema::table('outs', function (Blueprint $table) {
            $table->dropIndex(['balance']);
            $table->dropIndex(['created_at']);
            $table->dropIndex(['date']);
        });
    }
};
