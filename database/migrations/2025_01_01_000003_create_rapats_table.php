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
        Schema::create('rapats', function (Blueprint $table) {
            $table->id('id_rapat');
            $table->unsignedBigInteger('id_user');
            // $table->foreignId('id_user')->constrained('users')->onDelete('cascade');
            $table->string('judul_rapat');
            $table->date('tanggal_rapat');
            $table->time('waktu_rapat');
            $table->string('lokasi_rapat');
            $table->string('kategori_rapat');
            $table->string('status_rapat')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rapats');
    }
};
