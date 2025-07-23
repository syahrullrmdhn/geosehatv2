<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1) Tambah kolom region_id jika belum ada
        if (! Schema::hasColumn('health_workers', 'region_id')) {
            Schema::table('health_workers', function (Blueprint $table) {
                $table->unsignedBigInteger('region_id')
                      ->nullable()
                      ->after('profession');
            });
        }

        // 2) Migrasi data dari kolom string 'region' ke 'region_id'
        DB::table('health_workers')->get()->each(function ($worker) {
            $region = DB::table('regions')
                        ->where('name', $worker->region)
                        ->first();
            if ($region) {
                DB::table('health_workers')
                  ->where('id', $worker->id)
                  ->update(['region_id' => $region->id]);
            }
        });

        // 3) Ubah region_id menjadi NOT NULL, tambahkan FK, dan drop kolom lama
        Schema::table('health_workers', function (Blueprint $table) {
            // ubah jadi NOT NULL
            $table->unsignedBigInteger('region_id')
                  ->nullable(false)
                  ->change();

            // tambahkan foreign key constraint
            $table->foreign('region_id')
                  ->references('id')
                  ->on('regions')
                  ->cascadeOnDelete();

            // hapus kolom string region jika masih ada
            if (Schema::hasColumn('health_workers', 'region')) {
                $table->dropColumn('region');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('health_workers', function (Blueprint $table) {
            // tambahkan kembali kolom region sebagai string
            $table->string('region', 50)
                  ->after('profession');

            // drop foreign key & kolom region_id
            $table->dropForeign(['region_id']);
            $table->dropColumn('region_id');
        });
    }
};
