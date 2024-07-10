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

  

  Schema::create('videos', function (Blueprint $table) {
    $table->id();
    $table->string('title');
    $table->string('embed');
    $table->string('desc');
    $table->unsignedBigInteger('category_id');
    $table->timestamps();

    $table->foreign('category_id')->references('id')->on('category_videos')->onDelete('cascade')->onUpdate('cascade');
  });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('videos');
    }
};
