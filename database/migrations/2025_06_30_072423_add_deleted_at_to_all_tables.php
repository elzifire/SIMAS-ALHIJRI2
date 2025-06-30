<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Ambil semua nama tabel dari database
        $tables = DB::select('SHOW TABLES');

        // Ambil nama kolom tabel sesuai database
        $databaseName = DB::getDatabaseName();
        $key = "Tables_in_{$databaseName}";

        foreach ($tables as $table) {
            $tableName = $table->$key;

            // Cek apakah tabel sudah ada kolom deleted_at atau tidak
            if (!Schema::hasColumn($tableName, 'deleted_at')) {
                Schema::table($tableName, function (Blueprint $table) {
                    $table->timestamp('deleted_at')->nullable()->after('updated_at');
                });
            }
        }
    }

    public function down(): void
    {
        $tables = DB::select('SHOW TABLES');
        $databaseName = DB::getDatabaseName();
        $key = "Tables_in_{$databaseName}";

        foreach ($tables as $table) {
            $tableName = $table->$key;

            if (Schema::hasColumn($tableName, 'deleted_at')) {
                Schema::table($tableName, function (Blueprint $table) {
                    $table->dropColumn('deleted_at');
                });
            }
        }
    }
};
