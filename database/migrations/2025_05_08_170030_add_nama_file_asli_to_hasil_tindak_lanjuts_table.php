<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('hasil_tindak_lanjuts', function (Blueprint $table) {
            $table->string('nama_file_asli')->nullable();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('hasil_tindak_lanjuts', function (Blueprint $table) {
            //
        });
    }
};
