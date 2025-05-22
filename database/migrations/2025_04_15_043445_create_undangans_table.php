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
        Schema::create('undangans', function (Blueprint $table) {
            $table->id('id_undangan');
            $table->unsignedBigInteger('id_rapat');
            // $table->foreignId('id_rapat')->constrained('rapats', 'id_rapat')->onDelete('cascade');
            // $table->foreignId('id_rapat')->constrained('rapats')->onDelete('cascade');
            $table->string('file_undangan');
            $table->timestamps();

            // $table->foreign('id_rapat')->references('id_rapat')->on('rapats')->onDelete('cascade');
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('undangans');
    }
};
