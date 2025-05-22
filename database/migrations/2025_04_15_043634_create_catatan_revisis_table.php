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
        Schema::create('catatan_revisis', function (Blueprint $table) {
            $table->id('id_catatanrevisi');
            $table->unsignedBigInteger('id_tindaklanjut');
            $table->unsignedBigInteger('id_user');
            // $table->foreignId('id_tindaklanjut')->constrained('tindaklanjuts')->onDelete('cascade');
            // $table->foreignId('id_user')->constrained('users')->onDelete('cascade');
            $table->string('catatanrevisi');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('catatan_revisis');
    }
};
