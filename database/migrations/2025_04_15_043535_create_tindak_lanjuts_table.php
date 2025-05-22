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
        Schema::create('tindak_lanjuts', function (Blueprint $table) {
            $table->id('id_tindaklanjut');
            $table->unsignedBigInteger('id_rapat');
            // $table->unsignedBigInteger('id_user');
            // $table->foreignId('id_rapat')->constrained('rapats', 'id_rapat')->onDelete('cascade');
            // $table->foreignId('id_user')->constrained('users')->onDelete('cascade');
            $table->string('judul_tugas');
            $table->date('deadline_tugas');
            $table->text('deskripsi_tugas');
            $table->enum('status_tugas', ['Pending', 'In Progress', 'Completed'])->default('Pending');
            $table->string('file_path')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tindak_lanjuts');
    }
};
