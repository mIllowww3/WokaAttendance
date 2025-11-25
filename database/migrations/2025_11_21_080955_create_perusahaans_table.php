<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   public function up()
{
    Schema::create('perusahaans', function (Blueprint $table) {
        $table->bigIncrements('id');
        $table->string('nama_kantor');
        $table->decimal('latitude', 10, 8);
        $table->decimal('longitude', 11, 8);
        $table->integer('radius')->default(50);
        $table->string('alamat')->nullable();
        $table->enum('status', ['aktif','nonaktif']);
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('perusahaans');
    }
};
