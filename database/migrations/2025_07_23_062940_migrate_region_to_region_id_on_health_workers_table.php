<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('health_workers', function (Blueprint $table) {
            // 1) Tambah region_id nullable
            $table->unsignedBigInteger('region_id')->nullable()->after('profession');
        });

        // 2) Isi region_id berdasarkan nama wilayah di tabel regions
        //    (anggap kolom `region` berisi nama yang persis ada di regions.name)
        DB::table('health_workers')->get()->each(function($w) {
            $reg = DB::table('regions')->where('name', $w->region)->first();
            if ($reg) {
                DB::table('health_workers')
                  ->where('id', $w->id)
                  ->update(['region_id' => $reg->id]);
            }
        });

        Schema::table('health_workers', function (Blueprint $table) {
            // 3) Jadikan region_id NOT NULL
            $table->unsignedBigInteger('region_id')
                  ->nullable(false)
                  ->change();

            // 4) Tambahkan foreign key constraint
            $table->foreign('region_id')
                  ->references('id')
                  ->on('regions')
                  ->cascadeOnDelete();

            // 5) Drop kolom region lama
            $table->dropColumn('region');
        });
    }

    public function down(): void
    {
        Schema::table('health_workers', function (Blueprint $table) {
            // kembalikan kolom region string
            $table->string('region', 50)->after('profession');
            // drop fk & region_id
            $table->dropForeign(['region_id']);
            $table->dropColumn('region_id');
        });
    }
};
