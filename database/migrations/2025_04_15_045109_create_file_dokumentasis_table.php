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
        Schema::create('file_dokumentasis', function (Blueprint $table) {
            $table->id('id_file');
            $table->unsignedBigInteger('id_dokumentasi');
            $table->string('file_path');
            $table->timestamps();
            // $table->foreign('id_dokumentasi')->references('id_dokumentasi')->on('dokumentasis')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('file_dokumentasis');
    }
};
