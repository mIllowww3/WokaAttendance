<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
public function up()
{
    Schema::table('pegawais', function (Blueprint $table) {
        $table->string('qr_image')->nullable()->after('uid_qr');
        $table->date('qr_generated_at')->nullable()->after('qr_image');
    });
}

public function down()
{
    Schema::table('pegawai', function (Blueprint $table) {
        $table->dropColumn(['qr_image', 'qr_generated_at']);
    });
}

};
