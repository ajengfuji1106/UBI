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
        Schema::create('pesertas', function (Blueprint $table) {
            $table->id('id_peserta');
            $table->unsignedBigInteger('id_user');
            $table->unsignedBigInteger('id_rapat');
            // $table->foreignId('id_user')->constrained('users')->onDelete('cascade');
            // $table->foreignId('id_rapat')->constrained('rapats', 'id_rapat')->onDelete('cascade');
            // $table->foreignId('id_rapat')->constrained('rapats')->onDelete('cascade');
            $table->string('status_kehadiran')->nullable();
            $table->string('role_peserta');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pesertas');
    }
};
