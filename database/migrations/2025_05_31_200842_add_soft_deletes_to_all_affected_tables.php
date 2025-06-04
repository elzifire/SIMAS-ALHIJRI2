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
        $tables = [
            'categories_photos', 'categories', 'category_videos', 'contacts', 'enters',
            'events', 'leaders', 'managements', 'muadzins', 'mualafs', 'outs',
            'pendaftaran', 'posts', 'saksi', 'services', 'sliders', 'tags',
            'users', 'videos', 'visis', 'witnesses'
        ];

        foreach ($tables as $tableName) {
            if (Schema::hasTable($tableName) && !Schema::hasColumn($tableName, 'deleted_at')) {
                Schema::table($tableName, function (Blueprint $table) {
                    $table->softDeletes();
                });
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $tables = [
            'categories_photos', 'categories', 'category_videos', 'contacts', 'enters',
            'events', 'leaders', 'managements', 'muadzins', 'mualafs', 'outs',
            'pendaftaran', 'posts', 'saksi', 'services', 'sliders', 'tags',
            'users', 'videos', 'visis', 'witnesses'
        ];

        foreach ($tables as $tableName) {
            if (Schema::hasTable($tableName) && Schema::hasColumn($tableName, 'deleted_at')) {
                Schema::table($tableName, function (Blueprint $table) {
                    $table->dropSoftDeletes();
                });
            }
        }
    }
};