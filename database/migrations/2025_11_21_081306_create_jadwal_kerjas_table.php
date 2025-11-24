<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
public function up()
{
    Schema::create('jadwal_kerja', function (Blueprint $table) {
        $table->bigIncrements('id');
        $table->enum('hari', [
            'Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu'
        ]);
        $table->time('jam_masuk');
        $table->time('jam_pulang');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jadwal_kerjas');
    }
};
