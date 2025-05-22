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
        Schema::create('dokumentasis', function (Blueprint $table) {
            $table->id('id_dokumentasi');
            $table->unsignedBigInteger('id_rapat');
            // $table->foreignId('id_rapat')->constrained('rapats', 'id_rapat')->onDelete('cascade');
            $table->string('judul_dokumentasi');
            $table->text('deskripsi')->nullable();
            $table->string('file_path')->nullable();
            // $table->string('file_path');
            $table->timestamps();
            
            // $table->foreign('id_rapat')->references('id')->on('rapat')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dokumentasis');
    }
};
