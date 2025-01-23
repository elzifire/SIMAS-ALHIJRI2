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

  // Create categories_photos table
  Schema::create('categories_photos', function (Blueprint $table) {
    $table->id();
    $table->string('name');
    $table->timestamps();
  });

  Schema::create('photos', function (Blueprint $table) {
    $table->id();
    $table->string('image');
    $table->string('heading');
    $table->text('caption');
    $table->date('date');
    $table->bigInteger('category_id')->foreign('category_id')->references('id')->on('categories_photos')->onDelete('cascade');
    $table->timestamps();
  });
}
  
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('photos');
    }
};
