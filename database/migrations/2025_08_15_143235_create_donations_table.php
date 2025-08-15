<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('donations', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('phone_number')->nullable();
            $table->enum('donation_type', ['umum', 'terdaftar'])->default('umum');
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('campaign_id')->constrained('campaigns')->cascadeOnDelete();
            $table->foreignId('status_id')->default(1)->constrained('statuses')->restrictOnDelete();
            $table->string('rejected_reason')->nullable();
            $table->decimal('amount', 15, 2);
            $table->string('proof_image');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('donations');
    }
};
