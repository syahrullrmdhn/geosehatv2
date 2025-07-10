<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('case_records', function (Blueprint $table) {
    $table->id();
    $table->string('patient_name');
    $table->foreignId('disease_id')->constrained()->cascadeOnDelete();
    $table->foreignId('region_id')->constrained()->cascadeOnDelete();
    $table->date('date_reported');
    $table->decimal('latitude', 10, 7)->nullable();
    $table->decimal('longitude',10, 7)->nullable();
    $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('case_records');
    }
};
