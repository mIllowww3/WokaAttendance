<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
public function up()
{
    Schema::create('izin_sakits', function (Blueprint $table) {
        $table->id();

        $table->foreignId('pegawai_id')->constrained('pegawais')->cascadeOnDelete();

        $table->date('tanggal_mulai');
        $table->date('tanggal_selesai');

        $table->enum('jenis', ['izin','sakit']);
        $table->text('alasan');
        $table->string('lampiran')->nullable();

        $table->enum('status', ['pending','disetujui','ditolak'])->default('pending');

        $table->foreignId('approved_by')->nullable()->constrained('users')->cascadeOnDelete();

        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('izins');
    }
};
