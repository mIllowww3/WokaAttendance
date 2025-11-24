<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
public function up()
{
    Schema::create('absen', function (Blueprint $table) {
        $table->bigIncrements('id');

        $table->foreignId('pegawai_id')->constrained('pegawai');

        $table->date('tanggal');
        $table->time('jam_masuk')->nullable();
        $table->time('jam_pulang')->nullable();

        $table->enum('status', ['hadir','izin','sakit','alpha'])->default('alpha');

        $table->string('lokasi_masuk')->nullable();
        $table->string('lokasi_pulang')->nullable();

        $table->float('jarak_masuk')->nullable();
        $table->float('jarak_pulang')->nullable();

        $table->text('catatan')->nullable();

        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('absens');
    }
};
