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
        $table->unsignedBigInteger('id_tindak_lanjut_user')->after('id_catatanrevisi')->nullable();

        // $table->foreign('id_tindak_lanjut_user')->references('id')->on('tindak_lanjut_user')->onDelete('cascade');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down()
{
    Schema::table('catatan_revisis', function (Blueprint $table) {
        $table->dropForeign(['id_tindak_lanjut_user']);
        $table->dropColumn('id_tindak_lanjut_user');
    });
}
};
