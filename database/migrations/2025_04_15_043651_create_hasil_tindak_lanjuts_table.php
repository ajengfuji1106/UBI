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
        Schema::create('hasil_tindak_lanjuts', function (Blueprint $table) {
            $table->id('id_hasiltindaklanjut');
            $table->unsignedBigInteger('id_tindaklanjut');
            $table->unsignedBigInteger('id_user');
            // $table->foreignId('id_tindaklanjut')->constrained('tindak_lanjuts')->onDelete('cascade');
            // $table->foreignId('id_user')->constrained('users')->onDelete('cascade');
            $table->string('file_path');
            $table->string('status_tugas');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hasil_tindak_lanjuts');
    }
};
