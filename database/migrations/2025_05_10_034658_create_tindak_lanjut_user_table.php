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
    Schema::create('tindak_lanjut_user', function (Blueprint $table) {
    $table->id();
    $table->unsignedBigInteger('id_tindaklanjut');
    $table->unsignedBigInteger('id_user');

    // $table->foreign('id_tindaklanjut')
        // ->references('id_tindaklanjut')
        // ->on('tindak_lanjuts')
        // ->onDelete('cascade');
    // $table->foreign('id_user')
        // ->references('id') 
        // ->on('users')
        // ->onDelete('cascade');
    $table->enum('status_tugas', ['Pending', 'In Progress', 'Completed'])->default('Pending');
    $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tindak_lanjut_user');
    }
};
