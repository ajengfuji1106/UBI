<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('catatan_revisis', function (Blueprint $table) {
        $table->unsignedBigInteger('id_hasiltindaklanjut')->nullable();
        $table->foreign('id_hasiltindaklanjut')->references('id')->on('hasil_tindak_lanjut')->onDelete('cascade');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down()
{
    Schema::table('catatan_revisis', function (Blueprint $table) {
        $table->dropForeign(['id_hasiltindaklanjut']);
        $table->dropColumn('id_hasiltindaklanjut');
    });
}
};
