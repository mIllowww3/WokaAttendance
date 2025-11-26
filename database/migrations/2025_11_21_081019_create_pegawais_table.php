<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
public function up()
{
    Schema::create('pegawais', function (Blueprint $table) {
        $table->bigIncrements('id');

        $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
        $table->foreignId('departemen_id')->constrained('departemens')->cascadeOnDelete();
        $table->foreignId('kantor_id')->constrained('perusahaans')->cascadeOnDelete();
        $table->string('uid_qr')->unique();
        $table->string('foto')->nullable();
        $table->string('no_hp')->nullable();
        $table->text('alamat')->nullable();
        $table->enum('status', ['aktif','nonaktif']);

        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pegawais');
    }
};
