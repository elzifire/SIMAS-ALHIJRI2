<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('campaigns', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('image');
            $table->decimal('goal_amount', 15, 2);
            $table->decimal('total_collected', 15, 2)->default(0.00);
            $table->text('description');
            $table->date('expired');
            $table->foreignId('category_id')->constrained('categories_campaign')->cascadeOnDelete();
            $table->string('bank_info')->nullable();
            $table->string('status')->default('active');
            $table->string('file_qr')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('campaigns');
    }
};
